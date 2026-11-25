@extends('layouts.admin')

@section('title', 'Detail Sepeda Motor: ' . $vehicle->plate_number)
@section('header_title', 'Unit Sepeda Motor ' . $vehicle->plate_number)
@section('header_subtitle', 'Spesifikasi unit, identitas pemilik, dan seluruh rekam jejak servis.')

@section('content')
<div class="space-y-8">

    <!-- Top Card -->
    <div class="bg-[#191A1F] border border-[#303137] rounded-2xl p-6 sm:p-8 shadow-xl flex flex-col md:flex-row md:items-center justify-between gap-6">
        <div class="flex items-center gap-5">
            <div class="w-16 h-16 rounded-2xl bg-[#111216] border border-[#303137] flex items-center justify-center font-mono text-2xl font-bold text-[#b91a19] shadow-lg">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                </svg>
            </div>
            <div>
                <div class="flex items-center gap-3">
                    <h2 class="font-mono text-2xl font-bold text-[#F4F2EF]">{{ $vehicle->plate_number }}</h2>
                    <x-status-badge :status="$vehicle->type" type="vehicle" />
                </div>
                <p class="text-xs text-[#92939A] mt-1">Pemilik: <strong class="text-[#F4F2EF]">{{ $vehicle->customer->name ?? '-' }}</strong> • Terdaftar: {{ $vehicle->created_at->format('d M Y') }}</p>
            </div>
        </div>

        <div class="flex items-center gap-3">
            <a href="{{ route('admin.vehicles.edit', $vehicle->id) }}" class="bg-[#222329] hover:bg-[#303137] text-[#F4F2EF] text-xs uppercase tracking-wider font-semibold py-2.5 px-5 rounded-xl border border-[#303137] transition-colors">
                Edit Data Motor
            </a>
            <a href="{{ route('admin.services.create') }}?vehicle_id={{ $vehicle->id }}" class="bg-[#9a1312] hover:bg-[#b91a19] text-white text-xs uppercase tracking-wider font-semibold py-2.5 px-5 rounded-xl shadow-md transition-colors">
                + Pendaftaran Servis Baru
            </a>
        </div>
    </div>

    <!-- Specs Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="bg-[#191A1F] border border-[#303137] rounded-xl p-5">
            <span class="text-xs uppercase tracking-wider text-[#92939A] block mb-1">Nomor STNK</span>
            <p class="text-base font-semibold font-mono text-[#F4F2EF]">{{ $vehicle->stnk_number }}</p>
        </div>

        <div class="bg-[#191A1F] border border-[#303137] rounded-xl p-5">
            <span class="text-xs uppercase tracking-wider text-[#92939A] block mb-1">Tahun Perakitan</span>
            <p class="text-base font-semibold text-[#F4F2EF]">{{ $vehicle->year }}</p>
        </div>

        <div class="bg-[#191A1F] border border-[#303137] rounded-xl p-5">
            <span class="text-xs uppercase tracking-wider text-[#92939A] block mb-1">Warna Bodi</span>
            <p class="text-base font-semibold text-[#F4F2EF]">{{ $vehicle->color }}</p>
        </div>

        <div class="bg-[#191A1F] border border-[#303137] rounded-xl p-5">
            <span class="text-xs uppercase tracking-wider text-[#92939A] block mb-1">Total Kunjungan Servis</span>
            <p class="text-base font-semibold text-[#b91a19]">{{ $vehicle->serviceRegistrations->count() }} Kali Servis</p>
        </div>
    </div>

    <!-- Owner Information Card -->
    <div class="bg-[#191A1F] border border-[#303137] rounded-2xl p-6 shadow-xl flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
        <div>
            <span class="text-xs uppercase tracking-wider text-[#92939A] block">Pemilik Terdaftar:</span>
            <h3 class="font-display text-xl font-bold text-[#F4F2EF] mt-0.5">{{ $vehicle->customer->name ?? '-' }}</h3>
            <p class="text-xs text-[#92939A] mt-1">{{ $vehicle->customer->occupation ?? '-' }} • WhatsApp: {{ $vehicle->customer->phone ?? '-' }}</p>
            <p class="text-xs text-[#92939A] mt-0.5">Alamat: {{ $vehicle->customer->address ?? '-' }}</p>
        </div>
        @if($vehicle->customer)
            <a href="{{ route('admin.customers.show', $vehicle->customer->id) }}" class="text-xs text-[#b91a19] font-semibold hover:underline">
                Lihat Profil Pelanggan →
            </a>
        @endif
    </div>

    <!-- Service History Table -->
    <div class="bg-[#191A1F] border border-[#303137] rounded-2xl p-6 shadow-xl space-y-4">
        <h3 class="font-display text-xl font-bold text-[#F4F2EF] border-b border-[#303137] pb-4">
            Riwayat Servis Sepeda Motor Ini
        </h3>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-[#92939A]">
                <thead class="uppercase tracking-wider bg-[#111216] text-[#92939A] border-b border-[#303137]">
                    <tr>
                        <th class="px-4 py-3">ID Servis</th>
                        <th class="px-4 py-3">Tanggal Servis</th>
                        <th class="px-4 py-3">Keluhan</th>
                        <th class="px-4 py-3">Mekanik</th>
                        <th class="px-4 py-3">Status</th>
                        <th class="px-4 py-3">Total Biaya</th>
                        <th class="px-4 py-3 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#303137]/60">
                    @forelse($vehicle->serviceRegistrations as $srv)
                        <tr class="hover:bg-[#222329]/50">
                            <td class="px-4 py-3 font-mono font-bold text-[#F4F2EF]">{{ $srv->service_id }}</td>
                            <td class="px-4 py-3">{{ $srv->service_date->format('d M Y') }}</td>
                            <td class="px-4 py-3 max-w-xs truncate">{{ $srv->complaint }}</td>
                            <td class="px-4 py-3">{{ $srv->serviceDetail->mechanic->name ?? '-' }}</td>
                            <td class="px-4 py-3"><x-status-badge :status="$srv->status" type="service" /></td>
                            <td class="px-4 py-3 font-mono font-semibold text-[#F4F2EF]">
                                @if($srv->payment)
                                    Rp {{ number_format($srv->payment->total_amount, 0, ',', '.') }}
                                @else
                                    -
                                @endif
                            </td>
                            <td class="px-4 py-3 text-right">
                                <a href="{{ route('admin.services.show', $srv->id) }}" class="text-[#b91a19] font-semibold hover:underline">Detail</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-4 py-6 text-center text-[#92939A]">Unit motor ini belum memiliki riwayat pengerjaan servis.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
