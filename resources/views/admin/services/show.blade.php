@extends('layouts.admin')

@section('title', "Detail Servis {$service->service_id} | MOTOVEL")
@section('header_title', "Detail Servis: {$service->service_id}")
@section('header_subtitle', 'Tinjauan lengkap alur servis kendaraan, teknisi penanggung jawab, suku cadang, dan status kasir.')

@section('content')
<div class="space-y-6">

    <!-- Top Action Nav -->
    <div class="flex flex-wrap items-center justify-between gap-4">
        <a href="{{ route('admin.services.index') }}" class="inline-flex items-center gap-2 text-xs font-semibold uppercase tracking-wider text-[#92939A] hover:text-[#F4F2EF] transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            <span>Kembali ke Daftar Servis</span>
        </a>

        <div class="inline-flex items-center gap-3">
            @if(!$service->serviceDetail)
                <a href="{{ route('admin.service-details.create', ['service_id' => $service->id]) }}" class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-500 text-white text-xs font-semibold py-2 px-4 rounded-xl transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
                    <span>Input Pengerjaan Teknis</span>
                </a>
            @endif

            @if(!$service->payment)
                <a href="{{ route('admin.payments.create', ['service_id' => $service->id]) }}" class="inline-flex items-center gap-2 bg-emerald-600 hover:bg-emerald-500 text-white text-xs font-semibold py-2 px-4 rounded-xl transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                    <span>Buat Tagihan Kasir</span>
                </a>
            @else
                <a href="{{ route('admin.payments.print', $service->payment->id) }}" target="_blank" class="inline-flex items-center gap-2 bg-[#222329] hover:bg-[#303137] text-[#F4F2EF] text-xs font-semibold py-2 px-4 rounded-xl border border-[#303137] transition-colors">
                    <svg class="w-4 h-4 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                    <span>Cetak Nota Kasir</span>
                </a>
            @endif

            <a href="{{ route('admin.services.edit', $service->id) }}" class="inline-flex items-center gap-2 bg-[#222329] hover:bg-[#303137] text-white text-xs font-semibold py-2 px-4 rounded-xl border border-[#303137] transition-colors">
                <svg class="w-4 h-4 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                <span>Edit Servis</span>
            </a>
        </div>
    </div>

    <!-- Status & Overview Hero Card -->
    <div class="bg-[#191A1F] border border-[#303137] rounded-2xl p-6 shadow-xl">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 items-center">
            <div>
                <span class="text-xs uppercase tracking-wider text-[#92939A]">Nomor Pendaftaran</span>
                <h3 class="font-mono text-2xl font-bold text-[#b91a19] mt-1">{{ $service->service_id }}</h3>
                <p class="text-xs text-[#92939A] mt-1">Registrasi: {{ $service->created_at->translatedFormat('d F Y, H:i') }}</p>
            </div>
            <div>
                <span class="text-xs uppercase tracking-wider text-[#92939A]">Jadwal Servis</span>
                <div class="text-base font-semibold text-[#F4F2EF] font-mono mt-1">
                    {{ \Carbon\Carbon::parse($service->service_date)->translatedFormat('l, d F Y') }}
                </div>
            </div>
            <div>
                <span class="text-xs uppercase tracking-wider text-[#92939A]">Status Pengerjaan</span>
                <div class="mt-1">
                    @if($service->status === 'waiting')
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-amber-500/10 text-amber-400 border border-amber-500/20">Menunggu (Waiting)</span>
                    @elseif($service->status === 'in_progress')
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-blue-500/10 text-blue-400 border border-blue-500/20">Sedang Dikerjakan</span>
                    @elseif($service->status === 'completed')
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-emerald-500/10 text-emerald-400 border border-emerald-500/20">Selesai (Completed)</span>
                    @else
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-rose-500/10 text-rose-400 border border-rose-500/20">Dibatalkan</span>
                    @endif
                </div>
            </div>
            <div>
                <span class="text-xs uppercase tracking-wider text-[#92939A]">Status Pembayaran</span>
                <div class="mt-1">
                    @if($service->payment)
                        @if($service->payment->status === 'paid')
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-emerald-500/10 text-emerald-400 border border-emerald-500/20">
                                Lunas (Rp {{ number_format($service->payment->total_amount, 0, ',', '.') }})
                            </span>
                        @else
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-amber-500/10 text-amber-400 border border-amber-500/20">
                                Pending (Rp {{ number_format($service->payment->total_amount, 0, ',', '.') }})
                            </span>
                        @endif
                    @else
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-[#222329] text-[#92939A] border border-[#303137]">
                            Belum Dibuat Tagihan
                        </span>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Info Grid: Unit Motor & Customer Profile -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Motor Card -->
        <div class="bg-[#191A1F] border border-[#303137] rounded-2xl p-6 shadow-xl">
            <h4 class="text-xs uppercase tracking-wider text-[#b91a19] font-bold mb-4 flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                <span>Identitas Sepeda Motor</span>
            </h4>
            <div class="space-y-3 text-sm">
                <div class="flex justify-between py-2 border-b border-[#303137]/60">
                    <span class="text-[#92939A]">Nomor Polisi:</span>
                    <span class="font-bold text-[#F4F2EF] font-mono">{{ $service->vehicle->plate_number ?? '-' }}</span>
                </div>
                <div class="flex justify-between py-2 border-b border-[#303137]/60">
                    <span class="text-[#92939A]">Merek & Model:</span>
                    <span class="text-[#F4F2EF] font-medium">{{ $service->vehicle->brand ?? '-' }} {{ $service->vehicle->model ?? '' }}</span>
                </div>
                <div class="flex justify-between py-2 border-b border-[#303137]/60">
                    <span class="text-[#92939A]">Tipe Transmisi:</span>
                    <span class="text-[#F4F2EF] capitalize">{{ $service->vehicle->type ?? '-' }}</span>
                </div>
                <div class="flex justify-between py-2 border-b border-[#303137]/60">
                    <span class="text-[#92939A]">Tahun Pembuatan:</span>
                    <span class="text-[#F4F2EF] font-mono">{{ $service->vehicle->year ?? '-' }}</span>
                </div>
                <div class="flex justify-between py-2">
                    <span class="text-[#92939A]">Warna Unit:</span>
                    <span class="text-[#F4F2EF]">{{ $service->vehicle->color ?? '-' }}</span>
                </div>
            </div>
        </div>

        <!-- Customer Card -->
        <div class="bg-[#191A1F] border border-[#303137] rounded-2xl p-6 shadow-xl">
            <h4 class="text-xs uppercase tracking-wider text-[#b91a19] font-bold mb-4 flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                <span>Profil Pemilik (Pelanggan)</span>
            </h4>
            <div class="space-y-3 text-sm">
                <div class="flex justify-between py-2 border-b border-[#303137]/60">
                    <span class="text-[#92939A]">ID Pelanggan:</span>
                    <span class="font-mono text-xs font-bold text-[#b91a19]">{{ $service->customer->customer_id ?? '-' }}</span>
                </div>
                <div class="flex justify-between py-2 border-b border-[#303137]/60">
                    <span class="text-[#92939A]">Nama Lengkap:</span>
                    <span class="font-medium text-[#F4F2EF]">{{ $service->customer->name ?? '-' }}</span>
                </div>
                <div class="flex justify-between py-2 border-b border-[#303137]/60">
                    <span class="text-[#92939A]">Nomor HP / WhatsApp:</span>
                    <span class="font-mono text-[#F4F2EF]">{{ $service->customer->phone ?? '-' }}</span>
                </div>
                <div class="flex justify-between py-2 border-b border-[#303137]/60">
                    <span class="text-[#92939A]">Pekerjaan:</span>
                    <span class="text-[#F4F2EF]">{{ $service->customer->occupation ?? '-' }}</span>
                </div>
                <div class="flex justify-between py-2">
                    <span class="text-[#92939A]">Alamat:</span>
                    <span class="text-[#F4F2EF] text-right max-w-xs">{{ $service->customer->address ?? '-' }}</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Keluhan Permintaan Servis -->
    <div class="bg-[#191A1F] border border-[#303137] rounded-2xl p-6 shadow-xl">
        <h4 class="text-xs uppercase tracking-wider text-[#92939A] font-semibold mb-2">
            Keluhan / Catatan Permintaan Servis dari Pelanggan
        </h4>
        <div class="p-4 rounded-xl bg-[#111216] border border-[#303137] text-sm text-[#F4F2EF] leading-relaxed">
            {{ $service->complaint }}
        </div>
    </div>

    <!-- Technical Service Detail Section -->
    @if($service->serviceDetail)
        <div class="bg-[#191A1F] border border-[#303137] rounded-2xl p-6 shadow-xl space-y-6">
            <div class="flex flex-wrap items-center justify-between gap-4 pb-4 border-b border-[#303137]">
                <div>
                    <h4 class="text-lg font-display font-bold text-[#F4F2EF]">Rincian Teknis Pengerjaan Servis</h4>
                    <p class="text-xs text-[#92939A]">Kode Detail: <span class="font-mono text-[#b91a19]">{{ $service->serviceDetail->detail_id }}</span></p>
                </div>
                <div class="flex items-center gap-3">
                    <a href="{{ route('admin.service-details.show', $service->serviceDetail->id) }}" class="text-xs text-[#92939A] hover:text-[#F4F2EF] underline">Buka Lembar Pengerjaan</a>
                    <a href="{{ route('admin.service-details.edit', $service->serviceDetail->id) }}" class="text-xs bg-[#222329] hover:bg-[#303137] text-white px-3 py-1.5 rounded-lg border border-[#303137]">Edit Detail Teknis</a>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div>
                    <span class="text-xs text-[#92939A] uppercase tracking-wider">Mekanik Penanggung Jawab</span>
                    <div class="font-bold text-[#F4F2EF] mt-1">{{ $service->serviceDetail->mechanic->name ?? 'Belum Ditentukan' }}</div>
                    <div class="text-xs text-[#92939A] mt-0.5">Spesialisasi: {{ $service->serviceDetail->mechanic->specialization ?? '-' }}</div>
                </div>
                <div class="md:col-span-2">
                    <span class="text-xs text-[#92939A] uppercase tracking-wider">Catatan Estimasi & Diagnosis Teknis</span>
                    <p class="text-xs text-[#F4F2EF] mt-1 leading-relaxed bg-[#111216] p-3 rounded-xl border border-[#303137]">
                        {{ $service->serviceDetail->estimation ?: 'Tidak ada catatan teknis khusus.' }}
                    </p>
                </div>
            </div>

            <!-- Spareparts Used Table -->
            <div>
                <h5 class="text-xs uppercase tracking-wider text-[#92939A] font-semibold mb-3">Suku Cadang / Material yang Digunakan</h5>
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
                            @forelse($service->serviceDetail->serviceSpareparts as $part)
                                <tr>
                                    <td class="px-4 py-3 font-semibold text-[#F4F2EF]">
                                        {{ $part->sparepart->name ?? 'Part Tidak Ditemukan' }}
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
                                        Tidak ada suku cadang yang digunakan dalam servis ini (Hanya Jasa Perawatan).
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                        <tfoot class="bg-[#111216] border-t border-[#303137]">
                            <tr>
                                <td colspan="4" class="px-4 py-2.5 text-right uppercase tracking-wider text-xs font-semibold text-[#92939A]">Biaya Jasa Servis:</td>
                                <td class="px-4 py-2.5 text-right font-mono font-bold text-[#F4F2EF] text-xs">Rp {{ number_format($service->serviceDetail->service_cost, 0, ',', '.') }}</td>
                            </tr>
                            <tr>
                                <td colspan="4" class="px-4 py-2.5 text-right uppercase tracking-wider text-xs font-semibold text-[#92939A]">Total Suku Cadang:</td>
                                <td class="px-4 py-2.5 text-right font-mono font-bold text-[#F4F2EF] text-xs">
                                    Rp {{ number_format($service->serviceDetail->serviceSpareparts->sum('subtotal'), 0, ',', '.') }}
                                </td>
                            </tr>
                            <tr class="bg-[#222329]/60">
                                <td colspan="4" class="px-4 py-3 text-right uppercase tracking-wider text-xs font-bold text-[#b91a19]">Total Estimasi Biaya Servis:</td>
                                <td class="px-4 py-3 text-right font-mono font-bold text-base text-[#b91a19]">
                                    Rp {{ number_format($service->serviceDetail->service_cost + $service->serviceDetail->serviceSpareparts->sum('subtotal'), 0, ',', '.') }}
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    @else
        <div class="bg-[#191A1F] border border-dashed border-[#303137] rounded-2xl p-8 text-center">
            <svg class="w-12 h-12 mx-auto text-[#303137] mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
            </svg>
            <h4 class="text-sm font-semibold text-[#F4F2EF]">Belum Ada Rincian Teknis Mekanik</h4>
            <p class="text-xs text-[#92939A] mt-1 max-w-md mx-auto">
                Unit motor ini belum dialokasikan ke teknisi atau belum memiliki rincian pemakaian suku cadang dan jasa servis.
            </p>
            <a href="{{ route('admin.service-details.create', ['service_id' => $service->id]) }}" class="inline-flex items-center gap-2 mt-4 bg-[#9a1312] hover:bg-[#b91a19] text-white text-xs font-semibold py-2.5 px-5 rounded-xl transition-colors">
                <span>Alokasikan Teknisi & Biaya Servis</span>
            </a>
        </div>
    @endif

</div>
@endsection
