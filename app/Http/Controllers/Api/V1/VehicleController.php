<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\BaseApiController;
use App\Models\Vehicle;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class VehicleController extends BaseApiController
{
    /**
     * Tampilkan daftar sepeda motor (GET /api/v1/vehicles).
     */
    public function index(Request $request): JsonResponse
    {
        $search = $request->query('search');
        $type = $request->query('type');

        $vehicles = Vehicle::with('customer')
            ->withCount('serviceRegistrations')
            ->when($type, function ($query, $type) {
                $query->where('type', $type);
            })
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('plate_number', 'like', "%{$search}%")
                        ->orWhere('stnk_number', 'like', "%{$search}%")
                        ->orWhere('color', 'like', "%{$search}%")
                        ->orWhereHas('customer', function ($cq) use ($search) {
                            $cq->where('name', 'like', "%{$search}%");
                        });
                });
            })
            ->latest('id')
            ->paginate($request->query('per_page', 10));

        return $this->successResponse($vehicles, 'Daftar sepeda motor berhasil diambil.');
    }

    /**
     * Daftarkan sepeda motor baru (POST /api/v1/vehicles).
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'customer_id' => ['required', 'exists:customers,id'],
            'plate_number' => ['required', 'string', 'max:20', 'unique:vehicles,plate_number'],
            'type' => ['required', 'in:matic,manual'],
            'stnk_number' => ['required', 'string', 'max:50'],
            'year' => ['required', 'integer', 'min:1990', 'max:' . (date('Y') + 1)],
            'color' => ['required', 'string', 'max:50'],
        ]);

        $validated['plate_number'] = strtoupper(trim($validated['plate_number']));
        $validated['stnk_number'] = strtoupper(trim($validated['stnk_number']));

        $vehicle = Vehicle::create($validated);
        $vehicle->load('customer');

        return $this->successResponse($vehicle, 'Sepeda motor berhasil didaftarkan.', 201);
    }

    /**
     * Tampilkan detail sepeda motor beserta pemilik dan riwayat servis (GET /api/v1/vehicles/{vehicle}).
     */
    public function show(Vehicle $vehicle): JsonResponse
    {
        $vehicle->load(['customer', 'serviceRegistrations.serviceDetail.mechanic', 'serviceRegistrations.payment']);

        return $this->successResponse($vehicle, 'Detail sepeda motor berhasil diambil.');
    }

    /**
     * Perbarui data sepeda motor (PUT/PATCH /api/v1/vehicles/{vehicle}).
     */
    public function update(Request $request, Vehicle $vehicle): JsonResponse
    {
        $validated = $request->validate([
            'customer_id' => ['required', 'exists:customers,id'],
            'plate_number' => ['required', 'string', 'max:20', Rule::unique('vehicles', 'plate_number')->ignore($vehicle->id)],
            'type' => ['required', 'in:matic,manual'],
            'stnk_number' => ['required', 'string', 'max:50'],
            'year' => ['required', 'integer', 'min:1990', 'max:' . (date('Y') + 1)],
            'color' => ['required', 'string', 'max:50'],
        ]);

        $validated['plate_number'] = strtoupper(trim($validated['plate_number']));
        $validated['stnk_number'] = strtoupper(trim($validated['stnk_number']));

        $vehicle->update($validated);
        $vehicle->load('customer');

        return $this->successResponse($vehicle, 'Data sepeda motor berhasil diperbarui.');
    }

    /**
     * Hapus sepeda motor (DELETE /api/v1/vehicles/{vehicle}).
     */
    public function destroy(Vehicle $vehicle): JsonResponse
    {
        $plate = $vehicle->plate_number;
        $vehicle->delete();

        return $this->successResponse(null, "Unit sepeda motor {$plate} berhasil dihapus dari sistem.");
    }
}
