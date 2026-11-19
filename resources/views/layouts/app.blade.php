<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'MOTOVEL | Precision Motorcycle Care & Performance Workshop')</title>
    <meta name="description" content="@yield('meta_description', 'MOTOVEL adalah bengkel perawatan dan servis sepeda motor presisi dengan standar performa tertinggi, mekanik tersertifikasi, dan transparansi penuh.')">

    <!-- Google Fonts & Styles -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,400;0,500;0,600;0,700;1,400;1,600&family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Alpine.js for interactive UI components -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.14.8/dist/cdn.min.js"></script>

    <!-- Vite Assets -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @stack('styles')
</head>
<body class="bg-[#08090B] text-[#F4F2EF] font-sans antialiased selection:bg-[#C62828] selection:text-white flex flex-col min-h-screen">

    <!-- Flash Alert Notifications -->
    @include('components.alert')

    <!-- Top Floating Header / Navbar -->
    <header class="fixed top-0 left-0 right-0 z-40 transition-all duration-300" id="main-nav">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between">
                
                <!-- Brand Logo -->
                <a href="{{ url('/') }}" class="flex items-center gap-3 group focus:outline-none focus:ring-2 focus:ring-[#C62828] rounded-md p-1">
                    <span class="w-8 h-8 rounded-lg bg-[#C62828] flex items-center justify-center font-bold text-white text-base shadow-lg shadow-[#C62828]/30 group-hover:bg-[#E23B3B] transition-colors">
                        M
                    </span>
                    <div class="flex flex-col">
                        <span class="font-display text-2xl font-bold tracking-wider text-[#F4F2EF] leading-none group-hover:text-white transition-colors">
                            MOTOVEL
                        </span>
                        <span class="text-[9px] uppercase tracking-[0.2em] text-[#92939A] font-semibold mt-0.5">
                            Precision Care
                        </span>
                    </div>
                </a>

                <!-- Desktop Navigation Links -->
                <nav class="hidden md:flex items-center gap-8 text-sm font-medium" aria-label="Navigasi Utama">
                    <a href="{{ url('/') }}" class="text-[#F4F2EF] hover:text-[#E23B3B] transition-colors py-1 relative {{ request()->is('/') ? 'text-[#E23B3B] font-semibold' : 'text-[#92939A]' }}">
                        Beranda
                        @if(request()->is('/'))
                            <span class="absolute bottom-0 left-0 right-0 h-0.5 bg-[#C62828] rounded-full"></span>
                        @endif
                    </a>
                    <a href="{{ url('/about') }}" class="hover:text-[#E23B3B] transition-colors py-1 relative {{ request()->is('about') ? 'text-[#E23B3B] font-semibold' : 'text-[#92939A]' }}">
                        Tentang Kami
                        @if(request()->is('about'))
                            <span class="absolute bottom-0 left-0 right-0 h-0.5 bg-[#C62828] rounded-full"></span>
                        @endif
                    </a>
                    <a href="{{ url('/services') }}" class="hover:text-[#E23B3B] transition-colors py-1 relative {{ request()->is('services') ? 'text-[#E23B3B] font-semibold' : 'text-[#92939A]' }}">
                        Layanan
                        @if(request()->is('services'))
                            <span class="absolute bottom-0 left-0 right-0 h-0.5 bg-[#C62828] rounded-full"></span>
                        @endif
                    </a>
                    <a href="{{ url('/gallery') }}" class="hover:text-[#E23B3B] transition-colors py-1 relative {{ request()->is('gallery') ? 'text-[#E23B3B] font-semibold' : 'text-[#92939A]' }}">
                        Galeri
                        @if(request()->is('gallery'))
                            <span class="absolute bottom-0 left-0 right-0 h-0.5 bg-[#C62828] rounded-full"></span>
                        @endif
                    </a>
                    <a href="{{ url('/contact') }}" class="hover:text-[#E23B3B] transition-colors py-1 relative {{ request()->is('contact') ? 'text-[#E23B3B] font-semibold' : 'text-[#92939A]' }}">
                        Kontak
                        @if(request()->is('contact'))
                            <span class="absolute bottom-0 left-0 right-0 h-0.5 bg-[#C62828] rounded-full"></span>
                        @endif
                    </a>
                </nav>

                <!-- Desktop CTA Actions -->
                <div class="hidden md:flex items-center gap-4">
                    <a href="{{ url('/login') }}" class="text-xs uppercase tracking-wider font-semibold text-[#92939A] hover:text-[#F4F2EF] transition-colors py-2 px-3">
                        Portal Karyawan
                    </a>
                    <a href="{{ url('/booking') }}" class="inline-flex items-center gap-2 bg-[#C62828] hover:bg-[#E23B3B] text-white text-xs uppercase tracking-wider font-semibold py-2.5 px-5 rounded-full shadow-lg shadow-[#C62828]/25 hover:shadow-[#C62828]/40 transition-all duration-300 transform hover:-translate-y-0.5 focus:outline-none focus:ring-2 focus:ring-[#C62828] focus:ring-offset-2 focus:ring-offset-[#08090B]">
                        <span>Daftar Servis</span>
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                        </svg>
                    </a>
                </div>

                <!-- Mobile Hamburger Button -->
                <div class="flex md:hidden items-center gap-2">
                    <a href="{{ url('/booking') }}" class="bg-[#C62828] text-white text-[11px] uppercase tracking-wider font-semibold py-1.5 px-3 rounded-full">
                        Daftar
                    </a>
                    <button type="button" id="mobile-menu-btn" aria-expanded="false" aria-controls="mobile-menu" class="p-2 rounded-lg bg-[#191A1F] border border-[#303137] text-[#F4F2EF] hover:text-white focus:outline-none" aria-label="Buka navigasi">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7" />
                        </svg>
                    </button>
                </div>

            </div>

            <!-- Mobile Dropdown Menu -->
            <div id="mobile-menu" class="hidden md:hidden mt-3 p-4 rounded-xl bg-[#111216] border border-[#303137] shadow-2xl space-y-3">
                <a href="{{ url('/') }}" class="block px-3 py-2 rounded-lg text-sm font-medium {{ request()->is('/') ? 'bg-[#C62828]/15 text-[#E23B3B]' : 'text-[#92939A] hover:bg-[#191A1F] hover:text-[#F4F2EF]' }}">
                    Beranda
                </a>
                <a href="{{ url('/about') }}" class="block px-3 py-2 rounded-lg text-sm font-medium {{ request()->is('about') ? 'bg-[#C62828]/15 text-[#E23B3B]' : 'text-[#92939A] hover:bg-[#191A1F] hover:text-[#F4F2EF]' }}">
                    Tentang Kami
                </a>
                <a href="{{ url('/services') }}" class="block px-3 py-2 rounded-lg text-sm font-medium {{ request()->is('services') ? 'bg-[#C62828]/15 text-[#E23B3B]' : 'text-[#92939A] hover:bg-[#191A1F] hover:text-[#F4F2EF]' }}">
                    Layanan
                </a>
                <a href="{{ url('/gallery') }}" class="block px-3 py-2 rounded-lg text-sm font-medium {{ request()->is('gallery') ? 'bg-[#C62828]/15 text-[#E23B3B]' : 'text-[#92939A] hover:bg-[#191A1F] hover:text-[#F4F2EF]' }}">
                    Galeri
                </a>
                <a href="{{ url('/contact') }}" class="block px-3 py-2 rounded-lg text-sm font-medium {{ request()->is('contact') ? 'bg-[#C62828]/15 text-[#E23B3B]' : 'text-[#92939A] hover:bg-[#191A1F] hover:text-[#F4F2EF]' }}">
                    Kontak
                </a>
                <div class="pt-2 border-t border-[#303137] flex flex-col gap-2">
                    <a href="{{ url('/booking') }}" class="w-full text-center bg-[#C62828] hover:bg-[#E23B3B] text-white text-xs uppercase tracking-wider font-semibold py-2.5 rounded-lg shadow-md">
                        Daftar Servis Motor
                    </a>
                    <a href="{{ url('/login') }}" class="w-full text-center bg-[#191A1F] hover:bg-[#222329] border border-[#303137] text-xs uppercase tracking-wider font-semibold py-2 rounded-lg text-[#92939A]">
                        Login Portal Karyawan
                    </a>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Page Content -->
    <main class="flex-1 pt-20">
        @yield('content')
    </main>

    <!-- Experiential Luxury Footer -->
    <footer class="bg-[#08090B] border-t border-[#303137] pt-16 pb-12 mt-20 relative overflow-hidden">
        <!-- Subtle red glow at bottom corner -->
        <div class="absolute bottom-0 right-0 w-96 h-96 bg-[#C62828]/5 rounded-full blur-3xl pointer-events-none"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <!-- Footer Upper Statement -->
            <div class="flex flex-col lg:flex-row lg:items-end justify-between pb-12 border-b border-[#303137] gap-8">
                <div class="max-w-2xl">
                    <span class="text-xs uppercase tracking-[0.25em] text-[#C62828] font-bold">MOTOVEL Precision Workshop</span>
                    <h2 class="font-display text-3xl sm:text-4xl lg:text-5xl font-bold text-[#F4F2EF] mt-2 leading-tight">
                        Your Motorcycle Deserves Better. Built on Precision.
                    </h2>
                    <p class="text-[#92939A] text-sm sm:text-base mt-3 leading-relaxed">
                        Memberikan perawatan, ketelitian teknis, dan standar performa tertinggi bagi sepeda motor Anda bersama mekanik profesional tersertifikasi.
                    </p>
                </div>
                <div>
                    <a href="{{ url('/booking') }}" class="inline-flex items-center gap-3 bg-[#C62828] hover:bg-[#E23B3B] text-white text-xs uppercase tracking-widest font-semibold py-3.5 px-8 rounded-full shadow-xl shadow-[#C62828]/30 hover:shadow-[#C62828]/50 transition-all duration-300 transform hover:-translate-y-1">
                        <span>Daftar Servis Sekarang</span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                        </svg>
                    </a>
                </div>
            </div>

            <!-- Footer Columns -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-10 py-12 border-b border-[#303137]">
                <!-- Col 1: About & Info -->
                <div class="space-y-4">
                    <div class="flex items-center gap-2.5">
                        <span class="w-7 h-7 rounded bg-[#C62828] flex items-center justify-center font-bold text-white text-sm">M</span>
                        <span class="font-display text-xl font-bold tracking-wider text-[#F4F2EF]">MOTOVEL</span>
                    </div>
                    <p class="text-xs text-[#92939A] leading-relaxed">
                        Platform manajemen dan bengkel perawatan sepeda motor modern berfokus pada ketepatan diagnosa, suku cadang teruji, dan transparansi pengerjaan.
                    </p>
                    <div class="pt-2 text-xs text-[#92939A] space-y-1">
                        <p><strong class="text-[#F4F2EF]">Alamat:</strong> Jl. Mayjen Sungkono No. 108, Surabaya</p>
                        <p><strong class="text-[#F4F2EF]">Telepon:</strong> (031) 567-8900</p>
                        <p><strong class="text-[#F4F2EF]">Email:</strong> service@motovel.com</p>
                    </div>
                </div>

                <!-- Col 2: Navigation Links -->
                <div>
                    <h3 class="text-xs uppercase tracking-[0.2em] font-bold text-[#F4F2EF] mb-4">Navigasi Utama</h3>
                    <ul class="space-y-2.5 text-xs text-[#92939A]">
                        <li><a href="{{ url('/') }}" class="hover:text-[#E23B3B] transition-colors">Beranda</a></li>
                        <li><a href="{{ url('/about') }}" class="hover:text-[#E23B3B] transition-colors">Tentang Bengkel MOTOVEL</a></li>
                        <li><a href="{{ url('/services') }}" class="hover:text-[#E23B3B] transition-colors">Katalog Paket Servis</a></li>
                        <li><a href="{{ url('/gallery') }}" class="hover:text-[#E23B3B] transition-colors">Galeri Motor & Pengerjaan</a></li>
                        <li><a href="{{ url('/contact') }}" class="hover:text-[#E23B3B] transition-colors">Kontak & Lokasi</a></li>
                        <li><a href="{{ url('/booking') }}" class="hover:text-[#E23B3B] transition-colors">Pendaftaran Servis Mandiri</a></li>
                    </ul>
                </div>

                <!-- Col 3: Services -->
                <div>
                    <h3 class="text-xs uppercase tracking-[0.2em] font-bold text-[#F4F2EF] mb-4">Layanan Spesialis</h3>
                    <ul class="space-y-2.5 text-xs text-[#92939A]">
                        <li>Tune Up & Servis Ringan</li>
                        <li>Servis Besar & Overhaul Mesin</li>
                        <li>Perawatan Transmisi Matic (CVT)</li>
                        <li>Sistem Injeksi & Kalibrasi ECU</li>
                        <li>Penggantian Oli & Filter Racing</li>
                        <li>Pengecekan Pengereman & Suspensi</li>
                    </ul>
                </div>

                <!-- Col 4: Operational Hours -->
                <div>
                    <h3 class="text-xs uppercase tracking-[0.2em] font-bold text-[#F4F2EF] mb-4">Jam Operasional</h3>
                    <ul class="space-y-2 text-xs text-[#92939A]">
                        <li class="flex justify-between py-1 border-b border-[#303137]/60">
                            <span>Senin - Jumat</span>
                            <span class="text-[#F4F2EF] font-medium">08:00 - 17:00</span>
                        </li>
                        <li class="flex justify-between py-1 border-b border-[#303137]/60">
                            <span>Sabtu</span>
                            <span class="text-[#F4F2EF] font-medium">08:00 - 15:00</span>
                        </li>
                        <li class="flex justify-between py-1">
                            <span>Minggu & Hari Libur</span>
                            <span class="text-[#E23B3B] font-medium">Khusus Janji Temu</span>
                        </li>
                    </ul>
                    <div class="mt-4 p-3 rounded-lg bg-[#191A1F] border border-[#303137] text-xs">
                        <p class="text-[#F4F2EF] font-medium mb-1">Butuh bantuan darurat?</p>
                        <p class="text-[#92939A] text-[11px]">Hotline CS WhatsApp: 0812-3456-7890</p>
                    </div>
                </div>
            </div>

            <!-- Bottom Copyright & Back to Top -->
            <div class="pt-8 flex flex-col sm:flex-row items-center justify-between text-xs text-[#92939A] gap-4">
                <p>&copy; {{ date('Y') }} MOTOVEL. Seluruh hak cipta dilindungi undang-undang.</p>
                <div class="flex items-center gap-6">
                    <a href="{{ url('/login') }}" class="hover:text-[#F4F2EF] transition-colors">Portal Admin</a>
                    <button id="back-to-top" class="inline-flex items-center gap-1.5 text-xs uppercase tracking-wider font-medium text-[#F4F2EF] hover:text-[#E23B3B] transition-colors focus:outline-none" aria-label="Kembali ke atas">
                        <span>Kembali ke Atas</span>
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </footer>

    @stack('scripts')
</body>
</html>
