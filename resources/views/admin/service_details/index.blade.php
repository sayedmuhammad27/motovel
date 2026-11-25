@extends('layouts.admin')

@section('title', 'Detail Pengerjaan Servis | MOTOVEL')
@section('header_title', 'Rincian Pengerjaan Teknis')
@section('header_subtitle', 'Alokasi mekanik penanggung jawab, diagnosis teknis bengkel, dan pemakaian suku cadang motor.')

@section('content')
<div class="space-y-6">

    <!-- Top Action Bar -->
    <div class="flex flex-col sm:flex-row items-stretch sm:items-center justify-between gap-4">
        <!-- Search Form -->
        <form method="GET" action="{{ route('admin.service-details.index') }}" class="relative flex-1 max-w-md">
            <input type="text" 
                   name="search" 
                   value="{{ $search }}" 
                   placeholder="Cari ID Detail, ID Servis, plat motor, mekanik..." 
                   class="w-full bg-[#191A1F] border border-[#303137] rounded-xl pl-10 pr-4 py-2.5 text-xs text-[#F4F2EF] placeholder-[#92939A]/50 focus:outline-none focus:border-[#9a1312] focus:ring-1 focus:ring-[#9a1312]">
            <svg class="w-4 h-4 text-[#92939A] absolute left-3.5 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
            </svg>
            @if($search)
                <a href="{{ route('admin.service-details.index') }}" class="absolute right-3 top-1/2 -translate-y-1/2 text-xs text-[#92939A] hover:text-[#F4F2EF]">Reset</a>
            @endif
        </form>

        <!-- Tambah Button -->
        <a href="{{ route('admin.service-details.create') }}" class="inline-flex items-center justify-center gap-2 bg-[#9a1312] hover:bg-[#b91a19] text-white text-xs uppercase tracking-wider font-semibold py-2.5 px-5 rounded-xl shadow-md transition-colors whitespace-nowrap">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            <span>Input Pengerjaan Teknis</span>
        </a>
    </div>

    <!-- Table Container -->
    <div class="bg-[#191A1F] border border-[#303137] rounded-2xl overflow-hidden shadow-xl">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-[#92939A]">
                <thead class="text-xs uppercase tracking-wider bg-[#111216] text-[#92939A] border-b border-[#303137]">
                    <tr>
                        <th scope="col" class="px-6 py-4">ID Detail</th>
                        <th scope="col" class="px-6 py-4">ID Servis</th>
                        <th scope="col" class="px-6 py-4">Sepeda Motor</th>
                        <th scope="col" class="px-6 py-4">Mekanik</th>
                        <th scope="col" class="px-6 py-4 text-right">Biaya Jasa</th>
                        <th scope="col" class="px-6 py-4 text-center">Part Dipakai</th>
                        <th scope="col" class="px-6 py-4 text-center">Status Pengerjaan</th>
                        <th scope="col" class="px-6 py-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#303137]/60">
                    @forelse($details as $d)
                        <tr class="hover:bg-[#222329]/50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap font-mono text-xs font-bold text-[#b91a19]">
                                <a href="{{ route('admin.service-details.show', $d->id) }}" class="hover:underline">
                                    {{ $d->detail_id }}
                                </a>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap font-mono text-xs text-[#F4F2EF]">
                                <a href="{{ route('admin.services.show', $d->service_registration_id) }}" class="hover:underline text-[#F4F2EF] hover:text-[#b91a19]">
                                    {{ $d->serviceRegistration->service_id ?? '-' }}
                                </a>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="font-bold text-[#F4F2EF] font-mono">{{ $d->serviceRegistration->vehicle->plate_number ?? '-' }}</div>
                                <div class="text-xs text-[#92939A]">{{ $d->serviceRegistration->customer->name ?? '-' }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap font-medium text-[#F4F2EF]">
                                {{ $d->mechanic->name ?? 'Belum Ditentukan' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right font-mono font-bold text-[#F4F2EF] text-xs">
                                Rp {{ number_format($d->service_cost, 0, ',', '.') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-[#111216] border border-[#303137] text-[#F4F2EF]">
                                    {{ $d->serviceSpareparts->count() }} Jenis Part
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                @if($d->status === 'waiting')
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-amber-500/10 text-amber-400 border border-amber-500/20">Menunggu</span>
                                @elseif($d->status === 'in_progress')
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-blue-500/10 text-blue-400 border border-blue-500/20">Pengerjaan</span>
                                @elseif($d->status === 'completed')
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-emerald-500/10 text-emerald-400 border border-emerald-500/20">Selesai</span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-rose-500/10 text-rose-400 border border-rose-500/20">Dibatalkan</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-xs">
                                <div class="inline-flex items-center gap-3">
                                    <a href="{{ route('admin.service-details.show', $d->id) }}" class="text-[#92939A] hover:text-[#F4F2EF] transition-colors" title="Lihat Rincian Teknis">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                    </a>
                                    <a href="{{ route('admin.service-details.edit', $d->id) }}" class="text-blue-400 hover:text-blue-300 transition-colors" title="Edit Rincian Teknis">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                    </a>
                                    <form action="{{ route('admin.service-details.destroy', $d->id) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus rincian pengerjaan teknis ini? Stok sparepart akan dikembalikan.');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-zinc-500 hover:text-[#b91a19] transition-colors" title="Hapus Rincian">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-6 py-12 text-center text-[#92939A]">
                                <div class="max-w-xs mx-auto text-center">
                                    <svg class="w-12 h-12 mx-auto text-[#303137] mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" />
                                    </svg>
                                    <p class="text-sm font-medium text-[#F4F2EF]">Belum ada rincian teknis</p>
                                    <p class="text-xs text-[#92939A] mt-1">Data pengerjaan servis mekanik belum dicatat atau tidak ditemukan.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($details->hasPages())
            <div class="px-6 py-4 border-t border-[#303137] bg-[#111216]/50">
                {{ $details->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
