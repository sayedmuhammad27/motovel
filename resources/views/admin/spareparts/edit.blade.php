@extends('layouts.admin')

@section('title', "Edit {$sparepart->name} | MOTOVEL")
@section('header_title', 'Edit Suku Cadang')
@section('header_subtitle', "Perbarui data suku cadang ({$sparepart->sparepart_id}) pada katalog inventaris.")

@section('content')
<div class="max-w-2xl">
    <div class="bg-[#191A1F] border border-[#303137] rounded-2xl p-6 sm:p-8 shadow-xl">
        <form method="POST" action="{{ route('admin.spareparts.update', $sparepart->id) }}" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- ID Badge -->
            <div class="flex items-center justify-between p-4 rounded-xl bg-[#111216] border border-[#303137]">
                <div>
                    <span class="text-xs uppercase tracking-wider text-[#92939A]">Kode Suku Cadang</span>
                    <div class="font-mono text-base font-bold text-[#b91a19]">{{ $sparepart->sparepart_id }}</div>
                </div>
                <div class="text-right">
                    <span class="text-xs uppercase tracking-wider text-[#92939A]">Total Dipakai Servis</span>
                    <div class="font-mono text-xs text-[#F4F2EF]">{{ $sparepart->serviceDetails()->count() }} kali pengerjaan</div>
                </div>
            </div>

            <!-- Nama Sparepart -->
            <div>
                <label for="name" class="block text-xs uppercase tracking-wider text-[#92939A] font-semibold mb-2">
                    Nama Suku Cadang / Material <span class="text-[#b91a19]">*</span>
                </label>
                <input type="text" 
                       name="name" 
                       id="name" 
                       value="{{ old('name', $sparepart->name) }}" 
                       required 
                       class="w-full bg-[#111216] border @error('name') border-[#b91a19] @else border-[#303137] @enderror rounded-xl px-4 py-3 text-sm text-[#F4F2EF] focus:outline-none focus:border-[#9a1312] focus:ring-1 focus:ring-[#9a1312]">
                @error('name')
                    <p class="mt-1.5 text-xs text-[#b91a19]">{{ $message }}</p>
                @enderror
            </div>

            <!-- Kategori -->
            <div>
                <label for="category" class="block text-xs uppercase tracking-wider text-[#92939A] font-semibold mb-2">
                    Kategori Suku Cadang <span class="text-[#b91a19]">*</span>
                </label>
                <input type="text" 
                       name="category" 
                       id="category" 
                       value="{{ old('category', $sparepart->category) }}" 
                       required 
                       class="w-full bg-[#111216] border @error('category') border-[#b91a19] @else border-[#303137] @enderror rounded-xl px-4 py-3 text-sm text-[#F4F2EF] focus:outline-none focus:border-[#9a1312] focus:ring-1 focus:ring-[#9a1312]">
                @error('category')
                    <p class="mt-1.5 text-xs text-[#b91a19]">{{ $message }}</p>
                @enderror
            </div>

            <!-- Harga & Stok Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <!-- Harga Satuan -->
                <div>
                    <label for="price" class="block text-xs uppercase tracking-wider text-[#92939A] font-semibold mb-2">
                        Harga Jual Satuan (Rp) <span class="text-[#b91a19]">*</span>
                    </label>
                    <div class="relative">
                        <span class="absolute left-4 top-1/2 -translate-y-1/2 text-xs font-mono text-[#92939A]">Rp</span>
                        <input type="number" 
                               name="price" 
                               id="price" 
                               value="{{ old('price', $sparepart->price) }}" 
                               min="0" 
                               step="500"
                               required
                               class="w-full bg-[#111216] border @error('price') border-[#b91a19] @else border-[#303137] @enderror rounded-xl pl-12 pr-4 py-3 text-sm font-mono text-[#F4F2EF] focus:outline-none focus:border-[#9a1312] focus:ring-1 focus:ring-[#9a1312]">
                    </div>
                    @error('price')
                        <p class="mt-1.5 text-xs text-[#b91a19]">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Stok -->
                <div>
                    <label for="stock" class="block text-xs uppercase tracking-wider text-[#92939A] font-semibold mb-2">
                        Jumlah Stok Gudang <span class="text-[#b91a19]">*</span>
                    </label>
                    <input type="number" 
                           name="stock" 
                           id="stock" 
                           value="{{ old('stock', $sparepart->stock) }}" 
                           min="0" 
                           required
                           class="w-full bg-[#111216] border @error('stock') border-[#b91a19] @else border-[#303137] @enderror rounded-xl px-4 py-3 text-sm font-mono text-[#F4F2EF] focus:outline-none focus:border-[#9a1312] focus:ring-1 focus:ring-[#9a1312]">
                    @error('stock')
                        <p class="mt-1.5 text-xs text-[#b91a19]">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Deskripsi -->
            <div>
                <label for="description" class="block text-xs uppercase tracking-wider text-[#92939A] font-semibold mb-2">
                    Deskripsi / Spesifikasi
                </label>
                <textarea name="description" 
                          id="description" 
                          rows="3" 
                          class="w-full bg-[#111216] border @error('description') border-[#b91a19] @else border-[#303137] @enderror rounded-xl px-4 py-3 text-sm text-[#F4F2EF] focus:outline-none focus:border-[#9a1312] focus:ring-1 focus:ring-[#9a1312]">{{ old('description', $sparepart->description) }}</textarea>
                @error('description')
                    <p class="mt-1.5 text-xs text-[#b91a19]">{{ $message }}</p>
                @enderror
            </div>

            <!-- Submit Button Bar -->
            <div class="flex items-center justify-end gap-4 pt-4 border-t border-[#303137]">
                <a href="{{ route('admin.spareparts.index') }}" class="px-5 py-2.5 rounded-xl border border-[#303137] text-xs font-semibold text-[#92939A] hover:text-[#F4F2EF] hover:bg-[#222329] transition-colors">
                    Batal
                </a>
                <button type="submit" class="bg-[#9a1312] hover:bg-[#b91a19] text-white text-xs uppercase tracking-wider font-semibold py-2.5 px-6 rounded-xl shadow-md transition-colors">
                    Perbarui Suku Cadang
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
