@extends('layouts.admin')

@section('title', 'Pusat Laporan & Analitik | MOTOVEL')
@section('header_title', 'Pusat Laporan & Analitik Operasional')
@section('header_subtitle', 'Rekapitulasi performa finansial pendapatan bengkel, produktivitas servis, dan mutasi suku cadang.')

@section('content')
<div class="space-y-6">

    <!-- Report Type Selector & Date Filter Card -->
    <div class="bg-[#191A1F] border border-[#303137] rounded-2xl p-6 shadow-xl">
        <form method="GET" action="{{ route('admin.reports') }}" class="space-y-4">
            <!-- Tabs Laporan -->
            <div class="flex flex-wrap gap-2 pb-4 border-b border-[#303137]">
                <a href="{{ route('admin.reports', ['type' => 'revenue', 'start_date' => $startDate, 'end_date' => $endDate]) }}" 
                   class="px-4 py-2 rounded-xl text-xs font-semibold uppercase tracking-wider transition-all {{ $reportType === 'revenue' ? 'bg-[#9a1312] text-white shadow-lg' : 'bg-[#111216] text-[#92939A] hover:text-[#F4F2EF] border border-[#303137]' }}">
                    1. Pendapatan & Kasir
                </a>
                <a href="{{ route('admin.reports', ['type' => 'services', 'start_date' => $startDate, 'end_date' => $endDate]) }}" 
                   class="px-4 py-2 rounded-xl text-xs font-semibold uppercase tracking-wider transition-all {{ $reportType === 'services' ? 'bg-[#9a1312] text-white shadow-lg' : 'bg-[#111216] text-[#92939A] hover:text-[#F4F2EF] border border-[#303137]' }}">
                    2. Pengerjaan Servis
                </a>
                <a href="{{ route('admin.reports', ['type' => 'spareparts', 'start_date' => $startDate, 'end_date' => $endDate]) }}" 
                   class="px-4 py-2 rounded-xl text-xs font-semibold uppercase tracking-wider transition-all {{ $reportType === 'spareparts' ? 'bg-[#9a1312] text-white shadow-lg' : 'bg-[#111216] text-[#92939A] hover:text-[#F4F2EF] border border-[#303137]' }}">
                    3. Pemakaian Suku Cadang
                </a>
                <a href="{{ route('admin.reports', ['type' => 'customers', 'start_date' => $startDate, 'end_date' => $endDate]) }}" 
                   class="px-4 py-2 rounded-xl text-xs font-semibold uppercase tracking-wider transition-all {{ $reportType === 'customers' ? 'bg-[#9a1312] text-white shadow-lg' : 'bg-[#111216] text-[#92939A] hover:text-[#F4F2EF] border border-[#303137]' }}">
                    4. Data Pelanggan Baru
                </a>
                <a href="{{ route('admin.reports', ['type' => 'vehicles', 'start_date' => $startDate, 'end_date' => $endDate]) }}" 
                   class="px-4 py-2 rounded-xl text-xs font-semibold uppercase tracking-wider transition-all {{ $reportType === 'vehicles' ? 'bg-[#9a1312] text-white shadow-lg' : 'bg-[#111216] text-[#92939A] hover:text-[#F4F2EF] border border-[#303137]' }}">
                    5. Unit Sepeda Motor
                </a>
            </div>

            <!-- Date Range & Action Buttons -->
            <div class="flex flex-wrap items-center justify-between gap-4 pt-1">
                <input type="hidden" name="type" value="{{ $reportType }}">

                <div class="flex flex-wrap items-center gap-3">
                    <div class="flex items-center gap-2">
                        <span class="text-xs text-[#92939A]">Periode:</span>
                        <input type="date" name="start_date" value="{{ $startDate }}" class="bg-[#111216] border border-[#303137] rounded-xl px-3 py-2 text-xs text-[#F4F2EF] focus:outline-none focus:border-[#9a1312]">
                    </div>
                    <span class="text-xs text-[#92939A]">s/d</span>
                    <input type="date" name="end_date" value="{{ $endDate }}" class="bg-[#111216] border border-[#303137] rounded-xl px-3 py-2 text-xs text-[#F4F2EF] focus:outline-none focus:border-[#9a1312]">

                    <button type="submit" class="bg-[#222329] hover:bg-[#303137] text-white text-xs font-semibold py-2 px-4 rounded-xl border border-[#303137] transition-colors">
                        Tampilkan Laporan
                    </button>
                </div>

                <!-- Print Link Button -->
                <a href="{{ route('admin.reports.print', ['type' => $reportType, 'start_date' => $startDate, 'end_date' => $endDate]) }}" target="_blank" class="inline-flex items-center gap-2 bg-[#9a1312] hover:bg-[#b91a19] text-white text-xs uppercase tracking-wider font-semibold py-2.5 px-5 rounded-xl shadow-md transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                    <span>Cetak Dokumen Resmi</span>
                </a>
            </div>
        </form>
    </div>

    <!-- Dynamic Content based on Report Type -->
    @if($reportType === 'revenue')
        <!-- Revenue Stat Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <div class="p-5 rounded-2xl bg-[#191A1F] border border-[#303137]">
                <span class="text-xs uppercase tracking-wider text-[#92939A]">Total Pendapatan Lunas</span>
                <div class="font-mono text-xl font-bold text-emerald-400 mt-1">Rp {{ number_format($data['totalPaid'] ?? 0, 0, ',', '.') }}</div>
            </div>
            <div class="p-5 rounded-2xl bg-[#191A1F] border border-[#303137]">
                <span class="text-xs uppercase tracking-wider text-[#92939A]">Pendapatan Jasa Servis</span>
                <div class="font-mono text-xl font-bold text-[#F4F2EF] mt-1">Rp {{ number_format($data['totalServiceCost'] ?? 0, 0, ',', '.') }}</div>
            </div>
            <div class="p-5 rounded-2xl bg-[#191A1F] border border-[#303137]">
                <span class="text-xs uppercase tracking-wider text-[#92939A]">Pendapatan Suku Cadang</span>
                <div class="font-mono text-xl font-bold text-[#F4F2EF] mt-1">Rp {{ number_format($data['totalSparepartCost'] ?? 0, 0, ',', '.') }}</div>
            </div>
            <div class="p-5 rounded-2xl bg-[#191A1F] border border-[#303137]">
                <span class="text-xs uppercase tracking-wider text-[#92939A]">Piutang / Pending</span>
                <div class="font-mono text-xl font-bold text-amber-400 mt-1">Rp {{ number_format($data['totalPending'] ?? 0, 0, ',', '.') }}</div>
            </div>
        </div>

        <!-- Revenue Table -->
        <div class="bg-[#191A1F] border border-[#303137] rounded-2xl overflow-hidden shadow-xl">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm text-[#92939A]">
                    <thead class="text-xs uppercase tracking-wider bg-[#111216] text-[#92939A] border-b border-[#303137]">
                        <tr>
                            <th class="px-6 py-4">No. Invoice</th>
                            <th class="px-6 py-4">ID Servis</th>
                            <th class="px-6 py-4">Pelanggan</th>
                            <th class="px-6 py-4">Unit Motor</th>
                            <th class="px-6 py-4 text-right">Jasa</th>
                            <th class="px-6 py-4 text-right">Part</th>
                            <th class="px-6 py-4 text-right">Total Tagihan</th>
                            <th class="px-6 py-4 text-center">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#303137]/60">
                        @forelse($data['records'] as $r)
                            <tr class="hover:bg-[#222329]/50 transition-colors">
                                <td class="px-6 py-4 font-mono text-xs font-bold text-[#b91a19]">{{ $r->payment_id }}</td>
                                <td class="px-6 py-4 font-mono text-xs text-[#F4F2EF]">{{ $r->serviceRegistration->service_id ?? '-' }}</td>
                                <td class="px-6 py-4 text-xs text-[#F4F2EF]">{{ $r->serviceRegistration->customer->name ?? '-' }}</td>
                                <td class="px-6 py-4 text-xs font-mono font-bold text-[#F4F2EF]">{{ $r->serviceRegistration->vehicle->plate_number ?? '-' }}</td>
                                <td class="px-6 py-4 text-right font-mono text-xs">Rp {{ number_format($r->service_cost, 0, ',', '.') }}</td>
                                <td class="px-6 py-4 text-right font-mono text-xs">Rp {{ number_format($r->sparepart_cost, 0, ',', '.') }}</td>
                                <td class="px-6 py-4 text-right font-mono font-bold text-xs text-[#F4F2EF]">Rp {{ number_format($r->total_amount, 0, ',', '.') }}</td>
                                <td class="px-6 py-4 text-center">
                                    @if($r->status === 'paid')
                                        <span class="inline-flex px-2 py-0.5 rounded text-[11px] font-semibold bg-emerald-500/10 text-emerald-400">Lunas</span>
                                    @else
                                        <span class="inline-flex px-2 py-0.5 rounded text-[11px] font-semibold bg-amber-500/10 text-amber-400">Pending</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="8" class="px-6 py-8 text-center text-xs text-[#92939A]">Tidak ada data pembayaran dalam rentang tanggal ini.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    @elseif($reportType === 'services')
        <!-- Services Stat Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4">
            <div class="p-5 rounded-2xl bg-[#191A1F] border border-[#303137]">
                <span class="text-xs uppercase tracking-wider text-[#92939A]">Total Servis</span>
                <div class="font-mono text-xl font-bold text-[#F4F2EF] mt-1">{{ $data['totalServices'] ?? 0 }} Unit</div>
            </div>
            <div class="p-5 rounded-2xl bg-[#191A1F] border border-[#303137]">
                <span class="text-xs uppercase tracking-wider text-[#92939A]">Selesai</span>
                <div class="font-mono text-xl font-bold text-emerald-400 mt-1">{{ $data['completedCount'] ?? 0 }} Unit</div>
            </div>
            <div class="p-5 rounded-2xl bg-[#191A1F] border border-[#303137]">
                <span class="text-xs uppercase tracking-wider text-[#92939A]">Pengerjaan</span>
                <div class="font-mono text-xl font-bold text-blue-400 mt-1">{{ $data['inProgressCount'] ?? 0 }} Unit</div>
            </div>
            <div class="p-5 rounded-2xl bg-[#191A1F] border border-[#303137]">
                <span class="text-xs uppercase tracking-wider text-[#92939A]">Menunggu</span>
                <div class="font-mono text-xl font-bold text-amber-400 mt-1">{{ $data['waitingCount'] ?? 0 }} Unit</div>
            </div>
            <div class="p-5 rounded-2xl bg-[#191A1F] border border-[#303137]">
                <span class="text-xs uppercase tracking-wider text-[#92939A]">Dibatalkan</span>
                <div class="font-mono text-xl font-bold text-rose-400 mt-1">{{ $data['cancelledCount'] ?? 0 }} Unit</div>
            </div>
        </div>

        <!-- Services Table -->
        <div class="bg-[#191A1F] border border-[#303137] rounded-2xl overflow-hidden shadow-xl">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm text-[#92939A]">
                    <thead class="text-xs uppercase tracking-wider bg-[#111216] text-[#92939A] border-b border-[#303137]">
                        <tr>
                            <th class="px-6 py-4">ID Servis</th>
                            <th class="px-6 py-4">Tanggal</th>
                            <th class="px-6 py-4">Plat Motor</th>
                            <th class="px-6 py-4">Pelanggan</th>
                            <th class="px-6 py-4">Mekanik</th>
                            <th class="px-6 py-4 text-center">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#303137]/60">
                        @forelse($data['records'] as $s)
                            <tr class="hover:bg-[#222329]/50 transition-colors">
                                <td class="px-6 py-4 font-mono text-xs font-bold text-[#b91a19]">{{ $s->service_id }}</td>
                                <td class="px-6 py-4 font-mono text-xs text-[#F4F2EF]">{{ \Carbon\Carbon::parse($s->service_date)->format('d/m/Y') }}</td>
                                <td class="px-6 py-4 font-mono font-bold text-xs text-[#F4F2EF]">{{ $s->vehicle->plate_number ?? '-' }}</td>
                                <td class="px-6 py-4 text-xs text-[#F4F2EF]">{{ $s->customer->name ?? '-' }}</td>
                                <td class="px-6 py-4 text-xs">{{ $s->serviceDetail->mechanic->name ?? 'Belum Ditugaskan' }}</td>
                                <td class="px-6 py-4 text-center">
                                    <span class="inline-flex px-2 py-0.5 rounded text-[11px] font-semibold {{ $s->status === 'completed' ? 'bg-emerald-500/10 text-emerald-400' : 'bg-blue-500/10 text-blue-400' }}">
                                        {{ ucfirst($s->status) }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="6" class="px-6 py-8 text-center text-xs text-[#92939A]">Tidak ada data servis pada periode ini.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    @elseif($reportType === 'spareparts')
        <!-- Spareparts Stat Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div class="p-5 rounded-2xl bg-[#191A1F] border border-[#303137]">
                <span class="text-xs uppercase tracking-wider text-[#92939A]">Total Part Terpakai</span>
                <div class="font-mono text-xl font-bold text-[#F4F2EF] mt-1">{{ $data['totalQuantity'] ?? 0 }} Unit Item</div>
            </div>
            <div class="p-5 rounded-2xl bg-[#191A1F] border border-[#303137]">
                <span class="text-xs uppercase tracking-wider text-[#92939A]">Total Nilai Penggunaan Suku Cadang</span>
                <div class="font-mono text-xl font-bold text-[#b91a19] mt-1">Rp {{ number_format($data['totalValue'] ?? 0, 0, ',', '.') }}</div>
            </div>
        </div>

        <!-- Spareparts Table -->
        <div class="bg-[#191A1F] border border-[#303137] rounded-2xl overflow-hidden shadow-xl">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm text-[#92939A]">
                    <thead class="text-xs uppercase tracking-wider bg-[#111216] text-[#92939A] border-b border-[#303137]">
                        <tr>
                            <th class="px-6 py-4">Tanggal</th>
                            <th class="px-6 py-4">Nama Suku Cadang</th>
                            <th class="px-6 py-4">No. Polisi Motor</th>
                            <th class="px-6 py-4 text-center">Qty</th>
                            <th class="px-6 py-4 text-right">Harga Satuan</th>
                            <th class="px-6 py-4 text-right">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#303137]/60">
                        @forelse($data['records'] as $item)
                            <tr class="hover:bg-[#222329]/50 transition-colors">
                                <td class="px-6 py-4 font-mono text-xs text-[#92939A]">{{ $item->created_at->format('d/m/Y') }}</td>
                                <td class="px-6 py-4 text-xs font-semibold text-[#F4F2EF]">{{ $item->sparepart->name ?? '-' }}</td>
                                <td class="px-6 py-4 font-mono font-bold text-xs text-[#F4F2EF]">{{ $item->serviceDetail->serviceRegistration->vehicle->plate_number ?? '-' }}</td>
                                <td class="px-6 py-4 text-center font-mono text-xs text-[#F4F2EF]">{{ $item->quantity }}</td>
                                <td class="px-6 py-4 text-right font-mono text-xs">Rp {{ number_format($item->unit_price, 0, ',', '.') }}</td>
                                <td class="px-6 py-4 text-right font-mono font-bold text-xs text-[#F4F2EF]">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="6" class="px-6 py-8 text-center text-xs text-[#92939A]">Tidak ada data pemakaian suku cadang pada periode ini.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    @elseif($reportType === 'customers')
        <div class="p-5 rounded-2xl bg-[#191A1F] border border-[#303137]">
            <span class="text-xs uppercase tracking-wider text-[#92939A]">Pelanggan Terdaftar Baru</span>
            <div class="font-mono text-xl font-bold text-[#F4F2EF] mt-1">{{ $data['totalCustomers'] ?? 0 }} Orang</div>
        </div>

        <div class="bg-[#191A1F] border border-[#303137] rounded-2xl overflow-hidden shadow-xl">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm text-[#92939A]">
                    <thead class="text-xs uppercase tracking-wider bg-[#111216] text-[#92939A] border-b border-[#303137]">
                        <tr>
                            <th class="px-6 py-4">ID Pelanggan</th>
                            <th class="px-6 py-4">Nama Lengkap</th>
                            <th class="px-6 py-4">Nomor HP</th>
                            <th class="px-6 py-4">Pekerjaan</th>
                            <th class="px-6 py-4 text-center">Jumlah Motor</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#303137]/60">
                        @forelse($data['records'] as $c)
                            <tr class="hover:bg-[#222329]/50 transition-colors">
                                <td class="px-6 py-4 font-mono text-xs font-bold text-[#b91a19]">{{ $c->customer_id }}</td>
                                <td class="px-6 py-4 font-medium text-xs text-[#F4F2EF]">{{ $c->name }}</td>
                                <td class="px-6 py-4 font-mono text-xs text-[#F4F2EF]">{{ $c->phone }}</td>
                                <td class="px-6 py-4 text-xs">{{ $c->occupation }}</td>
                                <td class="px-6 py-4 text-center font-mono text-xs text-[#F4F2EF]">{{ $c->vehicles_count }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="5" class="px-6 py-8 text-center text-xs text-[#92939A]">Tidak ada data pendaftaran pelanggan baru pada periode ini.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    @elseif($reportType === 'vehicles')
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            <div class="p-5 rounded-2xl bg-[#191A1F] border border-[#303137]">
                <span class="text-xs uppercase tracking-wider text-[#92939A]">Total Unit Motor Masuk</span>
                <div class="font-mono text-xl font-bold text-[#F4F2EF] mt-1">{{ $data['totalVehicles'] ?? 0 }} Unit</div>
            </div>
            <div class="p-5 rounded-2xl bg-[#191A1F] border border-[#303137]">
                <span class="text-xs uppercase tracking-wider text-[#92939A]">Tipe Matic</span>
                <div class="font-mono text-xl font-bold text-[#F4F2EF] mt-1">{{ $data['maticCount'] ?? 0 }} Unit</div>
            </div>
            <div class="p-5 rounded-2xl bg-[#191A1F] border border-[#303137]">
                <span class="text-xs uppercase tracking-wider text-[#92939A]">Tipe Manual / Sport</span>
                <div class="font-mono text-xl font-bold text-[#F4F2EF] mt-1">{{ $data['manualCount'] ?? 0 }} Unit</div>
            </div>
        </div>

        <div class="bg-[#191A1F] border border-[#303137] rounded-2xl overflow-hidden shadow-xl">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm text-[#92939A]">
                    <thead class="text-xs uppercase tracking-wider bg-[#111216] text-[#92939A] border-b border-[#303137]">
                        <tr>
                            <th class="px-6 py-4">No. Polisi</th>
                            <th class="px-6 py-4">Merek & Model</th>
                            <th class="px-6 py-4">Pemilik</th>
                            <th class="px-6 py-4">Tipe</th>
                            <th class="px-6 py-4 text-center">Frekuensi Servis</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#303137]/60">
                        @forelse($data['records'] as $v)
                            <tr class="hover:bg-[#222329]/50 transition-colors">
                                <td class="px-6 py-4 font-mono text-xs font-bold text-[#F4F2EF]">{{ $v->plate_number }}</td>
                                <td class="px-6 py-4 text-xs font-medium text-[#F4F2EF]">{{ $v->brand }} {{ $v->model }}</td>
                                <td class="px-6 py-4 text-xs text-[#92939A]">{{ $v->customer->name ?? '-' }}</td>
                                <td class="px-6 py-4 text-xs uppercase">{{ $v->type }}</td>
                                <td class="px-6 py-4 text-center font-mono text-xs font-bold text-[#b91a19]">{{ $v->service_registrations_count }}x</td>
                            </tr>
                        @empty
                            <tr><td colspan="5" class="px-6 py-8 text-center text-xs text-[#92939A]">Tidak ada data sepeda motor pada periode ini.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    @endif

</div>
@endsection
