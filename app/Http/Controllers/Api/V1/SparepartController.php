<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\BaseApiController;
use App\Models\Sparepart;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SparepartController extends BaseApiController
{
    /**
     * Tampilkan katalog inventaris suku cadang (GET /api/v1/spareparts).
     */
    public function index(Request $request): JsonResponse
    {
        $search = $request->query('search');
        $category = $request->query('category');

        $spareparts = Sparepart::withCount('serviceDetails')
            ->when($category, function ($query, $category) {
                $query->where('category', $category);
            })
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                        ->orWhere('sparepart_id', 'like', "%{$search}%")
                        ->orWhere('description', 'like', "%{$search}%");
                });
            })
            ->orderBy('category')
            ->orderBy('name')
            ->paginate($request->query('per_page', 10));

        return $this->successResponse($spareparts, 'Katalog suku cadang berhasil diambil.');
    }

    /**
     * Tambah data suku cadang baru (POST /api/v1/spareparts).
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'category' => ['required', 'string', 'max:100'],
            'price' => ['required', 'numeric', 'min:0'],
            'stock' => ['required', 'integer', 'min:0'],
            'description' => ['nullable', 'string', 'max:1000'],
        ]);

        $sparepart = Sparepart::create($validated);

        return $this->successResponse($sparepart, "Suku cadang {$sparepart->name} berhasil ditambahkan.", 201);
    }

    /**
     * Tampilkan detail suku cadang beserta riwayat pemakaian servis (GET /api/v1/spareparts/{sparepart}).
     */
    public function show(Sparepart $sparepart): JsonResponse
    {
        $sparepart->load(['serviceDetails.serviceRegistration.vehicle', 'serviceDetails.mechanic']);

        return $this->successResponse($sparepart, 'Detail suku cadang berhasil diambil.');
    }

    /**
     * Perbarui data suku cadang (PUT/PATCH /api/v1/spareparts/{sparepart}).
     */
    public function update(Request $request, Sparepart $sparepart): JsonResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'category' => ['required', 'string', 'max:100'],
            'price' => ['required', 'numeric', 'min:0'],
            'stock' => ['required', 'integer', 'min:0'],
            'description' => ['nullable', 'string', 'max:1000'],
        ]);

        $sparepart->update($validated);

        return $this->successResponse($sparepart, "Data suku cadang {$sparepart->name} berhasil diperbarui.");
    }

    /**
     * Hapus suku cadang (DELETE /api/v1/spareparts/{sparepart}).
     */
    public function destroy(Sparepart $sparepart): JsonResponse
    {
        if ($sparepart->serviceDetails()->count() > 0) {
            return $this->errorResponse("Suku cadang {$sparepart->name} tidak dapat dihapus karena tercatat dalam riwayat servis pengerjaan.", null, 422);
        }

        $name = $sparepart->name;
        $sparepart->delete();

        return $this->successResponse(null, "Suku cadang {$name} berhasil dihapus dari inventaris.");
    }
}
