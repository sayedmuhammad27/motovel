<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nota Pembayaran: {{ $payment->payment_id }} | MOTOVEL</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;600;700&family=Cinzel+Decorative:wght@700&display=swap" rel="stylesheet">
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }
        body {
            font-family: 'Cinzel', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background-color: #f4f4f5;
            color: #18181b;
            padding: 24px;
            font-size: 13px;
            line-height: 1.5;
        }
        .invoice-box {
            max-width: 800px;
            margin: auto;
            background: #ffffff;
            padding: 40px;
            border-radius: 8px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }
        .header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            padding-bottom: 24px;
            border-bottom: 2px solid #e4e4e7;
            margin-bottom: 24px;
        }
        .brand {
            font-family: 'Cinzel Decorative', serif;
            font-size: 24px;
            font-weight: 700;
            color: #09090b;
            letter-spacing: 0.5px;
        }
        .brand span {
            color: #c62828;
        }
        .tagline {
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #71717a;
            margin-top: 4px;
        }
        .meta-invoice {
            text-align: right;
        }
        .meta-invoice .inv-title {
            font-size: 20px;
            font-weight: 700;
            color: #c62828;
            font-family: monospace;
        }
        .meta-invoice .inv-date {
            font-size: 12px;
            color: #71717a;
            margin-top: 4px;
        }
        .grid-2 {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 24px;
            margin-bottom: 24px;
        }
        .info-card {
            background: #fbfbfb;
            border: 1px solid #e4e4e7;
            border-radius: 6px;
            padding: 16px;
        }
        .info-card h4 {
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: #71717a;
            margin-bottom: 8px;
        }
        .info-card p {
            font-size: 12px;
            color: #27272a;
            margin-bottom: 4px;
        }
        .info-card p strong {
            color: #09090b;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 24px;
        }
        th {
            background-color: #f4f4f5;
            color: #3f3f46;
            text-align: left;
            padding: 10px 14px;
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border-top: 1px solid #e4e4e7;
            border-bottom: 1px solid #e4e4e7;
        }
        td {
            padding: 12px 14px;
            border-bottom: 1px solid #f4f4f5;
            font-size: 12px;
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
        .total-row td {
            font-weight: 600;
            color: #09090b;
            border-top: 1px solid #e4e4e7;
            border-bottom: none;
            padding-top: 10px;
            padding-bottom: 10px;
        }
        .grand-total td {
            font-size: 15px;
            font-weight: 700;
            color: #c62828;
            background: #fef2f2;
            border-top: 2px solid #c62828;
            border-bottom: 2px solid #c62828;
            padding-top: 14px;
            padding-bottom: 14px;
        }
        .badge {
            display: inline-block;
            padding: 3px 8px;
            border-radius: 4px;
            font-size: 11px;
            font-weight: 600;
            text-transform: uppercase;
        }
        .badge-paid {
            background: #ecfdf5;
            color: #047857;
            border: 1px solid #a7f3d0;
        }
        .badge-pending {
            background: #fffbeb;
            color: #b45309;
            border: 1px solid #fde68a;
        }
        .signatures {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 40px;
            margin-top: 40px;
            padding-top: 24px;
            border-top: 1px dashed #d4d4d8;
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
            min-width: 180px;
            padding-top: 4px;
        }
        .sig-role {
            font-size: 11px;
            color: #71717a;
            margin-top: 2px;
        }
        .no-print-bar {
            max-width: 800px;
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
            .invoice-box {
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
        <a href="{{ route('admin.payments.show', $payment->id) }}" class="btn-back">← Kembali ke Sistem</a>
        <button onclick="window.print()" class="btn-print">Cetak Nota Sekarang</button>
    </div>

    <div class="invoice-box">
        <!-- Header -->
        <div class="header">
            <div>
                <div class="brand" style="display: flex; align-items: center; gap: 10px;">
                    <img src="{{ asset('images/logo-badge.png') }}" alt="MOTOVEL" style="width: 38px; height: 38px; border-radius: 8px;">
                    <span>MOTO<span>VEL</span></span>
                </div>
                <div class="tagline">Precision Care. Performance You Can Trust.</div>
                <div style="font-size: 11px; color: #71717a; margin-top: 6px;">
                    Jl. Veteran Otomotif No. 88, Workshop Center, Indonesia<br>
                    Telp: (021) 7788-9900 | WhatsApp: +62 812-9988-7766
                </div>
            </div>
            <div class="meta-invoice">
                <div class="inv-title">{{ $payment->payment_id }}</div>
                <div class="inv-date">Tanggal: {{ \Carbon\Carbon::parse($payment->payment_date ?: $payment->created_at)->translatedFormat('d F Y') }}</div>
                <div style="margin-top: 8px;">
                    @if($payment->status === 'paid')
                        <span class="badge badge-paid">LUNAS / PAID</span>
                    @else
                        <span class="badge badge-pending">PENDING</span>
                    @endif
                </div>
            </div>
        </div>

        <!-- Meta Grid -->
        <div class="grid-2">
            <div class="info-card">
                <h4>Informasi Pelanggan</h4>
                <p><strong>Nama:</strong> {{ $payment->serviceRegistration->customer->name ?? '-' }}</p>
                <p><strong>No. HP / WA:</strong> <span class="mono">{{ $payment->serviceRegistration->customer->phone ?? '-' }}</span></p>
                <p><strong>Alamat:</strong> {{ $payment->serviceRegistration->customer->address ?? '-' }}</p>
            </div>
            <div class="info-card">
                <h4>Sepeda Motor & Servis</h4>
                <p><strong>No. Polisi:</strong> <span class="mono"><strong>{{ $payment->serviceRegistration->vehicle->plate_number ?? '-' }}</strong></span></p>
                <p><strong>Unit Motor:</strong> {{ $payment->serviceRegistration->vehicle->brand ?? '' }} {{ $payment->serviceRegistration->vehicle->model ?? '' }} ({{ $payment->serviceRegistration->vehicle->year ?? '' }})</p>
                <p><strong>Kode Servis:</strong> <span class="mono">{{ $payment->serviceRegistration->service_id ?? '-' }}</span></p>
                <p><strong>Mekanik:</strong> {{ $payment->serviceRegistration->serviceDetail->mechanic->name ?? 'Tim Mekanik MOTOVEL' }}</p>
            </div>
        </div>

        <!-- Line Items -->
        <table>
            <thead>
                <tr>
                    <th>Deskripsi Layanan / Suku Cadang</th>
                    <th class="text-center" style="width: 80px;">Qty</th>
                    <th class="text-right" style="width: 130px;">Harga Satuan</th>
                    <th class="text-right" style="width: 140px;">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                <!-- Jasa Servis -->
                <tr>
                    <td>
                        <strong>Biaya Jasa Servis & Perawatan Berkala</strong>
                        <div style="font-size: 11px; color: #71717a;">Pemeriksaan sistem kelistrikan, pelumasan, dan setting performa</div>
                    </td>
                    <td class="text-center mono">1</td>
                    <td class="text-right mono">Rp {{ number_format($payment->service_cost, 0, ',', '.') }}</td>
                    <td class="text-right mono">Rp {{ number_format($payment->service_cost, 0, ',', '.') }}</td>
                </tr>

                <!-- Spareparts -->
                @if($payment->serviceRegistration->serviceDetail && $payment->serviceRegistration->serviceDetail->serviceSpareparts->isNotEmpty())
                    @foreach($payment->serviceRegistration->serviceDetail->serviceSpareparts as $part)
                        <tr>
                            <td>
                                <strong>{{ $part->sparepart->name ?? 'Suku Cadang' }}</strong>
                                <div style="font-size: 11px; color: #71717a;">Kategori: {{ $part->sparepart->category ?? '-' }}</div>
                            </td>
                            <td class="text-center mono">{{ $part->quantity }}</td>
                            <td class="text-right mono">Rp {{ number_format($part->unit_price, 0, ',', '.') }}</td>
                            <td class="text-right mono">Rp {{ number_format($part->subtotal, 0, ',', '.') }}</td>
                        </tr>
                    @endforeach
                @endif

                <!-- Totals -->
                <tr class="total-row">
                    <td colspan="3" class="text-right">Subtotal Biaya Jasa Servis:</td>
                    <td class="text-right mono">Rp {{ number_format($payment->service_cost, 0, ',', '.') }}</td>
                </tr>
                <tr class="total-row">
                    <td colspan="3" class="text-right">Subtotal Suku Cadang / Material:</td>
                    <td class="text-right mono">Rp {{ number_format($payment->sparepart_cost, 0, ',', '.') }}</td>
                </tr>
                <tr class="grand-total">
                    <td colspan="3" class="text-right">TOTAL TAGIHAN:</td>
                    <td class="text-right mono">Rp {{ number_format($payment->total_amount, 0, ',', '.') }}</td>
                </tr>
            </tbody>
        </table>

        <!-- Catatan & Pembayaran -->
        <div style="font-size: 11px; color: #52525b; margin-bottom: 24px;">
            <p><strong>Metode Pembayaran:</strong> <span class="mono" style="text-transform: uppercase;">{{ $payment->payment_type }}</span></p>
            @if($payment->notes)
                <p style="margin-top: 4px;"><strong>Catatan:</strong> {{ $payment->notes }}</p>
            @endif
        </div>

        <!-- Signatures -->
        <div class="signatures">
            <div class="sig-block">
                <div class="sig-role">Pelanggan / Pemilik Motor</div>
                <div class="sig-space"></div>
                <div class="sig-name">{{ $payment->serviceRegistration->customer->name ?? '(..........................................)' }}</div>
            </div>
            <div class="sig-block">
                <div class="sig-role">Kasir / Bagian Operasional MOTOVEL</div>
                <div class="sig-space"></div>
                <div class="sig-name">MOTOVEL Service Staff</div>
            </div>
        </div>

        <!-- Print Footer Note -->
        <div style="text-align: center; font-size: 10px; color: #a1a1aa; margin-top: 40px;">
            Nota resmi ini dicetak secara otomatis melalui Sistem Informasi Servis MOTOVEL pada {{ date('d/m/Y H:i') }}. Garansi servis berlaku 7 hari setelah tanggal penyerahan unit motor.
        </div>
    </div>

</body>
</html>
