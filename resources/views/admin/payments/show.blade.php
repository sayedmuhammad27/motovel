@extends('layouts.admin')

@section('title', "Invoice {$payment->payment_id} | MOTOVEL")
@section('header_title', "Invoice Tagihan: {$payment->payment_id}")
@section('header_subtitle', 'Lembar rincian tagihan kasir, rincian biaya pengerjaan teknis, dan verifikasi pembayaran.')

@section('content')
<div class="space-y-6">

    <!-- Top Action Nav -->
    <div class="flex flex-wrap items-center justify-between gap-4">
        <a href="{{ route('admin.payments.index') }}" class="inline-flex items-center gap-2 text-xs font-semibold uppercase tracking-wider text-[#92939A] hover:text-[#F4F2EF] transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            <span>Kembali ke Kasir</span>
        </a>

        <div class="inline-flex items-center gap-3">
            <a href="{{ route('admin.payments.print', $payment->id) }}" target="_blank" class="inline-flex items-center gap-2 bg-[#222329] hover:bg-[#303137] text-[#F4F2EF] text-xs font-semibold py-2 px-4 rounded-xl border border-[#303137] transition-colors">
                <svg class="w-4 h-4 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                <span>Cetak Nota Struk</span>
            </a>

            <a href="{{ route('admin.payments.edit', $payment->id) }}" class="inline-flex items-center gap-2 bg-[#C62828] hover:bg-[#E23B3B] text-white text-xs font-semibold py-2 px-4 rounded-xl transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                <span>Edit Pembayaran</span>
            </a>
        </div>
    </div>

    <!-- Digital Invoice Wrapper -->
    <div class="bg-[#191A1F] border border-[#303137] rounded-2xl p-6 sm:p-10 shadow-2xl max-w-4xl mx-auto space-y-8">
        
        <!-- Invoice Header -->
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center pb-8 border-b border-[#303137] gap-4">
            <div>
                <div class="flex items-center gap-3">
                    <span class="font-display text-2xl font-bold tracking-tight text-[#F4F2EF]">MOTO<span class="text-[#E23B3B]">VEL</span></span>
                    <span class="text-xs uppercase tracking-widest text-[#92939A] px-2.5 py-0.5 rounded bg-[#111216] border border-[#303137]">Official Invoice</span>
                </div>
                <p class="text-xs text-[#92939A] mt-1">Precision Care. Performance You Can Trust.</p>
            </div>
            <div class="text-left sm:text-right">
                <div class="font-mono text-xl font-bold text-[#E23B3B]">{{ $payment->payment_id }}</div>
                <div class="text-xs text-[#92939A] mt-0.5">Tanggal Terbit: {{ $payment->created_at->translatedFormat('d F Y') }}</div>
            </div>
        </div>

        <!-- Meta Grid: Customer, Vehicle, & Payment Status -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 text-xs">
            <!-- Pelanggan -->
            <div class="p-4 rounded-xl bg-[#111216] border border-[#303137] space-y-1">
                <span class="uppercase tracking-wider text-[#92939A] font-semibold">Ditagihkan Kepada:</span>
                <div class="font-bold text-sm text-[#F4F2EF] mt-1">{{ $payment->serviceRegistration->customer->name ?? '-' }}</div>
                <div class="font-mono text-[#92939A]">{{ $payment->serviceRegistration->customer->phone ?? '-' }}</div>
                <div class="text-[#92939A] truncate">{{ $payment->serviceRegistration->customer->address ?? '-' }}</div>
            </div>

            <!-- Kendaraan & Mekanik -->
            <div class="p-4 rounded-xl bg-[#111216] border border-[#303137] space-y-1">
                <span class="uppercase tracking-wider text-[#92939A] font-semibold">Data Unit & Mekanik:</span>
                <div class="font-bold text-sm text-[#F4F2EF] font-mono mt-1">{{ $payment->serviceRegistration->vehicle->plate_number ?? '-' }}</div>
                <div class="text-[#92939A]">{{ $payment->serviceRegistration->vehicle->brand ?? '' }} {{ $payment->serviceRegistration->vehicle->model ?? '' }} ({{ $payment->serviceRegistration->vehicle->year ?? '' }})</div>
                <div class="text-[#92939A]">Mekanik: <span class="text-[#F4F2EF] font-medium">{{ $payment->serviceRegistration->serviceDetail->mechanic->name ?? 'Belum Ditentukan' }}</span></div>
            </div>

            <!-- Status Pelunasan -->
            <div class="p-4 rounded-xl bg-[#111216] border border-[#303137] space-y-2">
                <span class="uppercase tracking-wider text-[#92939A] font-semibold">Status Pelunasan:</span>
                <div>
                    @if($payment->status === 'paid')
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-emerald-500/10 text-emerald-400 border border-emerald-500/30">
                            LUNAS (PAID)
                        </span>
                        <div class="text-[11px] text-[#92939A] mt-1">
                            Tgl Bayar: {{ $payment->payment_date ? \Carbon\Carbon::parse($payment->payment_date)->translatedFormat('d F Y') : '-' }}
                        </div>
                    @else
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-amber-500/10 text-amber-400 border border-amber-500/30">
                            MENUNGGU PEMBAYARAN
                        </span>
                    @endif
                </div>
                <div class="text-[11px] text-[#92939A]">
                    Metode: <span class="font-mono font-bold uppercase text-[#F4F2EF]">{{ $payment->payment_type }}</span>
                </div>
            </div>
        </div>

        <!-- Line Items Table -->
        <div class="overflow-x-auto rounded-xl border border-[#303137]">
            <table class="w-full text-left text-xs text-[#92939A]">
                <thead class="bg-[#111216] uppercase tracking-wider text-[#92939A] border-b border-[#303137]">
                    <tr>
                        <th class="px-6 py-3.5">Deskripsi Transaksi / Layanan</th>
                        <th class="px-6 py-3.5 text-center">Qty</th>
                        <th class="px-6 py-3.5 text-right">Harga Satuan</th>
                        <th class="px-6 py-3.5 text-right">Total</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#303137]/60">
                    <!-- Biaya Jasa Servis -->
                    <tr>
                        <td class="px-6 py-4">
                            <div class="font-semibold text-[#F4F2EF]">Biaya Jasa Servis & Perawatan Mesin</div>
                            <div class="text-[11px] text-[#92939A] mt-0.5">Penanganan teknisi: {{ $payment->serviceRegistration->serviceDetail->mechanic->name ?? 'Tim Teknisi MOTOVEL' }}</div>
                        </td>
                        <td class="px-6 py-4 text-center font-mono">1</td>
                        <td class="px-6 py-4 text-right font-mono">Rp {{ number_format($payment->service_cost, 0, ',', '.') }}</td>
                        <td class="px-6 py-4 text-right font-mono font-bold text-[#F4F2EF]">Rp {{ number_format($payment->service_cost, 0, ',', '.') }}</td>
                    </tr>

                    <!-- Spareparts -->
                    @if($payment->serviceRegistration->serviceDetail && $payment->serviceRegistration->serviceDetail->serviceSpareparts->isNotEmpty())
                        @foreach($payment->serviceRegistration->serviceDetail->serviceSpareparts as $part)
                            <tr>
                                <td class="px-6 py-3.5">
                                    <div class="font-semibold text-[#F4F2EF]">{{ $part->sparepart->name ?? 'Part' }}</div>
                                    <div class="text-[11px] text-[#92939A]">Kategori: {{ $part->sparepart->category ?? '-' }}</div>
                                </td>
                                <td class="px-6 py-3.5 text-center font-mono">{{ $part->quantity }}</td>
                                <td class="px-6 py-3.5 text-right font-mono">Rp {{ number_format($part->unit_price, 0, ',', '.') }}</td>
                                <td class="px-6 py-3.5 text-right font-mono font-bold text-[#F4F2EF]">Rp {{ number_format($part->subtotal, 0, ',', '.') }}</td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
                <tfoot class="bg-[#111216] border-t border-[#303137]">
                    <tr>
                        <td colspan="3" class="px-6 py-2.5 text-right uppercase tracking-wider text-xs font-semibold text-[#92939A]">Subtotal Jasa Servis:</td>
                        <td class="px-6 py-2.5 text-right font-mono font-bold text-[#F4F2EF] text-xs">Rp {{ number_format($payment->service_cost, 0, ',', '.') }}</td>
                    </tr>
                    <tr>
                        <td colspan="3" class="px-6 py-2.5 text-right uppercase tracking-wider text-xs font-semibold text-[#92939A]">Subtotal Suku Cadang:</td>
                        <td class="px-6 py-2.5 text-right font-mono font-bold text-[#F4F2EF] text-xs">Rp {{ number_format($payment->sparepart_cost, 0, ',', '.') }}</td>
                    </tr>
                    <tr class="bg-[#222329]/80 border-t border-[#303137]">
                        <td colspan="3" class="px-6 py-4 text-right uppercase tracking-wider text-sm font-bold text-[#E23B3B]">Total Pembayaran Akhir:</td>
                        <td class="px-6 py-4 text-right font-mono font-bold text-xl text-[#E23B3B]">
                            Rp {{ number_format($payment->total_amount, 0, ',', '.') }}
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>

        @if($payment->notes)
            <div class="p-4 rounded-xl bg-[#111216] border border-[#303137] text-xs">
                <span class="uppercase tracking-wider text-[#92939A] font-semibold">Catatan Kasir:</span>
                <p class="text-[#F4F2EF] mt-1">{{ $payment->notes }}</p>
            </div>
        @endif

        <!-- Footer / Signatures Notice -->
        <div class="pt-6 border-t border-[#303137] flex flex-col sm:flex-row justify-between items-center text-xs text-[#92939A] gap-4">
            <p>Terima kasih telah mempercayakan perawatan motor Anda kepada MOTOVEL Service Workshop.</p>
            <div class="flex items-center gap-2">
                <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                <span>Terverifikasi Sistem Kasir Digital</span>
            </div>
        </div>

    </div>

</div>
@endsection
