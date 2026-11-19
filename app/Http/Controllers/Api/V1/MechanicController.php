<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\BaseApiController;
use App\Models\Mechanic;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class MechanicController extends BaseApiController
{
    /**
     * Tampilkan daftar teknisi / mekanik bengkel (GET /api/v1/mechanics).
     */
    public function index(Request $request): JsonResponse
    {
        $search = $request->query('search');

        $mechanics = Mechanic::withCount('serviceDetails')
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                        ->orWhere('mechanic_id', 'like', "%{$search}%")
                        ->orWhere('phone', 'like', "%{$search}%")
                        ->orWhere('address', 'like', "%{$search}%")
                        ->orWhere('specialty', 'like', "%{$search}%");
                });
            })
            ->latest('id')
            ->paginate($request->query('per_page', 10));

        return $this->successResponse($mechanics, 'Daftar mekanik berhasil diambil.');
    }

    /**
     * Daftarkan teknisi baru (POST /api/v1/mechanics).
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:20'],
            'address' => ['required', 'string', 'max:500'],
            'specialty' => ['required', 'string', 'max:255'],
        ]);

        $mechanic = Mechanic::create($validated);

        return $this->successResponse($mechanic, 'Data mekanik baru berhasil ditambahkan.', 201);
    }

    /**
     * Tampilkan detail mekanik beserta riwayat pengerjaan servis (GET /api/v1/mechanics/{mechanic}).
     */
    public function show(Mechanic $mechanic): JsonResponse
    {
        $mechanic->load(['serviceDetails.serviceRegistration.vehicle', 'serviceDetails.serviceRegistration.customer']);

        return $this->successResponse($mechanic, 'Detail data mekanik berhasil diambil.');
    }

    /**
     * Perbarui data mekanik (PUT/PATCH /api/v1/mechanics/{mechanic}).
     */
    public function update(Request $request, Mechanic $mechanic): JsonResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:20'],
            'address' => ['required', 'string', 'max:500'],
            'specialty' => ['required', 'string', 'max:255'],
        ]);

        $mechanic->update($validated);

        return $this->successResponse($mechanic, 'Data mekanik berhasil diperbarui.');
    }

    /**
     * Hapus mekanik (DELETE /api/v1/mechanics/{mechanic}).
     */
    public function destroy(Mechanic $mechanic): JsonResponse
    {
        if ($mechanic->serviceDetails()->count() > 0) {
            return $this->errorResponse("Mekanik {$mechanic->name} tidak dapat dihapus karena tercatat dalam riwayat pengerjaan servis bengkel.", null, 422);
        }

        $name = $mechanic->name;
        $mechanic->delete();

        return $this->successResponse(null, "Data mekanik {$name} berhasil dihapus.");
    }
}
