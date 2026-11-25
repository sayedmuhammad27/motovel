@extends('layouts.app')

@section('title', 'Kontak & Lokasi Workshop | MOTOVEL')
@section('meta_description', 'Hubungi tim bengkel MOTOVEL untuk konsultasi servis sepeda motor, ketersediaan suku cadang, atau bantuan darurat.')

@section('content')
<div class="py-12 sm:py-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-16">

        <!-- Header -->
        <div class="max-w-3xl space-y-4">
            <span class="text-xs uppercase tracking-[0.25em] text-[#9a1312] font-bold">Layanan Pelanggan</span>
            <h1 class="font-display text-4xl sm:text-5xl lg:text-6xl font-bold text-[#F4F2EF] leading-tight">
                Hubungi Kami & Kunjungi Workshop
            </h1>
            <p class="text-base sm:text-lg text-[#92939A] font-light leading-relaxed">
                Ada pertanyaan mengenai gejala motor Anda, ketersediaan suku cadang racing, atau ingin berkonsultasi langsung dengan kepala mekanik kami?
            </p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12">
            
            <!-- Left Info Cards -->
            <div class="lg:col-span-5 space-y-6">
                
                <div class="bg-[#111216] border border-[#303137] rounded-2xl p-6 sm:p-8 space-y-6">
                    <div>
                        <span class="text-xs uppercase tracking-wider text-[#9a1312] font-bold">Alamat Utama Bengkel</span>
                        <h3 class="font-display text-xl font-bold text-[#F4F2EF] mt-1">MOTOVEL Workshop Surabaya</h3>
                        <p class="text-xs text-[#92939A] mt-2 leading-relaxed">
                            Jl. Mayjen Sungkono No. 108, Sawahan, Surabaya, Jawa Timur 60256 (Tepat di seberang Gedung Graha Pena, deretan ruko otomotif).
                        </p>
                    </div>

                    <div class="space-y-4 text-xs border-t border-[#303137] pt-6">
                        <div>
                            <span class="text-[#92939A] block">Telepon Kantor:</span>
                            <span class="text-base font-semibold text-[#F4F2EF] font-mono">(031) 567-8900</span>
                        </div>
                        <div>
                            <span class="text-[#92939A] block">WhatsApp CS & Booking Darurat:</span>
                            <span class="text-base font-semibold text-emerald-400 font-mono">0812-3456-7890</span>
                        </div>
                        <div>
                            <span class="text-[#92939A] block">Email Resmi:</span>
                            <span class="text-sm font-semibold text-[#F4F2EF]">service@motovel.com</span>
                        </div>
                    </div>

                    <div class="border-t border-[#303137] pt-6">
                        <span class="text-xs uppercase tracking-wider text-[#9a1312] font-bold block mb-2">Jam Buka Bengkel</span>
                        <div class="text-xs space-y-1.5 text-[#92939A]">
                            <div class="flex justify-between">
                                <span>Senin - Jumat</span>
                                <span class="text-[#F4F2EF] font-medium">08:00 - 17:00 WIB</span>
                            </div>
                            <div class="flex justify-between">
                                <span>Sabtu</span>
                                <span class="text-[#F4F2EF] font-medium">08:00 - 15:00 WIB</span>
                            </div>
                            <div class="flex justify-between">
                                <span>Minggu / Hari Libur</span>
                                <span class="text-[#b91a19] font-medium">Khusus Appointment</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Fast Booking Callout -->
                <div class="bg-[#191A1F] border border-[#303137] rounded-2xl p-6 text-center space-y-3">
                    <p class="text-xs font-semibold text-[#F4F2EF]">Ingin langsung memesan jadwal servis?</p>
                    <p class="text-xs text-[#92939A]">Gunakan formulir pendaftaran mandiri kami untuk mendapatkan nomor antrean instan.</p>
                    <a href="{{ url('/booking') }}" class="inline-block w-full bg-[#9a1312] hover:bg-[#b91a19] text-white text-xs uppercase tracking-wider font-semibold py-3 rounded-xl transition-colors">
                        Buka Formulir Pendaftaran Servis
                    </a>
                </div>

            </div>

            <!-- Right Form -->
            <div class="lg:col-span-7">
                <div class="bg-[#111216] border border-[#303137] rounded-2xl p-6 sm:p-10 shadow-xl space-y-6">
                    <div>
                        <h2 class="font-display text-2xl sm:text-3xl font-bold text-[#F4F2EF]">Kirim Pesan ke Tim MOTOVEL</h2>
                        <p class="text-xs text-[#92939A] mt-1">Kami akan membalas pesan Anda selambat-lambatnya dalam 1x24 jam kerja.</p>
                    </div>

                    <form action="{{ url('/contact') }}" method="POST" class="space-y-5">
                        @csrf

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                            <div>
                                <label for="name" class="block text-xs font-semibold uppercase tracking-wider text-[#92939A] mb-2">Nama Lengkap *</label>
                                <input type="text" name="name" id="name" value="{{ old('name') }}" required 
                                       class="w-full bg-[#191A1F] border border-[#303137] rounded-xl px-4 py-3 text-sm text-[#F4F2EF] placeholder-[#92939A]/40 focus:outline-none focus:border-[#9a1312] focus:ring-1 focus:ring-[#9a1312]"
                                       placeholder="Contoh: Dimas Arya">
                                @error('name') <p class="text-xs text-[#b91a19] mt-1">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label for="email" class="block text-xs font-semibold uppercase tracking-wider text-[#92939A] mb-2">Alamat Email *</label>
                                <input type="email" name="email" id="email" value="{{ old('email') }}" required 
                                       class="w-full bg-[#191A1F] border border-[#303137] rounded-xl px-4 py-3 text-sm text-[#F4F2EF] placeholder-[#92939A]/40 focus:outline-none focus:border-[#9a1312] focus:ring-1 focus:ring-[#9a1312]"
                                       placeholder="nama@email.com">
                                @error('email') <p class="text-xs text-[#b91a19] mt-1">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                            <div>
                                <label for="phone" class="block text-xs font-semibold uppercase tracking-wider text-[#92939A] mb-2">Nomor Telepon / WhatsApp</label>
                                <input type="text" name="phone" id="phone" value="{{ old('phone') }}" 
                                       class="w-full bg-[#191A1F] border border-[#303137] rounded-xl px-4 py-3 text-sm text-[#F4F2EF] placeholder-[#92939A]/40 focus:outline-none focus:border-[#9a1312] focus:ring-1 focus:ring-[#9a1312]"
                                       placeholder="0812xxxxxxxx">
                                @error('phone') <p class="text-xs text-[#b91a19] mt-1">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label for="subject" class="block text-xs font-semibold uppercase tracking-wider text-[#92939A] mb-2">Subjek Keperluan *</label>
                                <select name="subject" id="subject" required 
                                        class="w-full bg-[#191A1F] border border-[#303137] rounded-xl px-4 py-3 text-sm text-[#F4F2EF] focus:outline-none focus:border-[#9a1312] focus:ring-1 focus:ring-[#9a1312]">
                                    <option value="" disabled {{ old('subject') ? '' : 'selected' }}>Pilih topik pertanyaan...</option>
                                    <option value="Konsultasi Servis Mesin" {{ old('subject') === 'Konsultasi Servis Mesin' ? 'selected' : '' }}>Konsultasi Servis Mesin</option>
                                    <option value="Ketersediaan Sparepart" {{ old('subject') === 'Ketersediaan Sparepart' ? 'selected' : '' }}>Ketersediaan Sparepart</option>
                                    <option value="Masalah Gredek CVT Matic" {{ old('subject') === 'Masalah Gredek CVT Matic' ? 'selected' : '' }}>Masalah Gredek CVT Matic</option>
                                    <option value="Kelistrikan & ECU" {{ old('subject') === 'Kelistrikan & ECU' ? 'selected' : '' }}>Kelistrikan & ECU</option>
                                    <option value="Kerjasama & Lainnya" {{ old('subject') === 'Kerjasama & Lainnya' ? 'selected' : '' }}>Kerjasama & Lainnya</option>
                                </select>
                                @error('subject') <p class="text-xs text-[#b91a19] mt-1">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        <div>
                            <label for="message" class="block text-xs font-semibold uppercase tracking-wider text-[#92939A] mb-2">Pesan atau Keluhan Motor *</label>
                            <textarea name="message" id="message" rows="5" required 
                                      class="w-full bg-[#191A1F] border border-[#303137] rounded-xl p-4 text-sm text-[#F4F2EF] placeholder-[#92939A]/40 focus:outline-none focus:border-[#9a1312] focus:ring-1 focus:ring-[#9a1312]"
                                      placeholder="Tuliskan secara singkat gejala yang dialami motor Anda, merk/tipe motor, atau suku cadang yang dicari...">{{ old('message') }}</textarea>
                            @error('message') <p class="text-xs text-[#b91a19] mt-1">{{ $message }}</p> @enderror
                        </div>

                        <button type="submit" 
                                class="w-full sm:w-auto bg-[#9a1312] hover:bg-[#b91a19] text-white text-xs uppercase tracking-widest font-semibold py-4 px-8 rounded-xl shadow-lg shadow-[#9a1312]/25 hover:shadow-[#9a1312]/40 transition-all duration-300">
                            Kirimkan Pesan
                        </button>
                    </form>
                </div>
            </div>

        </div>

    </div>
</div>
@endsection
