@extends('layouts.admin')

@section('title', 'Pendaftaran Servis | MOTOVEL')
@section('header_title', 'Pendaftaran & Antrean Servis')
@section('header_subtitle', 'Kelola jadwal booking servis motor, alokasi penanganan teknisi, dan status pengerjaan.')

@section('content')
<div class="space-y-6">

    <!-- Top Action Bar & Filter -->
    <div class="flex flex-col md:flex-row items-stretch md:items-center justify-between gap-4">
        <!-- Search & Status Filter Form -->
        <form method="GET" action="{{ route('admin.services.index') }}" class="flex flex-wrap items-center gap-3 flex-1">
            <div class="relative flex-1 min-w-[240px] max-w-md">
                <input type="text" 
                       name="search" 
                       value="{{ $search }}" 
                       placeholder="Cari ID Servis, plat motor, nama pemilik..." 
                       class="w-full bg-[#191A1F] border border-[#303137] rounded-xl pl-10 pr-4 py-2.5 text-xs text-[#F4F2EF] placeholder-[#92939A]/50 focus:outline-none focus:border-[#C62828] focus:ring-1 focus:ring-[#C62828]">
                <svg class="w-4 h-4 text-[#92939A] absolute left-3.5 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </div>

            <!-- Status Dropdown Filter -->
            <select name="status" onchange="this.form.submit()" class="bg-[#191A1F] border border-[#303137] rounded-xl px-3 py-2.5 text-xs text-[#F4F2EF] focus:outline-none focus:border-[#C62828]">
                <option value="">Semua Status Servis</option>
                <option value="waiting" {{ $status === 'waiting' ? 'selected' : '' }}>Menunggu (Waiting)</option>
                <option value="in_progress" {{ $status === 'in_progress' ? 'selected' : '' }}>Dikerjakan (In Progress)</option>
                <option value="completed" {{ $status === 'completed' ? 'selected' : '' }}>Selesai (Completed)</option>
                <option value="cancelled" {{ $status === 'cancelled' ? 'selected' : '' }}>Dibatalkan (Cancelled)</option>
            </select>

            @if($search || $status)
                <a href="{{ route('admin.services.index') }}" class="text-xs text-[#92939A] hover:text-[#F4F2EF] px-2 py-1">Reset Filter</a>
            @endif
        </form>

        <!-- Tambah Button -->
        <a href="{{ route('admin.services.create') }}" class="inline-flex items-center justify-center gap-2 bg-[#C62828] hover:bg-[#E23B3B] text-white text-xs uppercase tracking-wider font-semibold py-2.5 px-5 rounded-xl shadow-md transition-colors whitespace-nowrap">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            <span>Daftar Servis Baru</span>
        </a>
    </div>

    <!-- Table Container -->
    <div class="bg-[#191A1F] border border-[#303137] rounded-2xl overflow-hidden shadow-xl">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-[#92939A]">
                <thead class="text-xs uppercase tracking-wider bg-[#111216] text-[#92939A] border-b border-[#303137]">
                    <tr>
                        <th scope="col" class="px-6 py-4">ID Servis</th>
                        <th scope="col" class="px-6 py-4">Tanggal</th>
                        <th scope="col" class="px-6 py-4">Sepeda Motor</th>
                        <th scope="col" class="px-6 py-4">Pelanggan</th>
                        <th scope="col" class="px-6 py-4">Keluhan Utama</th>
                        <th scope="col" class="px-6 py-4 text-center">Status Servis</th>
                        <th scope="col" class="px-6 py-4 text-center">Kasir / Bayar</th>
                        <th scope="col" class="px-6 py-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#303137]/60">
                    @forelse($services as $s)
                        <tr class="hover:bg-[#222329]/50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap font-mono text-xs font-bold text-[#E23B3B]">
                                <a href="{{ route('admin.services.show', $s->id) }}" class="hover:underline">
                                    {{ $s->service_id }}
                                </a>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap font-mono text-xs text-[#F4F2EF]">
                                {{ \Carbon\Carbon::parse($s->service_date)->translatedFormat('d M Y') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="font-bold text-[#F4F2EF] font-mono">{{ $s->vehicle->plate_number ?? '-' }}</div>
                                <div class="text-xs text-[#92939A]">{{ $s->vehicle->brand ?? '' }} {{ $s->vehicle->model ?? '' }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="font-medium text-[#F4F2EF]">{{ $s->customer->name ?? '-' }}</div>
                                <div class="text-xs text-[#92939A] font-mono">{{ $s->customer->phone ?? '' }}</div>
                            </td>
                            <td class="px-6 py-4 max-w-xs truncate text-xs text-[#F4F2EF]">
                                {{ $s->complaint }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                @if($s->status === 'waiting')
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-amber-500/10 text-amber-400 border border-amber-500/20">Menunggu</span>
                                @elseif($s->status === 'in_progress')
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-blue-500/10 text-blue-400 border border-blue-500/20">Pengerjaan</span>
                                @elseif($s->status === 'completed')
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-emerald-500/10 text-emerald-400 border border-emerald-500/20">Selesai</span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-rose-500/10 text-rose-400 border border-rose-500/20">Dibatalkan</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center text-xs">
                                @if($s->payment)
                                    @if($s->payment->status === 'paid')
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-emerald-500/10 text-emerald-400 border border-emerald-500/20">Lunas</span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-amber-500/10 text-amber-400 border border-amber-500/20">Pending</span>
                                    @endif
                                @else
                                    <span class="text-xs text-[#92939A]/60 italic">Belum Kasir</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-xs">
                                <div class="inline-flex items-center gap-3">
                                    <a href="{{ route('admin.services.show', $s->id) }}" class="text-[#92939A] hover:text-[#F4F2EF] transition-colors" title="Lihat Detail Pengerjaan">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                    </a>
                                    <a href="{{ route('admin.services.edit', $s->id) }}" class="text-blue-400 hover:text-blue-300 transition-colors" title="Edit Pendaftaran">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                    </a>
                                    <form action="{{ route('admin.services.destroy', $s->id) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin membatalkan/menghapus pendaftaran servis {{ $s->service_id }}?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-zinc-500 hover:text-[#E23B3B] transition-colors" title="Hapus Servis">
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
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                    </svg>
                                    <p class="text-sm font-medium text-[#F4F2EF]">Tidak ada data servis</p>
                                    <p class="text-xs text-[#92939A] mt-1">Belum ada pendaftaran servis yang cocok dengan kriteria pencarian.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($services->hasPages())
            <div class="px-6 py-4 border-t border-[#303137] bg-[#111216]/50">
                {{ $services->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
