@extends('layouts.admin')

@section('title', 'Detail Pelanggan: ' . $customer->customer_id)
@section('header_title', $customer->name)
@section('header_subtitle', 'Profil lengkap pelanggan, daftar sepeda motor, dan rekam jejak servis.')

@section('content')
<div class="space-y-8">

    <!-- Top Card & Actions -->
    <div class="bg-[#191A1F] border border-[#303137] rounded-2xl p-6 sm:p-8 shadow-xl flex flex-col md:flex-row md:items-center justify-between gap-6">
        <div class="flex items-center gap-5">
            <div class="w-16 h-16 rounded-2xl bg-[#9a1312] text-white flex items-center justify-center font-display text-3xl font-bold shadow-lg shadow-[#9a1312]/30">
                {{ strtoupper(substr($customer->name, 0, 1)) }}
            </div>
            <div>
                <div class="flex items-center gap-3">
                    <h2 class="font-display text-2xl font-bold text-[#F4F2EF]">{{ $customer->name }}</h2>
                    <span class="font-mono text-xs font-bold text-[#b91a19] bg-[#9a1312]/10 px-2.5 py-0.5 rounded">{{ $customer->customer_id }}</span>
                </div>
                <p class="text-xs text-[#92939A] mt-1">{{ $customer->occupation }} • Terdaftar sejak {{ $customer->created_at->format('d F Y') }}</p>
            </div>
        </div>

        <div class="flex items-center gap-3">
            <a href="{{ route('admin.customers.edit', $customer->id) }}" class="bg-[#222329] hover:bg-[#303137] text-[#F4F2EF] text-xs uppercase tracking-wider font-semibold py-2.5 px-5 rounded-xl border border-[#303137] transition-colors">
                Edit Profil
            </a>
            <a href="{{ route('admin.vehicles.create') }}?customer_id={{ $customer->id }}" class="bg-[#9a1312] hover:bg-[#b91a19] text-white text-xs uppercase tracking-wider font-semibold py-2.5 px-5 rounded-xl shadow-md transition-colors">
                + Tambah Motor
            </a>
        </div>
    </div>

    <!-- Contact & Details Grid -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-[#191A1F] border border-[#303137] rounded-xl p-5">
            <span class="text-xs uppercase tracking-wider text-[#92939A] block mb-1">Nomor WhatsApp / HP</span>
            <p class="text-base font-semibold font-mono text-[#F4F2EF]">{{ $customer->phone }}</p>
        </div>

        <div class="bg-[#191A1F] border border-[#303137] rounded-xl p-5">
            <span class="text-xs uppercase tracking-wider text-[#92939A] block mb-1">Profesi Pekerjaan</span>
            <p class="text-base font-semibold text-[#F4F2EF]">{{ $customer->occupation }}</p>
        </div>

        <div class="bg-[#191A1F] border border-[#303137] rounded-xl p-5">
            <span class="text-xs uppercase tracking-wider text-[#92939A] block mb-1">Alamat Tinggal</span>
            <p class="text-xs text-[#F4F2EF] leading-relaxed">{{ $customer->address }}</p>
        </div>
    </div>

    <!-- Owned Vehicles List -->
    <div class="bg-[#191A1F] border border-[#303137] rounded-2xl p-6 shadow-xl space-y-4">
        <div class="flex items-center justify-between border-b border-[#303137] pb-4">
            <h3 class="font-display text-xl font-bold text-[#F4F2EF]">Sepeda Motor Terdaftar ({{ $customer->vehicles->count() }} Unit)</h3>
            <a href="{{ route('admin.vehicles.create') }}?customer_id={{ $customer->id }}" class="text-xs text-[#b91a19] font-semibold hover:underline">+ Daftarkan Motor Baru</a>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
            @forelse($customer->vehicles as $v)
                <div class="bg-[#111216] border border-[#303137] rounded-xl p-4 space-y-3">
                    <div class="flex items-center justify-between">
                        <span class="font-mono text-base font-bold text-[#F4F2EF]">{{ $v->plate_number }}</span>
                        <x-status-badge :status="$v->type" type="vehicle" />
                    </div>
                    <div class="text-xs text-[#92939A] space-y-1">
                        <p>No. STNK: <span class="font-mono text-[#F4F2EF]">{{ $v->stnk_number }}</span></p>
                        <p>Tahun: <span class="text-[#F4F2EF]">{{ $v->year }}</span> | Warna: <span class="text-[#F4F2EF]">{{ $v->color }}</span></p>
                        <p>Total Servis: <span class="text-[#b91a19] font-semibold">{{ $v->serviceRegistrations->count() }} kali</span></p>
                    </div>
                    <div class="pt-2 border-t border-[#303137] flex justify-between items-center text-xs">
                        <a href="{{ route('admin.vehicles.show', $v->id) }}" class="text-[#92939A] hover:text-[#F4F2EF]">Detail Motor →</a>
                        <a href="{{ route('admin.services.create') }}?vehicle_id={{ $v->id }}" class="text-[#b91a19] font-semibold">+ Buka Servis</a>
                    </div>
                </div>
            @empty
                <p class="text-xs text-[#92939A] col-span-3 py-4 text-center">Belum ada sepeda motor yang didaftarkan untuk pelanggan ini.</p>
            @endforelse
        </div>
    </div>

    <!-- Service History -->
    <div class="bg-[#191A1F] border border-[#303137] rounded-2xl p-6 shadow-xl space-y-4">
        <h3 class="font-display text-xl font-bold text-[#F4F2EF] border-b border-[#303137] pb-4">Riwayat Servis Pelanggan</h3>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-[#92939A]">
                <thead class="uppercase tracking-wider bg-[#111216] text-[#92939A] border-b border-[#303137]">
                    <tr>
                        <th class="px-4 py-3">ID Servis</th>
                        <th class="px-4 py-3">Tanggal</th>
                        <th class="px-4 py-3">Plat Motor</th>
                        <th class="px-4 py-3">Keluhan</th>
                        <th class="px-4 py-3">Status Servis</th>
                        <th class="px-4 py-3">Total Biaya</th>
                        <th class="px-4 py-3 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#303137]/60">
                    @forelse($customer->serviceRegistrations as $srv)
                        <tr class="hover:bg-[#222329]/50">
                            <td class="px-4 py-3 font-mono font-bold text-[#F4F2EF]">{{ $srv->service_id }}</td>
                            <td class="px-4 py-3">{{ $srv->service_date->format('d M Y') }}</td>
                            <td class="px-4 py-3 font-mono text-[#F4F2EF]">{{ $srv->vehicle->plate_number ?? '-' }}</td>
                            <td class="px-4 py-3 max-w-xs truncate">{{ $srv->complaint }}</td>
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
                            <td colspan="7" class="px-4 py-6 text-center text-[#92939A]">Belum pernah melakukan servis.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
