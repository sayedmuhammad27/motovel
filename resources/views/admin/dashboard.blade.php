@extends('layouts.admin')

@section('title', 'Dashboard Operasional | MOTOVEL')
@section('header_title', 'Ringkasan Operasional Bengkel')
@section('header_subtitle', 'Statistik performa servis, pergerakan pelanggan, dan rekapitulasi pendapatan kasir.')

@section('content')
<div class="space-y-8">

    <!-- Top Stats Overview Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
        
        <!-- Total Pelanggan -->
        <x-stat-card 
            title="Total Pelanggan Terdaftar" 
            :value="$totalCustomers . ' Orang'" 
            subtitle="Basis data pelanggan terverifikasi"
            accent="blue">
            <x-slot:icon>
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
            </x-slot:icon>
        </x-stat-card>

        <!-- Total Kendaraan -->
        <x-stat-card 
            title="Sepeda Motor Terdata" 
            :value="$totalVehicles . ' Unit'" 
            subtitle="Unit motor matic dan manual"
            accent="amber">
            <x-slot:icon>
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                </svg>
            </x-slot:icon>
        </x-stat-card>

        <!-- Total Servis -->
        <x-stat-card 
            title="Total Pendaftaran Servis" 
            :value="$totalServices . ' Registrasi'" 
            :subtitle="$servicesInProgress . ' sedang dikerjakan saat ini'"
            accent="red">
            <x-slot:icon>
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                </svg>
            </x-slot:icon>
        </x-stat-card>

        <!-- Total Pendapatan Lunas -->
        <x-stat-card 
            title="Total Pendapatan Lunas" 
            :value="'Rp ' . number_format($totalRevenue, 0, ',', '.')" 
            :subtitle="'Menunggu: Rp ' . number_format($pendingRevenue, 0, ',', '.')"
            accent="emerald">
            <x-slot:icon>
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </x-slot:icon>
        </x-stat-card>

    </div>

    <!-- Operational Status Mini Cards -->
    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
        <div class="bg-[#191A1F] border border-[#303137] rounded-xl p-4 flex items-center justify-between">
            <div>
                <span class="text-xs text-[#92939A]">Antrean Menunggu</span>
                <p class="text-xl font-bold font-display text-amber-400 mt-0.5">{{ $servicesWaiting }} Motor</p>
            </div>
            <span class="w-2.5 h-2.5 rounded-full bg-amber-400"></span>
        </div>

        <div class="bg-[#191A1F] border border-[#303137] rounded-xl p-4 flex items-center justify-between">
            <div>
                <span class="text-xs text-[#92939A]">Sedang Dikerjakan</span>
                <p class="text-xl font-bold font-display text-blue-400 mt-0.5">{{ $servicesInProgress }} Motor</p>
            </div>
            <span class="w-2.5 h-2.5 rounded-full bg-blue-400 animate-pulse"></span>
        </div>

        <div class="bg-[#191A1F] border border-[#303137] rounded-xl p-4 flex items-center justify-between">
            <div>
                <span class="text-xs text-[#92939A]">Servis Selesai</span>
                <p class="text-xl font-bold font-display text-emerald-400 mt-0.5">{{ $servicesCompleted }} Motor</p>
            </div>
            <span class="w-2.5 h-2.5 rounded-full bg-emerald-400"></span>
        </div>

        <div class="bg-[#191A1F] border border-[#303137] rounded-xl p-4 flex items-center justify-between">
            <div>
                <span class="text-xs text-[#92939A]">Servis Dibatalkan</span>
                <p class="text-xl font-bold font-display text-zinc-400 mt-0.5">{{ $servicesCancelled }} Motor</p>
            </div>
            <span class="w-2.5 h-2.5 rounded-full bg-zinc-400"></span>
        </div>
    </div>

    <!-- Analytical Charts Section -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <!-- Chart 1: Donut Distribusi Status -->
        <div class="bg-[#191A1F] border border-[#303137] rounded-2xl p-6 shadow-xl flex flex-col justify-between">
            <div>
                <h3 class="text-sm font-semibold uppercase tracking-wider text-[#F4F2EF]">Distribusi Status Servis</h3>
                <p class="text-xs text-[#92939A] mt-1">Proporsi status seluruh pendaftaran servis motor</p>
            </div>
            <div class="my-6 relative flex items-center justify-center min-h-[220px]">
                <canvas id="statusDonutChart"></canvas>
            </div>
            <div class="grid grid-cols-2 gap-2 text-xs text-[#92939A] pt-4 border-t border-[#303137]/60">
                <div class="flex items-center gap-2"><span class="w-2 h-2 rounded-full bg-amber-400"></span> Menunggu: {{ $servicesWaiting }}</div>
                <div class="flex items-center gap-2"><span class="w-2 h-2 rounded-full bg-blue-400"></span> Pengerjaan: {{ $servicesInProgress }}</div>
                <div class="flex items-center gap-2"><span class="w-2 h-2 rounded-full bg-emerald-400"></span> Selesai: {{ $servicesCompleted }}</div>
                <div class="flex items-center gap-2"><span class="w-2 h-2 rounded-full bg-zinc-500"></span> Dibatalkan: {{ $servicesCancelled }}</div>
            </div>
        </div>

        <!-- Chart 2: Komposisi Finansial & Kasir -->
        <div class="lg:col-span-2 bg-[#191A1F] border border-[#303137] rounded-2xl p-6 shadow-xl flex flex-col justify-between">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-sm font-semibold uppercase tracking-wider text-[#F4F2EF]">Status Finansial & Kasir</h3>
                    <p class="text-xs text-[#92939A] mt-1">Perbandingan nominal pendapatan kasir lunas vs pending</p>
                </div>
                <span class="text-xs text-[#92939A] bg-[#222329] px-3 py-1 rounded-full border border-[#303137]">Bulan Ini</span>
            </div>
            <div class="my-6 min-h-[220px]">
                <canvas id="revenueBarChart"></canvas>
            </div>
            <div class="flex items-center justify-between pt-4 border-t border-[#303137]/60 text-xs">
                <div class="flex items-center gap-2">
                    <span class="w-3 h-3 rounded bg-emerald-500"></span>
                    <span class="text-[#92939A]">Lunas Terverifikasi: <strong class="text-[#F4F2EF]">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</strong></span>
                </div>
                <div class="flex items-center gap-2">
                    <span class="w-3 h-3 rounded bg-amber-500"></span>
                    <span class="text-[#92939A]">Menunggu Pembayaran: <strong class="text-[#F4F2EF]">Rp {{ number_format($pendingRevenue, 0, ',', '.') }}</strong></span>
                </div>
            </div>
        </div>

    </div>

    <!-- Recent Services Activity Table -->
    <div class="bg-[#191A1F] border border-[#303137] rounded-2xl overflow-hidden shadow-xl">
        <div class="p-6 border-b border-[#303137] flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h3 class="text-base font-bold font-display text-[#F4F2EF] tracking-wide">Pendaftaran Servis Terbaru</h3>
                <p class="text-xs text-[#92939A] mt-0.5">Daftar reservasi dan pengerjaan servis terkini yang masuk ke sistem bengkel</p>
            </div>
            <a href="{{ url('/admin/services') }}" class="inline-flex items-center gap-2 text-xs text-[#C62828] hover:text-[#E23B3B] font-semibold transition-colors">
                <span>Lihat Seluruh Servis</span>
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-[#92939A]">
                <thead class="text-xs uppercase tracking-wider bg-[#111216] text-[#92939A] border-b border-[#303137]">
                    <tr>
                        <th scope="col" class="px-6 py-4">ID Servis</th>
                        <th scope="col" class="px-6 py-4">Tanggal</th>
                        <th scope="col" class="px-6 py-4">Sepeda Motor & Pelanggan</th>
                        <th scope="col" class="px-6 py-4">Keluhan Utama</th>
                        <th scope="col" class="px-6 py-4">Mekanik</th>
                        <th scope="col" class="px-6 py-4">Status Servis</th>
                        <th scope="col" class="px-6 py-4">Total Biaya</th>
                        <th scope="col" class="px-6 py-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#303137]/60">
                    @forelse($recentServices as $srv)
                        <tr class="hover:bg-[#222329]/50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap font-mono text-xs font-bold text-[#F4F2EF]">
                                {{ $srv->service_id }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-xs">
                                {{ $srv->service_date ? $srv->service_date->format('d M Y') : '-' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-[#F4F2EF] font-semibold text-xs">{{ $srv->vehicle->plate_number ?? '-' }}</div>
                                <div class="text-[11px] text-[#92939A]">{{ $srv->customer->name ?? '-' }} ({{ ucfirst($srv->vehicle->type ?? '-') }})</div>
                            </td>
                            <td class="px-6 py-4 max-w-xs truncate text-xs">
                                {{ $srv->complaint }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-xs">
                                @if($srv->serviceDetail && $srv->serviceDetail->mechanic)
                                    <span class="text-[#F4F2EF]">{{ $srv->serviceDetail->mechanic->name }}</span>
                                @else
                                    <span class="text-zinc-500 italic">Belum ditugaskan</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <x-status-badge :status="$srv->status" type="service" />
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap font-mono text-xs font-semibold text-[#F4F2EF]">
                                @if($srv->payment)
                                    Rp {{ number_format($srv->payment->total_amount, 0, ',', '.') }}
                                @else
                                    <span class="text-zinc-500">-</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-xs">
                                <a href="{{ url('/admin/services/' . $srv->id) }}" class="text-[#C62828] hover:text-[#E23B3B] font-semibold transition-colors">
                                    Detail
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-6 py-12 text-center text-[#92939A]">
                                <div class="flex flex-col items-center justify-center gap-2">
                                    <svg class="w-8 h-8 text-[#92939A]/40" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                    </svg>
                                    <p>Belum ada data pendaftaran servis terbaru.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // 1. Donut Chart Status Servis
        const donutCtx = document.getElementById('statusDonutChart');
        if (donutCtx) {
            new Chart(donutCtx, {
                type: 'doughnut',
                data: {
                    labels: ['Menunggu', 'Sedang Dikerjakan', 'Selesai', 'Dibatalkan'],
                    datasets: [{
                        data: [
                            {{ $servicesWaiting }},
                            {{ $servicesInProgress }},
                            {{ $servicesCompleted }},
                            {{ $servicesCancelled }}
                        ],
                        backgroundColor: [
                            '#f59e0b', // amber
                            '#3b82f6', // blue
                            '#10b981', // emerald
                            '#71717a'  // zinc
                        ],
                        borderColor: '#191A1F',
                        borderWidth: 3,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false }
                    },
                    cutout: '72%'
                }
            });
        }

        // 2. Bar Chart Pendapatan
        const barCtx = document.getElementById('revenueBarChart');
        if (barCtx) {
            new Chart(barCtx, {
                type: 'bar',
                data: {
                    labels: ['Pendapatan Lunas (Kas Masuk)', 'Pembayaran Pending (Tertunda)'],
                    datasets: [{
                        label: 'Nominal (Rp)',
                        data: [{{ $totalRevenue }}, {{ $pendingRevenue }}],
                        backgroundColor: [
                            'rgba(16, 185, 129, 0.75)',
                            'rgba(245, 158, 11, 0.75)'
                        ],
                        borderColor: [
                            '#10b981',
                            '#f59e0b'
                        ],
                        borderWidth: 1,
                        borderRadius: 8
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false }
                    },
                    scales: {
                        x: {
                            grid: { display: false },
                            ticks: { color: '#92939A', font: { size: 11 } }
                        },
                        y: {
                            grid: { color: '#303137' },
                            ticks: {
                                color: '#92939A',
                                callback: function (value) {
                                    return 'Rp ' + (value / 1000).toLocaleString('id-ID') + 'k';
                                }
                            }
                        }
                    }
                }
            });
        }
    });
</script>
@endpush
