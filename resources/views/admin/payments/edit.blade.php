@extends('layouts.admin')

@section('title', "Edit Transaksi {$payment->payment_id} | MOTOVEL")
@section('header_title', 'Edit Transaksi Kasir')
@section('header_subtitle', "Perbarui rincian kasir dan status pelunasan transaksi {$payment->payment_id}.")

@section('content')
<div class="max-w-3xl" x-data="paymentEditForm()">
    <div class="bg-[#191A1F] border border-[#303137] rounded-2xl p-6 sm:p-8 shadow-xl">
        <form method="POST" action="{{ route('admin.payments.update', $payment->id) }}" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- Invoice Header Card -->
            <div class="p-4 rounded-xl bg-[#111216] border border-[#303137] flex flex-wrap items-center justify-between gap-4">
                <div>
                    <span class="text-xs uppercase tracking-wider text-[#92939A]">Nomor Tagihan Kasir</span>
                    <div class="font-mono text-base font-bold text-[#b91a19]">{{ $payment->payment_id }}</div>
                    <div class="text-xs text-[#F4F2EF] mt-0.5">
                        Servis: <a href="{{ route('admin.services.show', $payment->service_registration_id) }}" class="font-mono hover:underline text-[#b91a19]">{{ $payment->serviceRegistration->service_id ?? '-' }}</a>
                        : Plat {{ $payment->serviceRegistration->vehicle->plate_number ?? '-' }}
                    </div>
                </div>
                <div class="text-right">
                    <span class="text-xs uppercase tracking-wider text-[#92939A]">Pelanggan</span>
                    <div class="font-medium text-xs text-[#F4F2EF]">{{ $payment->serviceRegistration->customer->name ?? '-' }}</div>
                    <div class="font-mono text-xs text-[#92939A] mt-0.5">{{ $payment->serviceRegistration->customer->phone ?? '' }}</div>
                </div>
            </div>

            <!-- Rincian Biaya Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <!-- Biaya Jasa Servis -->
                <div>
                    <label for="service_cost" class="block text-xs uppercase tracking-wider text-[#92939A] font-semibold mb-2">
                        Biaya Jasa Servis (Rp) <span class="text-[#b91a19]">*</span>
                    </label>
                    <div class="relative">
                        <span class="absolute left-4 top-1/2 -translate-y-1/2 text-xs font-mono text-[#92939A]">Rp</span>
                        <input type="number" 
                               name="service_cost" 
                               id="service_cost" 
                               x-model.number="serviceCost"
                               min="0" 
                               step="1000"
                               required
                               class="w-full bg-[#111216] border @error('service_cost') border-[#b91a19] @else border-[#303137] @enderror rounded-xl pl-12 pr-4 py-3 text-sm font-mono text-[#F4F2EF] focus:outline-none focus:border-[#9a1312] focus:ring-1 focus:ring-[#9a1312]">
                    </div>
                    @error('service_cost')
                        <p class="mt-1.5 text-xs text-[#b91a19]">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Biaya Suku Cadang -->
                <div>
                    <label for="sparepart_cost" class="block text-xs uppercase tracking-wider text-[#92939A] font-semibold mb-2">
                        Biaya Total Suku Cadang (Rp) <span class="text-[#b91a19]">*</span>
                    </label>
                    <div class="relative">
                        <span class="absolute left-4 top-1/2 -translate-y-1/2 text-xs font-mono text-[#92939A]">Rp</span>
                        <input type="number" 
                               name="sparepart_cost" 
                               id="sparepart_cost" 
                               x-model.number="sparepartCost"
                               min="0" 
                               step="1000"
                               required
                               class="w-full bg-[#111216] border @error('sparepart_cost') border-[#b91a19] @else border-[#303137] @enderror rounded-xl pl-12 pr-4 py-3 text-sm font-mono text-[#F4F2EF] focus:outline-none focus:border-[#9a1312] focus:ring-1 focus:ring-[#9a1312]">
                    </div>
                    @error('sparepart_cost')
                        <p class="mt-1.5 text-xs text-[#b91a19]">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Grand Total Highlight Card -->
            <div class="p-5 rounded-xl bg-[#111216] border border-[#303137] flex items-center justify-between">
                <div>
                    <span class="text-xs uppercase tracking-wider text-[#92939A]">Total Tagihan Yang Harus Dibayar</span>
                    <div class="text-xs text-[#92939A] mt-0.5">Biaya Jasa Mekanik + Seluruh Suku Cadang</div>
                </div>
                <div class="text-right">
                    <span class="font-mono text-2xl font-bold text-[#b91a19]">
                        Rp <span x-text="formatRupiah(totalAmount())">0</span>
                    </span>
                </div>
            </div>

            <!-- Metode & Status Kasir Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <!-- Metode Pembayaran -->
                <div>
                    <label for="payment_type" class="block text-xs uppercase tracking-wider text-[#92939A] font-semibold mb-2">
                        Metode Pembayaran <span class="text-[#b91a19]">*</span>
                    </label>
                    <select name="payment_type" id="payment_type" required class="w-full bg-[#111216] border @error('payment_type') border-[#b91a19] @else border-[#303137] @enderror rounded-xl px-4 py-3 text-sm text-[#F4F2EF] focus:outline-none focus:border-[#9a1312]">
                        <option value="cash" {{ old('payment_type', $payment->payment_type) == 'cash' ? 'selected' : '' }}>Tunai / Cash</option>
                        <option value="non-cash" {{ old('payment_type', $payment->payment_type) == 'non-cash' ? 'selected' : '' }}>Non-Tunai / QRIS / Transfer Bank</option>
                    </select>
                    @error('payment_type')
                        <p class="mt-1.5 text-xs text-[#b91a19]">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Status Pembayaran -->
                <div>
                    <label for="status" class="block text-xs uppercase tracking-wider text-[#92939A] font-semibold mb-2">
                        Status Pembayaran <span class="text-[#b91a19]">*</span>
                    </label>
                    <select name="status" id="status" required class="w-full bg-[#111216] border @error('status') border-[#b91a19] @else border-[#303137] @enderror rounded-xl px-4 py-3 text-sm text-[#F4F2EF] focus:outline-none focus:border-[#9a1312]">
                        <option value="paid" {{ old('status', $payment->status) == 'paid' ? 'selected' : '' }}>Lunas (Paid)</option>
                        <option value="pending" {{ old('status', $payment->status) == 'pending' ? 'selected' : '' }}>Menunggu Pembayaran (Pending)</option>
                    </select>
                    @error('status')
                        <p class="mt-1.5 text-xs text-[#b91a19]">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Tanggal Bayar -->
            <div>
                <label for="payment_date" class="block text-xs uppercase tracking-wider text-[#92939A] font-semibold mb-2">
                    Tanggal Pelunasan Kasir
                </label>
                <input type="date" 
                       name="payment_date" 
                       id="payment_date" 
                       value="{{ old('payment_date', $payment->payment_date ? \Carbon\Carbon::parse($payment->payment_date)->format('Y-m-d') : date('Y-m-d')) }}" 
                       class="w-full bg-[#111216] border @error('payment_date') border-[#b91a19] @else border-[#303137] @enderror rounded-xl px-4 py-3 text-sm text-[#F4F2EF] focus:outline-none focus:border-[#9a1312]">
                @error('payment_date')
                    <p class="mt-1.5 text-xs text-[#b91a19]">{{ $message }}</p>
                @enderror
            </div>

            <!-- Catatan Tambahan -->
            <div>
                <label for="notes" class="block text-xs uppercase tracking-wider text-[#92939A] font-semibold mb-2">
                    Catatan Kasir / Keterangan Transaksi
                </label>
                <textarea name="notes" 
                          id="notes" 
                          rows="2" 
                          class="w-full bg-[#111216] border @error('notes') border-[#b91a19] @else border-[#303137] @enderror rounded-xl px-4 py-3 text-sm text-[#F4F2EF] focus:outline-none focus:border-[#9a1312]">{{ old('notes', $payment->notes) }}</textarea>
                @error('notes')
                    <p class="mt-1.5 text-xs text-[#b91a19]">{{ $message }}</p>
                @enderror
            </div>

            <!-- Submit Button Bar -->
            <div class="flex items-center justify-end gap-4 pt-4 border-t border-[#303137]">
                <a href="{{ route('admin.payments.index') }}" class="px-5 py-2.5 rounded-xl border border-[#303137] text-xs font-semibold text-[#92939A] hover:text-[#F4F2EF] hover:bg-[#222329] transition-colors">
                    Batal
                </a>
                <button type="submit" class="bg-[#9a1312] hover:bg-[#b91a19] text-white text-xs uppercase tracking-wider font-semibold py-2.5 px-6 rounded-xl shadow-md transition-colors">
                    Perbarui Transaksi Kasir
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function paymentEditForm() {
    return {
        serviceCost: {{ old('service_cost', $payment->service_cost) }},
        sparepartCost: {{ old('sparepart_cost', $payment->sparepart_cost) }},
        totalAmount() {
            return (this.serviceCost || 0) + (this.sparepartCost || 0);
        },
        formatRupiah(val) {
            return new Intl.NumberFormat('id-ID').format(val || 0);
        }
    }
}
</script>
@endsection
