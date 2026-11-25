@extends('layouts.app')

@section('title', 'Pendaftaran Servis Berhasil: ' . $service->service_id)

@section('content')
<div class="py-12 sm:py-20">
    <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">

        <!-- Success Header -->
        <div class="text-center space-y-3">
            <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-emerald-500/10 text-emerald-400 border border-emerald-500/30 mb-2">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
            </div>
            <span class="text-xs uppercase tracking-[0.25em] text-emerald-400 font-bold block">Pendaftaran Berhasil</span>
            <h1 class="font-display text-3xl sm:text-4xl font-bold text-[#F4F2EF]">
                Reservasi Servis Motor Anda Terkonfirmasi
            </h1>
            <p class="text-xs sm:text-sm text-[#92939A]">
                Data pendaftaran telah tersimpan ke dalam sistem antrean bengkel MOTOVEL.
            </p>
        </div>

        <!-- Official Booking Card (Printable) -->
        <div id="booking-receipt" class="bg-[#111216] border border-[#303137] rounded-2xl p-6 sm:p-8 shadow-2xl relative overflow-hidden space-y-6">
            <!-- Red Decorative Accent Stripe -->
            <div class="absolute top-0 left-0 right-0 h-1.5 bg-gradient-to-r from-[#9a1312] via-[#b91a19] to-[#9a1312]"></div>

            <div class="flex items-center justify-between border-b border-[#303137] pb-5">
                <div>
                    <span class="text-[10px] uppercase tracking-[0.2em] text-[#92939A] block">Kode Pendaftaran Servis</span>
                    <span class="font-mono text-2xl sm:text-3xl font-bold text-[#b91a19] tracking-wider">{{ $service->service_id }}</span>
                </div>
                <div class="text-right">
                    <x-status-badge :status="$service->status" type="service" />
                    <span class="text-[10px] text-[#92939A] block mt-1">Status Antrean</span>
                </div>
            </div>

            <!-- Detail Information List -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs">
                <div>
                    <span class="text-[#92939A] block">Nama Pemilik:</span>
                    <strong class="text-[#F4F2EF] text-sm">{{ $service->customer->name ?? '-' }}</strong>
                    <span class="text-[11px] text-[#92939A] block font-mono">{{ $service->customer->customer_id ?? '' }}</span>
                </div>

                <div>
                    <span class="text-[#92939A] block">Nomor WhatsApp:</span>
                    <strong class="text-[#F4F2EF] text-sm font-mono">{{ $service->customer->phone ?? '-' }}</strong>
                </div>

                <div>
                    <span class="text-[#92939A] block">Sepeda Motor:</span>
                    <strong class="text-[#F4F2EF] text-sm font-mono">{{ $service->vehicle->plate_number ?? '-' }}</strong>
                    <span class="text-[11px] text-[#92939A] block">{{ ucfirst($service->vehicle->type ?? '-') }} | {{ $service->vehicle->color ?? '' }} ({{ $service->vehicle->year ?? '' }})</span>
                </div>

                <div>
                    <span class="text-[#92939A] block">Rencana Tanggal Servis:</span>
                    <strong class="text-[#F4F2EF] text-sm">{{ $service->service_date ? $service->service_date->format('d F Y') : '-' }}</strong>
                    <span class="text-[11px] text-[#b91a19] block">Pukul 08:30 - 16:30 WIB</span>
                </div>
            </div>

            <!-- Complaint -->
            <div class="border-t border-[#303137] pt-4 text-xs">
                <span class="text-[#92939A] block mb-1">Keluhan / Catatan Teknis:</span>
                <p class="text-[#F4F2EF] bg-[#191A1F] border border-[#303137] p-3 rounded-lg leading-relaxed">
                    {{ $service->complaint }}
                </p>
            </div>

            <!-- Location Instructions -->
            <div class="p-4 rounded-xl bg-[#191A1F] border border-[#303137] text-xs text-[#92939A] space-y-1">
                <p class="font-semibold text-[#F4F2EF]">Petunjuk Kedatangan ke Bengkel:</p>
                <p>1. Datanglah ke bengkel MOTOVEL (Jl. Mayjen Sungkono No. 108, Surabaya) sesuai tanggal yang dipilih.</p>
                <p>2. Tunjukkan kode pendaftaran <strong class="text-[#F4F2EF] font-mono">{{ $service->service_id }}</strong> kepada petugas Front Office.</p>
                <p>3. Kendaraan Anda akan langsung masuk ke antrean pit inspeksi teknisi.</p>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
            <button onclick="window.print()" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 bg-[#191A1F] hover:bg-[#222329] border border-[#303137] text-[#F4F2EF] text-xs uppercase tracking-wider font-semibold py-3 px-6 rounded-xl transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                </svg>
                <span>Cetak / Simpan Bukti</span>
            </button>

            <a href="{{ url('/') }}" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 bg-[#9a1312] hover:bg-[#b91a19] text-white text-xs uppercase tracking-wider font-semibold py-3 px-8 rounded-xl transition-colors shadow-lg">
                <span>Kembali ke Beranda</span>
            </a>
        </div>

    </div>
</div>
@endsection
