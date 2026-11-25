@extends('layouts.admin')

@section('title', 'Detail Mekanik: ' . $mechanic->name)
@section('header_title', $mechanic->name)
@section('header_subtitle', 'Profil teknisi bengkel, spesialisasi keahlian, dan riwayat servis yang ditangani.')

@section('content')
<div class="space-y-8">

    <!-- Top Card -->
    <div class="bg-[#191A1F] border border-[#303137] rounded-2xl p-6 sm:p-8 shadow-xl flex flex-col md:flex-row md:items-center justify-between gap-6">
        <div class="flex items-center gap-5">
            <div class="w-16 h-16 rounded-2xl bg-[#9a1312] text-white flex items-center justify-center font-display text-3xl font-bold shadow-lg shadow-[#9a1312]/30">
                {{ strtoupper(substr($mechanic->name, 0, 1)) }}
            </div>
            <div>
                <div class="flex items-center gap-3">
                    <h2 class="font-display text-2xl font-bold text-[#F4F2EF]">{{ $mechanic->name }}</h2>
                    <span class="font-mono text-xs font-bold text-[#b91a19] bg-[#9a1312]/10 px-2.5 py-0.5 rounded">{{ $mechanic->mechanic_id }}</span>
                </div>
                <p class="text-xs text-[#92939A] mt-1">Spesialisasi: <strong class="text-[#F4F2EF]">{{ $mechanic->specialty }}</strong> • Terdaftar: {{ $mechanic->created_at->format('d M Y') }}</p>
            </div>
        </div>

        <div class="flex items-center gap-3">
            <a href="{{ route('admin.mechanics.edit', $mechanic->id) }}" class="bg-[#222329] hover:bg-[#303137] text-[#F4F2EF] text-xs uppercase tracking-wider font-semibold py-2.5 px-5 rounded-xl border border-[#303137] transition-colors">
                Edit Data Mekanik
            </a>
        </div>
    </div>

    <!-- Contact & Details Grid -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-[#191A1F] border border-[#303137] rounded-xl p-5">
            <span class="text-xs uppercase tracking-wider text-[#92939A] block mb-1">Nomor Kontak WhatsApp</span>
            <p class="text-base font-semibold font-mono text-[#F4F2EF]">{{ $mechanic->phone }}</p>
        </div>

        <div class="bg-[#191A1F] border border-[#303137] rounded-xl p-5">
            <span class="text-xs uppercase tracking-wider text-[#92939A] block mb-1">Bidang Keahlian Utama</span>
            <p class="text-base font-semibold text-[#b91a19]">{{ $mechanic->specialty }}</p>
        </div>

        <div class="bg-[#191A1F] border border-[#303137] rounded-xl p-5">
            <span class="text-xs uppercase tracking-wider text-[#92939A] block mb-1">Alamat Tinggal</span>
            <p class="text-xs text-[#F4F2EF] leading-relaxed">{{ $mechanic->address }}</p>
        </div>
    </div>

    <!-- Handled Services Table -->
    <div class="bg-[#191A1F] border border-[#303137] rounded-2xl p-6 shadow-xl space-y-4">
        <div class="flex items-center justify-between border-b border-[#303137] pb-4">
            <h3 class="font-display text-xl font-bold text-[#F4F2EF]">
                Daftar Servis yang Ditangani ({{ $mechanic->serviceDetails->count() }} Pengerjaan)
            </h3>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-[#92939A]">
                <thead class="uppercase tracking-wider bg-[#111216] text-[#92939A] border-b border-[#303137]">
                    <tr>
                        <th class="px-4 py-3">ID Detail</th>
                        <th class="px-4 py-3">ID Servis</th>
                        <th class="px-4 py-3">Sepeda Motor</th>
                        <th class="px-4 py-3">Pelanggan</th>
                        <th class="px-4 py-3">Catatan Estimasi</th>
                        <th class="px-4 py-3">Status</th>
                        <th class="px-4 py-3 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#303137]/60">
                    @forelse($mechanic->serviceDetails as $dtl)
                        <tr class="hover:bg-[#222329]/50">
                            <td class="px-4 py-3 font-mono font-bold text-[#b91a19]">{{ $dtl->detail_id }}</td>
                            <td class="px-4 py-3 font-mono font-bold text-[#F4F2EF]">{{ $dtl->serviceRegistration->service_id ?? '-' }}</td>
                            <td class="px-4 py-3 font-mono text-[#F4F2EF]">{{ $dtl->serviceRegistration->vehicle->plate_number ?? '-' }}</td>
                            <td class="px-4 py-3">{{ $dtl->serviceRegistration->customer->name ?? '-' }}</td>
                            <td class="px-4 py-3 max-w-xs truncate">{{ $dtl->estimation ?? '-' }}</td>
                            <td class="px-4 py-3"><x-status-badge :status="$dtl->status" type="service" /></td>
                            <td class="px-4 py-3 text-right">
                                <a href="{{ route('admin.service-details.show', $dtl->id) }}" class="text-[#b91a19] font-semibold hover:underline">Detail Pengerjaan</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-4 py-6 text-center text-[#92939A]">Belum ada servis yang ditugaskan ke mekanik ini.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
