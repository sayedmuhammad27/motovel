<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Resmi {{ ucfirst($reportType) }} | MOTOVEL Service Center</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Playfair+Display:wght@700&display=swap" rel="stylesheet">
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background-color: #f4f4f5;
            color: #18181b;
            padding: 24px;
            font-size: 12px;
            line-height: 1.5;
        }
        .report-box {
            max-width: 960px;
            margin: auto;
            background: #ffffff;
            padding: 40px;
            border-radius: 8px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }
        .letterhead {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-bottom: 20px;
            border-bottom: 3px double #18181b;
            margin-bottom: 24px;
        }
        .brand {
            font-family: 'Playfair Display', serif;
            font-size: 26px;
            font-weight: 700;
            color: #09090b;
        }
        .brand span {
            color: #c62828;
        }
        .subtitle {
            font-size: 11px;
            color: #52525b;
            margin-top: 2px;
        }
        .report-title-section {
            text-align: center;
            margin-bottom: 24px;
        }
        .report-title {
            font-size: 16px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: #09090b;
        }
        .report-period {
            font-size: 12px;
            color: #71717a;
            margin-top: 4px;
        }
        .kpi-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
            gap: 16px;
            margin-bottom: 24px;
        }
        .kpi-card {
            background: #fbfbfb;
            border: 1px solid #e4e4e7;
            padding: 12px 16px;
            border-radius: 6px;
        }
        .kpi-label {
            font-size: 10px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: #71717a;
        }
        .kpi-value {
            font-size: 16px;
            font-weight: 700;
            color: #09090b;
            margin-top: 4px;
            font-family: monospace;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 24px;
        }
        th {
            background-color: #f4f4f5;
            color: #27272a;
            text-align: left;
            padding: 8px 10px;
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border-top: 1px solid #d4d4d8;
            border-bottom: 1px solid #d4d4d8;
        }
        td {
            padding: 8px 10px;
            border-bottom: 1px solid #f4f4f5;
            font-size: 11px;
            color: #27272a;
        }
        .text-right {
            text-align: right;
        }
        .text-center {
            text-align: center;
        }
        .mono {
            font-family: monospace;
        }
        .signatures {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 60px;
            margin-top: 48px;
            padding-top: 24px;
        }
        .sig-block {
            text-align: center;
        }
        .sig-space {
            height: 70px;
        }
        .sig-name {
            font-weight: 600;
            border-top: 1px solid #27272a;
            display: inline-block;
            min-width: 200px;
            padding-top: 4px;
        }
        .sig-role {
            font-size: 11px;
            color: #71717a;
            margin-top: 2px;
        }
        .no-print-bar {
            max-width: 960px;
            margin: 0 auto 20px auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .btn-print {
            background-color: #c62828;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 6px;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
        }
        .btn-back {
            color: #52525b;
            text-decoration: none;
            font-size: 13px;
            font-weight: 500;
        }
        @media print {
            body {
                background: #ffffff;
                padding: 0;
            }
            .report-box {
                box-shadow: none;
                padding: 0;
                max-width: 100%;
            }
            .no-print-bar {
                display: none !important;
            }
        }
    </style>
</head>
<body>

    <div class="no-print-bar">
        <a href="{{ route('admin.reports', ['type' => $reportType, 'start_date' => $startDate, 'end_date' => $endDate]) }}" class="btn-back">← Kembali ke Sistem Analitik</a>
        <button onclick="window.print()" class="btn-print">Cetak Laporan Resmi</button>
    </div>

    <div class="report-box">
        <!-- Letterhead -->
        <div class="letterhead">
            <div>
                <div class="brand">MOTO<span>VEL</span></div>
                <div class="subtitle"><strong>MOTOVEL PRECISION MOTORCYCLE WORKSHOP CENTER</strong></div>
                <div class="subtitle">Jl. Veteran Otomotif No. 88, Bengkel Sentra Otomotif Indonesia | Telp: (021) 7788-9900</div>
            </div>
            <div style="text-align: right; font-size: 11px; color: #71717a;">
                <div>Dokumen: <strong>LAP/{{ strtoupper($reportType) }}/{{ date('Ymd') }}</strong></div>
                <div>Dicetak: {{ date('d F Y, H:i') }} WIB</div>
            </div>
        </div>

        <!-- Title -->
        <div class="report-title-section">
            <h2 class="report-title">
                @if($reportType === 'revenue') Laporan Pendapatan & Rekapitulasi Kasir
                @elseif($reportType === 'services') Laporan Pelayanan & Pengerjaan Servis Motor
                @elseif($reportType === 'spareparts') Laporan Mutasi & Pemakaian Suku Cadang
                @elseif($reportType === 'customers') Laporan Pertumbuhan Pelanggan Baru
                @else Laporan Distribusi Sepeda Motor Pelanggan
                @endif
            </h2>
            <div class="report-period">
                Periode Data: <strong>{{ \Carbon\Carbon::parse($startDate)->translatedFormat('d F Y') }}</strong> s/d <strong>{{ \Carbon\Carbon::parse($endDate)->translatedFormat('d F Y') }}</strong>
            </div>
        </div>

        <!-- Dynamic Tables & KPIs -->
        @if($reportType === 'revenue')
            <div class="kpi-grid">
                <div class="kpi-card">
                    <div class="kpi-label">Total Pendapatan Lunas</div>
                    <div class="kpi-value" style="color: #047857;">Rp {{ number_format($data['totalPaid'] ?? 0, 0, ',', '.') }}</div>
                </div>
                <div class="kpi-card">
                    <div class="kpi-label">Jasa Servis (Lunas)</div>
                    <div class="kpi-value">Rp {{ number_format($data['totalServiceCost'] ?? 0, 0, ',', '.') }}</div>
                </div>
                <div class="kpi-card">
                    <div class="kpi-label">Suku Cadang (Lunas)</div>
                    <div class="kpi-value">Rp {{ number_format($data['totalSparepartCost'] ?? 0, 0, ',', '.') }}</div>
                </div>
                <div class="kpi-card">
                    <div class="kpi-label">Piutang / Pending</div>
                    <div class="kpi-value" style="color: #b45309;">Rp {{ number_format($data['totalPending'] ?? 0, 0, ',', '.') }}</div>
                </div>
            </div>

            <table>
                <thead>
                    <tr>
                        <th>No. Invoice</th>
                        <th>ID Servis</th>
                        <th>Pelanggan</th>
                        <th>No. Polisi</th>
                        <th class="text-right">Jasa</th>
                        <th class="text-right">Part</th>
                        <th class="text-right">Total Tagihan</th>
                        <th class="text-center">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($data['records'] as $r)
                        <tr>
                            <td class="mono"><strong>{{ $r->payment_id }}</strong></td>
                            <td class="mono">{{ $r->serviceRegistration->service_id ?? '-' }}</td>
                            <td>{{ $r->serviceRegistration->customer->name ?? '-' }}</td>
                            <td class="mono"><strong>{{ $r->serviceRegistration->vehicle->plate_number ?? '-' }}</strong></td>
                            <td class="text-right mono">Rp {{ number_format($r->service_cost, 0, ',', '.') }}</td>
                            <td class="text-right mono">Rp {{ number_format($r->sparepart_cost, 0, ',', '.') }}</td>
                            <td class="text-right mono"><strong>Rp {{ number_format($r->total_amount, 0, ',', '.') }}</strong></td>
                            <td class="text-center mono" style="text-transform: uppercase;">{{ $r->status }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

        @elseif($reportType === 'services')
            <div class="kpi-grid">
                <div class="kpi-card">
                    <div class="kpi-label">Total Unit Diservis</div>
                    <div class="kpi-value">{{ $data['totalServices'] ?? 0 }} Unit</div>
                </div>
                <div class="kpi-card">
                    <div class="kpi-label">Pengerjaan Selesai</div>
                    <div class="kpi-value" style="color: #047857;">{{ $data['completedCount'] ?? 0 }} Unit</div>
                </div>
                <div class="kpi-card">
                    <div class="kpi-label">Dalam Pengerjaan</div>
                    <div class="kpi-value" style="color: #1d4ed8;">{{ $data['inProgressCount'] ?? 0 }} Unit</div>
                </div>
                <div class="kpi-card">
                    <div class="kpi-label">Menunggu Antrean</div>
                    <div class="kpi-value" style="color: #b45309;">{{ $data['waitingCount'] ?? 0 }} Unit</div>
                </div>
            </div>

            <table>
                <thead>
                    <tr>
                        <th>ID Servis</th>
                        <th>Tanggal</th>
                        <th>No. Polisi</th>
                        <th>Pelanggan</th>
                        <th>Mekanik</th>
                        <th class="text-center">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($data['records'] as $s)
                        <tr>
                            <td class="mono"><strong>{{ $s->service_id }}</strong></td>
                            <td class="mono">{{ \Carbon\Carbon::parse($s->service_date)->format('d/m/Y') }}</td>
                            <td class="mono"><strong>{{ $s->vehicle->plate_number ?? '-' }}</strong></td>
                            <td>{{ $s->customer->name ?? '-' }}</td>
                            <td>{{ $s->serviceDetail->mechanic->name ?? 'Belum Ditugaskan' }}</td>
                            <td class="text-center mono" style="text-transform: uppercase;">{{ $s->status }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

        @elseif($reportType === 'spareparts')
            <div class="kpi-grid">
                <div class="kpi-card">
                    <div class="kpi-label">Total Kuantitas Terpakai</div>
                    <div class="kpi-value">{{ $data['totalQuantity'] ?? 0 }} Pcs</div>
                </div>
                <div class="kpi-card">
                    <div class="kpi-label">Total Nilai Pemakaian</div>
                    <div class="kpi-value" style="color: #c62828;">Rp {{ number_format($data['totalValue'] ?? 0, 0, ',', '.') }}</div>
                </div>
            </div>

            <table>
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>Nama Suku Cadang</th>
                        <th>No. Polisi Motor</th>
                        <th class="text-center">Qty</th>
                        <th class="text-right">Harga Satuan</th>
                        <th class="text-right">Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($data['records'] as $item)
                        <tr>
                            <td class="mono">{{ $item->created_at->format('d/m/Y') }}</td>
                            <td><strong>{{ $item->sparepart->name ?? '-' }}</strong></td>
                            <td class="mono">{{ $item->serviceDetail->serviceRegistration->vehicle->plate_number ?? '-' }}</td>
                            <td class="text-center mono">{{ $item->quantity }}</td>
                            <td class="text-right mono">Rp {{ number_format($item->unit_price, 0, ',', '.') }}</td>
                            <td class="text-right mono"><strong>Rp {{ number_format($item->subtotal, 0, ',', '.') }}</strong></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

        @elseif($reportType === 'customers')
            <table>
                <thead>
                    <tr>
                        <th>ID Pelanggan</th>
                        <th>Nama Pelanggan</th>
                        <th>Nomor HP</th>
                        <th>Pekerjaan</th>
                        <th class="text-center">Jumlah Motor</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($data['records'] as $c)
                        <tr>
                            <td class="mono"><strong>{{ $c->customer_id }}</strong></td>
                            <td>{{ $c->name }}</td>
                            <td class="mono">{{ $c->phone }}</td>
                            <td>{{ $c->occupation }}</td>
                            <td class="text-center mono">{{ $c->vehicles_count }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

        @else
            <table>
                <thead>
                    <tr>
                        <th>No. Polisi</th>
                        <th>Merek & Model</th>
                        <th>Pemilik</th>
                        <th>Tipe</th>
                        <th class="text-center">Frekuensi Servis</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($data['records'] as $v)
                        <tr>
                            <td class="mono"><strong>{{ $v->plate_number }}</strong></td>
                            <td>{{ $v->brand }} {{ $v->model }}</td>
                            <td>{{ $v->customer->name ?? '-' }}</td>
                            <td style="text-transform: uppercase;">{{ $v->type }}</td>
                            <td class="text-center mono">{{ $v->service_registrations_count }}x</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif

        <!-- Signatures Section -->
        <div class="signatures">
            <div class="sig-block">
                <div class="sig-role">Penanggung Jawab Operasional Bengkel</div>
                <div class="sig-space"></div>
                <div class="sig-name">MOTOVEL Workshop Manager</div>
            </div>
            <div class="sig-block">
                <div class="sig-role">Pimpinan / Pemilik Bengkel MOTOVEL</div>
                <div class="sig-space"></div>
                <div class="sig-name">Executive Director</div>
            </div>
        </div>

    </div>

</body>
</html>
