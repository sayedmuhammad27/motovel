<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Admin Dashboard | MOTOVEL')</title>
    <link rel="icon" type="image/png" href="{{ asset('images/favicon.png') }}">
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}">

    <!-- Google Fonts (Cinzel & Cinzel Decorative) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;500;600;700;800;900&family=Cinzel+Decorative:wght@400;700;900&family=Montserrat:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,400;1,600&display=swap" rel="stylesheet">

    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.14.8/dist/cdn.min.js"></script>

    <!-- Chart.js for Dashboard Graphs -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.7/dist/chart.umd.min.js"></script>

    <!-- Vite Assets -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @stack('styles')
</head>
<body class="bg-[#08090B] text-[#F4F2EF] font-sans antialiased min-h-screen flex flex-col lg:flex-row selection:bg-[#9a1312] selection:text-white" x-data="{ sidebarOpen: false }">

    <!-- Flash Alert Notifications -->
    @include('components.alert')

    <!-- Mobile Backdrop -->
    <div x-show="sidebarOpen" 
         x-transition:enter="transition-opacity ease-linear duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition-opacity ease-linear duration-300"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         @click="sidebarOpen = false" 
         class="fixed inset-0 bg-black/80 z-40 lg:hidden" 
         style="display: none;"></div>

    <!-- Admin Sidebar -->
    <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'" 
           class="fixed inset-y-0 left-0 z-50 w-64 bg-[#111216] border-r border-[#303137] flex flex-col transition-transform duration-300 ease-in-out lg:translate-x-0 lg:static lg:inset-auto">
        
        <!-- Sidebar Brand Header -->
        <div class="h-20 flex items-center justify-between px-6 border-b border-[#303137]">
            <a href="{{ url('/admin/dashboard') }}" class="flex items-center gap-3">
                <img src="{{ asset('images/logo-badge.png') }}" alt="MOTOVEL Logo" class="w-10 h-10 object-contain rounded-xl shadow-md border border-[#9a1312]/40">
                <div class="flex flex-col">
                    <span class="font-display text-xl font-bold tracking-wider text-[#F4F2EF]">MOTOVEL</span>
                    <span class="text-[9px] uppercase tracking-[0.2em] text-[#92939A] font-semibold">Workspace Admin</span>
                </div>
            </a>
            <button @click="sidebarOpen = false" class="lg:hidden p-1.5 rounded-lg text-[#92939A] hover:text-[#F4F2EF] hover:bg-[#191A1F]">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <!-- Navigation Menu -->
        <nav class="flex-1 overflow-y-auto px-4 py-6 space-y-6">
            
            <!-- Group 1: Ringkasan Utama -->
            <div>
                <p class="px-3 text-[10px] uppercase tracking-[0.2em] font-bold text-[#92939A] mb-2">Utama</p>
                <div class="space-y-1">
                    <a href="{{ url('/admin/dashboard') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-all duration-200 {{ request()->is('admin/dashboard') ? 'bg-[#9a1312] text-white shadow-md shadow-[#9a1312]/25 font-semibold' : 'text-[#92939A] hover:bg-[#191A1F] hover:text-[#F4F2EF]' }}">
                        <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                        </svg>
                        <span>Dashboard</span>
                    </a>
                </div>
            </div>

            <!-- Group 2: Operasional Servis -->
            <div>
                <p class="px-3 text-[10px] uppercase tracking-[0.2em] font-bold text-[#92939A] mb-2">Operasional Servis</p>
                <div class="space-y-1">
                    <a href="{{ url('/admin/services') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-all duration-200 {{ request()->is('admin/services*') ? 'bg-[#9a1312] text-white shadow-md shadow-[#9a1312]/25 font-semibold' : 'text-[#92939A] hover:bg-[#191A1F] hover:text-[#F4F2EF]' }}">
                        <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                        <span>Pendaftaran Servis</span>
                    </a>

                    <a href="{{ url('/admin/service-details') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-all duration-200 {{ request()->is('admin/service-details*') ? 'bg-[#9a1312] text-white shadow-md shadow-[#9a1312]/25 font-semibold' : 'text-[#92939A] hover:bg-[#191A1F] hover:text-[#F4F2EF]' }}">
                        <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        <span>Detail Pengerjaan</span>
                    </a>

                    <a href="{{ url('/admin/payments') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-all duration-200 {{ request()->is('admin/payments*') ? 'bg-[#9a1312] text-white shadow-md shadow-[#9a1312]/25 font-semibold' : 'text-[#92939A] hover:bg-[#191A1F] hover:text-[#F4F2EF]' }}">
                        <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                        <span>Kasir Pembayaran</span>
                    </a>

                    <a href="{{ url('/admin/history') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-all duration-200 {{ request()->is('admin/history*') ? 'bg-[#9a1312] text-white shadow-md shadow-[#9a1312]/25 font-semibold' : 'text-[#92939A] hover:bg-[#191A1F] hover:text-[#F4F2EF]' }}">
                        <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span>Riwayat Servis</span>
                    </a>
                </div>
            </div>

            <!-- Group 3: Data Master -->
            <div>
                <p class="px-3 text-[10px] uppercase tracking-[0.2em] font-bold text-[#92939A] mb-2">Data Master</p>
                <div class="space-y-1">
                    <a href="{{ url('/admin/customers') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-all duration-200 {{ request()->is('admin/customers*') ? 'bg-[#9a1312] text-white shadow-md shadow-[#9a1312]/25 font-semibold' : 'text-[#92939A] hover:bg-[#191A1F] hover:text-[#F4F2EF]' }}">
                        <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                        <span>Data Pelanggan</span>
                    </a>

                    <a href="{{ url('/admin/vehicles') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-all duration-200 {{ request()->is('admin/vehicles*') ? 'bg-[#9a1312] text-white shadow-md shadow-[#9a1312]/25 font-semibold' : 'text-[#92939A] hover:bg-[#191A1F] hover:text-[#F4F2EF]' }}">
                        <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                        <span>Data Sepeda Motor</span>
                    </a>

                    <a href="{{ url('/admin/mechanics') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-all duration-200 {{ request()->is('admin/mechanics*') ? 'bg-[#9a1312] text-white shadow-md shadow-[#9a1312]/25 font-semibold' : 'text-[#92939A] hover:bg-[#191A1F] hover:text-[#F4F2EF]' }}">
                        <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                        <span>Data Mekanik</span>
                    </a>

                    <a href="{{ url('/admin/spareparts') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-all duration-200 {{ request()->is('admin/spareparts*') ? 'bg-[#9a1312] text-white shadow-md shadow-[#9a1312]/25 font-semibold' : 'text-[#92939A] hover:bg-[#191A1F] hover:text-[#F4F2EF]' }}">
                        <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                        </svg>
                        <span>Katalog Sparepart</span>
                    </a>
                </div>
            </div>

            <!-- Group 4: Laporan & Ekspor -->
            <div>
                <p class="px-3 text-[10px] uppercase tracking-[0.2em] font-bold text-[#92939A] mb-2">Laporan</p>
                <div class="space-y-1">
                    <a href="{{ url('/admin/reports') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-all duration-200 {{ request()->is('admin/reports*') ? 'bg-[#9a1312] text-white shadow-md shadow-[#9a1312]/25 font-semibold' : 'text-[#92939A] hover:bg-[#191A1F] hover:text-[#F4F2EF]' }}">
                        <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        <span>Laporan & Analisis</span>
                    </a>
                </div>
            </div>

            <!-- Group 5: Shortcut Publik -->
            <div class="pt-4 border-t border-[#303137]">
                <a href="{{ url('/') }}" target="_blank" class="flex items-center justify-between px-3 py-2 rounded-lg text-xs font-medium text-[#92939A] hover:bg-[#191A1F] hover:text-[#F4F2EF] transition-colors">
                    <span class="flex items-center gap-2">
                        <svg class="w-4 h-4 text-[#9a1312]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                        </svg>
                        <span>Lihat Website Publik</span>
                    </span>
                    <span class="text-[10px] text-[#92939A] bg-[#191A1F] px-1.5 py-0.5 rounded border border-[#303137]">Tab baru</span>
                </a>
            </div>

        </nav>

        <!-- Sidebar User Footer -->
        <div class="p-4 border-t border-[#303137] bg-[#0E0F13]">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-3 overflow-hidden">
                    <div class="w-9 h-9 rounded-full bg-[#191A1F] border border-[#303137] flex items-center justify-center font-bold text-[#F4F2EF] text-sm flex-shrink-0">
                        {{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 1)) }}
                    </div>
                    <div class="overflow-hidden">
                        <p class="text-xs font-semibold text-[#F4F2EF] truncate">{{ auth()->user()->name ?? 'Administrator' }}</p>
                        <p class="text-[10px] uppercase tracking-wider text-[#9a1312] font-bold">{{ auth()->user()->role ?? 'Admin' }}</p>
                    </div>
                </div>
                <form action="{{ url('/logout') }}" method="POST" class="flex-shrink-0">
                    @csrf
                    <button type="submit" class="p-2 text-[#92939A] hover:text-[#b91a19] hover:bg-[#191A1F] rounded-lg transition-colors focus:outline-none" title="Keluar / Logout">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                        </svg>
                    </button>
                </form>
            </div>
        </div>

    </aside>

    <!-- Main Workspace Area -->
    <div class="flex-1 flex flex-col min-w-0 overflow-hidden">
        
        <!-- Topbar -->
        <header class="h-20 bg-[#111216]/80 backdrop-blur-md border-b border-[#303137] flex items-center justify-between px-4 sm:px-6 lg:px-8 sticky top-0 z-30">
            <div class="flex items-center gap-4">
                <button @click="sidebarOpen = true" class="lg:hidden p-2 rounded-lg bg-[#191A1F] border border-[#303137] text-[#92939A] hover:text-[#F4F2EF]">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
                <div>
                    <h1 class="text-lg sm:text-xl font-bold font-display text-[#F4F2EF] tracking-wide">
                        @yield('header_title', 'Dashboard')
                    </h1>
                    <p class="text-xs text-[#92939A]">@yield('header_subtitle', 'Sistem Manajemen Bengkel Presisi MOTOVEL')</p>
                </div>
            </div>

            <!-- Topbar Quick Action -->
            <div class="flex items-center gap-3">
                <span class="hidden sm:inline-flex items-center gap-2 text-xs text-[#92939A] bg-[#191A1F] border border-[#303137] px-3 py-1.5 rounded-full">
                    <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                    <span>Database MySQL Online</span>
                </span>
                
                <a href="{{ url('/admin/services/create') }}" class="inline-flex items-center gap-2 bg-[#9a1312] hover:bg-[#b91a19] text-white text-xs uppercase tracking-wider font-semibold py-2 px-4 rounded-lg shadow-md transition-colors">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    <span class="hidden sm:inline">Servis Baru</span>
                </a>
            </div>
        </header>

        <!-- Main Dashboard View Content -->
        <main class="flex-1 p-4 sm:p-6 lg:p-8 overflow-y-auto">
            @yield('content')
        </main>

    </div>

    @stack('scripts')
</body>
</html>
