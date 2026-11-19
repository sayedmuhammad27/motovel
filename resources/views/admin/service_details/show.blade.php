@extends('layouts.admin')

@section('title', "Detail Pengerjaan {$serviceDetail->detail_id} | MOTOVEL")
@section('header_title', "Rincian Teknis: {$serviceDetail->detail_id}")
@section('header_subtitle', 'Lembar kerja teknisi bengkel, diagnosis kerusakan motor, dan rincian pemakaian suku cadang.')

@section('content')
<div class="space-y-6">

    <!-- Top Action Nav -->
    <div class="flex flex-wrap items-center justify-between gap-4">
        <a href="{{ route('admin.service-details.index') }}" class="inline-flex items-center gap-2 text-xs font-semibold uppercase tracking-wider text-[#92939A] hover:text-[#F4F2EF] transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            <span>Kembali ke Daftar Rincian Teknis</span>
        </a>

        <div class="inline-flex items-center gap-3">
            <a href="{{ route('admin.services.show', $serviceDetail->service_registration_id) }}" class="inline-flex items-center gap-2 bg-[#222329] hover:bg-[#303137] text-[#F4F2EF] text-xs font-semibold py-2 px-4 rounded-xl border border-[#303137] transition-colors">
                <svg class="w-4 h-4 text-[#E23B3B]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                <span>Lihat Pendaftaran Servis</span>
            </a>

            @if($serviceDetail->serviceRegistration->payment)
                <a href="{{ route('admin.payments.show', $serviceDetail->serviceRegistration->payment->id) }}" class="inline-flex items-center gap-2 bg-[#222329] hover:bg-[#303137] text-white text-xs font-semibold py-2 px-4 rounded-xl border border-[#303137] transition-colors">
                    <svg class="w-4 h-4 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                    <span>Tagihan Kasir</span>
                </a>
            @endif

            <a href="{{ route('admin.service-details.edit', $serviceDetail->id) }}" class="inline-flex items-center gap-2 bg-[#C62828] hover:bg-[#E23B3B] text-white text-xs font-semibold py-2 px-4 rounded-xl transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                <span>Edit Rincian</span>
            </a>
        </div>
    </div>

    <!-- Main Detail Card -->
    <div class="bg-[#191A1F] border border-[#303137] rounded-2xl p-6 shadow-xl">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
            <div>
                <span class="text-xs uppercase tracking-wider text-[#92939A]">Nomor Rincian Teknis</span>
                <div class="font-mono text-2xl font-bold text-[#E23B3B] mt-1">{{ $serviceDetail->detail_id }}</div>
                <div class="text-xs text-[#92939A] mt-1">Dicatat: {{ $serviceDetail->created_at->translatedFormat('d F Y, H:i') }}</div>
            </div>
            <div>
                <span class="text-xs uppercase tracking-wider text-[#92939A]">Pendaftaran Servis</span>
                <div class="font-mono text-lg font-bold text-[#F4F2EF] mt-1">
                    {{ $serviceDetail->serviceRegistration->service_id ?? '-' }}
                </div>
                <div class="text-xs text-[#92939A] mt-0.5">
                    Tgl Servis: {{ \Carbon\Carbon::parse($serviceDetail->serviceRegistration->service_date)->format('d/m/Y') }}
                </div>
            </div>
            <div>
                <span class="text-xs uppercase tracking-wider text-[#92939A]">Sepeda Motor & Pemilik</span>
                <div class="font-mono text-lg font-bold text-[#F4F2EF] mt-1">
                    {{ $serviceDetail->serviceRegistration->vehicle->plate_number ?? '-' }}
                </div>
                <div class="text-xs text-[#92939A] mt-0.5">
                    {{ $serviceDetail->serviceRegistration->customer->name ?? '-' }} ({{ $serviceDetail->serviceRegistration->vehicle->brand ?? '' }} {{ $serviceDetail->serviceRegistration->vehicle->model ?? '' }})
                </div>
            </div>
            <div>
                <span class="text-xs uppercase tracking-wider text-[#92939A]">Status Pengerjaan</span>
                <div class="mt-2">
                    @if($serviceDetail->status === 'waiting')
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-amber-500/10 text-amber-400 border border-amber-500/20">Menunggu (Waiting)</span>
                    @elseif($serviceDetail->status === 'in_progress')
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-blue-500/10 text-blue-400 border border-blue-500/20">Sedang Dikerjakan</span>
                    @elseif($serviceDetail->status === 'completed')
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-emerald-500/10 text-emerald-400 border border-emerald-500/20">Pengerjaan Selesai</span>
                    @else
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-rose-500/10 text-rose-400 border border-rose-500/20">Dibatalkan</span>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Mechanic Profile & Diagnostics -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Mechanic Card -->
        <div class="bg-[#191A1F] border border-[#303137] rounded-2xl p-6 shadow-xl">
            <h4 class="text-xs uppercase tracking-wider text-[#E23B3B] font-bold mb-4 flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                <span>Mekanik Penanggung Jawab</span>
            </h4>
            <div class="space-y-3 text-sm">
                <div>
                    <span class="text-xs text-[#92939A]">Nama Mekanik:</span>
                    <div class="font-bold text-[#F4F2EF] text-base mt-0.5">{{ $serviceDetail->mechanic->name ?? 'Belum Ditugaskan' }}</div>
                </div>
                <div>
                    <span class="text-xs text-[#92939A]">ID Mekanik:</span>
                    <div class="font-mono text-xs text-[#E23B3B]">{{ $serviceDetail->mechanic->mechanic_id ?? '-' }}</div>
                </div>
                <div>
                    <span class="text-xs text-[#92939A]">Spesialisasi:</span>
                    <div class="text-xs text-[#F4F2EF]">{{ $serviceDetail->mechanic->specialization ?? '-' }}</div>
                </div>
                <div>
                    <span class="text-xs text-[#92939A]">Nomor Kontak:</span>
                    <div class="font-mono text-xs text-[#F4F2EF]">{{ $serviceDetail->mechanic->phone ?? '-' }}</div>
                </div>
            </div>
        </div>

        <!-- Diagnostics Card -->
        <div class="md:col-span-2 bg-[#191A1F] border border-[#303137] rounded-2xl p-6 shadow-xl space-y-4">
            <div>
                <span class="text-xs uppercase tracking-wider text-[#92939A] font-semibold">Keluhan Awal Pelanggan:</span>
                <p class="text-xs text-[#F4F2EF] mt-1 bg-[#111216] p-3 rounded-xl border border-[#303137]">
                    {{ $serviceDetail->serviceRegistration->complaint ?? '-' }}
                </p>
            </div>
            <div>
                <span class="text-xs uppercase tracking-wider text-[#E23B3B] font-semibold">Catatan Diagnosis & Tindakan Teknisi:</span>
                <p class="text-xs text-[#F4F2EF] mt-1 bg-[#111216] p-3 rounded-xl border border-[#303137] leading-relaxed">
                    {{ $serviceDetail->estimation ?: 'Tidak ada rincian diagnosa tertulis.' }}
                </p>
            </div>
        </div>
    </div>

    <!-- Spareparts Breakdown Table -->
    <div class="bg-[#191A1F] border border-[#303137] rounded-2xl p-6 shadow-xl space-y-4">
        <h4 class="text-xs uppercase tracking-wider text-[#92939A] font-semibold">
            Rincian Suku Cadang & Bahan Servis
        </h4>
        <div class="overflow-x-auto rounded-xl border border-[#303137]">
            <table class="w-full text-left text-xs text-[#92939A]">
                <thead class="bg-[#111216] uppercase tracking-wider text-[#92939A] border-b border-[#303137]">
                    <tr>
                        <th class="px-4 py-3">Nama Suku Cadang</th>
                        <th class="px-4 py-3">Kategori</th>
                        <th class="px-4 py-3 text-center">Jumlah (Qty)</th>
                        <th class="px-4 py-3 text-right">Harga Satuan</th>
                        <th class="px-4 py-3 text-right">Subtotal</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#303137]/60">
                    @forelse($serviceDetail->serviceSpareparts as $part)
                        <tr>
                            <td class="px-4 py-3 font-semibold text-[#F4F2EF]">
                                {{ $part->sparepart->name ?? 'Part Terhapus' }}
                            </td>
                            <td class="px-4 py-3">
                                <span class="inline-flex px-2 py-0.5 rounded text-[11px] bg-[#111216] border border-[#303137] text-[#92939A]">
                                    {{ $part->sparepart->category ?? '-' }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-center font-mono text-[#F4F2EF]">{{ $part->quantity }}</td>
                            <td class="px-4 py-3 text-right font-mono">Rp {{ number_format($part->unit_price, 0, ',', '.') }}</td>
                            <td class="px-4 py-3 text-right font-mono font-bold text-[#F4F2EF]">Rp {{ number_format($part->subtotal, 0, ',', '.') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-4 py-6 text-center text-[#92939A] italic">
                                Servis ini tidak memerlukan penggantian suku cadang (Hanya Biaya Jasa Servis).
                            </td>
                        </tr>
                    @endforelse
                </tbody>
                <tfoot class="bg-[#111216] border-t border-[#303137]">
                    <tr>
                        <td colspan="4" class="px-4 py-2.5 text-right uppercase tracking-wider text-xs font-semibold text-[#92939A]">Biaya Jasa Servis:</td>
                        <td class="px-4 py-2.5 text-right font-mono font-bold text-[#F4F2EF] text-xs">Rp {{ number_format($serviceDetail->service_cost, 0, ',', '.') }}</td>
                    </tr>
                    <tr>
                        <td colspan="4" class="px-4 py-2.5 text-right uppercase tracking-wider text-xs font-semibold text-[#92939A]">Total Biaya Suku Cadang:</td>
                        <td class="px-4 py-2.5 text-right font-mono font-bold text-[#F4F2EF] text-xs">
                            Rp {{ number_format($serviceDetail->serviceSpareparts->sum('subtotal'), 0, ',', '.') }}
                        </td>
                    </tr>
                    <tr class="bg-[#222329]/60">
                        <td colspan="4" class="px-4 py-3 text-right uppercase tracking-wider text-xs font-bold text-[#E23B3B]">Grand Total Biaya:</td>
                        <td class="px-4 py-3 text-right font-mono font-bold text-base text-[#E23B3B]">
                            Rp {{ number_format($serviceDetail->service_cost + $serviceDetail->serviceSpareparts->sum('subtotal'), 0, ',', '.') }}
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>

</div>
@endsection
