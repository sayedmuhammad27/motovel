@extends('layouts.admin')

@section('title', 'Tambah Suku Cadang | MOTOVEL')
@section('header_title', 'Tambah Suku Cadang Baru')
@section('header_subtitle', 'Daftarkan sparepart atau oli baru ke dalam katalog inventaris bengkel.')

@section('content')
<div class="max-w-2xl">
    <div class="bg-[#191A1F] border border-[#303137] rounded-2xl p-6 sm:p-8 shadow-xl">
        <form method="POST" action="{{ route('admin.spareparts.store') }}" class="space-y-6">
            @csrf

            <!-- Nama Sparepart -->
            <div>
                <label for="name" class="block text-xs uppercase tracking-wider text-[#92939A] font-semibold mb-2">
                    Nama Suku Cadang / Material <span class="text-[#E23B3B]">*</span>
                </label>
                <input type="text" 
                       name="name" 
                       id="name" 
                       value="{{ old('name') }}" 
                       required 
                       placeholder="Contoh: Motul 7100 10W-40 1L, Busi Iridium NGK CR9EIX"
                       class="w-full bg-[#111216] border @error('name') border-[#E23B3B] @else border-[#303137] @enderror rounded-xl px-4 py-3 text-sm text-[#F4F2EF] placeholder-[#92939A]/40 focus:outline-none focus:border-[#C62828] focus:ring-1 focus:ring-[#C62828]">
                @error('name')
                    <p class="mt-1.5 text-xs text-[#E23B3B]">{{ $message }}</p>
                @enderror
            </div>

            <!-- Kategori -->
            <div>
                <label for="category" class="block text-xs uppercase tracking-wider text-[#92939A] font-semibold mb-2">
                    Kategori Suku Cadang <span class="text-[#E23B3B]">*</span>
                </label>
                <input type="text" 
                       name="category" 
                       id="category" 
                       value="{{ old('category') }}" 
                       required 
                       placeholder="Contoh: Oli Mesin, Sistem Rem, Filter Udara, Transmisi CVT, Busi"
                       class="w-full bg-[#111216] border @error('category') border-[#E23B3B] @else border-[#303137] @enderror rounded-xl px-4 py-3 text-sm text-[#F4F2EF] placeholder-[#92939A]/40 focus:outline-none focus:border-[#C62828] focus:ring-1 focus:ring-[#C62828]">
                @error('category')
                    <p class="mt-1.5 text-xs text-[#E23B3B]">{{ $message }}</p>
                @enderror
            </div>

            <!-- Harga & Stok Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <!-- Harga Satuan -->
                <div>
                    <label for="price" class="block text-xs uppercase tracking-wider text-[#92939A] font-semibold mb-2">
                        Harga Jual Satuan (Rp) <span class="text-[#E23B3B]">*</span>
                    </label>
                    <div class="relative">
                        <span class="absolute left-4 top-1/2 -translate-y-1/2 text-xs font-mono text-[#92939A]">Rp</span>
                        <input type="number" 
                               name="price" 
                               id="price" 
                               value="{{ old('price') }}" 
                               min="0" 
                               step="500"
                               required
                               placeholder="125000"
                               class="w-full bg-[#111216] border @error('price') border-[#E23B3B] @else border-[#303137] @enderror rounded-xl pl-12 pr-4 py-3 text-sm font-mono text-[#F4F2EF] placeholder-[#92939A]/40 focus:outline-none focus:border-[#C62828] focus:ring-1 focus:ring-[#C62828]">
                    </div>
                    @error('price')
                        <p class="mt-1.5 text-xs text-[#E23B3B]">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Stok Awal -->
                <div>
                    <label for="stock" class="block text-xs uppercase tracking-wider text-[#92939A] font-semibold mb-2">
                        Jumlah Stok Awal <span class="text-[#E23B3B]">*</span>
                    </label>
                    <input type="number" 
                           name="stock" 
                           id="stock" 
                           value="{{ old('stock', 10) }}" 
                           min="0" 
                           required
                           class="w-full bg-[#111216] border @error('stock') border-[#E23B3B] @else border-[#303137] @enderror rounded-xl px-4 py-3 text-sm font-mono text-[#F4F2EF] focus:outline-none focus:border-[#C62828] focus:ring-1 focus:ring-[#C62828]">
                    @error('stock')
                        <p class="mt-1.5 text-xs text-[#E23B3B]">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Deskripsi / Spesifikasi -->
            <div>
                <label for="description" class="block text-xs uppercase tracking-wider text-[#92939A] font-semibold mb-2">
                    Deskripsi / Spesifikasi Kompatibilitas
                </label>
                <textarea name="description" 
                          id="description" 
                          rows="3" 
                          placeholder="Spesifikasi teknis, kekentalan, kompatibilitas tipe motor..."
                          class="w-full bg-[#111216] border @error('description') border-[#E23B3B] @else border-[#303137] @enderror rounded-xl px-4 py-3 text-sm text-[#F4F2EF] placeholder-[#92939A]/40 focus:outline-none focus:border-[#C62828] focus:ring-1 focus:ring-[#C62828]">{{ old('description') }}</textarea>
                @error('description')
                    <p class="mt-1.5 text-xs text-[#E23B3B]">{{ $message }}</p>
                @enderror
            </div>

            <!-- Submit Button Bar -->
            <div class="flex items-center justify-end gap-4 pt-4 border-t border-[#303137]">
                <a href="{{ route('admin.spareparts.index') }}" class="px-5 py-2.5 rounded-xl border border-[#303137] text-xs font-semibold text-[#92939A] hover:text-[#F4F2EF] hover:bg-[#222329] transition-colors">
                    Batal
                </a>
                <button type="submit" class="bg-[#C62828] hover:bg-[#E23B3B] text-white text-xs uppercase tracking-wider font-semibold py-2.5 px-6 rounded-xl shadow-md transition-colors">
                    Simpan Suku Cadang
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
