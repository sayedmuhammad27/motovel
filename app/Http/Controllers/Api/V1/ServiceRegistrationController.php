<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\BaseApiController;
use App\Models\ServiceRegistration;
use App\Models\Vehicle;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ServiceRegistrationController extends BaseApiController
{
    /**
     * Tampilkan seluruh antrean pendaftaran servis (GET /api/v1/services).
     */
    public function index(Request $request): JsonResponse
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
                                ->orWhere('phone', 'like', "%{$search}%");
                        });
                });
            })
            ->latest('service_date')
            ->latest('id')
            ->paginate($request->query('per_page', 10));

        return $this->successResponse($services, 'Daftar antrean servis berhasil diambil.');
    }

    /**
     * Daftarkan servis sepeda motor baru (POST /api/v1/services).
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'vehicle_id' => ['required', 'exists:vehicles,id'],
            'complaint' => ['required', 'string', 'min:5', 'max:1000'],
            'service_date' => ['required', 'date'],
            'status' => ['required', 'in:waiting,in_progress,completed,cancelled'],
        ]);

        $vehicle = Vehicle::findOrFail($validated['vehicle_id']);
        $validated['customer_id'] = $vehicle->customer_id;

        $service = ServiceRegistration::create($validated);
        $service->load(['vehicle.customer', 'customer']);

        return $this->successResponse($service, "Pendaftaran servis {$service->service_id} berhasil dibuat.", 201);
    }

    /**
     * Tampilkan detail pendaftaran servis (GET /api/v1/services/{service}).
     */
    public function show(ServiceRegistration $service): JsonResponse
    {
        $service->load(['vehicle.customer', 'customer', 'serviceDetail.mechanic', 'serviceDetail.serviceSpareparts.sparepart', 'payment']);

        return $this->successResponse($service, 'Detail pendaftaran servis berhasil diambil.');
    }

    /**
     * Perbarui data pendaftaran servis (PUT/PATCH /api/v1/services/{service}).
     */
    public function update(Request $request, ServiceRegistration $service): JsonResponse
    {
        $validated = $request->validate([
            'vehicle_id' => ['required', 'exists:vehicles,id'],
            'complaint' => ['required', 'string', 'min:5', 'max:1000'],
            'service_date' => ['required', 'date'],
            'status' => ['required', 'in:waiting,in_progress,completed,cancelled'],
        ]);

        $vehicle = Vehicle::findOrFail($validated['vehicle_id']);
        $validated['customer_id'] = $vehicle->customer_id;

        $service->update($validated);
        $service->load(['vehicle.customer', 'customer']);

        return $this->successResponse($service, "Pendaftaran servis {$service->service_id} berhasil diperbarui.");
    }

    /**
     * Hapus pendaftaran servis (DELETE /api/v1/services/{service}).
     */
    public function destroy(ServiceRegistration $service): JsonResponse
    {
        $code = $service->service_id;
        $service->delete();

        return $this->successResponse(null, "Pendaftaran servis {$code} berhasil dihapus dari sistem.");
    }
}
