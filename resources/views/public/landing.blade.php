@extends('layouts.app')

@section('title', 'MOTOVEL | Precision Motorcycle Care & Performance Workshop')
@section('meta_description', 'Bengkel servis motor premium dan perawatan presisi. Teknisi tersertifikasi, suku cadang original, kalibrasi injeksi, dan transparansi penuh.')

@section('content')

<!-- ========================================================================= -->
<!-- SECTION 1: HERO (Fullscreen Cinematic) -->
<!-- ========================================================================= -->
<section class="relative min-h-[92vh] flex items-center justify-center overflow-hidden -mt-20 pt-20">
    <!-- Hero Background Image with Chiaroscuro Lighting -->
    <div class="absolute inset-0 z-0">
        <img src="https://images.unsplash.com/photo-1558618666-fcd25c85f82e?w=1920&auto=format&fit=crop&q=85" 
             alt="Sepeda motor sport premium di bengkel MOTOVEL" 
             class="w-full h-full object-cover object-center filter brightness-[0.38] contrast-[1.15] transform scale-105 transition-transform duration-1000 ease-out"
             fetchpriority="high">
        <!-- Dark Luxury Radial Vignette & Gradient Overlays -->
        <div class="absolute inset-0 bg-gradient-to-t from-[#08090B] via-[#08090B]/60 to-transparent"></div>
        <div class="absolute inset-0 bg-gradient-to-r from-[#08090B]/90 via-transparent to-[#08090B]/80"></div>
        <!-- Subtle Red Ambient Glow -->
        <div class="absolute top-1/3 left-1/2 -translate-x-1/2 w-[700px] h-[350px] bg-[#C62828]/12 rounded-full blur-[150px] pointer-events-none"></div>
    </div>

    <!-- Hero Content -->
    <div class="relative z-10 max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 text-center py-20 reveal-on-scroll">
        
        <!-- Category Kicker -->
        <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-[#191A1F]/80 border border-[#303137] text-xs font-semibold uppercase tracking-[0.25em] text-[#E23B3B] mb-6">
            <span class="w-1.5 h-1.5 rounded-full bg-[#C62828] animate-pulse"></span>
            Precision Motorcycle Care
        </div>

        <!-- Main Headline -->
        <h1 class="font-display text-4xl sm:text-6xl md:text-7xl lg:text-8xl font-bold tracking-tight text-[#F4F2EF] leading-[1.08] mb-6">
            Beyond Ordinary.<br>
            <span class="text-transparent bg-clip-text bg-gradient-to-r from-[#F4F2EF] via-[#F4F2EF] to-[#92939A]">Built on Precision.</span>
        </h1>

        <!-- Subtitle -->
        <p class="max-w-2xl mx-auto text-base sm:text-lg md:text-xl text-[#92939A] font-light leading-relaxed mb-10">
            Professional Motorcycle Service. Precision Maintenance. Performance You Can Trust.
        </p>

        <!-- CTAs -->
        <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
            <a href="{{ url('/booking') }}" 
               class="w-full sm:w-auto inline-flex items-center justify-center gap-3 bg-[#C62828] hover:bg-[#E23B3B] text-white text-xs uppercase tracking-widest font-semibold py-4 px-9 rounded-full shadow-2xl shadow-[#C62828]/35 hover:shadow-[#C62828]/55 transition-all duration-300 transform hover:-translate-y-1 focus:outline-none focus:ring-2 focus:ring-[#C62828]">
                <span>Daftar Servis Sekarang</span>
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                </svg>
            </a>
            <a href="#services-section" 
               class="w-full sm:w-auto inline-flex items-center justify-center gap-2 bg-[#191A1F]/80 hover:bg-[#222329] border border-[#303137] hover:border-[#92939A] text-[#F4F2EF] text-xs uppercase tracking-widest font-semibold py-4 px-8 rounded-full transition-all duration-300 focus:outline-none">
                <span>Jelajahi Layanan</span>
                <svg class="w-3.5 h-3.5 text-[#92939A]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                </svg>
            </a>
        </div>

        <!-- Scroll Indicator -->
        <div class="mt-16 flex flex-col items-center gap-2 text-[10px] uppercase tracking-[0.25em] text-[#92939A]">
            <span>Gulir ke Bawah</span>
            <div class="w-5 h-8 rounded-full border border-[#303137] flex items-start justify-center p-1">
                <div class="w-1 h-2 rounded-full bg-[#C62828] animate-bounce"></div>
            </div>
        </div>

    </div>
</section>

<!-- ========================================================================= -->
<!-- SECTION 2: BRAND INTRODUCTION (Editorial Asymmetric Layout) -->
<!-- ========================================================================= -->
<section class="py-24 bg-[#08090B] relative">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-16 items-center">
            
            <!-- Left Editorial Text -->
            <div class="lg:col-span-6 space-y-6 reveal-on-scroll">
                <span class="text-xs uppercase tracking-[0.25em] text-[#C62828] font-bold">Atelier Servis Presisi</span>
                <h2 class="font-display text-3xl sm:text-4xl lg:text-5xl font-bold text-[#F4F2EF] leading-tight">
                    More Than Just A Motorcycle Workshop.
                </h2>
                <div class="space-y-4 text-sm sm:text-base text-[#92939A] leading-relaxed">
                    <p>
                        MOTOVEL lahir dari komitmen mendalam bahwa setiap sepeda motor adalah mahakarya mekanis yang membutuhkan penanganan teliti, alat diagnostik akurat, dan transparansi pengerjaan tanpa kompromi.
                    </p>
                    <p>
                        Kami menolak praktik bengkel konvensional yang menebak masalah tanpa dasar data. Dari motor matic harian hingga motor sport performa tinggi, setiap unit kendaraan diperiksa menggunakan prosedur terstandarisasi, suku cadang teruji, dan dikerjakan oleh mekanik berpengalaman.
                    </p>
                </div>

                <div class="pt-4 grid grid-cols-3 gap-4 border-t border-[#303137]">
                    <div>
                        <p class="font-display text-2xl lg:text-3xl font-bold text-[#F4F2EF]">{{ $totalCustomers }}+</p>
                        <p class="text-xs text-[#92939A] uppercase tracking-wider mt-0.5">Pelanggan Aktif</p>
                    </div>
                    <div>
                        <p class="font-display text-2xl lg:text-3xl font-bold text-[#E23B3B]">{{ $totalServicesDone }}+</p>
                        <p class="text-xs text-[#92939A] uppercase tracking-wider mt-0.5">Servis Tuntas</p>
                    </div>
                    <div>
                        <p class="font-display text-2xl lg:text-3xl font-bold text-[#F4F2EF]">{{ $totalMechanics }}</p>
                        <p class="text-xs text-[#92939A] uppercase tracking-wider mt-0.5">Mekanik Handal</p>
                    </div>
                </div>
            </div>

            <!-- Right Featured Image with Frame Depth -->
            <div class="lg:col-span-6 relative reveal-on-scroll reveal-delay-2">
                <div class="relative rounded-2xl overflow-hidden border border-[#303137] bg-[#111216] shadow-2xl group">
                    <img src="https://images.unsplash.com/photo-1619642751034-765dfdf7c58e?w=1000&auto=format&fit=crop&q=80" 
                         alt="Mekanik MOTOVEL melakukan servis presisi pada sepeda motor" 
                         class="w-full h-[450px] object-cover filter contrast-[1.1] group-hover:scale-105 transition-transform duration-700">
                    <div class="absolute inset-0 bg-gradient-to-t from-[#08090B] via-transparent to-transparent"></div>
                    <div class="absolute bottom-6 left-6 right-6 p-4 rounded-xl bg-[#111216]/90 backdrop-blur-md border border-[#303137]">
                        <p class="text-xs font-semibold text-[#F4F2EF]">Standar Pengerjaan Bersih & Tertata</p>
                        <p class="text-[11px] text-[#92939A]">Peralatan torsi presisi, diagnostic scanner OEM, dan dokumentasi setiap komponen.</p>
                    </div>
                </div>
            </div>

        </div>

    </div>
</section>

<!-- ========================================================================= -->
<!-- SECTION 3: OUR PHILOSOPHY (Three Values) -->
<!-- ========================================================================= -->
<section class="py-24 bg-[#111216] border-y border-[#303137] relative">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="text-center max-w-2xl mx-auto mb-16 reveal-on-scroll">
            <span class="text-xs uppercase tracking-[0.25em] text-[#C62828] font-bold">Fondasi Layanan</span>
            <h2 class="font-display text-3xl sm:text-4xl lg:text-5xl font-bold text-[#F4F2EF] mt-2">
                Filosofi Kerja Kami
            </h2>
            <p class="text-sm text-[#92939A] mt-3">
                Tiga pilar utama yang mendasari setiap keputusan teknis dan interaksi di bengkel MOTOVEL.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            
            <!-- Value 1: Precision -->
            <div class="bg-[#191A1F] border border-[#303137] p-8 rounded-2xl relative overflow-hidden group hover:border-[#C62828]/50 transition-all duration-300 reveal-on-scroll">
                <span class="font-display text-6xl font-bold text-[#303137]/40 absolute top-4 right-6 pointer-events-none group-hover:text-[#C62828]/20 transition-colors">01</span>
                <div class="w-12 h-12 rounded-xl bg-[#C62828]/10 text-[#E23B3B] border border-[#C62828]/20 flex items-center justify-center mb-6">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <circle cx="12" cy="12" r="10" stroke-width="2"/>
                        <circle cx="12" cy="12" r="6" stroke-width="2"/>
                        <circle cx="12" cy="12" r="2" stroke-width="2"/>
                    </svg>
                </div>
                <h3 class="font-display text-2xl font-bold text-[#F4F2EF] mb-3">Precision</h3>
                <p class="text-sm text-[#92939A] leading-relaxed">
                    Ketelitian tinggi dalam setiap baut, celah klep, dan takaran cairan. Kami menggunakan kunci torsi bersertifikasi untuk memastikan setiap bagian terpasang sesuai spesifikasi pabrikan.
                </p>
            </div>

            <!-- Value 2: Expertise -->
            <div class="bg-[#191A1F] border border-[#303137] p-8 rounded-2xl relative overflow-hidden group hover:border-[#C62828]/50 transition-all duration-300 reveal-on-scroll reveal-delay-2">
                <span class="font-display text-6xl font-bold text-[#303137]/40 absolute top-4 right-6 pointer-events-none group-hover:text-[#C62828]/20 transition-colors">02</span>
                <div class="w-12 h-12 rounded-xl bg-[#C62828]/10 text-[#E23B3B] border border-[#C62828]/20 flex items-center justify-center mb-6">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                </div>
                <h3 class="font-display text-2xl font-bold text-[#F4F2EF] mb-3">Expertise</h3>
                <p class="text-sm text-[#92939A] leading-relaxed">
                    Dikerjakan langsung oleh mekanik berpengalaman yang memahami karakteristik mesin matic, kopling manual, serta teknologi kontrol elektronik modern terkini.
                </p>
            </div>

            <!-- Value 3: Reliability -->
            <div class="bg-[#191A1F] border border-[#303137] p-8 rounded-2xl relative overflow-hidden group hover:border-[#C62828]/50 transition-all duration-300 reveal-on-scroll reveal-delay-3">
                <span class="font-display text-6xl font-bold text-[#303137]/40 absolute top-4 right-6 pointer-events-none group-hover:text-[#C62828]/20 transition-colors">03</span>
                <div class="w-12 h-12 rounded-xl bg-[#C62828]/10 text-[#E23B3B] border border-[#C62828]/20 flex items-center justify-center mb-6">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                    </svg>
                </div>
                <h3 class="font-display text-2xl font-bold text-[#F4F2EF] mb-3">Reliability</h3>
                <p class="text-sm text-[#92939A] leading-relaxed">
                    Transparansi biaya di awal, jaminan suku cadang teruji keasliannya, serta garansi servis pasca pengerjaan untuk ketenangan pikiran Anda saat berkendara.
                </p>
            </div>

        </div>

    </div>
</section>

<!-- ========================================================================= -->
<!-- SECTION 4: OUR SERVICES (7 Dedicated Disciplines) -->
<!-- ========================================================================= -->
<section id="services-section" class="py-24 bg-[#08090B]">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="flex flex-col md:flex-row md:items-end justify-between mb-16 gap-6 reveal-on-scroll">
            <div>
                <span class="text-xs uppercase tracking-[0.25em] text-[#C62828] font-bold">Keahlian Bengkel</span>
                <h2 class="font-display text-3xl sm:text-4xl lg:text-5xl font-bold text-[#F4F2EF] mt-2">
                    Layanan Servis MOTOVEL
                </h2>
                <p class="text-sm text-[#92939A] mt-2 max-w-xl">
                    Paket perawatan komprehensif dirancang khusus untuk mempertahankan daya tahan dan performa puncak sepeda motor.
                </p>
            </div>
            <a href="{{ url('/services') }}" class="inline-flex items-center gap-2 text-xs uppercase tracking-wider font-semibold text-[#C62828] hover:text-[#E23B3B] transition-colors">
                <span>Lihat Seluruh Detail Layanan</span>
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                </svg>
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($services as $index => $srv)
                <div class="bg-[#111216] border border-[#303137] rounded-2xl overflow-hidden group hover:border-[#C62828]/50 transition-all duration-300 flex flex-col reveal-on-scroll {{ $index === 0 ? 'md:col-span-2 lg:col-span-2' : '' }}">
                    <div class="h-56 relative overflow-hidden bg-[#191A1F]">
                        <img src="{{ $srv['image'] }}" 
                             alt="{{ $srv['title'] }}" 
                             class="w-full h-full object-cover filter contrast-[1.1] brightness-75 group-hover:scale-105 transition-transform duration-700">
                        <div class="absolute inset-0 bg-gradient-to-t from-[#111216] via-transparent to-transparent"></div>
                        <span class="absolute top-4 left-4 bg-[#C62828] text-white text-[10px] uppercase tracking-widest font-bold px-3 py-1 rounded-full shadow-md">
                            {{ $srv['badge'] }}
                        </span>
                    </div>
                    <div class="p-6 flex-1 flex flex-col justify-between space-y-4">
                        <div>
                            <span class="text-xs uppercase tracking-wider text-[#92939A] font-semibold">{{ $srv['category'] }}</span>
                            <h3 class="font-display text-xl sm:text-2xl font-bold text-[#F4F2EF] mt-1">{{ $srv['title'] }}</h3>
                            <p class="text-xs sm:text-sm text-[#92939A] mt-2 leading-relaxed">
                                {{ $srv['description'] }}
                            </p>
                        </div>
                        <div class="pt-4 border-t border-[#303137] flex items-center justify-between">
                            <span class="text-[11px] text-[#92939A]">Pengerjaan Terjadwal</span>
                            <a href="{{ url('/booking') }}" class="text-xs font-semibold text-[#E23B3B] hover:text-white transition-colors inline-flex items-center gap-1">
                                <span>Pesan Servis Ini</span>
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

    </div>
</section>

<!-- ========================================================================= -->
<!-- SECTION 5: WHY CHOOSE MOTOVEL -->
<!-- ========================================================================= -->
<section class="py-24 bg-[#111216] border-t border-[#303137] relative">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
            
            <div class="lg:col-span-5 space-y-6 reveal-on-scroll">
                <span class="text-xs uppercase tracking-[0.25em] text-[#C62828] font-bold">Keunggulan Standar Bengkel</span>
                <h2 class="font-display text-3xl sm:text-4xl lg:text-5xl font-bold text-[#F4F2EF] leading-tight">
                    Mengapa Memilih Bengkel MOTOVEL?
                </h2>
                <p class="text-sm text-[#92939A] leading-relaxed">
                    Kami menghadirkan pengalaman servis bengkel profesional dengan kepastian waktu, dokumentasi suku cadang bekas yang ditunjukkan ke pelanggan, dan ruang tunggu nyaman.
                </p>
                <div class="pt-2">
                    <a href="{{ url('/about') }}" class="inline-flex items-center gap-2 text-xs uppercase tracking-wider font-semibold text-[#C62828] hover:text-[#E23B3B] transition-colors">
                        <span>Pelajari Standar Sertifikasi Mekanik</span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                        </svg>
                    </a>
                </div>
            </div>

            <div class="lg:col-span-7 grid grid-cols-1 sm:grid-cols-2 gap-5 reveal-on-scroll reveal-delay-2">
                
                <div class="bg-[#191A1F] border border-[#303137] p-6 rounded-xl space-y-2">
                    <div class="w-9 h-9 rounded-lg bg-[#C62828]/10 text-[#E23B3B] flex items-center justify-center font-bold">1</div>
                    <h3 class="font-display text-lg font-bold text-[#F4F2EF]">Mekanik Tersertifikasi</h3>
                    <p class="text-xs text-[#92939A] leading-relaxed">Teknisi berpengalaman dengan keahlian khusus mesin sport, transmisi CVT, dan kelistrikan ECU.</p>
                </div>

                <div class="bg-[#191A1F] border border-[#303137] p-6 rounded-xl space-y-2">
                    <div class="w-9 h-9 rounded-lg bg-[#C62828]/10 text-[#E23B3B] flex items-center justify-center font-bold">2</div>
                    <h3 class="font-display text-lg font-bold text-[#F4F2EF]">Suku Cadang 100% Asli</h3>
                    <p class="text-xs text-[#92939A] leading-relaxed">Pilihan sparepart OEM dan brand after-market kelas dunia (Motul, Brembo, DID, K&N, Pirelli).</p>
                </div>

                <div class="bg-[#191A1F] border border-[#303137] p-6 rounded-xl space-y-2">
                    <div class="w-9 h-9 rounded-lg bg-[#C62828]/10 text-[#E23B3B] flex items-center justify-center font-bold">3</div>
                    <h3 class="font-display text-lg font-bold text-[#F4F2EF]">Transparansi Penuh</h3>
                    <p class="text-xs text-[#92939A] leading-relaxed">Estimasi biaya diberikan di awal sebelum pengerjaan. Sparepart bekas selalu dikembalikan ke pemilik.</p>
                </div>

                <div class="bg-[#191A1F] border border-[#303137] p-6 rounded-xl space-y-2">
                    <div class="w-9 h-9 rounded-lg bg-[#C62828]/10 text-[#E23B3B] flex items-center justify-center font-bold">4</div>
                    <h3 class="font-display text-lg font-bold text-[#F4F2EF]">Booking Online Praktis</h3>
                    <p class="text-xs text-[#92939A] leading-relaxed">Daftar antrean servis motor mandiri kapan saja dari ponsel tanpa antre panjang di bengkel.</p>
                </div>

            </div>

        </div>

    </div>
</section>

<!-- ========================================================================= -->
<!-- SECTION 6: SERVICE PROCESS (4 Steps) -->
<!-- ========================================================================= -->
<section class="py-24 bg-[#08090B]">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="text-center max-w-2xl mx-auto mb-16 reveal-on-scroll">
            <span class="text-xs uppercase tracking-[0.25em] text-[#C62828] font-bold">Alur Pengerjaan</span>
            <h2 class="font-display text-3xl sm:text-4xl lg:text-5xl font-bold text-[#F4F2EF] mt-2">
                4 Tahapan Servis Presisi
            </h2>
            <p class="text-sm text-[#92939A] mt-2">
                Setiap tahapan dirancang sistematis guna memastikan kondisi motor teruji menyeluruh.
            </p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            
            <div class="bg-[#111216] border border-[#303137] p-6 rounded-2xl relative reveal-on-scroll">
                <span class="text-xs font-mono font-bold text-[#C62828] bg-[#C62828]/10 px-2.5 py-1 rounded">TAHAP 01</span>
                <h3 class="font-display text-xl font-bold text-[#F4F2EF] mt-4 mb-2">Booking & Keluhan</h3>
                <p class="text-xs text-[#92939A] leading-relaxed">Pelanggan mendaftar via sistem website, memilih tanggal servis, dan mencatat gejala keluhan motor.</p>
            </div>

            <div class="bg-[#111216] border border-[#303137] p-6 rounded-2xl relative reveal-on-scroll reveal-delay-1">
                <span class="text-xs font-mono font-bold text-[#C62828] bg-[#C62828]/10 px-2.5 py-1 rounded">TAHAP 02</span>
                <h3 class="font-display text-xl font-bold text-[#F4F2EF] mt-4 mb-2">Inspeksi Menyeluruh</h3>
                <p class="text-xs text-[#92939A] leading-relaxed">Pemeriksaan fisik, pemindaian scanner ECU, dan konfirmasi rincian estimasi biaya ke pelanggan.</p>
            </div>

            <div class="bg-[#111216] border border-[#303137] p-6 rounded-2xl relative reveal-on-scroll reveal-delay-2">
                <span class="text-xs font-mono font-bold text-[#C62828] bg-[#C62828]/10 px-2.5 py-1 rounded">TAHAP 03</span>
                <h3 class="font-display text-xl font-bold text-[#F4F2EF] mt-4 mb-2">Pengerjaan Mekanik</h3>
                <p class="text-xs text-[#92939A] leading-relaxed">Eksekusi servis oleh mekanik ahli menggunakan peralatan standar industri dan sparepart asli.</p>
            </div>

            <div class="bg-[#111216] border border-[#303137] p-6 rounded-2xl relative reveal-on-scroll reveal-delay-3">
                <span class="text-xs font-mono font-bold text-[#C62828] bg-[#C62828]/10 px-2.5 py-1 rounded">TAHAP 04</span>
                <h3 class="font-display text-xl font-bold text-[#F4F2EF] mt-4 mb-2">Uji Jalan & Selesai</h3>
                <p class="text-xs text-[#92939A] leading-relaxed">Uji coba performa akhir, pembersihan ringan kendaraan, kasir pembayaran, dan serah terima unit.</p>
            </div>

        </div>

    </div>
</section>

<!-- ========================================================================= -->
<!-- SECTION 7: MOTORCYCLE SHOWCASE -->
<!-- ========================================================================= -->
<section class="py-24 bg-[#111216] border-y border-[#303137]">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="flex flex-col md:flex-row md:items-end justify-between mb-16 gap-6 reveal-on-scroll">
            <div>
                <span class="text-xs uppercase tracking-[0.25em] text-[#C62828] font-bold">Galeri Dokumentasi</span>
                <h2 class="font-display text-3xl sm:text-4xl lg:text-5xl font-bold text-[#F4F2EF] mt-2">
                    Motorcycle Showcase
                </h2>
                <p class="text-sm text-[#92939A] mt-2">
                    Dokumentasi sepeda motor yang mempercayakan perawatannya di MOTOVEL.
                </p>
            </div>
            <a href="{{ url('/gallery') }}" class="inline-flex items-center gap-2 text-xs uppercase tracking-wider font-semibold text-[#C62828] hover:text-[#E23B3B] transition-colors">
                <span>Lihat Koleksi Galeri Lengkap</span>
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                </svg>
            </a>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            
            <div class="relative rounded-2xl overflow-hidden border border-[#303137] group aspect-[4/3] reveal-on-scroll">
                <img src="https://images.unsplash.com/photo-1558618666-fcd25c85f82e?w=800&auto=format&fit=crop&q=80" 
                     alt="Sepeda motor sport premium di pit MOTOVEL" 
                     class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
                <div class="absolute inset-0 bg-gradient-to-t from-[#08090B] via-transparent to-transparent opacity-80 group-hover:opacity-95 transition-opacity"></div>
                <div class="absolute bottom-4 left-4 right-4">
                    <span class="text-[10px] uppercase tracking-wider text-[#C62828] font-bold">Sport Series</span>
                    <h3 class="font-display text-lg font-bold text-[#F4F2EF]">Honda CBR250RR Precision Overhaul</h3>
                </div>
            </div>

            <div class="relative rounded-2xl overflow-hidden border border-[#303137] group aspect-[4/3] reveal-on-scroll reveal-delay-1">
                <img src="https://images.unsplash.com/photo-1568772585407-9361f9bf3a87?w=800&auto=format&fit=crop&q=80" 
                     alt="Maxi scooter matic premium di workshop" 
                     class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
                <div class="absolute inset-0 bg-gradient-to-t from-[#08090B] via-transparent to-transparent opacity-80 group-hover:opacity-95 transition-opacity"></div>
                <div class="absolute bottom-4 left-4 right-4">
                    <span class="text-[10px] uppercase tracking-wider text-blue-400 font-bold">Maxi Scooter</span>
                    <h3 class="font-display text-lg font-bold text-[#F4F2EF]">Yamaha NMAX 155 Full CVT Balancing</h3>
                </div>
            </div>

            <div class="relative rounded-2xl overflow-hidden border border-[#303137] group aspect-[4/3] reveal-on-scroll reveal-delay-2">
                <img src="https://images.unsplash.com/photo-1449426468159-d96dbf08f19f?w=800&auto=format&fit=crop&q=80" 
                     alt="Naked bike performa tinggi di pit bengkel" 
                     class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
                <div class="absolute inset-0 bg-gradient-to-t from-[#08090B] via-transparent to-transparent opacity-80 group-hover:opacity-95 transition-opacity"></div>
                <div class="absolute bottom-4 left-4 right-4">
                    <span class="text-[10px] uppercase tracking-wider text-emerald-400 font-bold">Supernaked</span>
                    <h3 class="font-display text-lg font-bold text-[#F4F2EF]">Kawasaki Z900 Brake & Dyno Remap</h3>
                </div>
            </div>

        </div>

    </div>
</section>

<!-- ========================================================================= -->
<!-- SECTION 8: CALL TO ACTION (Conversion Banner) -->
<!-- ========================================================================= -->
<section class="py-24 bg-[#08090B] relative overflow-hidden text-center">
    <!-- Red Ambient Light Blade -->
    <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[600px] h-[300px] bg-[#C62828]/15 rounded-full blur-[140px] pointer-events-none"></div>

    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 reveal-on-scroll">
        <span class="text-xs uppercase tracking-[0.25em] text-[#C62828] font-bold">Waktunya Memberikan yang Terbaik</span>
        <h2 class="font-display text-4xl sm:text-5xl lg:text-6xl font-bold text-[#F4F2EF] mt-3 leading-tight">
            Your Motorcycle Deserves Better.
        </h2>
        <p class="text-base sm:text-lg text-[#92939A] mt-4 max-w-2xl mx-auto leading-relaxed">
            Give your motorcycle the care, attention, and precision it deserves. Daftarkan jadwal servis secara online hari ini untuk slot antrean prioritas.
        </p>
        <div class="mt-8 flex flex-col sm:flex-row items-center justify-center gap-4">
            <a href="{{ url('/booking') }}" 
               class="inline-flex items-center gap-3 bg-[#C62828] hover:bg-[#E23B3B] text-white text-xs uppercase tracking-widest font-semibold py-4 px-10 rounded-full shadow-2xl shadow-[#C62828]/40 hover:shadow-[#C62828]/60 transition-all duration-300 transform hover:-translate-y-1">
                <span>Daftar Servis Mandiri</span>
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                </svg>
            </a>
            <a href="{{ url('/contact') }}" 
               class="inline-flex items-center gap-2 bg-[#191A1F] hover:bg-[#222329] border border-[#303137] text-[#F4F2EF] text-xs uppercase tracking-widest font-semibold py-4 px-8 rounded-full transition-colors">
                <span>Hubungi Tim Bengkel</span>
            </a>
        </div>
    </div>
</section>

<!-- ========================================================================= -->
<!-- SECTION 9: CONTACT PREVIEW -->
<!-- ========================================================================= -->
<section class="py-20 bg-[#111216] border-t border-[#303137]">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="p-6 rounded-2xl bg-[#191A1F] border border-[#303137] space-y-2">
                <span class="text-xs uppercase tracking-wider text-[#C62828] font-bold">Lokasi Workshop</span>
                <h3 class="font-display text-xl font-bold text-[#F4F2EF]">Surabaya Barat</h3>
                <p class="text-xs text-[#92939A] leading-relaxed">Jl. Mayjen Sungkono No. 108, Surabaya, Jawa Timur 60256 (Depan Gedung Graha Pena).</p>
            </div>
            <div class="p-6 rounded-2xl bg-[#191A1F] border border-[#303137] space-y-2">
                <span class="text-xs uppercase tracking-wider text-[#C62828] font-bold">Kontak Servis</span>
                <h3 class="font-display text-xl font-bold text-[#F4F2EF]">(031) 567-8900</h3>
                <p class="text-xs text-[#92939A] leading-relaxed">WhatsApp Hotline 24 Jam: 0812-3456-7890. Email: service@motovel.com</p>
            </div>
            <div class="p-6 rounded-2xl bg-[#191A1F] border border-[#303137] space-y-2">
                <span class="text-xs uppercase tracking-wider text-[#C62828] font-bold">Jam Layanan</span>
                <h3 class="font-display text-xl font-bold text-[#F4F2EF]">08:00 - 17:00 WIB</h3>
                <p class="text-xs text-[#92939A] leading-relaxed">Buka setiap Senin hingga Sabtu. Hari Minggu khusus layanan janji temu (appointment).</p>
            </div>
        </div>
    </div>
</section>

@endsection
