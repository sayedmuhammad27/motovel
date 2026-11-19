@extends('layouts.admin')

@section('title', 'Riwayat Servis Lengkap | MOTOVEL')
@section('header_title', 'Riwayat Servis & Log Operasional')
@section('header_subtitle', 'Audit riwayat servis seluruh unit kendaraan, penanganan teknisi, dan status transaksi finansial.')

@section('content')
<div class="space-y-6">

    <!-- Filter & Search Toolbar -->
    <div class="bg-[#191A1F] border border-[#303137] rounded-2xl p-6 shadow-xl">
        <form method="GET" action="{{ route('admin.history') }}" class="space-y-4">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-3">
                <!-- Search text -->
                <div class="lg:col-span-2 relative">
                    <label class="block text-[11px] uppercase tracking-wider text-[#92939A] mb-1 font-semibold">Pencarian</label>
                    <div class="relative">
                        <input type="text" 
                               name="search" 
                               value="{{ $search }}" 
                               placeholder="ID Servis, plat motor, nama, mekanik..." 
                               class="w-full bg-[#111216] border border-[#303137] rounded-xl pl-9 pr-4 py-2.5 text-xs text-[#F4F2EF] placeholder-[#92939A]/50 focus:outline-none focus:border-[#C62828]">
                        <svg class="w-4 h-4 text-[#92939A] absolute left-3 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                </div>

                <!-- Status Servis -->
                <div>
                    <label class="block text-[11px] uppercase tracking-wider text-[#92939A] mb-1 font-semibold">Status Servis</label>
                    <select name="service_status" class="w-full bg-[#111216] border border-[#303137] rounded-xl px-3 py-2.5 text-xs text-[#F4F2EF] focus:outline-none focus:border-[#C62828]">
                        <option value="">Semua Status</option>
                        <option value="completed" {{ $serviceStatus === 'completed' ? 'selected' : '' }}>Selesai (Completed)</option>
                        <option value="in_progress" {{ $serviceStatus === 'in_progress' ? 'selected' : '' }}>Pengerjaan</option>
                        <option value="waiting" {{ $serviceStatus === 'waiting' ? 'selected' : '' }}>Menunggu</option>
                        <option value="cancelled" {{ $serviceStatus === 'cancelled' ? 'selected' : '' }}>Dibatalkan</option>
                    </select>
                </div>

                <!-- Status Kasir -->
                <div>
                    <label class="block text-[11px] uppercase tracking-wider text-[#92939A] mb-1 font-semibold">Status Pembayaran</label>
                    <select name="payment_status" class="w-full bg-[#111216] border border-[#303137] rounded-xl px-3 py-2.5 text-xs text-[#F4F2EF] focus:outline-none focus:border-[#C62828]">
                        <option value="">Semua Status Kasir</option>
                        <option value="paid" {{ $paymentStatus === 'paid' ? 'selected' : '' }}>Lunas (Paid)</option>
                        <option value="pending" {{ $paymentStatus === 'pending' ? 'selected' : '' }}>Pending</option>
                    </select>
                </div>

                <!-- Dari Tanggal -->
                <div>
                    <label class="block text-[11px] uppercase tracking-wider text-[#92939A] mb-1 font-semibold">Mulai Tanggal</label>
                    <input type="date" 
                           name="start_date" 
                           value="{{ $startDate }}" 
                           class="w-full bg-[#111216] border border-[#303137] rounded-xl px-3 py-2.5 text-xs text-[#F4F2EF] focus:outline-none focus:border-[#C62828]">
                </div>
            </div>

            <!-- Second Row with End Date and Submit Buttons -->
            <div class="flex flex-wrap items-center justify-between gap-3 pt-3 border-t border-[#303137]/60">
                <div class="flex items-center gap-3">
                    <span class="text-xs text-[#92939A]">Sampai Tanggal:</span>
                    <input type="date" 
                           name="end_date" 
                           value="{{ $endDate }}" 
                           class="bg-[#111216] border border-[#303137] rounded-xl px-3 py-2 text-xs text-[#F4F2EF] focus:outline-none focus:border-[#C62828]">
                </div>

                <div class="flex items-center gap-3">
                    @if($search || $serviceStatus || $paymentStatus || $startDate || $endDate)
                        <a href="{{ route('admin.history') }}" class="text-xs text-[#92939A] hover:text-[#F4F2EF] px-3 py-2">Reset Filter</a>
                    @endif
                    <button type="submit" class="bg-[#C62828] hover:bg-[#E23B3B] text-white text-xs uppercase tracking-wider font-semibold py-2 px-5 rounded-xl transition-colors">
                        Terapkan Filter
                    </button>
                </div>
            </div>
        </form>
    </div>

    <!-- History Audit Table -->
    <div class="bg-[#191A1F] border border-[#303137] rounded-2xl overflow-hidden shadow-xl">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-[#92939A]">
                <thead class="text-xs uppercase tracking-wider bg-[#111216] text-[#92939A] border-b border-[#303137]">
                    <tr>
                        <th scope="col" class="px-6 py-4">ID Servis</th>
                        <th scope="col" class="px-6 py-4">Tanggal Masuk</th>
                        <th scope="col" class="px-6 py-4">Sepeda Motor</th>
                        <th scope="col" class="px-6 py-4">Pemilik</th>
                        <th scope="col" class="px-6 py-4">Mekanik</th>
                        <th scope="col" class="px-6 py-4 text-center">Status Servis</th>
                        <th scope="col" class="px-6 py-4 text-right">Total Tagihan</th>
                        <th scope="col" class="px-6 py-4 text-center">Kasir</th>
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
                                {{ \Carbon\Carbon::parse($s->service_date)->format('d/m/Y') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="font-bold text-[#F4F2EF] font-mono">{{ $s->vehicle->plate_number ?? '-' }}</div>
                                <div class="text-xs text-[#92939A]">{{ $s->vehicle->brand ?? '' }} {{ $s->vehicle->model ?? '' }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="font-medium text-[#F4F2EF]">{{ $s->customer->name ?? '-' }}</div>
                                <div class="text-xs text-[#92939A] font-mono">{{ $s->customer->phone ?? '' }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-xs text-[#F4F2EF]">
                                {{ $s->serviceDetail->mechanic->name ?? 'Belum Ditugaskan' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                @if($s->status === 'completed')
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-emerald-500/10 text-emerald-400 border border-emerald-500/20">Selesai</span>
                                @elseif($s->status === 'in_progress')
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-blue-500/10 text-blue-400 border border-blue-500/20">Pengerjaan</span>
                                @elseif($s->status === 'waiting')
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-amber-500/10 text-amber-400 border border-amber-500/20">Menunggu</span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-rose-500/10 text-rose-400 border border-rose-500/20">Dibatalkan</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right font-mono font-bold text-xs text-[#F4F2EF]">
                                @if($s->payment)
                                    Rp {{ number_format($s->payment->total_amount, 0, ',', '.') }}
                                @else
                                    <span class="text-zinc-600">-</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center text-xs">
                                @if($s->payment)
                                    @if($s->payment->status === 'paid')
                                        <span class="inline-flex px-2 py-0.5 rounded text-[11px] font-semibold bg-emerald-500/10 text-emerald-400">Lunas</span>
                                    @else
                                        <span class="inline-flex px-2 py-0.5 rounded text-[11px] font-semibold bg-amber-500/10 text-amber-400">Pending</span>
                                    @endif
                                @else
                                    <span class="text-zinc-600 text-xs italic">Belum Kasir</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-xs">
                                <a href="{{ route('admin.services.show', $s->id) }}" class="text-xs text-[#92939A] hover:text-[#F4F2EF] underline">
                                    Detail Lengkap
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="px-6 py-12 text-center text-[#92939A]">
                                <div class="max-w-xs mx-auto text-center">
                                    <svg class="w-12 h-12 mx-auto text-[#303137] mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <p class="text-sm font-medium text-[#F4F2EF]">Tidak ada riwayat servis</p>
                                    <p class="text-xs text-[#92939A] mt-1">Tidak ada data pengerjaan yang cocok dengan kriteria filter yang Anda pilih.</p>
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
