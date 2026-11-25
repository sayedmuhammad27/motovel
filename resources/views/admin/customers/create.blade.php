@extends('layouts.admin')

@section('title', 'Tambah Pelanggan Baru | MOTOVEL')
@section('header_title', 'Registrasi Pelanggan Baru')
@section('header_subtitle', 'Masukkan identitas lengkap pemilik kendaraan untuk arsip bengkel.')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="bg-[#191A1F] border border-[#303137] rounded-2xl p-6 sm:p-8 shadow-xl">
        <form action="{{ route('admin.customers.store') }}" method="POST" class="space-y-6">
            @csrf

            <div>
                <label for="name" class="block text-xs font-semibold uppercase tracking-wider text-[#92939A] mb-2">
                    Nama Lengkap Pelanggan *
                </label>
                <input type="text" name="name" id="name" value="{{ old('name') }}" required 
                       class="w-full bg-[#111216] border border-[#303137] rounded-xl px-4 py-3 text-sm text-[#F4F2EF] placeholder-[#92939A]/40 focus:outline-none focus:border-[#9a1312] focus:ring-1 focus:ring-[#9a1312]"
                       placeholder="Contoh: Dimas Arya Pratama">
                @error('name') <p class="text-xs text-[#b91a19] mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div>
                    <label for="phone" class="block text-xs font-semibold uppercase tracking-wider text-[#92939A] mb-2">
                        Nomor Handphone / WhatsApp *
                    </label>
                    <input type="text" name="phone" id="phone" value="{{ old('phone') }}" required 
                           class="w-full bg-[#111216] border border-[#303137] rounded-xl px-4 py-3 text-sm text-[#F4F2EF] font-mono placeholder-[#92939A]/40 focus:outline-none focus:border-[#9a1312] focus:ring-1 focus:ring-[#9a1312]"
                           placeholder="Contoh: 081234567890">
                    @error('phone') <p class="text-xs text-[#b91a19] mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="occupation" class="block text-xs font-semibold uppercase tracking-wider text-[#92939A] mb-2">
                        Profesi / Pekerjaan *
                    </label>
                    <input type="text" name="occupation" id="occupation" value="{{ old('occupation') }}" required 
                           class="w-full bg-[#111216] border border-[#303137] rounded-xl px-4 py-3 text-sm text-[#F4F2EF] placeholder-[#92939A]/40 focus:outline-none focus:border-[#9a1312] focus:ring-1 focus:ring-[#9a1312]"
                           placeholder="Contoh: Software Engineer, Dokter, Wirausaha">
                    @error('occupation') <p class="text-xs text-[#b91a19] mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <div>
                <label for="address" class="block text-xs font-semibold uppercase tracking-wider text-[#92939A] mb-2">
                    Alamat Domisili Lengkap *
                </label>
                <textarea name="address" id="address" rows="3" required 
                          class="w-full bg-[#111216] border border-[#303137] rounded-xl p-4 text-sm text-[#F4F2EF] placeholder-[#92939A]/40 focus:outline-none focus:border-[#9a1312] focus:ring-1 focus:ring-[#9a1312]"
                          placeholder="Jalan, nomor rumah, RT/RW, kelurahan, kota">{{ old('address') }}</textarea>
                @error('address') <p class="text-xs text-[#b91a19] mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="pt-4 border-t border-[#303137] flex items-center justify-between">
                <a href="{{ route('admin.customers.index') }}" class="text-xs uppercase tracking-wider text-[#92939A] hover:text-[#F4F2EF] transition-colors">
                    Batal
                </a>
                <button type="submit" class="bg-[#9a1312] hover:bg-[#b91a19] text-white text-xs uppercase tracking-wider font-semibold py-3 px-8 rounded-xl shadow-lg transition-colors">
                    Simpan Pelanggan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
