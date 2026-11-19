@extends('layouts.admin')

@section('title', 'Tambah Mekanik Baru | MOTOVEL')
@section('header_title', 'Registrasi Mekanik Baru')
@section('header_subtitle', 'Tambahkan data teknisi bengkel beserta bidang spesialisasi servis.')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="bg-[#191A1F] border border-[#303137] rounded-2xl p-6 sm:p-8 shadow-xl">
        <form action="{{ route('admin.mechanics.store') }}" method="POST" class="space-y-6">
            @csrf

            <div>
                <label for="name" class="block text-xs font-semibold uppercase tracking-wider text-[#92939A] mb-2">
                    Nama Lengkap Mekanik *
                </label>
                <input type="text" name="name" id="name" value="{{ old('name') }}" required 
                       class="w-full bg-[#111216] border border-[#303137] rounded-xl px-4 py-3 text-sm text-[#F4F2EF] placeholder-[#92939A]/40 focus:outline-none focus:border-[#C62828] focus:ring-1 focus:ring-[#C62828]"
                       placeholder="Contoh: Bambang Sudiro">
                @error('name') <p class="text-xs text-[#E23B3B] mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div>
                    <label for="phone" class="block text-xs font-semibold uppercase tracking-wider text-[#92939A] mb-2">
                        Nomor Handphone / WhatsApp *
                    </label>
                    <input type="text" name="phone" id="phone" value="{{ old('phone') }}" required 
                           class="w-full bg-[#111216] border border-[#303137] rounded-xl px-4 py-3 text-sm text-[#F4F2EF] font-mono placeholder-[#92939A]/40 focus:outline-none focus:border-[#C62828] focus:ring-1 focus:ring-[#C62828]"
                           placeholder="Contoh: 081234567801">
                    @error('phone') <p class="text-xs text-[#E23B3B] mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="specialty" class="block text-xs font-semibold uppercase tracking-wider text-[#92939A] mb-2">
                        Bidang Spesialisasi Keahlian *
                    </label>
                    <input type="text" name="specialty" id="specialty" value="{{ old('specialty') }}" required 
                           class="w-full bg-[#111216] border border-[#303137] rounded-xl px-4 py-3 text-sm text-[#F4F2EF] placeholder-[#92939A]/40 focus:outline-none focus:border-[#C62828] focus:ring-1 focus:ring-[#C62828]"
                           placeholder="Contoh: Sport Tuning, CVT Matic, Kelistrikan ECU">
                    @error('specialty') <p class="text-xs text-[#E23B3B] mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <div>
                <label for="address" class="block text-xs font-semibold uppercase tracking-wider text-[#92939A] mb-2">
                    Alamat Tempat Tinggal *
                </label>
                <textarea name="address" id="address" rows="3" required 
                          class="w-full bg-[#111216] border border-[#303137] rounded-xl p-4 text-sm text-[#F4F2EF] placeholder-[#92939A]/40 focus:outline-none focus:border-[#C62828] focus:ring-1 focus:ring-[#C62828]"
                          placeholder="Alamat domisili lengkap mekanik">{{ old('address') }}</textarea>
                @error('address') <p class="text-xs text-[#E23B3B] mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="pt-4 border-t border-[#303137] flex items-center justify-between">
                <a href="{{ route('admin.mechanics.index') }}" class="text-xs uppercase tracking-wider text-[#92939A] hover:text-[#F4F2EF] transition-colors">
                    Batal
                </a>
                <button type="submit" class="bg-[#C62828] hover:bg-[#E23B3B] text-white text-xs uppercase tracking-wider font-semibold py-3 px-8 rounded-xl shadow-lg transition-colors">
                    Simpan Mekanik
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
