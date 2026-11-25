@extends('layouts.app')

@section('title', 'Galeri Sepeda Motor & Bengkel | MOTOVEL')
@section('meta_description', 'Koleksi dokumentasi visual pengerjaan servis sepeda motor sport, maxi scooter, dan fasilitas workshop bengkel MOTOVEL.')

@section('content')
<div class="py-12 sm:py-20" x-data="{ activeTab: 'all' }">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-12">

        <!-- Header -->
        <div class="max-w-3xl space-y-4">
            <span class="text-xs uppercase tracking-[0.25em] text-[#9a1312] font-bold">Showcase Portofolio</span>
            <h1 class="font-display text-4xl sm:text-5xl lg:text-6xl font-bold text-[#F4F2EF] leading-tight">
                Galeri Motor & Aktivitas Bengkel
            </h1>
            <p class="text-base sm:text-lg text-[#92939A] font-light leading-relaxed">
                Dokumentasi estetika mesin, detail pengerjaan komponen, dan sepeda motor pelanggan yang mempercayakan perawatannya di MOTOVEL.
            </p>
        </div>

        <!-- Filter Tabs -->
        <div class="flex flex-wrap items-center gap-2 sm:gap-3 border-b border-[#303137] pb-6">
            <button @click="activeTab = 'all'" 
                    :class="activeTab === 'all' ? 'bg-[#9a1312] text-white font-semibold' : 'bg-[#191A1F] text-[#92939A] hover:text-[#F4F2EF] border border-[#303137]'"
                    class="px-5 py-2.5 rounded-full text-xs uppercase tracking-wider transition-all">
                Semua Koleksi
            </button>
            <button @click="activeTab = 'sport'" 
                    :class="activeTab === 'sport' ? 'bg-[#9a1312] text-white font-semibold' : 'bg-[#191A1F] text-[#92939A] hover:text-[#F4F2EF] border border-[#303137]'"
                    class="px-5 py-2.5 rounded-full text-xs uppercase tracking-wider transition-all">
                Motor Sport
            </button>
            <button @click="activeTab = 'matic'" 
                    :class="activeTab === 'matic' ? 'bg-[#9a1312] text-white font-semibold' : 'bg-[#191A1F] text-[#92939A] hover:text-[#F4F2EF] border border-[#303137]'"
                    class="px-5 py-2.5 rounded-full text-xs uppercase tracking-wider transition-all">
                Maxi Scooter
            </button>
            <button @click="activeTab = 'workshop'" 
                    :class="activeTab === 'workshop' ? 'bg-[#9a1312] text-white font-semibold' : 'bg-[#191A1F] text-[#92939A] hover:text-[#F4F2EF] border border-[#303137]'"
                    class="px-5 py-2.5 rounded-full text-xs uppercase tracking-wider transition-all">
                Aktivitas Bengkel
            </button>
        </div>

        <!-- Gallery Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            
            <!-- Item 1: Sport -->
            <div x-show="activeTab === 'all' || activeTab === 'sport'" class="relative rounded-2xl overflow-hidden border border-[#303137] bg-[#111216] aspect-[4/3] group">
                <img src="{{ asset('images/gallery/cbr250rr-sp.jpg') }}" 
                     alt="Sepeda motor sport premium" 
                     class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
                <div class="absolute inset-0 bg-gradient-to-t from-[#08090B] via-transparent to-transparent opacity-80 group-hover:opacity-95 transition-opacity"></div>
                <div class="absolute bottom-5 left-5 right-5 space-y-1">
                    <span class="text-[10px] uppercase tracking-wider text-[#9a1312] font-bold">Sport Series</span>
                    <h3 class="font-display text-xl font-bold text-[#F4F2EF]">Honda CBR250RR SP</h3>
                    <p class="text-xs text-[#92939A]">Pembersihan Throttle Body & Penggantian Filter K&N</p>
                </div>
            </div>

            <!-- Item 2: Matic -->
            <div x-show="activeTab === 'all' || activeTab === 'matic'" class="relative rounded-2xl overflow-hidden border border-[#303137] bg-[#111216] aspect-[4/3] group">
                <img src="{{ asset('images/gallery/nmax-155.jpg') }}" 
                     alt="Maxi Scooter Matic" 
                     class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
                <div class="absolute inset-0 bg-gradient-to-t from-[#08090B] via-transparent to-transparent opacity-80 group-hover:opacity-95 transition-opacity"></div>
                <div class="absolute bottom-5 left-5 right-5 space-y-1">
                    <span class="text-[10px] uppercase tracking-wider text-blue-400 font-bold">Maxi Scooter</span>
                    <h3 class="font-display text-xl font-bold text-[#F4F2EF]">Yamaha NMAX 155 Connected</h3>
                    <p class="text-xs text-[#92939A]">Overhaul CVT, Penggantian Roller KTC & V-Belt Gates</p>
                </div>
            </div>

            <!-- Item 3: Workshop -->
            <div x-show="activeTab === 'all' || activeTab === 'workshop'" class="relative rounded-2xl overflow-hidden border border-[#303137] bg-[#111216] aspect-[4/3] group">
                <img src="https://images.unsplash.com/photo-1619642751034-765dfdf7c58e?w=800&auto=format&fit=crop&q=80" 
                     alt="Aktivitas mekanik di bengkel" 
                     class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
                <div class="absolute inset-0 bg-gradient-to-t from-[#08090B] via-transparent to-transparent opacity-80 group-hover:opacity-95 transition-opacity"></div>
                <div class="absolute bottom-5 left-5 right-5 space-y-1">
                    <span class="text-[10px] uppercase tracking-wider text-amber-400 font-bold">Pit Service</span>
                    <h3 class="font-display text-xl font-bold text-[#F4F2EF]">Penyetelan Rantai Torsi Tinggi</h3>
                    <p class="text-xs text-[#92939A]">Pemasangan Rantai DID 520 O-Ring dan Sprocket Alumunium</p>
                </div>
            </div>

            <!-- Item 4: Sport -->
            <div x-show="activeTab === 'all' || activeTab === 'sport'" class="relative rounded-2xl overflow-hidden border border-[#303137] bg-[#111216] aspect-[4/3] group">
                <img src="{{ asset('images/gallery/ninja-zx25r.jpg') }}" 
                     alt="Kawasaki Ninja ZX-25R 4 Silinder" 
                     class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
                <div class="absolute inset-0 bg-gradient-to-t from-[#08090B] via-transparent to-transparent opacity-80 group-hover:opacity-95 transition-opacity"></div>
                <div class="absolute bottom-5 left-5 right-5 space-y-1">
                    <span class="text-[10px] uppercase tracking-wider text-[#9a1312] font-bold">4-Cylinder Screamer</span>
                    <h3 class="font-display text-xl font-bold text-[#F4F2EF]">Kawasaki Ninja ZX-25R</h3>
                    <p class="text-xs text-[#92939A]">Servis 10.000 KM & Penggantian Oli Motul 7100 Ester</p>
                </div>
            </div>

            <!-- Item 5: Workshop -->
            <div x-show="activeTab === 'all' || activeTab === 'workshop'" class="relative rounded-2xl overflow-hidden border border-[#303137] bg-[#111216] aspect-[4/3] group">
                <img src="{{ asset('images/gallery/brembo-caliper.jpg') }}" 
                     alt="Inspeksi pengereman cakram" 
                     class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
                <div class="absolute inset-0 bg-gradient-to-t from-[#08090B] via-transparent to-transparent opacity-80 group-hover:opacity-95 transition-opacity"></div>
                <div class="absolute bottom-5 left-5 right-5 space-y-1">
                    <span class="text-[10px] uppercase tracking-wider text-emerald-400 font-bold">Brake Lab</span>
                    <h3 class="font-display text-xl font-bold text-[#F4F2EF]">Peremajaan Master Kaliper Brembo</h3>
                    <p class="text-xs text-[#92939A]">Flushing Minyak Rem Racing Motul RBF 600 Factory Line</p>
                </div>
            </div>

            <!-- Item 6: Matic -->
            <div x-show="activeTab === 'all' || activeTab === 'matic'" class="relative rounded-2xl overflow-hidden border border-[#303137] bg-[#111216] aspect-[4/3] group">
                <img src="{{ asset('images/gallery/pcx-160.jpg') }}" 
                     alt="Matic Honda PCX 160" 
                     class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
                <div class="absolute inset-0 bg-gradient-to-t from-[#08090B] via-transparent to-transparent opacity-80 group-hover:opacity-95 transition-opacity"></div>
                <div class="absolute bottom-5 left-5 right-5 space-y-1">
                    <span class="text-[10px] uppercase tracking-wider text-blue-400 font-bold">Maxi Scooter</span>
                    <h3 class="font-display text-xl font-bold text-[#F4F2EF]">Honda PCX 160 eSP+</h3>
                    <p class="text-xs text-[#92939A]">Penyetelan Klep In & Ex, Penggantian Busi Iridium NGK</p>
                </div>
            </div>

        </div>

    </div>
</div>
@endsection
