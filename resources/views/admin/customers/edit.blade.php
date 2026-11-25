@extends('layouts.admin')

@section('title', 'Edit Pelanggan: ' . $customer->customer_id)
@section('header_title', 'Perbarui Data Pelanggan')
@section('header_subtitle', 'Ubah data kontak dan informasi tempat tinggal pelanggan.')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="bg-[#191A1F] border border-[#303137] rounded-2xl p-6 sm:p-8 shadow-xl">
        <div class="flex items-center justify-between pb-4 mb-6 border-b border-[#303137]">
            <div>
                <span class="text-xs text-[#92939A]">ID Pelanggan</span>
                <p class="font-mono text-xl font-bold text-[#b91a19]">{{ $customer->customer_id }}</p>
            </div>
            <span class="text-xs text-[#92939A]">Terdaftar: {{ $customer->created_at->format('d M Y') }}</span>
        </div>

        <form action="{{ route('admin.customers.update', $customer->id) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <div>
                <label for="name" class="block text-xs font-semibold uppercase tracking-wider text-[#92939A] mb-2">
                    Nama Lengkap Pelanggan *
                </label>
                <input type="text" name="name" id="name" value="{{ old('name', $customer->name) }}" required 
                       class="w-full bg-[#111216] border border-[#303137] rounded-xl px-4 py-3 text-sm text-[#F4F2EF] focus:outline-none focus:border-[#9a1312] focus:ring-1 focus:ring-[#9a1312]">
                @error('name') <p class="text-xs text-[#b91a19] mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div>
                    <label for="phone" class="block text-xs font-semibold uppercase tracking-wider text-[#92939A] mb-2">
                        Nomor Handphone / WhatsApp *
                    </label>
                    <input type="text" name="phone" id="phone" value="{{ old('phone', $customer->phone) }}" required 
                           class="w-full bg-[#111216] border border-[#303137] rounded-xl px-4 py-3 text-sm text-[#F4F2EF] font-mono focus:outline-none focus:border-[#9a1312] focus:ring-1 focus:ring-[#9a1312]">
                    @error('phone') <p class="text-xs text-[#b91a19] mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="occupation" class="block text-xs font-semibold uppercase tracking-wider text-[#92939A] mb-2">
                        Profesi / Pekerjaan *
                    </label>
                    <input type="text" name="occupation" id="occupation" value="{{ old('occupation', $customer->occupation) }}" required 
                           class="w-full bg-[#111216] border border-[#303137] rounded-xl px-4 py-3 text-sm text-[#F4F2EF] focus:outline-none focus:border-[#9a1312] focus:ring-1 focus:ring-[#9a1312]">
                    @error('occupation') <p class="text-xs text-[#b91a19] mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <div>
                <label for="address" class="block text-xs font-semibold uppercase tracking-wider text-[#92939A] mb-2">
                    Alamat Domisili Lengkap *
                </label>
                <textarea name="address" id="address" rows="3" required 
                          class="w-full bg-[#111216] border border-[#303137] rounded-xl p-4 text-sm text-[#F4F2EF] focus:outline-none focus:border-[#9a1312] focus:ring-1 focus:ring-[#9a1312]">{{ old('address', $customer->address) }}</textarea>
                @error('address') <p class="text-xs text-[#b91a19] mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="pt-4 border-t border-[#303137] flex items-center justify-between">
                <a href="{{ route('admin.customers.index') }}" class="text-xs uppercase tracking-wider text-[#92939A] hover:text-[#F4F2EF] transition-colors">
                    Batal
                </a>
                <button type="submit" class="bg-[#9a1312] hover:bg-[#b91a19] text-white text-xs uppercase tracking-wider font-semibold py-3 px-8 rounded-xl shadow-lg transition-colors">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
