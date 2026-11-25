@extends('layouts.admin')

@section('title', 'Data Sepeda Motor | MOTOVEL')
@section('header_title', 'Master Data Sepeda Motor')
@section('header_subtitle', 'Data registrasi kendaraan, jenis transmisi, nomor STNK, dan pemilik motor.')

@section('content')
<div class="space-y-6">

    <!-- Top Action Bar -->
    <div class="flex flex-col sm:flex-row items-stretch sm:items-center justify-between gap-4">
        <!-- Search Form -->
        <form method="GET" action="{{ route('admin.vehicles.index') }}" class="relative flex-1 max-w-md">
            <input type="text" 
                   name="search" 
                   value="{{ $search }}" 
                   placeholder="Cari plat nomor, STNK, warna, nama pemilik..." 
                   class="w-full bg-[#191A1F] border border-[#303137] rounded-xl pl-10 pr-4 py-2.5 text-xs text-[#F4F2EF] placeholder-[#92939A]/50 focus:outline-none focus:border-[#9a1312] focus:ring-1 focus:ring-[#9a1312]">
            <svg class="w-4 h-4 text-[#92939A] absolute left-3.5 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
            </svg>
            @if($search)
                <a href="{{ route('admin.vehicles.index') }}" class="absolute right-3 top-1/2 -translate-y-1/2 text-xs text-[#92939A] hover:text-[#F4F2EF]">Reset</a>
            @endif
        </form>

        <!-- Tambah Button -->
        <a href="{{ route('admin.vehicles.create') }}" class="inline-flex items-center justify-center gap-2 bg-[#9a1312] hover:bg-[#b91a19] text-white text-xs uppercase tracking-wider font-semibold py-2.5 px-5 rounded-xl shadow-md transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            <span>Daftarkan Motor</span>
        </a>
    </div>

    <!-- Table Container -->
    <div class="bg-[#191A1F] border border-[#303137] rounded-2xl overflow-hidden shadow-xl">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-[#92939A]">
                <thead class="text-xs uppercase tracking-wider bg-[#111216] text-[#92939A] border-b border-[#303137]">
                    <tr>
                        <th scope="col" class="px-6 py-4">Nomor Plat</th>
                        <th scope="col" class="px-6 py-4">Jenis Transmisi</th>
                        <th scope="col" class="px-6 py-4">Nomor STNK</th>
                        <th scope="col" class="px-6 py-4">Tahun / Warna</th>
                        <th scope="col" class="px-6 py-4">Pemilik Terdaftar</th>
                        <th scope="col" class="px-6 py-4 text-center">Total Servis</th>
                        <th scope="col" class="px-6 py-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#303137]/60">
                    @forelse($vehicles as $v)
                        <tr class="hover:bg-[#222329]/50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <a href="{{ route('admin.vehicles.show', $v->id) }}" class="font-mono text-sm font-bold text-[#F4F2EF] hover:text-[#b91a19] transition-colors">
                                    {{ $v->plate_number }}
                                </a>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <x-status-badge :status="$v->type" type="vehicle" />
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap font-mono text-xs text-[#F4F2EF]">
                                {{ $v->stnk_number }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-xs">
                                <span class="text-[#F4F2EF]">{{ $v->year }}</span> • <span>{{ $v->color }}</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($v->customer)
                                    <a href="{{ route('admin.customers.show', $v->customer->id) }}" class="text-xs font-semibold text-[#F4F2EF] hover:underline">
                                        {{ $v->customer->name }}
                                    </a>
                                    <div class="text-[11px] text-[#92939A] font-mono">{{ $v->customer->phone }}</div>
                                @else
                                    <span class="text-zinc-500 italic">Tanpa Pemilik</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-[#111216] border border-[#303137] text-[#92939A]">
                                    {{ $v->service_registrations_count }} Servis
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-xs">
                                <div class="inline-flex items-center gap-3">
                                    <a href="{{ route('admin.services.create') }}?vehicle_id={{ $v->id }}" class="text-[#b91a19] font-semibold hover:underline" title="Buka Servis">
                                        + Servis
                                    </a>
                                    <a href="{{ route('admin.vehicles.show', $v->id) }}" class="text-[#92939A] hover:text-[#F4F2EF] transition-colors" title="Lihat Detail">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                    </a>
                                    <a href="{{ route('admin.vehicles.edit', $v->id) }}" class="text-blue-400 hover:text-blue-300 transition-colors" title="Edit Data">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                    </a>
                                    <form action="{{ route('admin.vehicles.destroy', $v->id) }}" method="POST" class="inline" onsubmit="return confirm('Hapus sepeda motor plat {{ $v->plate_number }}?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-zinc-500 hover:text-[#b91a19] transition-colors" title="Hapus Unit">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center text-[#92939A]">
                                Tidak ada data sepeda motor yang sesuai dengan pencarian Anda.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{ $vehicles->links('vendor.pagination.tailwind') }}
    </div>

</div>
@endsection
