<?php

namespace App\Http\Controllers;

use App\Models\Mechanic;
use App\Models\Payment;
use App\Models\ServiceDetail;
use App\Models\ServiceRegistration;
use App\Models\ServiceSparepart;
use App\Models\Sparepart;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class ServiceDetailController extends Controller
{
    /**
     * Tampilkan seluruh data detail pengerjaan servis mekanik.
     */
    public function index(Request $request): View
    {
        $search = $request->query('search');

        $details = ServiceDetail::with(['serviceRegistration.vehicle', 'serviceRegistration.customer', 'mechanic', 'serviceSpareparts.sparepart'])
            ->when($search, function ($query, $search) {
                $query->where('detail_id', 'like', "%{$search}%")
                    ->orWhere('estimation', 'like', "%{$search}%")
                    ->orWhereHas('mechanic', function ($mq) use ($search) {
                        $mq->where('name', 'like', "%{$search}%");
                    })
                    ->orWhereHas('serviceRegistration', function ($sq) use ($search) {
                        $sq->where('service_id', 'like', "%{$search}%")
                            ->orWhereHas('vehicle', function ($vq) use ($search) {
                                $vq->where('plate_number', 'like', "%{$search}%");
                            });
                    });
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('admin.service_details.index', compact('details', 'search'));
    }

    /**
     * Tampilkan form pembuatan rincian pengerjaan servis baru.
     */
    public function create(Request $request): View
    {
        // Hanya servis yang belum memiliki detail atau sedang menunggu/pengerjaan
        $selectedServiceId = $request->query('service_id');

        $services = ServiceRegistration::with(['vehicle', 'customer'])
            ->doesntHave('serviceDetail')
            ->orWhere('id', $selectedServiceId)
            ->latest()
            ->get();

        $mechanics = Mechanic::orderBy('name')->get();
        $spareparts = Sparepart::where('stock', '>', 0)->orderBy('category')->orderBy('name')->get();

        return view('admin.service_details.create', compact('services', 'mechanics', 'spareparts', 'selectedServiceId'));
    }

    /**
     * Simpan rincian pengerjaan servis, alokasi sparepart, dan hitung total biaya.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'service_registration_id' => ['required', 'exists:service_registrations,id', 'unique:service_details,service_registration_id'],
            'mechanic_id' => ['required', 'exists:mechanics,id'],
            'estimation' => ['nullable', 'string', 'max:1000'],
            'service_cost' => ['required', 'numeric', 'min:0'],
            'service_status' => ['required', 'in:waiting,in_progress,completed,cancelled'],
            'spareparts' => ['nullable', 'array'],
            'spareparts.*.id' => ['required_with:spareparts', 'exists:spareparts,id'],
            'spareparts.*.qty' => ['required_with:spareparts', 'integer', 'min:1'],
        ], [
            'service_registration_id.required' => 'Pilih pendaftaran servis.',
            'service_registration_id.unique' => 'Servis ini sudah memiliki rincian pengerjaan teknis.',
            'mechanic_id.required' => 'Pilih mekanik penanggung jawab.',
            'service_cost.required' => 'Biaya jasa servis wajib ditentukan (bisa Rp 0 jika free servis).',
        ]);

        return DB::transaction(function () use ($validated, $request) {
            // 1. Buat Service Detail
            $detail = ServiceDetail::create([
                'service_registration_id' => $validated['service_registration_id'],
                'mechanic_id' => $validated['mechanic_id'],
                'estimation' => $validated['estimation'],
                'service_cost' => $validated['service_cost'],
                'status' => $validated['service_status'],
            ]);

            // 2. Update status pendaftaran servis
            $service = ServiceRegistration::findOrFail($validated['service_registration_id']);
            $service->update(['status' => $validated['service_status']]);

            // 3. Simpan Pemakaian Sparepart & Kurangi Stok
            $totalSparepartCost = 0;

            if (!empty($request->input('spareparts'))) {
                foreach ($request->input('spareparts') as $item) {
                    if (!isset($item['id']) || empty($item['id']) || !isset($item['qty']) || $item['qty'] <= 0) {
                        continue;
                    }

                    $sparepart = Sparepart::lockForUpdate()->findOrFail($item['id']);
                    $qty = (int) $item['qty'];

                    if ($sparepart->stock < $qty) {
                        throw \Illuminate\Validation\ValidationException::withMessages([
                            'spareparts' => "Stok suku cadang {$sparepart->name} tidak mencukupi (Tersisa: {$sparepart->stock}).",
                        ]);
                    }

                    $subtotal = $sparepart->price * $qty;
                    $totalSparepartCost += $subtotal;

                    ServiceSparepart::create([
                        'service_detail_id' => $detail->id,
                        'sparepart_id' => $sparepart->id,
                        'quantity' => $qty,
                        'unit_price' => $sparepart->price,
                        'subtotal' => $subtotal,
                    ]);

                    // Kurangi stok suku cadang di gudang
                    $sparepart->decrement('stock', $qty);
                }
            }

            // 4. Update atau Buat Record Pembayaran di Kasir
            $totalAmount = $validated['service_cost'] + $totalSparepartCost;

            Payment::updateOrCreate(
                ['service_registration_id' => $service->id],
                [
                    'service_cost' => $validated['service_cost'],
                    'sparepart_cost' => $totalSparepartCost,
                    'total_amount' => $totalAmount,
                    'payment_type' => 'cash',
                    'status' => 'pending',
                ]
            );

            return redirect()->route('admin.service-details.index')
                ->with('success', "Rincian pengerjaan {$detail->detail_id} untuk servis {$service->service_id} berhasil disimpan.");
        });
    }

    /**
     * Tampilkan detail pengerjaan.
     */
    public function show(ServiceDetail $serviceDetail): View
    {
        $serviceDetail->load(['serviceRegistration.vehicle', 'serviceRegistration.customer', 'mechanic', 'serviceSpareparts.sparepart', 'serviceRegistration.payment']);

        return view('admin.service_details.show', compact('serviceDetail'));
    }

    /**
     * Tampilkan form edit detail pengerjaan.
     */
    public function edit(ServiceDetail $serviceDetail): View
    {
        $serviceDetail->load(['serviceRegistration.vehicle', 'serviceSpareparts']);
        $mechanics = Mechanic::orderBy('name')->get();
        $spareparts = Sparepart::orderBy('category')->orderBy('name')->get();

        return view('admin.service_details.edit', compact('serviceDetail', 'mechanics', 'spareparts'));
    }

    /**
     * Perbarui data detail pengerjaan dan sesuaikan stok sparepart.
     */
    public function update(Request $request, ServiceDetail $serviceDetail): RedirectResponse
    {
        $validated = $request->validate([
            'mechanic_id' => ['required', 'exists:mechanics,id'],
            'estimation' => ['nullable', 'string', 'max:1000'],
            'service_cost' => ['required', 'numeric', 'min:0'],
            'service_status' => ['required', 'in:waiting,in_progress,completed,cancelled'],
            'spareparts' => ['nullable', 'array'],
            'spareparts.*.id' => ['required_with:spareparts', 'exists:spareparts,id'],
            'spareparts.*.qty' => ['required_with:spareparts', 'integer', 'min:1'],
        ]);

        return DB::transaction(function () use ($validated, $request, $serviceDetail) {
            // 1. Kembalikan stok sparepart lama terlebih dahulu
            foreach ($serviceDetail->serviceSpareparts as $oldItem) {
                Sparepart::where('id', $oldItem->sparepart_id)->increment('stock', $oldItem->quantity);
            }
            $serviceDetail->serviceSpareparts()->delete();

            // 2. Update data pokok detail servis
            $serviceDetail->update([
                'mechanic_id' => $validated['mechanic_id'],
                'estimation' => $validated['estimation'],
                'service_cost' => $validated['service_cost'],
                'status' => $validated['service_status'],
            ]);

            // 3. Update status pendaftaran servis
            $service = $serviceDetail->serviceRegistration;
            $service->update(['status' => $validated['service_status']]);

            // 4. Masukkan sparepart baru & kurangi stok baru
            $totalSparepartCost = 0;

            if (!empty($request->input('spareparts'))) {
                foreach ($request->input('spareparts') as $item) {
                    if (!isset($item['id']) || empty($item['id']) || !isset($item['qty']) || $item['qty'] <= 0) {
                        continue;
                    }

                    $sparepart = Sparepart::lockForUpdate()->findOrFail($item['id']);
                    $qty = (int) $item['qty'];

                    if ($sparepart->stock < $qty) {
                        throw \Illuminate\Validation\ValidationException::withMessages([
                            'spareparts' => "Stok suku cadang {$sparepart->name} tidak mencukupi (Tersisa: {$sparepart->stock}).",
                        ]);
                    }

                    $subtotal = $sparepart->price * $qty;
                    $totalSparepartCost += $subtotal;

                    ServiceSparepart::create([
                        'service_detail_id' => $serviceDetail->id,
                        'sparepart_id' => $sparepart->id,
                        'quantity' => $qty,
                        'unit_price' => $sparepart->price,
                        'subtotal' => $subtotal,
                    ]);

                    $sparepart->decrement('stock', $qty);
                }
            }

            // 5. Sinkronkan ke modul kasir pembayaran
            $totalAmount = $validated['service_cost'] + $totalSparepartCost;

            Payment::updateOrCreate(
                ['service_registration_id' => $service->id],
                [
                    'service_cost' => $validated['service_cost'],
                    'sparepart_cost' => $totalSparepartCost,
                    'total_amount' => $totalAmount,
                ]
            );

            return redirect()->route('admin.service-details.index')
                ->with('success', "Rincian pengerjaan {$serviceDetail->detail_id} berhasil diperbarui.");
        });
    }

    /**
     * Hapus rincian pengerjaan servis dan kembalikan stok sparepart.
     */
    public function destroy(ServiceDetail $serviceDetail): RedirectResponse
    {
        return DB::transaction(function () use ($serviceDetail) {
            $code = $serviceDetail->detail_id;

            // Kembalikan stok
            foreach ($serviceDetail->serviceSpareparts as $item) {
                Sparepart::where('id', $item->sparepart_id)->increment('stock', $item->quantity);
            }

            $serviceDetail->delete();

            return redirect()->route('admin.service-details.index')
                ->with('success', "Rincian pengerjaan {$code} berhasil dihapus dan stok sparepart telah dikembalikan.");
        });
    }
}
