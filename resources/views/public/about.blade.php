@extends('layouts.app')

@section('title', 'Tentang Kami | MOTOVEL Precision Workshop')
@section('meta_description', 'Mengenal MOTOVEL, dedikasi kami pada presisi mekanis, mekanik tersertifikasi, dan fasilitas bengkel modern.')

@section('content')
<div class="py-12 sm:py-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-24">

        <!-- Header Hero Section -->
        <div class="max-w-3xl space-y-4">
            <span class="text-xs uppercase tracking-[0.25em] text-[#C62828] font-bold">Tentang MOTOVEL</span>
            <h1 class="font-display text-4xl sm:text-5xl lg:text-6xl font-bold text-[#F4F2EF] leading-tight">
                Membangun Standar Baru Perawatan Sepeda Motor.
            </h1>
            <p class="text-base sm:text-lg text-[#92939A] leading-relaxed font-light">
                MOTOVEL didirikan dengan keyakinan bahwa performa, keandalan, dan keselamatan berkendara lahir dari ketelitian tanpa kompromi. Kami menggabungkan keterampilan mekanik profesional dengan teknologi diagnostik digital terkini.
            </p>
        </div>

        <!-- Vision and Mission Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <div class="bg-[#111216] border border-[#303137] p-8 sm:p-10 rounded-2xl relative overflow-hidden">
                <div class="w-10 h-10 rounded-xl bg-[#C62828]/15 text-[#E23B3B] flex items-center justify-center font-bold mb-6">
                    V
                </div>
                <h2 class="font-display text-2xl sm:text-3xl font-bold text-[#F4F2EF] mb-3">Visi Kami</h2>
                <p class="text-sm text-[#92939A] leading-relaxed">
                    Menjadi pusat layanan perawatan sepeda motor paling tepercaya di Indonesia yang menetapkan tolok ukur tertinggi dalam hal akurasi diagnosa mekanis, orisinalitas suku cadang, dan kepuasan pelanggan.
                </p>
            </div>

            <div class="bg-[#111216] border border-[#303137] p-8 sm:p-10 rounded-2xl relative overflow-hidden">
                <div class="w-10 h-10 rounded-xl bg-[#C62828]/15 text-[#E23B3B] flex items-center justify-center font-bold mb-6">
                    M
                </div>
                <h2 class="font-display text-2xl sm:text-3xl font-bold text-[#F4F2EF] mb-3">Misi Kami</h2>
                <ul class="text-sm text-[#92939A] space-y-2.5 list-disc list-inside leading-relaxed">
                    <li>Memberikan diagnosa berbasis data akurat menggunakan scanner OEM modern.</li>
                    <li>Menyediakan suku cadang 100% original dengan jaminan kualitas terbaik.</li>
                    <li>Menerapkan transparansi harga dan dokumentasi pengerjaan yang terbuka.</li>
                    <li>Mengembangkan kompetensi teknisi melalui pelatihan berkala bersertifikasi.</li>
                </ul>
            </div>
        </div>

        <!-- Workshop Facilities Showcase -->
        <div class="space-y-8">
            <div>
                <span class="text-xs uppercase tracking-[0.25em] text-[#C62828] font-bold">Fasilitas Bengkel</span>
                <h2 class="font-display text-3xl sm:text-4xl font-bold text-[#F4F2EF] mt-1">Standar Bengkel Modern</h2>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                <div class="bg-[#191A1F] border border-[#303137] p-6 rounded-xl space-y-3">
                    <h3 class="font-display text-lg font-bold text-[#F4F2EF]">Pit Servis Hidraulik</h3>
                    <p class="text-xs text-[#92939A] leading-relaxed">Lift motor hidraulik elektrik dengan penerangan LED terfokus untuk inspeksi bagian bawah rangka secara optimal.</p>
                </div>
                <div class="bg-[#191A1F] border border-[#303137] p-6 rounded-xl space-y-3">
                    <h3 class="font-display text-lg font-bold text-[#F4F2EF]">Diagnostic Scanner OEM</h3>
                    <p class="text-xs text-[#92939A] leading-relaxed">Peralatan komputer pemindai sensor injeksi terkini untuk motor Honda, Yamaha, Kawasaki, Suzuki, dan Vespa.</p>
                </div>
                <div class="bg-[#191A1F] border border-[#303137] p-6 rounded-xl space-y-3">
                    <h3 class="font-display text-lg font-bold text-[#F4F2EF]">Tyre Changer Elektrik</h3>
                    <p class="text-xs text-[#92939A] leading-relaxed">Mesin bongkar pasang ban otomatis dengan pelindung teflon khusus sehingga bibir velg motor Anda tidak baret.</p>
                </div>
                <div class="bg-[#191A1F] border border-[#303137] p-6 rounded-xl space-y-3">
                    <h3 class="font-display text-lg font-bold text-[#F4F2EF]">Lounge Ruang Tunggu</h3>
                    <p class="text-xs text-[#92939A] leading-relaxed">Ruang tunggu ber-AC dengan kaca transparan ke arah pit servis, kopi gratis, high-speed WiFi, dan charging station.</p>
                </div>
            </div>
        </div>

        <!-- Meet Our Certified Mechanics -->
        <div class="space-y-8">
            <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-4">
                <div>
                    <span class="text-xs uppercase tracking-[0.25em] text-[#C62828] font-bold">Tim Teknis Kami</span>
                    <h2 class="font-display text-3xl sm:text-4xl font-bold text-[#F4F2EF] mt-1">Mekanik Profesional Tersertifikasi</h2>
                    <p class="text-xs sm:text-sm text-[#92939A] mt-1">Ditenagai oleh teknisi handal dengan keahlian spesialisasi masing-masing.</p>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($mechanics as $mech)
                    <div class="bg-[#191A1F] border border-[#303137] rounded-xl p-6 space-y-3 group hover:border-[#C62828]/50 transition-colors">
                        <div class="flex items-center justify-between">
                            <span class="font-mono text-xs text-[#C62828] font-bold bg-[#C62828]/10 px-2 py-0.5 rounded">{{ $mech->mechanic_id }}</span>
                            <span class="text-xs text-[#92939A]">Mekanik Senior</span>
                        </div>
                        <h3 class="font-display text-xl font-bold text-[#F4F2EF] group-hover:text-white transition-colors">{{ $mech->name }}</h3>
                        <div class="pt-2 border-t border-[#303137] text-xs space-y-1">
                            <p class="text-[#E23B3B] font-medium"><strong class="text-[#92939A]">Spesialisasi:</strong> {{ $mech->specialty }}</p>
                            <p class="text-[#92939A]"><strong class="text-[#F4F2EF]">Domisili:</strong> {{ $mech->address }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Conversion Section -->
        <div class="bg-[#111216] border border-[#303137] rounded-2xl p-8 sm:p-12 text-center space-y-6">
            <h2 class="font-display text-3xl sm:text-4xl font-bold text-[#F4F2EF]">Ingin Sepeda Motor Anda Ditangani Ahlinya?</h2>
            <p class="text-sm text-[#92939A] max-w-xl mx-auto">Jadwalkan servis kendaraan Anda dengan sistem reservasi mandiri kami yang cepat dan transparan.</p>
            <div>
                <a href="{{ url('/booking') }}" class="inline-flex items-center gap-3 bg-[#C62828] hover:bg-[#E23B3B] text-white text-xs uppercase tracking-widest font-semibold py-3.5 px-8 rounded-full shadow-xl transition-all">
                    <span>Daftar Servis Sekarang</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                    </svg>
                </a>
            </div>
        </div>

    </div>
</div>
@endsection
