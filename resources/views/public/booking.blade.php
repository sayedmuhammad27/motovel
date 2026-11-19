@extends('layouts.app')

@section('title', 'Pendaftaran Servis Mandiri | MOTOVEL')
@section('meta_description', 'Formulir pendaftaran servis mandiri sepeda motor MOTOVEL. Cek nomor HP, pilih motor, isi keluhan, dan pilih tanggal pengerjaan.')

@section('content')
<div class="py-12 sm:py-20" x-data="bookingEngine()">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 space-y-10">

        <!-- Header -->
        <div class="text-center max-w-2xl mx-auto space-y-3">
            <span class="text-xs uppercase tracking-[0.25em] text-[#C62828] font-bold">Booking Online Mandiri</span>
            <h1 class="font-display text-3xl sm:text-4xl lg:text-5xl font-bold text-[#F4F2EF] leading-tight">
                Pendaftaran Servis Sepeda Motor
            </h1>
            <p class="text-xs sm:text-sm text-[#92939A]">
                Sistem pendaftaran terhubung langsung ke antrean bengkel MySQL MOTOVEL. Masukkan nomor HP Anda untuk memulai.
            </p>
        </div>

        <!-- Progress Steps Bar -->
        <div class="bg-[#111216] border border-[#303137] rounded-2xl p-4 sm:p-6 shadow-xl">
            <div class="grid grid-cols-3 gap-2 text-center text-xs">
                <div class="flex flex-col items-center gap-1.5" :class="step >= 1 ? 'text-[#F4F2EF]' : 'text-[#92939A]'">
                    <span class="w-7 h-7 rounded-full flex items-center justify-center font-bold text-xs"
                          :class="step >= 1 ? 'bg-[#C62828] text-white shadow-md shadow-[#C62828]/30' : 'bg-[#191A1F] border border-[#303137]'">
                        1
                    </span>
                    <span class="font-medium text-[11px] sm:text-xs">Identitas & No. HP</span>
                </div>

                <div class="flex flex-col items-center gap-1.5" :class="step >= 2 ? 'text-[#F4F2EF]' : 'text-[#92939A]'">
                    <span class="w-7 h-7 rounded-full flex items-center justify-center font-bold text-xs"
                          :class="step >= 2 ? 'bg-[#C62828] text-white shadow-md shadow-[#C62828]/30' : 'bg-[#191A1F] border border-[#303137]'">
                        2
                    </span>
                    <span class="font-medium text-[11px] sm:text-xs">Data Sepeda Motor</span>
                </div>

                <div class="flex flex-col items-center gap-1.5" :class="step >= 3 ? 'text-[#F4F2EF]' : 'text-[#92939A]'">
                    <span class="w-7 h-7 rounded-full flex items-center justify-center font-bold text-xs"
                          :class="step >= 3 ? 'bg-[#C62828] text-white shadow-md shadow-[#C62828]/30' : 'bg-[#191A1F] border border-[#303137]'">
                        3
                    </span>
                    <span class="font-medium text-[11px] sm:text-xs">Keluhan & Jadwal</span>
                </div>
            </div>
        </div>

        <!-- Main Form Container -->
        <div class="bg-[#111216] border border-[#303137] rounded-2xl p-6 sm:p-10 shadow-2xl">
            <form action="{{ url('/booking') }}" method="POST" id="booking-form">
                @csrf

                <!-- STEP 1: Verifikasi Nomor HP & Data Pelanggan -->
                <div x-show="step === 1" class="space-y-6">
                    <div class="border-b border-[#303137] pb-4">
                        <h2 class="font-display text-2xl font-bold text-[#F4F2EF]">Langkah 1: Verifikasi Nomor HP Pelanggan</h2>
                        <p class="text-xs text-[#92939A] mt-1">Masukkan nomor WhatsApp aktif Anda untuk memeriksa apakah sudah terdaftar sebagai pelanggan MOTOVEL.</p>
                    </div>

                    <div class="space-y-4">
                        <div>
                            <label for="phone_input" class="block text-xs font-semibold uppercase tracking-wider text-[#92939A] mb-2">
                                Nomor Handphone / WhatsApp *
                            </label>
                            <div class="flex gap-3">
                                <input type="text" 
                                       name="phone" 
                                       id="phone_input"
                                       x-model="phone" 
                                       required
                                       class="flex-1 bg-[#191A1F] border border-[#303137] rounded-xl px-4 py-3 text-sm text-[#F4F2EF] font-mono placeholder-[#92939A]/40 focus:outline-none focus:border-[#C62828] focus:ring-1 focus:ring-[#C62828]"
                                       placeholder="Contoh: 081390123401">
                                <button type="button" 
                                        @click="verifyPhone()" 
                                        :disabled="isSearching || phone.length < 9"
                                        class="bg-[#C62828] hover:bg-[#E23B3B] disabled:opacity-50 text-white text-xs uppercase tracking-wider font-semibold px-6 py-3 rounded-xl transition-all flex items-center gap-2">
                                    <span x-show="!isSearching">Cek Nomor</span>
                                    <span x-show="isSearching" class="animate-spin inline-block w-4 h-4 border-2 border-white border-t-transparent rounded-full"></span>
                                </button>
                            </div>
                            <p class="text-[11px] text-[#92939A] mt-1.5">Ketik minimal 9 digit angka lalu klik "Cek Nomor".</p>
                        </div>

                        <!-- Status Alert Hasil Pengecekan -->
                        <template x-if="checkStatus === 'found'">
                            <div class="p-4 rounded-xl bg-emerald-500/10 border border-emerald-500/30 text-emerald-400 text-xs flex items-center justify-between">
                                <div class="flex items-center gap-2">
                                    <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                    </svg>
                                    <span>Pelanggan terdaftar: <strong class="text-white" x-text="customer.name"></strong> (<span x-text="customer.customer_id"></span>)</span>
                                </div>
                                <span class="text-[10px] bg-emerald-500/20 px-2 py-0.5 rounded font-mono" x-text="vehicles.length + ' motor tersimpan'"></span>
                            </div>
                        </template>

                        <template x-if="checkStatus === 'new'">
                            <div class="p-4 rounded-xl bg-blue-500/10 border border-blue-500/30 text-blue-400 text-xs flex items-center gap-2">
                                <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <span>Nomor belum terdaftar. Silakan lengkapi formulir identitas di bawah ini untuk pendaftaran akun pelanggan baru.</span>
                            </div>
                        </template>

                        <!-- Form Tambah Pelanggan Baru (Hanya jika belum terdaftar) -->
                        <div x-show="checkStatus === 'new'" class="space-y-4 pt-4 border-t border-[#303137]">
                            <h3 class="text-xs uppercase tracking-wider font-semibold text-[#F4F2EF]">Identitas Pelanggan Baru</h3>

                            <div>
                                <label class="block text-xs font-semibold uppercase tracking-wider text-[#92939A] mb-1.5">Nama Lengkap *</label>
                                <input type="text" name="name" x-model="customer.name" 
                                       class="w-full bg-[#191A1F] border border-[#303137] rounded-xl px-4 py-3 text-sm text-[#F4F2EF] focus:outline-none focus:border-[#C62828]"
                                       placeholder="Nama pemilik kendaraan">
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-xs font-semibold uppercase tracking-wider text-[#92939A] mb-1.5">Profesi / Pekerjaan *</label>
                                    <input type="text" name="occupation" x-model="customer.occupation" 
                                           class="w-full bg-[#191A1F] border border-[#303137] rounded-xl px-4 py-3 text-sm text-[#F4F2EF] focus:outline-none focus:border-[#C62828]"
                                           placeholder="Contoh: Karyawan Swasta, Wirausaha">
                                </div>
                                <div>
                                    <label class="block text-xs font-semibold uppercase tracking-wider text-[#92939A] mb-1.5">Alamat Lengkap *</label>
                                    <input type="text" name="address" x-model="customer.address" 
                                           class="w-full bg-[#191A1F] border border-[#303137] rounded-xl px-4 py-3 text-sm text-[#F4F2EF] focus:outline-none focus:border-[#C62828]"
                                           placeholder="Alamat domisili kota">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tombol Lanjut ke Langkah 2 -->
                    <div class="pt-6 border-t border-[#303137] flex justify-end">
                        <button type="button" 
                                @click="goToStep2()" 
                                :disabled="!canProceedToStep2()"
                                class="bg-[#C62828] hover:bg-[#E23B3B] disabled:opacity-40 text-white text-xs uppercase tracking-wider font-semibold py-3 px-8 rounded-xl transition-all flex items-center gap-2">
                            <span>Lanjut: Data Motor</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- STEP 2: Pilih / Tambah Kendaraan -->
                <div x-show="step === 2" class="space-y-6" style="display: none;">
                    <div class="border-b border-[#303137] pb-4">
                        <h2 class="font-display text-2xl font-bold text-[#F4F2EF]">Langkah 2: Pilih Sepeda Motor yang Akan Diservis</h2>
                        <p class="text-xs text-[#92939A] mt-1">Pilih dari unit motor yang sudah tersimpan atau daftarkan unit sepeda motor baru.</p>
                    </div>

                    <!-- Hidden Input Mode Kendaraan -->
                    <input type="hidden" name="vehicle_mode" :value="vehicleMode">

                    <!-- Opsi Kendaraan Tersimpan (Jika ada) -->
                    <template x-if="checkStatus === 'found' && vehicles.length > 0">
                        <div class="space-y-3">
                            <div class="flex items-center justify-between">
                                <label class="text-xs uppercase tracking-wider font-semibold text-[#92939A]">Pilihan Sepeda Motor:</label>
                                <button type="button" 
                                        @click="vehicleMode = (vehicleMode === 'existing' ? 'new' : 'existing')" 
                                        class="text-xs text-[#E23B3B] hover:underline font-medium">
                                    <span x-text="vehicleMode === 'existing' ? '+ Daftarkan Motor Baru' : '← Pilih Motor yang Sudah Ada'"></span>
                                </button>
                            </div>

                            <div x-show="vehicleMode === 'existing'" class="space-y-2">
                                <template x-for="v in vehicles" :key="v.id">
                                    <label class="flex items-center justify-between p-4 rounded-xl border cursor-pointer transition-all"
                                           :class="selectedVehicleId == v.id ? 'bg-[#C62828]/10 border-[#C62828] text-white' : 'bg-[#191A1F] border-[#303137] text-[#92939A] hover:border-[#92939A]'">
                                        <div class="flex items-center gap-3">
                                            <input type="radio" name="vehicle_id" :value="v.id" x-model="selectedVehicleId" class="text-[#C62828] focus:ring-[#C62828]">
                                            <div>
                                                <p class="text-sm font-bold font-mono text-[#F4F2EF]" x-text="v.plate_number"></p>
                                                <p class="text-xs text-[#92939A]" x-text="'Tipe: ' + v.type.toUpperCase() + ' | Tahun ' + v.year + ' | Warna: ' + v.color"></p>
                                            </div>
                                        </div>
                                        <span class="text-xs font-mono text-[#92939A]" x-text="v.stnk_number"></span>
                                    </label>
                                </template>
                            </div>
                        </div>
                    </template>

                    <!-- Form Tambah Kendaraan Baru -->
                    <div x-show="vehicleMode === 'new' || checkStatus === 'new'" class="space-y-4 bg-[#191A1F] border border-[#303137] p-6 rounded-xl">
                        <h3 class="text-xs uppercase tracking-wider font-semibold text-[#F4F2EF]">Formulir Registrasi Sepeda Motor</h3>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-semibold uppercase tracking-wider text-[#92939A] mb-1.5">Nomor Plat Motor *</label>
                                <input type="text" name="plate_number" x-model="newVehicle.plate_number" 
                                       class="w-full bg-[#111216] border border-[#303137] rounded-xl px-4 py-3 text-sm font-mono text-[#F4F2EF] uppercase focus:outline-none focus:border-[#C62828]"
                                       placeholder="Contoh: L 1234 XY">
                            </div>

                            <div>
                                <label class="block text-xs font-semibold uppercase tracking-wider text-[#92939A] mb-1.5">Jenis Transmisi Motor *</label>
                                <div class="grid grid-cols-2 gap-3 pt-1">
                                    <label class="flex items-center gap-2 p-3 rounded-lg border border-[#303137] bg-[#111216] cursor-pointer text-xs"
                                           :class="newVehicle.type === 'matic' ? 'border-[#C62828] text-white' : 'text-[#92939A]'">
                                        <input type="radio" name="type" value="matic" x-model="newVehicle.type" class="text-[#C62828]">
                                        <span>Matic / CVT</span>
                                    </label>
                                    <label class="flex items-center gap-2 p-3 rounded-lg border border-[#303137] bg-[#111216] cursor-pointer text-xs"
                                           :class="newVehicle.type === 'manual' ? 'border-[#C62828] text-white' : 'text-[#92939A]'">
                                        <input type="radio" name="type" value="manual" x-model="newVehicle.type" class="text-[#C62828]">
                                        <span>Manual / Sport</span>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                            <div>
                                <label class="block text-xs font-semibold uppercase tracking-wider text-[#92939A] mb-1.5">Nomor STNK *</label>
                                <input type="text" name="stnk_number" x-model="newVehicle.stnk_number" 
                                       class="w-full bg-[#111216] border border-[#303137] rounded-xl px-4 py-2.5 text-xs text-[#F4F2EF] font-mono focus:outline-none focus:border-[#C62828]"
                                       placeholder="STNK-xxxxxxx">
                            </div>
                            <div>
                                <label class="block text-xs font-semibold uppercase tracking-wider text-[#92939A] mb-1.5">Tahun Pembuatan *</label>
                                <input type="number" name="year" x-model="newVehicle.year" min="1990" max="{{ date('Y') + 1 }}" 
                                       class="w-full bg-[#111216] border border-[#303137] rounded-xl px-4 py-2.5 text-xs text-[#F4F2EF] font-mono focus:outline-none focus:border-[#C62828]"
                                       placeholder="Contoh: 2023">
                            </div>
                            <div>
                                <label class="block text-xs font-semibold uppercase tracking-wider text-[#92939A] mb-1.5">Warna Bodi Motor *</label>
                                <input type="text" name="color" x-model="newVehicle.color" 
                                       class="w-full bg-[#111216] border border-[#303137] rounded-xl px-4 py-2.5 text-xs text-[#F4F2EF] focus:outline-none focus:border-[#C62828]"
                                       placeholder="Contoh: Matte Black">
                            </div>
                        </div>
                    </div>

                    <!-- Navigasi Langkah 2 -->
                    <div class="pt-6 border-t border-[#303137] flex items-center justify-between">
                        <button type="button" @click="step = 1" class="text-xs uppercase tracking-wider text-[#92939A] hover:text-[#F4F2EF] transition-colors">
                            ← Kembali ke Langkah 1
                        </button>

                        <button type="button" 
                                @click="goToStep3()" 
                                :disabled="!canProceedToStep3()"
                                class="bg-[#C62828] hover:bg-[#E23B3B] disabled:opacity-40 text-white text-xs uppercase tracking-wider font-semibold py-3 px-8 rounded-xl transition-all flex items-center gap-2">
                            <span>Lanjut: Keluhan & Tanggal</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- STEP 3: Keluhan & Tanggal Servis -->
                <div x-show="step === 3" class="space-y-6" style="display: none;">
                    <div class="border-b border-[#303137] pb-4">
                        <h2 class="font-display text-2xl font-bold text-[#F4F2EF]">Langkah 3: Keluhan & Pemilihan Tanggal Servis</h2>
                        <p class="text-xs text-[#92939A] mt-1">Jelaskan gejala kerusakan yang dialami atau paket perawatan yang Anda butuhkan.</p>
                    </div>

                    <div class="space-y-5">
                        <div>
                            <label for="complaint_input" class="block text-xs font-semibold uppercase tracking-wider text-[#92939A] mb-2">
                                Deskripsi Keluhan / Catatan Servis *
                            </label>
                            <textarea name="complaint" 
                                      id="complaint_input" 
                                      x-model="complaint" 
                                      rows="4" 
                                      required
                                      class="w-full bg-[#191A1F] border border-[#303137] rounded-xl p-4 text-sm text-[#F4F2EF] placeholder-[#92939A]/40 focus:outline-none focus:border-[#C62828] focus:ring-1 focus:ring-[#C62828]"
                                      placeholder="Tuliskan secara rinci, contoh: Servis rutin 10.000 KM, tarikan awal CVT gredek saat tanjakan, dan minta ganti oli Motul 7100."></textarea>
                            <p class="text-[11px] text-[#92939A] mt-1">Informasi ini akan langsung dibaca oleh kepala mekanik kami saat persiapan pit servis.</p>
                        </div>

                        <div>
                            <label for="service_date_input" class="block text-xs font-semibold uppercase tracking-wider text-[#92939A] mb-2">
                                Rencana Tanggal Kedatangan Servis *
                            </label>
                            <input type="date" 
                                   name="service_date" 
                                   id="service_date_input" 
                                   x-model="serviceDate" 
                                   min="{{ date('Y-m-d') }}"
                                   required
                                   class="w-full sm:w-64 bg-[#191A1F] border border-[#303137] rounded-xl px-4 py-3 text-sm text-[#F4F2EF] focus:outline-none focus:border-[#C62828] focus:ring-1 focus:ring-[#C62828]">
                            <p class="text-[11px] text-[#92939A] mt-1">Pilih tanggal hari ini atau beberapa hari ke depan (Senin s.d. Sabtu).</p>
                        </div>

                        <!-- Ringkasan Singkat Pra-Kirim -->
                        <div class="bg-[#191A1F] border border-[#303137] rounded-xl p-5 text-xs text-[#92939A] space-y-2">
                            <p class="font-semibold text-[#F4F2EF] uppercase tracking-wider text-[11px]">Ringkasan Pendaftaran:</p>
                            <div class="grid grid-cols-2 gap-2 text-[11px]">
                                <div>Pemilik: <span class="text-white font-medium" x-text="customer.name"></span></div>
                                <div>No. WhatsApp: <span class="text-white font-medium font-mono" x-text="phone"></span></div>
                                <div>Kendaraan: <span class="text-white font-medium font-mono" x-text="vehicleMode === 'existing' ? 'Motor Terpilih' : newVehicle.plate_number"></span></div>
                                <div>Tanggal Servis: <span class="text-white font-medium" x-text="serviceDate"></span></div>
                            </div>
                        </div>
                    </div>

                    <!-- Navigasi Langkah 3 & Submit -->
                    <div class="pt-6 border-t border-[#303137] flex items-center justify-between">
                        <button type="button" @click="step = 2" class="text-xs uppercase tracking-wider text-[#92939A] hover:text-[#F4F2EF] transition-colors">
                            ← Kembali ke Langkah 2
                        </button>

                        <button type="submit" 
                                :disabled="complaint.length < 5 || !serviceDate"
                                class="bg-[#C62828] hover:bg-[#E23B3B] disabled:opacity-40 text-white text-xs uppercase tracking-widest font-semibold py-4 px-10 rounded-xl shadow-xl shadow-[#C62828]/30 transition-all flex items-center gap-2">
                            <span>Konfirmasi & Simpan Booking</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                        </button>
                    </div>
                </div>

            </form>
        </div>

    </div>
</div>

@push('scripts')
<script>
    function bookingEngine() {
        return {
            step: 1,
            phone: '',
            isSearching: false,
            checkStatus: null, // 'found', 'new', null
            customer: {
                id: null,
                customer_id: '',
                name: '',
                address: '',
                occupation: ''
            },
            vehicles: [],
            vehicleMode: 'existing', // 'existing' or 'new'
            selectedVehicleId: '',
            newVehicle: {
                plate_number: '',
                type: 'matic',
                stnk_number: '',
                year: '{{ date("Y") }}',
                color: ''
            },
            complaint: '',
            serviceDate: '{{ date("Y-m-d") }}',

            async verifyPhone() {
                if (this.phone.trim().length < 9) return;
                this.isSearching = true;

                try {
                    const response = await fetch('{{ url("/booking/check-phone") }}?phone=' + encodeURIComponent(this.phone.trim()));
                    const result = await response.json();

                    if (result.found) {
                        this.checkStatus = 'found';
                        this.customer = result.customer;
                        this.vehicles = result.vehicles;
                        this.vehicleMode = this.vehicles.length > 0 ? 'existing' : 'new';
                        if (this.vehicles.length > 0) {
                            this.selectedVehicleId = this.vehicles[0].id;
                        }
                    } else {
                        this.checkStatus = 'new';
                        this.customer = { id: null, customer_id: '', name: '', address: '', occupation: '' };
                        this.vehicles = [];
                        this.vehicleMode = 'new';
                    }
                } catch (error) {
                    console.error('Error checking phone:', error);
                    alert('Gagal menghubungi server. Pastikan server lokal aktif.');
                } finally {
                    this.isSearching = false;
                }
            },

            canProceedToStep2() {
                if (!this.checkStatus) return false;
                if (this.checkStatus === 'found') return true;
                if (this.checkStatus === 'new') {
                    return this.customer.name.trim().length > 2 &&
                           this.customer.address.trim().length > 3 &&
                           this.customer.occupation.trim().length > 2;
                }
                return false;
            },

            goToStep2() {
                if (this.canProceedToStep2()) {
                    this.step = 2;
                }
            },

            canProceedToStep3() {
                if (this.vehicleMode === 'existing') {
                    return this.selectedVehicleId !== '';
                } else {
                    return this.newVehicle.plate_number.trim().length >= 3 &&
                           this.newVehicle.stnk_number.trim().length >= 4 &&
                           this.newVehicle.color.trim().length >= 2 &&
                           this.newVehicle.year > 1990;
                }
            },

            goToStep3() {
                if (this.canProceedToStep3()) {
                    this.step = 3;
                }
            }
        }
    }
</script>
@endpush
@endsection
