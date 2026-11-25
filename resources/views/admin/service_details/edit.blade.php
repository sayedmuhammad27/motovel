@extends('layouts.admin')

@section('title', "Edit Detail Pengerjaan {$serviceDetail->detail_id} | MOTOVEL")
@section('header_title', 'Edit Rincian Pengerjaan Teknis')
@section('header_subtitle', "Perbarui alokasi teknisi, diagnosis pengerjaan, dan suku cadang untuk {$serviceDetail->detail_id}.")

@section('content')
<div class="max-w-4xl" x-data="serviceDetailEditForm()">
    <div class="bg-[#191A1F] border border-[#303137] rounded-2xl p-6 sm:p-8 shadow-xl">
        <form method="POST" action="{{ route('admin.service-details.update', $serviceDetail->id) }}" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- Service Header Info Card -->
            <div class="p-4 rounded-xl bg-[#111216] border border-[#303137] flex flex-wrap items-center justify-between gap-4">
                <div>
                    <span class="text-xs uppercase tracking-wider text-[#92939A]">Pendaftaran Servis Terkait</span>
                    <div class="font-mono text-base font-bold text-[#b91a19]">
                        {{ $serviceDetail->serviceRegistration->service_id ?? '-' }}
                    </div>
                    <div class="text-xs text-[#F4F2EF] mt-0.5">
                        {{ $serviceDetail->serviceRegistration->vehicle->plate_number ?? '-' }} : {{ $serviceDetail->serviceRegistration->vehicle->brand ?? '' }} {{ $serviceDetail->serviceRegistration->vehicle->model ?? '' }}
                    </div>
                </div>
                <div class="text-right">
                    <span class="text-xs uppercase tracking-wider text-[#92939A]">ID Detail</span>
                    <div class="font-mono text-xs text-[#92939A]">{{ $serviceDetail->detail_id }}</div>
                    <div class="text-xs text-[#92939A] mt-0.5">Terdaftar: {{ $serviceDetail->created_at->format('d/m/Y') }}</div>
                </div>
            </div>

            <!-- Mekanik & Status Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Mekanik -->
                <div>
                    <label for="mechanic_id" class="block text-xs uppercase tracking-wider text-[#92939A] font-semibold mb-2">
                        Mekanik Penanggung Jawab <span class="text-[#b91a19]">*</span>
                    </label>
                    <select name="mechanic_id" id="mechanic_id" required class="w-full bg-[#111216] border @error('mechanic_id') border-[#b91a19] @else border-[#303137] @enderror rounded-xl px-4 py-3 text-sm text-[#F4F2EF] focus:outline-none focus:border-[#9a1312] focus:ring-1 focus:ring-[#9a1312]">
                        @foreach($mechanics as $m)
                            <option value="{{ $m->id }}" {{ old('mechanic_id', $serviceDetail->mechanic_id) == $m->id ? 'selected' : '' }}>
                                {{ $m->name }} (Spesialisasi: {{ $m->specialization }})
                            </option>
                        @endforeach
                    </select>
                    @error('mechanic_id')
                        <p class="mt-1.5 text-xs text-[#b91a19]">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Status Pengerjaan -->
                <div>
                    <label for="service_status" class="block text-xs uppercase tracking-wider text-[#92939A] font-semibold mb-2">
                        Status Pengerjaan <span class="text-[#b91a19]">*</span>
                    </label>
                    <select name="service_status" id="service_status" required class="w-full bg-[#111216] border @error('service_status') border-[#b91a19] @else border-[#303137] @enderror rounded-xl px-4 py-3 text-sm text-[#F4F2EF] focus:outline-none focus:border-[#9a1312]">
                        <option value="in_progress" {{ old('service_status', $serviceDetail->status) == 'in_progress' ? 'selected' : '' }}>Sedang Dikerjakan (In Progress)</option>
                        <option value="completed" {{ old('service_status', $serviceDetail->status) == 'completed' ? 'selected' : '' }}>Pengerjaan Selesai (Completed)</option>
                        <option value="waiting" {{ old('service_status', $serviceDetail->status) == 'waiting' ? 'selected' : '' }}>Menunggu Part / Antre (Waiting)</option>
                        <option value="cancelled" {{ old('service_status', $serviceDetail->status) == 'cancelled' ? 'selected' : '' }}>Dibatalkan (Cancelled)</option>
                    </select>
                    @error('service_status')
                        <p class="mt-1.5 text-xs text-[#b91a19]">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Estimasi & Catatan Diagnosis Teknis -->
            <div>
                <label for="estimation" class="block text-xs uppercase tracking-wider text-[#92939A] font-semibold mb-2">
                    Catatan Diagnosis & Rekomendasi Teknis Mekanik
                </label>
                <textarea name="estimation" 
                          id="estimation" 
                          rows="3" 
                          class="w-full bg-[#111216] border @error('estimation') border-[#b91a19] @else border-[#303137] @enderror rounded-xl px-4 py-3 text-sm text-[#F4F2EF] focus:outline-none focus:border-[#9a1312] focus:ring-1 focus:ring-[#9a1312]">{{ old('estimation', $serviceDetail->estimation) }}</textarea>
                @error('estimation')
                    <p class="mt-1.5 text-xs text-[#b91a19]">{{ $message }}</p>
                @enderror
            </div>

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

            <!-- Bagian Pemakaian Suku Cadang Dinamis -->
            <div class="pt-6 border-t border-[#303137] space-y-4">
                <div class="flex items-center justify-between">
                    <div>
                        <h4 class="text-sm font-bold uppercase tracking-wider text-[#F4F2EF]">Suku Cadang & Bahan yang Digunakan</h4>
                        <p class="text-xs text-[#92939A]">Menyimpan perubahan akan mengembalikan stok sebelumnya dan memperbarui stok baru.</p>
                    </div>
                    <button type="button" 
                            @click="addPart()" 
                            class="inline-flex items-center gap-1.5 bg-[#222329] hover:bg-[#303137] text-white text-xs font-semibold py-2 px-3.5 rounded-xl border border-[#303137] transition-colors">
                        <svg class="w-4 h-4 text-[#b91a19]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                        <span>Tambah Suku Cadang</span>
                    </button>
                </div>

                <div class="space-y-3">
                    <template x-for="(item, index) in items" :key="index">
                        <div class="grid grid-cols-12 gap-3 p-3 rounded-xl bg-[#111216] border border-[#303137] items-center">
                            <!-- Select Part (Col 6) -->
                            <div class="col-span-12 sm:col-span-6">
                                <label class="block text-[11px] text-[#92939A] mb-1">Pilih Part</label>
                                <select :name="'spareparts[' + index + '][id]'" 
                                        x-model="item.id" 
                                        @change="updatePartInfo(index)"
                                        required 
                                        class="w-full bg-[#191A1F] border border-[#303137] rounded-lg px-3 py-2 text-xs text-[#F4F2EF] focus:outline-none focus:border-[#9a1312]">
                                    <option value="">-- Pilih Suku Cadang --</option>
                                    @foreach($spareparts as $sp)
                                        <option value="{{ $sp->id }}" data-price="{{ $sp->price }}" data-stock="{{ $sp->stock }}">
                                            {{ $sp->name }} (Rp {{ number_format($sp->price, 0, ',', '.') }}) [Stok: {{ $sp->stock }}]
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Quantity (Col 2) -->
                            <div class="col-span-4 sm:col-span-2">
                                <label class="block text-[11px] text-[#92939A] mb-1">Jumlah (Qty)</label>
                                <input type="number" 
                                       :name="'spareparts[' + index + '][qty]'" 
                                       x-model.number="item.qty" 
                                       min="1" 
                                       required
                                       class="w-full bg-[#191A1F] border border-[#303137] rounded-lg px-3 py-2 text-xs text-center font-mono text-[#F4F2EF] focus:outline-none focus:border-[#9a1312]">
                            </div>

                            <!-- Subtotal (Col 3) -->
                            <div class="col-span-6 sm:col-span-3">
                                <label class="block text-[11px] text-[#92939A] mb-1">Subtotal Part</label>
                                <div class="px-3 py-2 bg-[#191A1F] border border-[#303137] rounded-lg text-xs font-mono font-bold text-[#F4F2EF] text-right">
                                    Rp <span x-text="formatRupiah(item.price * item.qty)">0</span>
                                </div>
                            </div>

                            <!-- Hapus (Col 1) -->
                            <div class="col-span-2 sm:col-span-1 text-right sm:pt-4">
                                <button type="button" 
                                        @click="removePart(index)" 
                                        class="p-2 text-zinc-500 hover:text-[#b91a19] transition-colors" 
                                        title="Hapus Baris">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                </button>
                            </div>
                        </div>
                    </template>

                    <div x-show="items.length === 0" class="p-4 rounded-xl bg-[#111216]/50 border border-dashed border-[#303137] text-center text-xs text-[#92939A]">
                        Belum ada suku cadang yang digunakan.
                    </div>
                </div>

                <!-- Total Kalkulasi Summary -->
                <div class="p-4 rounded-xl bg-[#111216] border border-[#303137] space-y-2 text-xs">
                    <div class="flex justify-between text-[#92939A]">
                        <span>Total Biaya Jasa:</span>
                        <span class="font-mono font-semibold text-[#F4F2EF]">Rp <span x-text="formatRupiah(serviceCost || 0)">0</span></span>
                    </div>
                    <div class="flex justify-between text-[#92939A]">
                        <span>Total Suku Cadang:</span>
                        <span class="font-mono font-semibold text-[#F4F2EF]">Rp <span x-text="formatRupiah(totalSparepartsCost())">0</span></span>
                    </div>
                    <div class="flex justify-between pt-2 border-t border-[#303137] text-sm font-bold text-[#b91a19]">
                        <span>Grand Total (Jasa + Part):</span>
                        <span class="font-mono text-base">Rp <span x-text="formatRupiah(grandTotal())">0</span></span>
                    </div>
                </div>
            </div>

            <!-- Submit Button Bar -->
            <div class="flex items-center justify-end gap-4 pt-4 border-t border-[#303137]">
                <a href="{{ route('admin.service-details.index') }}" class="px-5 py-2.5 rounded-xl border border-[#303137] text-xs font-semibold text-[#92939A] hover:text-[#F4F2EF] hover:bg-[#222329] transition-colors">
                    Batal
                </a>
                <button type="submit" class="bg-[#9a1312] hover:bg-[#b91a19] text-white text-xs uppercase tracking-wider font-semibold py-2.5 px-6 rounded-xl shadow-md transition-colors">
                    Perbarui Rincian Teknis
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function serviceDetailEditForm() {
    return {
        serviceCost: {{ old('service_cost', $serviceDetail->service_cost) }},
        items: [
            @foreach($serviceDetail->serviceSpareparts as $p)
            {
                id: '{{ $p->sparepart_id }}',
                qty: {{ $p->quantity }},
                price: {{ $p->unit_price }},
                stock: {{ $p->sparepart->stock ?? 0 }}
            },
            @endforeach
        ],
        addPart() {
            this.items.push({ id: '', qty: 1, price: 0, stock: 0 });
        },
        removePart(index) {
            this.items.splice(index, 1);
        },
        updatePartInfo(index) {
            const selectEl = document.querySelectorAll("select[name^='spareparts'][name$='[id]']")[index];
            if (selectEl && selectEl.selectedOptions[0]) {
                const opt = selectEl.selectedOptions[0];
                this.items[index].price = parseInt(opt.getAttribute('data-price')) || 0;
                this.items[index].stock = parseInt(opt.getAttribute('data-stock')) || 0;
            }
        },
        totalSparepartsCost() {
            return this.items.reduce((sum, item) => sum + ((item.price || 0) * (item.qty || 0)), 0);
        },
        grandTotal() {
            return (this.serviceCost || 0) + this.totalSparepartsCost();
        },
        formatRupiah(val) {
            return new Intl.NumberFormat('id-ID').format(val || 0);
        }
    }
}
</script>
@endsection
