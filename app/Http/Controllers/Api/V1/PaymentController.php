<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\BaseApiController;
use App\Models\Payment;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PaymentController extends BaseApiController
{
    /**
     * Tampilkan seluruh transaksi kasir pembayaran servis (GET /api/v1/payments).
     */
    public function index(Request $request): JsonResponse
    {
        $search = $request->query('search');
        $status = $request->query('status');

        $payments = Payment::with(['serviceRegistration.vehicle', 'serviceRegistration.customer'])
            ->when($status, function ($query, $status) {
                $query->where('status', $status);
            })
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('payment_id', 'like', "%{$search}%")
                        ->orWhere('payment_type', 'like', "%{$search}%")
                        ->orWhere('notes', 'like', "%{$search}%")
                        ->orWhereHas('serviceRegistration', function ($sq) use ($search) {
                            $sq->where('service_id', 'like', "%{$search}%")
                                ->orWhereHas('vehicle', function ($vq) use ($search) {
                                    $vq->where('plate_number', 'like', "%{$search}%");
                                })
                                ->orWhereHas('customer', function ($cq) use ($search) {
                                    $cq->where('name', 'like', "%{$search}%");
                                });
                        });
                });
            })
            ->latest('id')
            ->paginate($request->query('per_page', 10));

        return $this->successResponse($payments, 'Daftar transaksi kasir berhasil diambil.');
    }

    /**
     * Catat transaksi pembayaran baru (POST /api/v1/payments).
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'service_registration_id' => ['required', 'exists:service_registrations,id', 'unique:payments,service_registration_id'],
            'service_cost' => ['required', 'numeric', 'min:0'],
            'sparepart_cost' => ['required', 'numeric', 'min:0'],
            'payment_type' => ['required', 'in:cash,non-cash'],
            'status' => ['required', 'in:pending,paid'],
            'notes' => ['nullable', 'string', 'max:500'],
            'payment_date' => ['nullable', 'date'],
        ]);

        $validated['total_amount'] = $validated['service_cost'] + $validated['sparepart_cost'];

        if ($validated['status'] === 'paid' && empty($validated['payment_date'])) {
            $validated['payment_date'] = Carbon::now()->toDateString();
        }

        $payment = Payment::create($validated);
        $payment->load(['serviceRegistration.vehicle', 'serviceRegistration.customer']);

        return $this->successResponse($payment, "Transaksi pembayaran {$payment->payment_id} berhasil disimpan.", 201);
    }

    /**
     * Tampilkan detail transaksi pembayaran (GET /api/v1/payments/{payment}).
     */
    public function show(Payment $payment): JsonResponse
    {
        $payment->load(['serviceRegistration.vehicle', 'serviceRegistration.customer', 'serviceRegistration.serviceDetail.mechanic', 'serviceRegistration.serviceDetail.serviceSpareparts.sparepart']);

        return $this->successResponse($payment, 'Detail transaksi kasir berhasil diambil.');
    }

    /**
     * Perbarui data transaksi kasir (PUT/PATCH /api/v1/payments/{payment}).
     */
    public function update(Request $request, Payment $payment): JsonResponse
    {
        $validated = $request->validate([
            'service_cost' => ['required', 'numeric', 'min:0'],
            'sparepart_cost' => ['required', 'numeric', 'min:0'],
            'payment_type' => ['required', 'in:cash,non-cash'],
            'status' => ['required', 'in:pending,paid'],
            'notes' => ['nullable', 'string', 'max:500'],
            'payment_date' => ['nullable', 'date'],
        ]);

        $validated['total_amount'] = $validated['service_cost'] + $validated['sparepart_cost'];

        if ($validated['status'] === 'paid' && empty($validated['payment_date'])) {
            $validated['payment_date'] = Carbon::now()->toDateString();
        }

        $payment->update($validated);
        $payment->load(['serviceRegistration.vehicle', 'serviceRegistration.customer']);

        return $this->successResponse($payment, "Transaksi pembayaran {$payment->payment_id} berhasil diperbarui.");
    }

    /**
     * Hapus data transaksi kasir (DELETE /api/v1/payments/{payment}).
     */
    public function destroy(Payment $payment): JsonResponse
    {
        $id = $payment->payment_id;
        $payment->delete();

        return $this->successResponse(null, "Transaksi pembayaran {$id} berhasil dihapus.");
    }
}
