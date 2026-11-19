<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\BaseApiController;
use App\Models\Customer;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CustomerController extends BaseApiController
{
    /**
     * Tampilkan daftar pelanggan (GET /api/v1/customers).
     */
    public function index(Request $request): JsonResponse
    {
        $search = $request->query('search');

        $customers = Customer::withCount(['vehicles', 'serviceRegistrations'])
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                        ->orWhere('customer_id', 'like', "%{$search}%")
                        ->orWhere('phone', 'like', "%{$search}%")
                        ->orWhere('occupation', 'like', "%{$search}%");
                });
            })
            ->latest('id')
            ->paginate($request->query('per_page', 10));

        return $this->successResponse($customers, 'Daftar pelanggan berhasil diambil.');
    }

    /**
     * Simpan data pelanggan baru (POST /api/v1/customers).
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:20', 'unique:customers,phone'],
            'address' => ['required', 'string', 'max:1000'],
            'occupation' => ['nullable', 'string', 'max:100'],
        ]);

        $customer = Customer::create($validated);

        return $this->successResponse($customer, 'Pelanggan baru berhasil ditambahkan.', 201);
    }

    /**
     * Tampilkan detail pelanggan beserta unit motor dan riwayat servis (GET /api/v1/customers/{customer}).
     */
    public function show(Customer $customer): JsonResponse
    {
        $customer->load(['vehicles', 'serviceRegistrations.serviceDetail.mechanic', 'serviceRegistrations.payment']);

        return $this->successResponse($customer, 'Detail pelanggan berhasil diambil.');
    }

    /**
     * Perbarui data pelanggan (PUT/PATCH /api/v1/customers/{customer}).
     */
    public function update(Request $request, Customer $customer): JsonResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:20', Rule::unique('customers', 'phone')->ignore($customer->id)],
            'address' => ['required', 'string', 'max:1000'],
            'occupation' => ['nullable', 'string', 'max:100'],
        ]);

        $customer->update($validated);

        return $this->successResponse($customer, 'Data pelanggan berhasil diperbarui.');
    }

    /**
     * Hapus data pelanggan (DELETE /api/v1/customers/{customer}).
     */
    public function destroy(Customer $customer): JsonResponse
    {
        $id = $customer->customer_id;
        $customer->delete();

        return $this->successResponse(null, "Pelanggan {$id} berhasil dihapus dari sistem.");
    }
}
