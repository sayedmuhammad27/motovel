@extends('layouts.admin')

@section('title', "{$sparepart->name} | MOTOVEL")
@section('header_title', "Detail Suku Cadang: {$sparepart->name}")
@section('header_subtitle', 'Informasi spesifikasi teknis, harga, tingkat ketersediaan stok, dan riwayat pemakaian servis.')

@section('content')
<div class="space-y-6">

    <!-- Top Action Nav -->
    <div class="flex flex-wrap items-center justify-between gap-4">
        <a href="{{ route('admin.spareparts.index') }}" class="inline-flex items-center gap-2 text-xs font-semibold uppercase tracking-wider text-[#92939A] hover:text-[#F4F2EF] transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            <span>Kembali ke Inventaris</span>
        </a>

        <div class="inline-flex items-center gap-3">
            <a href="{{ route('admin.spareparts.edit', $sparepart->id) }}" class="inline-flex items-center gap-2 bg-[#9a1312] hover:bg-[#b91a19] text-white text-xs font-semibold py-2 px-4 rounded-xl transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                <span>Edit Suku Cadang</span>
            </a>
        </div>
    </div>

    <!-- Metadata Card -->
    <div class="bg-[#191A1F] border border-[#303137] rounded-2xl p-6 shadow-xl">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
            <div>
                <span class="text-xs uppercase tracking-wider text-[#92939A]">Kode Suku Cadang</span>
                <div class="font-mono text-2xl font-bold text-[#b91a19] mt-1">{{ $sparepart->sparepart_id }}</div>
                <div class="text-xs text-[#92939A] mt-1">Ditambahkan: {{ $sparepart->created_at->format('d/m/Y') }}</div>
            </div>
            <div>
                <span class="text-xs uppercase tracking-wider text-[#92939A]">Kategori</span>
                <div class="mt-1">
                    <span class="inline-flex px-3 py-1 rounded-full text-xs font-medium bg-[#111216] border border-[#303137] text-[#F4F2EF]">
                        {{ $sparepart->category }}
                    </span>
                </div>
            </div>
            <div>
                <span class="text-xs uppercase tracking-wider text-[#92939A]">Harga Jual Satuan</span>
                <div class="font-mono text-xl font-bold text-[#F4F2EF] mt-1">
                    Rp {{ number_format($sparepart->price, 0, ',', '.') }}
                </div>
            </div>
            <div>
                <span class="text-xs uppercase tracking-wider text-[#92939A]">Status Stok Gudang</span>
                <div class="mt-1">
                    @if($sparepart->stock <= 5)
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-rose-500/10 text-rose-400 border border-rose-500/30">
                            {{ $sparepart->stock }} Unit (Stok Kritis)
                        </span>
                    @elseif($sparepart->stock <= 15)
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-amber-500/10 text-amber-400 border border-amber-500/30">
                            {{ $sparepart->stock }} Unit (Stok Menipis)
                        </span>
                    @else
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-emerald-500/10 text-emerald-400 border border-emerald-500/30 font-mono">
                            {{ $sparepart->stock }} Unit (Tersedia)
                        </span>
                    @endif
                </div>
            </div>
        </div>

        @if($sparepart->description)
            <div class="mt-6 pt-6 border-t border-[#303137]">
                <span class="text-xs uppercase tracking-wider text-[#92939A] font-semibold">Deskripsi & Catatan Spesifikasi</span>
                <p class="text-xs text-[#F4F2EF] mt-1.5 leading-relaxed bg-[#111216] p-4 rounded-xl border border-[#303137]">
                    {{ $sparepart->description }}
                </p>
            </div>
        @endif
    </div>

    <!-- Usage History Table -->
    <div class="bg-[#191A1F] border border-[#303137] rounded-2xl p-6 shadow-xl space-y-4">
        <h4 class="text-sm font-bold uppercase tracking-wider text-[#F4F2EF]">
            Riwayat Pemakaian dalam Servis Bengkel
        </h4>
        <div class="overflow-x-auto rounded-xl border border-[#303137]">
            <table class="w-full text-left text-xs text-[#92939A]">
                <thead class="bg-[#111216] uppercase tracking-wider text-[#92939A] border-b border-[#303137]">
                    <tr>
                        <th class="px-6 py-3.5">ID Servis</th>
                        <th class="px-6 py-3.5">Sepeda Motor</th>
                        <th class="px-6 py-3.5">Mekanik Penanggung Jawab</th>
                        <th class="px-6 py-3.5 text-center">Status Servis</th>
                        <th class="px-6 py-3.5 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#303137]/60">
                    @forelse($sparepart->serviceDetails as $detail)
                        <tr class="hover:bg-[#222329]/50 transition-colors">
                            <td class="px-6 py-3.5 font-mono font-bold text-[#b91a19]">
                                {{ $detail->serviceRegistration->service_id ?? '-' }}
                            </td>
                            <td class="px-6 py-3.5">
                                <span class="font-mono font-bold text-[#F4F2EF]">{{ $detail->serviceRegistration->vehicle->plate_number ?? '-' }}</span>
                                <span class="text-[#92939A] ml-1">({{ $detail->serviceRegistration->vehicle->brand ?? '' }} {{ $detail->serviceRegistration->vehicle->model ?? '' }})</span>
                            </td>
                            <td class="px-6 py-3.5 text-[#F4F2EF]">
                                {{ $detail->mechanic->name ?? '-' }}
                            </td>
                            <td class="px-6 py-3.5 text-center">
                                @if($detail->status === 'completed')
                                    <span class="inline-flex px-2 py-0.5 rounded text-[11px] font-semibold bg-emerald-500/10 text-emerald-400">Selesai</span>
                                @else
                                    <span class="inline-flex px-2 py-0.5 rounded text-[11px] font-semibold bg-blue-500/10 text-blue-400">{{ ucfirst($detail->status) }}</span>
                                @endif
                            </td>
                            <td class="px-6 py-3.5 text-right">
                                <a href="{{ route('admin.service-details.show', $detail->id) }}" class="text-xs text-blue-400 hover:text-blue-300">Detail Pengerjaan</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-8 text-center text-[#92939A] italic">
                                Suku cadang ini belum pernah digunakan dalam transaksi pengerjaan servis bengkel.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
