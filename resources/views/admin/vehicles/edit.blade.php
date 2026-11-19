@extends('layouts.admin')

@section('title', 'Edit Sepeda Motor: ' . $vehicle->plate_number)
@section('header_title', 'Perbarui Data Sepeda Motor')
@section('header_subtitle', 'Ubah data teknis, nomor STNK, warna, atau alihkan pemilik motor.')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="bg-[#191A1F] border border-[#303137] rounded-2xl p-6 sm:p-8 shadow-xl">
        <div class="flex items-center justify-between pb-4 mb-6 border-b border-[#303137]">
            <div>
                <span class="text-xs text-[#92939A]">Plat Nomor Polisi</span>
                <p class="font-mono text-xl font-bold text-[#F4F2EF]">{{ $vehicle->plate_number }}</p>
            </div>
            <x-status-badge :status="$vehicle->type" type="vehicle" />
        </div>

        <form action="{{ route('admin.vehicles.update', $vehicle->id) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- Pemilik Dropdown -->
            <div>
                <label for="customer_id" class="block text-xs font-semibold uppercase tracking-wider text-[#92939A] mb-2">
                    Pemilik Kendaraan (Pelanggan) *
                </label>
                <select name="customer_id" id="customer_id" required 
                        class="w-full bg-[#111216] border border-[#303137] rounded-xl px-4 py-3 text-sm text-[#F4F2EF] focus:outline-none focus:border-[#C62828] focus:ring-1 focus:ring-[#C62828]">
                    @foreach($customers as $c)
                        <option value="{{ $c->id }}" {{ old('customer_id', $vehicle->customer_id) == $c->id ? 'selected' : '' }}>
                            {{ $c->name }} ({{ $c->customer_id }}) • {{ $c->phone }}
                        </option>
                    @endforeach
                </select>
                @error('customer_id') <p class="text-xs text-[#E23B3B] mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <!-- Plat Nomor -->
                <div>
                    <label for="plate_number" class="block text-xs font-semibold uppercase tracking-wider text-[#92939A] mb-2">
                        Nomor Plat Polisi *
                    </label>
                    <input type="text" name="plate_number" id="plate_number" value="{{ old('plate_number', $vehicle->plate_number) }}" required 
                           class="w-full bg-[#111216] border border-[#303137] rounded-xl px-4 py-3 text-sm text-[#F4F2EF] font-mono uppercase focus:outline-none focus:border-[#C62828] focus:ring-1 focus:ring-[#C62828]">
                    @error('plate_number') <p class="text-xs text-[#E23B3B] mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Nomor STNK -->
                <div>
                    <label for="stnk_number" class="block text-xs font-semibold uppercase tracking-wider text-[#92939A] mb-2">
                        Nomor STNK *
                    </label>
                    <input type="text" name="stnk_number" id="stnk_number" value="{{ old('stnk_number', $vehicle->stnk_number) }}" required 
                           class="w-full bg-[#111216] border border-[#303137] rounded-xl px-4 py-3 text-sm text-[#F4F2EF] font-mono uppercase focus:outline-none focus:border-[#C62828] focus:ring-1 focus:ring-[#C62828]">
                    @error('stnk_number') <p class="text-xs text-[#E23B3B] mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <!-- Jenis Transmisi Radio Button -->
            <div>
                <label class="block text-xs font-semibold uppercase tracking-wider text-[#92939A] mb-2">
                    Jenis Transmisi Sepeda Motor *
                </label>
                <div class="grid grid-cols-2 gap-4">
                    <label class="flex items-center gap-3 p-4 rounded-xl border border-[#303137] bg-[#111216] cursor-pointer hover:border-[#92939A] transition-colors">
                        <input type="radio" name="type" value="matic" {{ old('type', $vehicle->type) === 'matic' ? 'checked' : '' }} class="text-[#C62828] focus:ring-[#C62828]">
                        <div>
                            <span class="block text-sm font-semibold text-[#F4F2EF]">Transmisi Matic (CVT)</span>
                            <span class="text-[11px] text-[#92939A]">Skutik harian, Maxi Scooter</span>
                        </div>
                    </label>

                    <label class="flex items-center gap-3 p-4 rounded-xl border border-[#303137] bg-[#111216] cursor-pointer hover:border-[#92939A] transition-colors">
                        <input type="radio" name="type" value="manual" {{ old('type', $vehicle->type) === 'manual' ? 'checked' : '' }} class="text-[#C62828] focus:ring-[#C62828]">
                        <div>
                            <span class="block text-sm font-semibold text-[#F4F2EF]">Transmisi Manual / Sport</span>
                            <span class="text-[11px] text-[#92939A]">Motor sport, kopling manual</span>
                        </div>
                    </label>
                </div>
                @error('type') <p class="text-xs text-[#E23B3B] mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <!-- Tahun Pembuatan -->
                <div>
                    <label for="year" class="block text-xs font-semibold uppercase tracking-wider text-[#92939A] mb-2">
                        Tahun Perakitan *
                    </label>
                    <input type="number" name="year" id="year" value="{{ old('year', $vehicle->year) }}" min="1990" max="{{ date('Y') + 1 }}" required 
                           class="w-full bg-[#111216] border border-[#303137] rounded-xl px-4 py-3 text-sm text-[#F4F2EF] font-mono focus:outline-none focus:border-[#C62828] focus:ring-1 focus:ring-[#C62828]">
                    @error('year') <p class="text-xs text-[#E23B3B] mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Warna Kendaraan -->
                <div>
                    <label for="color" class="block text-xs font-semibold uppercase tracking-wider text-[#92939A] mb-2">
                        Warna Bodi Motor *
                    </label>
                    <input type="text" name="color" id="color" value="{{ old('color', $vehicle->color) }}" required 
                           class="w-full bg-[#111216] border border-[#303137] rounded-xl px-4 py-3 text-sm text-[#F4F2EF] focus:outline-none focus:border-[#C62828] focus:ring-1 focus:ring-[#C62828]">
                    @error('color') <p class="text-xs text-[#E23B3B] mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="pt-4 border-t border-[#303137] flex items-center justify-between">
                <a href="{{ route('admin.vehicles.index') }}" class="text-xs uppercase tracking-wider text-[#92939A] hover:text-[#F4F2EF] transition-colors">
                    Batal
                </a>
                <button type="submit" class="bg-[#C62828] hover:bg-[#E23B3B] text-white text-xs uppercase tracking-wider font-semibold py-3 px-8 rounded-xl shadow-lg transition-colors">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
