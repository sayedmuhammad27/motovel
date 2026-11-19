@extends('layouts.app')

@section('title', 'Masuk Portal | MOTOVEL')

@section('content')
<div class="min-h-[80vh] flex items-center justify-center px-4 py-12 relative">
    <!-- Background Glow -->
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[600px] h-[600px] bg-[#C62828]/10 rounded-full blur-[140px]"></div>
    </div>

    <div class="relative z-10 w-full max-w-md">
        <!-- Brand Badge -->
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-12 h-12 rounded-xl bg-[#C62828] text-white font-bold text-xl shadow-xl shadow-[#C62828]/30 mb-4">
                M
            </div>
            <h1 class="font-display text-3xl font-bold text-[#F4F2EF] tracking-wider">MOTOVEL PORTAL</h1>
            <p class="text-xs text-[#92939A] mt-1 uppercase tracking-[0.2em]">Autentikasi Staf & Administrator</p>
        </div>

        <!-- Login Card -->
        <div class="bg-[#111216]/90 backdrop-blur-xl border border-[#303137] rounded-2xl p-6 sm:p-8 shadow-2xl">
            <form action="{{ url('/login') }}" method="POST" class="space-y-5">
                @csrf

                <!-- Email Input -->
                <div>
                    <label for="email" class="block text-xs font-semibold uppercase tracking-wider text-[#92939A] mb-2">
                        Alamat Email
                    </label>
                    <input type="email" 
                           name="email" 
                           id="email" 
                           value="{{ old('email', 'admin@motovel.com') }}" 
                           required 
                           autocomplete="email"
                           class="w-full bg-[#191A1F] border border-[#303137] rounded-xl px-4 py-3 text-sm text-[#F4F2EF] placeholder-[#92939A]/50 focus:outline-none focus:border-[#C62828] focus:ring-1 focus:ring-[#C62828] transition-all"
                           placeholder="nama@motovel.com">
                    @error('email')
                        <p class="text-xs text-[#E23B3B] mt-1.5">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password Input -->
                <div>
                    <label for="password" class="block text-xs font-semibold uppercase tracking-wider text-[#92939A] mb-2">
                        Kata Sandi
                    </label>
                    <input type="password" 
                           name="password" 
                           id="password" 
                           required 
                           autocomplete="current-password"
                           value="password"
                           class="w-full bg-[#191A1F] border border-[#303137] rounded-xl px-4 py-3 text-sm text-[#F4F2EF] placeholder-[#92939A]/50 focus:outline-none focus:border-[#C62828] focus:ring-1 focus:ring-[#C62828] transition-all"
                           placeholder="••••••••">
                    @error('password')
                        <p class="text-xs text-[#E23B3B] mt-1.5">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Remember Me -->
                <div class="flex items-center justify-between text-xs">
                    <label class="flex items-center gap-2 cursor-pointer text-[#92939A] hover:text-[#F4F2EF]">
                        <input type="checkbox" name="remember" class="rounded bg-[#191A1F] border-[#303137] text-[#C62828] focus:ring-[#C62828]/30">
                        <span>Ingat sesi saya</span>
                    </label>
                </div>

                <!-- Submit Button -->
                <button type="submit" 
                        class="w-full bg-[#C62828] hover:bg-[#E23B3B] text-white font-semibold text-xs uppercase tracking-widest py-3.5 px-4 rounded-xl shadow-xl shadow-[#C62828]/25 hover:shadow-[#C62828]/40 transition-all duration-300 transform active:scale-[0.99] focus:outline-none focus:ring-2 focus:ring-[#C62828] focus:ring-offset-2 focus:ring-offset-[#08090B]">
                    Masuk ke Sistem
                </button>
            </form>

            <!-- Quick Demo Accounts Helper -->
            <div class="mt-6 pt-6 border-t border-[#303137] text-xs text-[#92939A]">
                <p class="font-semibold text-[#F4F2EF] mb-2 text-[11px] uppercase tracking-wider">Akun Demo Terdaftar:</p>
                <div class="space-y-1.5 font-mono text-[11px] bg-[#191A1F] p-3 rounded-lg border border-[#303137]/60">
                    <div class="flex justify-between items-center cursor-pointer hover:text-[#F4F2EF]" onclick="document.getElementById('email').value='admin@motovel.com'; document.getElementById('password').value='password';">
                        <span><strong class="text-[#E23B3B]">Admin:</strong> admin@motovel.com</span>
                        <span class="text-[10px] bg-[#303137] px-1.5 py-0.5 rounded text-white font-sans">Klik pakai</span>
                    </div>
                    <div class="flex justify-between items-center cursor-pointer hover:text-[#F4F2EF]" onclick="document.getElementById('email').value='petugas@motovel.com'; document.getElementById('password').value='password';">
                        <span><strong class="text-blue-400">Petugas:</strong> petugas@motovel.com</span>
                        <span class="text-[10px] bg-[#303137] px-1.5 py-0.5 rounded text-white font-sans">Klik pakai</span>
                    </div>
                    <div class="pt-1 text-[10px] text-[#92939A] font-sans">Password sama: <code class="text-emerald-400">password</code></div>
                </div>
            </div>
        </div>

        <!-- Back to Website -->
        <div class="text-center mt-6">
            <a href="{{ url('/') }}" class="inline-flex items-center gap-2 text-xs text-[#92939A] hover:text-[#F4F2EF] transition-colors">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                <span>Kembali ke Beranda Publik</span>
            </a>
        </div>
    </div>
</div>
@endsection
