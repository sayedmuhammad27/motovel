@extends('layouts.app')

@section('title', 'Katalog Layanan Servis | MOTOVEL')
@section('meta_description', 'Daftar paket layanan perawatan dan servis sepeda motor presisi MOTOVEL lengkap dengan estimasi durasi dan garansi.')

@section('content')
<div class="py-12 sm:py-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-16">

        <!-- Header -->
        <div class="max-w-3xl space-y-4">
            <span class="text-xs uppercase tracking-[0.25em] text-[#9a1312] font-bold">Katalog Layanan</span>
            <h1 class="font-display text-4xl sm:text-5xl lg:text-6xl font-bold text-[#F4F2EF] leading-tight">
                Paket Layanan Servis Presisi MOTOVEL
            </h1>
            <p class="text-base sm:text-lg text-[#92939A] font-light leading-relaxed">
                Setiap jenis pengerjaan dikerjakan menggunakan checklist SOP resmi, peralatan berstandar industri, dan garansi servis pasca pengerjaan.
            </p>
        </div>

        <!-- Services Detailed List -->
        <div class="space-y-8">
            
            <!-- Service 1 -->
            <div class="bg-[#111216] border border-[#303137] rounded-2xl p-6 sm:p-8 flex flex-col lg:flex-row gap-8 items-start lg:items-center justify-between hover:border-[#9a1312]/50 transition-colors">
                <div class="space-y-3 max-w-2xl">
                    <div class="flex items-center gap-3">
                        <span class="text-xs font-mono font-bold text-[#9a1312] bg-[#9a1312]/10 px-2.5 py-1 rounded">PAKET 01</span>
                        <span class="text-xs text-[#92939A]">Estimasi: 45 - 60 Menit</span>
                        <span class="text-xs text-emerald-400 border border-emerald-500/30 bg-emerald-500/10 px-2 py-0.5 rounded-full">Garansi 7 Hari</span>
                    </div>
                    <h2 class="font-display text-2xl sm:text-3xl font-bold text-[#F4F2EF]">Tune Up & Servis Ringan Berkala</h2>
                    <p class="text-sm text-[#92939A] leading-relaxed">
                        Pembersihan throttle body dan ruang bakar menggunakan carbon cleaner, pembersihan filter udara, pengecekan celah klep, busi, aki, tekanan ban, dan pelumasan 18 titik komponen bergerak.
                    </p>
                    <div class="text-xs text-[#92939A] flex flex-wrap gap-4 pt-2">
                        <span>• Cocok untuk matic dan sport harian</span>
                        <span>• Kalibrasi sensor TPS komputer</span>
                        <span>• Free check aki & pengisian</span>
                    </div>
                </div>
                <div class="flex flex-col sm:flex-row lg:flex-col items-start lg:items-end justify-between w-full lg:w-auto gap-4 pt-4 lg:pt-0 border-t lg:border-t-0 border-[#303137]">
                    <div class="lg:text-right">
                        <span class="text-xs text-[#92939A] block">Jasa Servis Mulai</span>
                        <span class="font-display text-2xl font-bold text-[#F4F2EF]">Rp 95.000</span>
                    </div>
                    <a href="{{ url('/booking') }}" class="w-full sm:w-auto bg-[#9a1312] hover:bg-[#b91a19] text-white text-xs uppercase tracking-widest font-semibold py-3 px-6 rounded-xl transition-colors text-center">
                        Pilih Servis Ini
                    </a>
                </div>
            </div>

            <!-- Service 2 -->
            <div class="bg-[#111216] border border-[#303137] rounded-2xl p-6 sm:p-8 flex flex-col lg:flex-row gap-8 items-start lg:items-center justify-between hover:border-[#9a1312]/50 transition-colors">
                <div class="space-y-3 max-w-2xl">
                    <div class="flex items-center gap-3">
                        <span class="text-xs font-mono font-bold text-[#9a1312] bg-[#9a1312]/10 px-2.5 py-1 rounded">PAKET 02</span>
                        <span class="text-xs text-[#92939A]">Estimasi: 1 - 2 Hari</span>
                        <span class="text-xs text-emerald-400 border border-emerald-500/30 bg-emerald-500/10 px-2 py-0.5 rounded-full">Garansi 30 Hari</span>
                    </div>
                    <h2 class="font-display text-2xl sm:text-3xl font-bold text-[#F4F2EF]">Servis Besar & Overhaul Mesin</h2>
                    <p class="text-sm text-[#92939A] leading-relaxed">
                        Pembongkaran silinder blok dan head, pembersihan kerak ruang bakar secara mendalam, skir klep, penggantian sil klep dan paking set original, pengecekan stang seher dan kruk as.
                    </p>
                    <div class="text-xs text-[#92939A] flex flex-wrap gap-4 pt-2">
                        <span>• Khusus motor dengan asap putih atau kompresi drop</span>
                        <span>• Pemasangan dengan kunci torsi presisi</span>
                    </div>
                </div>
                <div class="flex flex-col sm:flex-row lg:flex-col items-start lg:items-end justify-between w-full lg:w-auto gap-4 pt-4 lg:pt-0 border-t lg:border-t-0 border-[#303137]">
                    <div class="lg:text-right">
                        <span class="text-xs text-[#92939A] block">Jasa Servis Mulai</span>
                        <span class="font-display text-2xl font-bold text-[#F4F2EF]">Rp 350.000</span>
                    </div>
                    <a href="{{ url('/booking') }}" class="w-full sm:w-auto bg-[#9a1312] hover:bg-[#b91a19] text-white text-xs uppercase tracking-widest font-semibold py-3 px-6 rounded-xl transition-colors text-center">
                        Pilih Servis Ini
                    </a>
                </div>
            </div>

            <!-- Service 3 -->
            <div class="bg-[#111216] border border-[#303137] rounded-2xl p-6 sm:p-8 flex flex-col lg:flex-row gap-8 items-start lg:items-center justify-between hover:border-[#9a1312]/50 transition-colors">
                <div class="space-y-3 max-w-2xl">
                    <div class="flex items-center gap-3">
                        <span class="text-xs font-mono font-bold text-[#9a1312] bg-[#9a1312]/10 px-2.5 py-1 rounded">PAKET 03</span>
                        <span class="text-xs text-[#92939A]">Estimasi: 60 Menit</span>
                        <span class="text-xs text-emerald-400 border border-emerald-500/30 bg-emerald-500/10 px-2 py-0.5 rounded-full">Garansi 14 Hari</span>
                    </div>
                    <h2 class="font-display text-2xl sm:text-3xl font-bold text-[#F4F2EF]">Perawatan CVT Matic Bebas Gredek</h2>
                    <p class="text-sm text-[#92939A] leading-relaxed">
                        Pembersihan mangkok ganda, kampas kopling matic, puli primer & sekunder, penggantian grease CVT bersuhu tinggi, pengecekan keausan V-belt, slider, dan roller CVT.
                    </p>
                    <div class="text-xs text-[#92939A] flex flex-wrap gap-4 pt-2">
                        <span>• Solusi tuntas getaran awal motor matic</span>
                        <span>• Pelumasan grease hi-temp tahan panas</span>
                    </div>
                </div>
                <div class="flex flex-col sm:flex-row lg:flex-col items-start lg:items-end justify-between w-full lg:w-auto gap-4 pt-4 lg:pt-0 border-t lg:border-t-0 border-[#303137]">
                    <div class="lg:text-right">
                        <span class="text-xs text-[#92939A] block">Jasa Servis Mulai</span>
                        <span class="font-display text-2xl font-bold text-[#F4F2EF]">Rp 75.000</span>
                    </div>
                    <a href="{{ url('/booking') }}" class="w-full sm:w-auto bg-[#9a1312] hover:bg-[#b91a19] text-white text-xs uppercase tracking-widest font-semibold py-3 px-6 rounded-xl transition-colors text-center">
                        Pilih Servis Ini
                    </a>
                </div>
            </div>

            <!-- Service 4 -->
            <div class="bg-[#111216] border border-[#303137] rounded-2xl p-6 sm:p-8 flex flex-col lg:flex-row gap-8 items-start lg:items-center justify-between hover:border-[#9a1312]/50 transition-colors">
                <div class="space-y-3 max-w-2xl">
                    <div class="flex items-center gap-3">
                        <span class="text-xs font-mono font-bold text-[#9a1312] bg-[#9a1312]/10 px-2.5 py-1 rounded">PAKET 04</span>
                        <span class="text-xs text-[#92939A]">Estimasi: 30 - 45 Menit</span>
                        <span class="text-xs text-emerald-400 border border-emerald-500/30 bg-emerald-500/10 px-2 py-0.5 rounded-full">Garansi Pengerjaan</span>
                    </div>
                    <h2 class="font-display text-2xl sm:text-3xl font-bold text-[#F4F2EF]">Sistem Pengereman & Bleeding Hidraulik</h2>
                    <p class="text-sm text-[#92939A] leading-relaxed">
                        Pembersihan piston kaliper rem dari debu asbes, pelumasan pin kaliper, penggantian kampas rem depan/belakang, pengurasan dan bleeding minyak rem baru bebas angin palsu.
                    </p>
                </div>
                <div class="flex flex-col sm:flex-row lg:flex-col items-start lg:items-end justify-between w-full lg:w-auto gap-4 pt-4 lg:pt-0 border-t lg:border-t-0 border-[#303137]">
                    <div class="lg:text-right">
                        <span class="text-xs text-[#92939A] block">Jasa Servis Mulai</span>
                        <span class="font-display text-2xl font-bold text-[#F4F2EF]">Rp 50.000</span>
                    </div>
                    <a href="{{ url('/booking') }}" class="w-full sm:w-auto bg-[#9a1312] hover:bg-[#b91a19] text-white text-xs uppercase tracking-widest font-semibold py-3 px-6 rounded-xl transition-colors text-center">
                        Pilih Servis Ini
                    </a>
                </div>
            </div>

            <!-- Service 5 -->
            <div class="bg-[#111216] border border-[#303137] rounded-2xl p-6 sm:p-8 flex flex-col lg:flex-row gap-8 items-start lg:items-center justify-between hover:border-[#9a1312]/50 transition-colors">
                <div class="space-y-3 max-w-2xl">
                    <div class="flex items-center gap-3">
                        <span class="text-xs font-mono font-bold text-[#9a1312] bg-[#9a1312]/10 px-2.5 py-1 rounded">PAKET 05</span>
                        <span class="text-xs text-[#92939A]">Estimasi: 45 Menit</span>
                        <span class="text-xs text-emerald-400 border border-emerald-500/30 bg-emerald-500/10 px-2 py-0.5 rounded-full">Hasil Akurat</span>
                    </div>
                    <h2 class="font-display text-2xl sm:text-3xl font-bold text-[#F4F2EF]">Diagnostik Injeksi & Reset ECU</h2>
                    <p class="text-sm text-[#92939A] leading-relaxed">
                        Pemindaian seluruh sensor injeksi (IAT, MAP, TPS, EOT/ECT, O2 Sensor), reset kode riwayat kerusakan mesin, penyetelan sudut pengapian dan AFR (Air Fuel Ratio).
                    </p>
                </div>
                <div class="flex flex-col sm:flex-row lg:flex-col items-start lg:items-end justify-between w-full lg:w-auto gap-4 pt-4 lg:pt-0 border-t lg:border-t-0 border-[#303137]">
                    <div class="lg:text-right">
                        <span class="text-xs text-[#92939A] block">Jasa Servis Mulai</span>
                        <span class="font-display text-2xl font-bold text-[#F4F2EF]">Rp 80.000</span>
                    </div>
                    <a href="{{ url('/booking') }}" class="w-full sm:w-auto bg-[#9a1312] hover:bg-[#b91a19] text-white text-xs uppercase tracking-widest font-semibold py-3 px-6 rounded-xl transition-colors text-center">
                        Pilih Servis Ini
                    </a>
                </div>
            </div>

        </div>

    </div>
</div>
@endsection
