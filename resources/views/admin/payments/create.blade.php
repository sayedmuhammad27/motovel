@extends('layouts.admin')

@section('title', 'Catat Pembayaran Kasir | MOTOVEL')
@section('header_title', 'Catat Transaksi Kasir Baru')
@section('header_subtitle', 'Terbitkan lembar tagihan pembayaran servis motor pelanggan dan catat pelunasannya.')

@section('content')
<div class="max-w-3xl" x-data="paymentForm()">
    <div class="bg-[#191A1F] border border-[#303137] rounded-2xl p-6 sm:p-8 shadow-xl">
        <form method="POST" action="{{ route('admin.payments.store') }}" class="space-y-6">
            @csrf

            <!-- Pilihan Servis -->
            <div>
                <label for="service_registration_id" class="block text-xs uppercase tracking-wider text-[#92939A] font-semibold mb-2">
                    Pilih Pendaftaran Servis <span class="text-[#E23B3B]">*</span>
                </label>
                <select name="service_registration_id" 
                        id="service_registration_id" 
                        required 
                        @change="onServiceSelect($event)"
                        class="w-full bg-[#111216] border @error('service_registration_id') border-[#E23B3B] @else border-[#303137] @enderror rounded-xl px-4 py-3 text-sm text-[#F4F2EF] focus:outline-none focus:border-[#C62828] focus:ring-1 focus:ring-[#C62828]">
                    <option value="">-- Pilih Servis Motor --</option>
                    @foreach($services as $s)
                        @php
                            $sCost = $s->serviceDetail ? $s->serviceDetail->service_cost : 0;
                            $pCost = $s->serviceDetail ? $s->serviceDetail->serviceSpareparts->sum('subtotal') : 0;
                        @endphp
                        <option value="{{ $s->id }}" 
                                data-service-cost="{{ $sCost }}" 
                                data-sparepart-cost="{{ $pCost }}"
                                {{ (old('service_registration_id') == $s->id || $selectedServiceId == $s->id) ? 'selected' : '' }}>
                            {{ $s->service_id }} : {{ $s->vehicle->plate_number ?? '-' }} ({{ $s->customer->name ?? '-' }}) [Status: {{ ucfirst($s->status) }}]
                        </option>
                    @endforeach
                </select>
                @error('service_registration_id')
                    <p class="mt-1.5 text-xs text-[#E23B3B]">{{ $message }}</p>
                @enderror
            </div>

            <!-- Rincian Biaya Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <!-- Biaya Jasa Servis -->
                <div>
                    <label for="service_cost" class="block text-xs uppercase tracking-wider text-[#92939A] font-semibold mb-2">
                        Biaya Jasa Servis (Rp) <span class="text-[#E23B3B]">*</span>
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
                               class="w-full bg-[#111216] border @error('service_cost') border-[#E23B3B] @else border-[#303137] @enderror rounded-xl pl-12 pr-4 py-3 text-sm font-mono text-[#F4F2EF] focus:outline-none focus:border-[#C62828] focus:ring-1 focus:ring-[#C62828]">
                    </div>
                    @error('service_cost')
                        <p class="mt-1.5 text-xs text-[#E23B3B]">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Biaya Suku Cadang -->
                <div>
                    <label for="sparepart_cost" class="block text-xs uppercase tracking-wider text-[#92939A] font-semibold mb-2">
                        Biaya Total Suku Cadang (Rp) <span class="text-[#E23B3B]">*</span>
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
                               class="w-full bg-[#111216] border @error('sparepart_cost') border-[#E23B3B] @else border-[#303137] @enderror rounded-xl pl-12 pr-4 py-3 text-sm font-mono text-[#F4F2EF] focus:outline-none focus:border-[#C62828] focus:ring-1 focus:ring-[#C62828]">
                    </div>
                    @error('sparepart_cost')
                        <p class="mt-1.5 text-xs text-[#E23B3B]">{{ $message }}</p>
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
                    <span class="font-mono text-2xl font-bold text-[#E23B3B]">
                        Rp <span x-text="formatRupiah(totalAmount())">0</span>
                    </span>
                </div>
            </div>

            <!-- Metode & Status Kasir Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <!-- Metode Pembayaran -->
                <div>
                    <label for="payment_type" class="block text-xs uppercase tracking-wider text-[#92939A] font-semibold mb-2">
                        Metode Pembayaran <span class="text-[#E23B3B]">*</span>
                    </label>
                    <select name="payment_type" id="payment_type" required class="w-full bg-[#111216] border @error('payment_type') border-[#E23B3B] @else border-[#303137] @enderror rounded-xl px-4 py-3 text-sm text-[#F4F2EF] focus:outline-none focus:border-[#C62828]">
                        <option value="cash" {{ old('payment_type') == 'cash' ? 'selected' : '' }}>Tunai / Cash</option>
                        <option value="non-cash" {{ old('payment_type') == 'non-cash' ? 'selected' : '' }}>Non-Tunai / QRIS / Transfer Bank</option>
                    </select>
                    @error('payment_type')
                        <p class="mt-1.5 text-xs text-[#E23B3B]">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Status Pembayaran -->
                <div>
                    <label for="status" class="block text-xs uppercase tracking-wider text-[#92939A] font-semibold mb-2">
                        Status Pembayaran <span class="text-[#E23B3B]">*</span>
                    </label>
                    <select name="status" id="status" required class="w-full bg-[#111216] border @error('status') border-[#E23B3B] @else border-[#303137] @enderror rounded-xl px-4 py-3 text-sm text-[#F4F2EF] focus:outline-none focus:border-[#C62828]">
                        <option value="paid" {{ old('status', 'paid') == 'paid' ? 'selected' : '' }}>Lunas (Paid)</option>
                        <option value="pending" {{ old('status') == 'pending' ? 'selected' : '' }}>Menunggu Pembayaran (Pending)</option>
                    </select>
                    @error('status')
                        <p class="mt-1.5 text-xs text-[#E23B3B]">{{ $message }}</p>
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
                       value="{{ old('payment_date', date('Y-m-d')) }}" 
                       class="w-full bg-[#111216] border @error('payment_date') border-[#E23B3B] @else border-[#303137] @enderror rounded-xl px-4 py-3 text-sm text-[#F4F2EF] focus:outline-none focus:border-[#C62828]">
                @error('payment_date')
                    <p class="mt-1.5 text-xs text-[#E23B3B]">{{ $message }}</p>
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
                          placeholder="Nomor referensi transfer bank, kasir bertugas, potongan promo jika ada..."
                          class="w-full bg-[#111216] border @error('notes') border-[#E23B3B] @else border-[#303137] @enderror rounded-xl px-4 py-3 text-sm text-[#F4F2EF] placeholder-[#92939A]/40 focus:outline-none focus:border-[#C62828]">{{ old('notes') }}</textarea>
                @error('notes')
                    <p class="mt-1.5 text-xs text-[#E23B3B]">{{ $message }}</p>
                @enderror
            </div>

            <!-- Submit Button Bar -->
            <div class="flex items-center justify-end gap-4 pt-4 border-t border-[#303137]">
                <a href="{{ route('admin.payments.index') }}" class="px-5 py-2.5 rounded-xl border border-[#303137] text-xs font-semibold text-[#92939A] hover:text-[#F4F2EF] hover:bg-[#222329] transition-colors">
                    Batal
                </a>
                <button type="submit" class="bg-[#C62828] hover:bg-[#E23B3B] text-white text-xs uppercase tracking-wider font-semibold py-2.5 px-6 rounded-xl shadow-md transition-colors">
                    Simpan Transaksi Kasir
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function paymentForm() {
    return {
        serviceCost: {{ old('service_cost', 0) }},
        sparepartCost: {{ old('sparepart_cost', 0) }},
        init() {
            // Cek apakah ada selected option saat pertama dimuat
            const selectEl = document.getElementById('service_registration_id');
            if (selectEl && selectEl.value) {
                const opt = selectEl.selectedOptions[0];
                if (this.serviceCost === 0 && this.sparepartCost === 0) {
                    this.serviceCost = parseInt(opt.getAttribute('data-service-cost')) || 0;
                    this.sparepartCost = parseInt(opt.getAttribute('data-sparepart-cost')) || 0;
                }
            }
        },
        onServiceSelect(event) {
            const opt = event.target.selectedOptions[0];
            if (opt) {
                this.serviceCost = parseInt(opt.getAttribute('data-service-cost')) || 0;
                this.sparepartCost = parseInt(opt.getAttribute('data-sparepart-cost')) || 0;
            }
        },
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
