<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\ServiceRegistration;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PaymentController extends Controller
{
    /**
     * Tampilkan daftar transaksi pembayaran kasir bengkel.
     */
    public function index(Request $request): View
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
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('admin.payments.index', compact('payments', 'search', 'status'));
    }

    /**
     * Tampilkan form pembuatan invoice kasir pembayaran baru.
     */
    public function create(Request $request): View
    {
        $selectedServiceId = $request->query('service_id');

        $services = ServiceRegistration::with(['vehicle', 'customer', 'serviceDetail.serviceSpareparts'])
            ->whereDoesntHave('payment')
            ->orWhere('id', $selectedServiceId)
            ->latest()
            ->get();

        return view('admin.payments.create', compact('services', 'selectedServiceId'));
    }

    /**
     * Simpan transaksi pembayaran kasir.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'service_registration_id' => ['required', 'exists:service_registrations,id', 'unique:payments,service_registration_id'],
            'service_cost' => ['required', 'numeric', 'min:0'],
            'sparepart_cost' => ['required', 'numeric', 'min:0'],
            'payment_type' => ['required', 'in:cash,non-cash'],
            'status' => ['required', 'in:pending,paid'],
            'notes' => ['nullable', 'string', 'max:500'],
            'payment_date' => ['nullable', 'date'],
        ], [
            'service_registration_id.required' => 'Pilih pendaftaran servis untuk pembayaran.',
            'service_registration_id.unique' => 'Servis ini sudah memiliki catatan pembayaran kasir.',
            'payment_type.required' => 'Pilih metode pembayaran (Cash atau Non-cash).',
            'status.required' => 'Tentukan status pembayaran.',
        ]);

        // Kalkulasi total otomatis
        $validated['total_amount'] = $validated['service_cost'] + $validated['sparepart_cost'];

        if ($validated['status'] === 'paid' && empty($validated['payment_date'])) {
            $validated['payment_date'] = Carbon::now()->toDateString();
        }

        $payment = Payment::create($validated);

        return redirect()->route('admin.payments.index')
            ->with('success', "Transaksi kasir {$payment->payment_id} berhasil disimpan.");
    }

    /**
     * Tampilkan detail pembayaran / struk invoice kasir.
     */
    public function show(Payment $payment): View
    {
        $payment->load(['serviceRegistration.vehicle', 'serviceRegistration.customer', 'serviceRegistration.serviceDetail.mechanic', 'serviceRegistration.serviceDetail.serviceSpareparts.sparepart']);

        return view('admin.payments.show', compact('payment'));
    }

    /**
     * Tampilkan form edit pembayaran.
     */
    public function edit(Payment $payment): View
    {
        $payment->load(['serviceRegistration.vehicle', 'serviceRegistration.customer']);

        return view('admin.payments.edit', compact('payment'));
    }

    /**
     * Perbarui data pembayaran kasir.
     */
    public function update(Request $request, Payment $payment): RedirectResponse
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

        return redirect()->route('admin.payments.index')
            ->with('success', "Transaksi pembayaran {$payment->payment_id} berhasil diperbarui.");
    }

    /**
     * Hapus data transaksi kasir.
     */
    public function destroy(Payment $payment): RedirectResponse
    {
        $code = $payment->payment_id;
        $payment->delete();

        return redirect()->route('admin.payments.index')
            ->with('success', "Transaksi kasir {$code} berhasil dihapus.");
    }

    /**
     * Cetak Struk Pembayaran Kasir (Invoice Print View).
     */
    public function print(Payment $payment): View
    {
        $payment->load(['serviceRegistration.vehicle', 'serviceRegistration.customer', 'serviceRegistration.serviceDetail.mechanic', 'serviceRegistration.serviceDetail.serviceSpareparts.sparepart']);

        return view('admin.payments.print', compact('payment'));
    }
}
