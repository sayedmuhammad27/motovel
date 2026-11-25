@extends('layouts.admin')

@section('title', 'Transaksi Kasir & Pembayaran | MOTOVEL')
@section('header_title', 'Kasir & Pembayaran Servis')
@section('header_subtitle', 'Kelola penagihan servis, pelunasan pembayaran kasir, dan penerbitan nota transaksi bengkel.')

@section('content')
<div class="space-y-6">

    <!-- Top Action Bar & Filter -->
    <div class="flex flex-col md:flex-row items-stretch md:items-center justify-between gap-4">
        <!-- Search & Status Filter Form -->
        <form method="GET" action="{{ route('admin.payments.index') }}" class="flex flex-wrap items-center gap-3 flex-1">
            <div class="relative flex-1 min-w-[240px] max-w-md">
                <input type="text" 
                       name="search" 
                       value="{{ $search }}" 
                       placeholder="Cari ID Invoice, ID Servis, plat motor, pelanggan..." 
                       class="w-full bg-[#191A1F] border border-[#303137] rounded-xl pl-10 pr-4 py-2.5 text-xs text-[#F4F2EF] placeholder-[#92939A]/50 focus:outline-none focus:border-[#9a1312] focus:ring-1 focus:ring-[#9a1312]">
                <svg class="w-4 h-4 text-[#92939A] absolute left-3.5 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </div>

            <!-- Status Pembayaran Filter -->
            <select name="status" onchange="this.form.submit()" class="bg-[#191A1F] border border-[#303137] rounded-xl px-3 py-2.5 text-xs text-[#F4F2EF] focus:outline-none focus:border-[#9a1312]">
                <option value="">Semua Status Kasir</option>
                <option value="paid" {{ $status === 'paid' ? 'selected' : '' }}>Lunas (Paid)</option>
                <option value="pending" {{ $status === 'pending' ? 'selected' : '' }}>Menunggu Bayar (Pending)</option>
            </select>

            @if($search || $status)
                <a href="{{ route('admin.payments.index') }}" class="text-xs text-[#92939A] hover:text-[#F4F2EF] px-2 py-1">Reset Filter</a>
            @endif
        </form>

        <!-- Tambah Button -->
        <a href="{{ route('admin.payments.create') }}" class="inline-flex items-center justify-center gap-2 bg-[#9a1312] hover:bg-[#b91a19] text-white text-xs uppercase tracking-wider font-semibold py-2.5 px-5 rounded-xl shadow-md transition-colors whitespace-nowrap">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            <span>Catat Transaksi Kasir</span>
        </a>
    </div>

    <!-- Table Container -->
    <div class="bg-[#191A1F] border border-[#303137] rounded-2xl overflow-hidden shadow-xl">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-[#92939A]">
                <thead class="text-xs uppercase tracking-wider bg-[#111216] text-[#92939A] border-b border-[#303137]">
                    <tr>
                        <th scope="col" class="px-6 py-4">ID Invoice</th>
                        <th scope="col" class="px-6 py-4">ID Servis</th>
                        <th scope="col" class="px-6 py-4">Sepeda Motor</th>
                        <th scope="col" class="px-6 py-4">Pelanggan</th>
                        <th scope="col" class="px-6 py-4 text-right">Biaya Jasa</th>
                        <th scope="col" class="px-6 py-4 text-right">Biaya Part</th>
                        <th scope="col" class="px-6 py-4 text-right">Total Tagihan</th>
                        <th scope="col" class="px-6 py-4 text-center">Metode</th>
                        <th scope="col" class="px-6 py-4 text-center">Status</th>
                        <th scope="col" class="px-6 py-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#303137]/60">
                    @forelse($payments as $p)
                        <tr class="hover:bg-[#222329]/50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap font-mono text-xs font-bold text-[#b91a19]">
                                <a href="{{ route('admin.payments.show', $p->id) }}" class="hover:underline">
                                    {{ $p->payment_id }}
                                </a>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap font-mono text-xs text-[#F4F2EF]">
                                <a href="{{ route('admin.services.show', $p->service_registration_id) }}" class="hover:underline text-[#F4F2EF] hover:text-[#b91a19]">
                                    {{ $p->serviceRegistration->service_id ?? '-' }}
                                </a>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="font-bold text-[#F4F2EF] font-mono">{{ $p->serviceRegistration->vehicle->plate_number ?? '-' }}</div>
                                <div class="text-xs text-[#92939A]">{{ $p->serviceRegistration->vehicle->brand ?? '' }} {{ $p->serviceRegistration->vehicle->model ?? '' }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="font-medium text-[#F4F2EF]">{{ $p->serviceRegistration->customer->name ?? '-' }}</div>
                                <div class="text-xs text-[#92939A] font-mono">{{ $p->serviceRegistration->customer->phone ?? '' }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right font-mono text-xs text-[#92939A]">
                                Rp {{ number_format($p->service_cost, 0, ',', '.') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right font-mono text-xs text-[#92939A]">
                                Rp {{ number_format($p->sparepart_cost, 0, ',', '.') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right font-mono font-bold text-sm text-[#F4F2EF]">
                                Rp {{ number_format($p->total_amount, 0, ',', '.') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <span class="inline-flex px-2.5 py-0.5 rounded text-xs font-semibold uppercase font-mono {{ $p->payment_type === 'cash' ? 'bg-zinc-800 text-zinc-300' : 'bg-blue-900/40 text-blue-300' }}">
                                    {{ $p->payment_type }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                @if($p->status === 'paid')
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-emerald-500/10 text-emerald-400 border border-emerald-500/20">Lunas</span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-amber-500/10 text-amber-400 border border-amber-500/20">Pending</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-xs">
                                <div class="inline-flex items-center gap-3">
                                    <a href="{{ route('admin.payments.print', $p->id) }}" target="_blank" class="text-emerald-400 hover:text-emerald-300 transition-colors" title="Cetak Struk Nota">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                                    </a>
                                    <a href="{{ route('admin.payments.show', $p->id) }}" class="text-[#92939A] hover:text-[#F4F2EF] transition-colors" title="Lihat Invoice">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                    </a>
                                    <a href="{{ route('admin.payments.edit', $p->id) }}" class="text-blue-400 hover:text-blue-300 transition-colors" title="Edit Transaksi">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                    </a>
                                    <form action="{{ route('admin.payments.destroy', $p->id) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data transaksi kasir {{ $p->payment_id }}?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-zinc-500 hover:text-[#b91a19] transition-colors" title="Hapus Transaksi">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="10" class="px-6 py-12 text-center text-[#92939A]">
                                <div class="max-w-xs mx-auto text-center">
                                    <svg class="w-12 h-12 mx-auto text-[#303137] mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                                    </svg>
                                    <p class="text-sm font-medium text-[#F4F2EF]">Belum ada transaksi pembayaran</p>
                                    <p class="text-xs text-[#92939A] mt-1">Data kasir dan penagihan servis belum dicatat.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($payments->hasPages())
            <div class="px-6 py-4 border-t border-[#303137] bg-[#111216]/50">
                {{ $payments->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
