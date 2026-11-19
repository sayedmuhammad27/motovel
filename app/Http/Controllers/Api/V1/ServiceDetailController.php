<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\BaseApiController;
use App\Models\Payment;
use App\Models\ServiceDetail;
use App\Models\ServiceRegistration;
use App\Models\ServiceSparepart;
use App\Models\Sparepart;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class ServiceDetailController extends BaseApiController
{
    /**
     * Tampilkan seluruh rincian pengerjaan teknis servis (GET /api/v1/service-details).
     */
    public function index(Request $request): JsonResponse
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
            ->latest('id')
            ->paginate($request->query('per_page', 10));

        return $this->successResponse($details, 'Daftar rincian teknis servis berhasil diambil.');
    }

    /**
     * Simpan pengerjaan teknis, alokasikan sparepart, kurangi stok gudang, dan kalkulasi tagihan (POST /api/v1/service-details).
     */
    public function store(Request $request): JsonResponse
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
        ]);

        return DB::transaction(function () use ($validated, $request) {
            // 1. Buat Service Detail
            $detail = ServiceDetail::create([
                'service_registration_id' => $validated['service_registration_id'],
                'mechanic_id' => $validated['mechanic_id'],
                'estimation' => $validated['estimation'] ?? null,
                'service_cost' => $validated['service_cost'],
                'status' => $validated['service_status'],
            ]);

            // 2. Update status registrasi servis
            $service = ServiceRegistration::findOrFail($validated['service_registration_id']);
            $service->update(['status' => $validated['service_status']]);

            // 3. Masukkan suku cadang & kurangi stok
            $totalSparepartCost = 0;

            if (!empty($request->input('spareparts'))) {
                foreach ($request->input('spareparts') as $item) {
                    if (!isset($item['id']) || empty($item['id']) || !isset($item['qty']) || $item['qty'] <= 0) {
                        continue;
                    }

                    $sparepart = Sparepart::lockForUpdate()->findOrFail($item['id']);
                    $qty = (int) $item['qty'];

                    if ($sparepart->stock < $qty) {
                        throw ValidationException::withMessages([
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

            $detail->load(['serviceRegistration.vehicle', 'mechanic', 'serviceSpareparts.sparepart']);

            return $this->successResponse($detail, "Rincian teknis {$detail->detail_id} berhasil disimpan.", 201);
        });
    }

    /**
     * Tampilkan detail pengerjaan teknis servis (GET /api/v1/service-details/{service_detail}).
     */
    public function show(ServiceDetail $serviceDetail): JsonResponse
    {
        $serviceDetail->load(['serviceRegistration.vehicle.customer', 'mechanic', 'serviceSpareparts.sparepart', 'serviceRegistration.payment']);

        return $this->successResponse($serviceDetail, 'Detail pengerjaan teknis berhasil diambil.');
    }

    /**
     * Perbarui data pengerjaan teknis servis dan sesuaikan mutasi stok (PUT/PATCH /api/v1/service-details/{service_detail}).
     */
    public function update(Request $request, ServiceDetail $serviceDetail): JsonResponse
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
            // 1. Kembalikan stok sparepart lama
            foreach ($serviceDetail->serviceSpareparts as $oldItem) {
                Sparepart::where('id', $oldItem->sparepart_id)->increment('stock', $oldItem->quantity);
            }
            $serviceDetail->serviceSpareparts()->delete();

            // 2. Update data pokok detail servis
            $serviceDetail->update([
                'mechanic_id' => $validated['mechanic_id'],
                'estimation' => $validated['estimation'] ?? null,
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
                        throw ValidationException::withMessages([
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

            // 5. Sinkronkan tagihan kasir
            $totalAmount = $validated['service_cost'] + $totalSparepartCost;

            Payment::updateOrCreate(
                ['service_registration_id' => $service->id],
                [
                    'service_cost' => $validated['service_cost'],
                    'sparepart_cost' => $totalSparepartCost,
                    'total_amount' => $totalAmount,
                ]
            );

            $serviceDetail->load(['serviceRegistration.vehicle', 'mechanic', 'serviceSpareparts.sparepart']);

            return $this->successResponse($serviceDetail, "Rincian teknis {$serviceDetail->detail_id} berhasil diperbarui.");
        });
    }

    /**
     * Hapus pengerjaan teknis servis dan kembalikan stok sparepart (DELETE /api/v1/service-details/{service_detail}).
     */
    public function destroy(ServiceDetail $serviceDetail): JsonResponse
    {
        return DB::transaction(function () use ($serviceDetail) {
            $code = $serviceDetail->detail_id;

            // Kembalikan stok
            foreach ($serviceDetail->serviceSpareparts as $item) {
                Sparepart::where('id', $item->sparepart_id)->increment('stock', $item->quantity);
            }

            $serviceDetail->delete();

            return $this->successResponse(null, "Rincian teknis {$code} berhasil dihapus dan seluruh stok sparepart telah dikembalikan.");
        });
    }
}
