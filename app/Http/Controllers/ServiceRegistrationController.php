<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\ServiceRegistration;
use App\Models\Vehicle;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ServiceRegistrationController extends Controller
{
    /**
     * Tampilkan seluruh daftar pendaftaran servis dengan filter status dan pencarian.
     */
    public function index(Request $request): View
    {
        $search = $request->query('search');
        $status = $request->query('status');

        $services = ServiceRegistration::with(['vehicle.customer', 'customer', 'serviceDetail.mechanic', 'payment'])
            ->when($status, function ($query, $status) {
                $query->where('status', $status);
            })
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('service_id', 'like', "%{$search}%")
                        ->orWhere('complaint', 'like', "%{$search}%")
                        ->orWhereHas('vehicle', function ($vq) use ($search) {
                            $vq->where('plate_number', 'like', "%{$search}%");
                        })
                        ->orWhereHas('customer', function ($cq) use ($search) {
                            $cq->where('name', 'like', "%{$search}%")
                                ->orWhere('customer_id', 'like', "%{$search}%")
                                ->orWhere('phone', 'like', "%{$search}%");
                        });
                });
            })
            ->latest('service_date')
            ->latest('id')
            ->paginate(10)
            ->withQueryString();

        return view('admin.services.index', compact('services', 'search', 'status'));
    }

    /**
     * Tampilkan form pendaftaran servis baru.
     */
    public function create(): View
    {
        $vehicles = Vehicle::with('customer')->orderBy('plate_number')->get();
        $customers = Customer::orderBy('name')->get();

        return view('admin.services.create', compact('vehicles', 'customers'));
    }

    /**
     * Simpan pendaftaran servis baru.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'vehicle_id' => ['required', 'exists:vehicles,id'],
            'complaint' => ['required', 'string', 'min:5', 'max:1000'],
            'service_date' => ['required', 'date'],
            'status' => ['required', 'in:waiting,in_progress,completed,cancelled'],
        ], [
            'vehicle_id.required' => 'Pilih sepeda motor yang akan diservis.',
            'complaint.required' => 'Keluhan atau rincian servis wajib diisi.',
            'service_date.required' => 'Tanggal servis wajib ditentukan.',
            'status.required' => 'Status pendaftaran wajib dipilih.',
        ]);

        // Otomatis tentukan customer_id berdasarkan pemilik kendaraan
        $vehicle = Vehicle::findOrFail($validated['vehicle_id']);
        $validated['customer_id'] = $vehicle->customer_id;

        $service = ServiceRegistration::create($validated);

        return redirect()->route('admin.services.index')
            ->with('success', "Pendaftaran servis {$service->service_id} untuk unit {$vehicle->plate_number} berhasil dibuat.");
    }

    /**
     * Tampilkan detail pendaftaran servis beserta pengerjaan dan pembayarannya.
     */
    public function show(ServiceRegistration $service): View
    {
        $service->load(['vehicle.customer', 'customer', 'serviceDetail.mechanic', 'serviceDetail.serviceSpareparts.sparepart', 'payment']);

        return view('admin.services.show', compact('service'));
    }

    /**
     * Tampilkan form edit pendaftaran servis.
     */
    public function edit(ServiceRegistration $service): View
    {
        $vehicles = Vehicle::with('customer')->orderBy('plate_number')->get();
        $customers = Customer::orderBy('name')->get();

        return view('admin.services.edit', compact('service', 'vehicles', 'customers'));
    }

    /**
     * Perbarui data pendaftaran servis.
     */
    public function update(Request $request, ServiceRegistration $service): RedirectResponse
    {
        $validated = $request->validate([
            'vehicle_id' => ['required', 'exists:vehicles,id'],
            'complaint' => ['required', 'string', 'min:5', 'max:1000'],
            'service_date' => ['required', 'date'],
            'status' => ['required', 'in:waiting,in_progress,completed,cancelled'],
        ], [
            'vehicle_id.required' => 'Pilih sepeda motor.',
            'complaint.required' => 'Keluhan servis wajib diisi.',
            'service_date.required' => 'Tanggal servis wajib ditentukan.',
            'status.required' => 'Status servis wajib dipilih.',
        ]);

        $vehicle = Vehicle::findOrFail($validated['vehicle_id']);
        $validated['customer_id'] = $vehicle->customer_id;

        $service->update($validated);

        return redirect()->route('admin.services.index')
            ->with('success', "Pendaftaran servis {$service->service_id} berhasil diperbarui.");
    }

    /**
     * Hapus pendaftaran servis.
     */
    public function destroy(ServiceRegistration $service): RedirectResponse
    {
        $code = $service->service_id;
        $service->delete();

        return redirect()->route('admin.services.index')
            ->with('success', "Pendaftaran servis {$code} berhasil dihapus dari sistem.");
    }
}
