<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Pemeliharaan</title>
    <style>
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            font-size: 12px;
            color: #333;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 2px solid #612713;
            padding-bottom: 10px;
        }
        .header h1 {
            color: #612713;
            font-size: 20px;
            margin: 0;
            text-transform: uppercase;
            font-weight: bold;
        }
        .header p {
            margin: 5px 0;
            font-size: 14px;
        }
        .info-table {
            width: 100%;
            margin-bottom: 20px;
        }
        .info-table td {
            vertical-align: top;
        }
        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }
        .data-table th, .data-table td {
            border: 1px solid #ddd;
            padding: 8px 10px;
            text-align: left;
        }
        .data-table th {
            background-color: #612713;
            color: #ffffff;
            font-weight: bold;
        }
        .data-table tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .total-row td {
            font-weight: bold;
            background-color: #f0e6e1 !important;
            color: #612713;
        }
        .text-center {
            text-align: center !important;
        }
        .text-right {
            text-align: right !important;
        }
        .footer {
            margin-top: 50px;
            text-align: right;
            padding-right: 20px;
        }
        .footer p {
            margin-bottom: 60px;
        }
    </style>
</head>
<body>

    <div class="header">
        <h1>LAPORAN PENGELUARAN PEMELIHARAAN</h1>
        <p>House of Legacy</p>
    </div>

    <table class="info-table">
        <tr>
            <td width="15%"><strong>Periode</strong></td>
            <td width="3%">:</td>
            <td>{{ $bulanStr }} {{ $tahun }}</td>
        </tr>
        <tr>
            <td><strong>Tanggal Cetak</strong></td>
            <td>:</td>
            <td>{{ date('d-m-Y H:i:s') }}</td>
        </tr>
    </table>

    <table class="data-table">
        <thead>
            <tr>
                <th class="text-center" width="5%">No</th>
                <th class="text-center" width="25%">Nama Pemeliharaan</th>
                <th class="text-center" width="10%">Jumlah</th>
                <th class="text-center" width="20%">Jenis Pemeliharaan</th>
                <th class="text-center" width="20%">Tanggal Mulai</th>
                <th class="text-center" width="20%">Tanggal Selesai</th>
                <th class="text-center" width="15%">Status</th>
                <th class="text-right" width="25%">Biaya (Rp)</th>
            </tr>
        </thead>
        <tbody>
            @forelse($pemeliharaan as $index => $item)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td class="text-center">{{ $item->nama_pemeliharaan }}</td>
                    <td class="text-center">{{ $item->jumlah_pemeliharaan ?? '-' }}</td>
                    <td class="text-center">{{ $item->jenis_pemeliharaan }}</td>
                    <td class="text-center">{{ \Carbon\Carbon::parse($item->tglMulai_pemeliharaan)->translatedFormat('d F Y') }}</td>
                    <td class="text-center">{{ \Carbon\Carbon::parse($item->tglSelesai_pemeliharaan)->translatedFormat('d F Y') }}</td>
                    <td class="text-center">{{ $item->status_pemeliharaan }}</td>
                    <td class="text-right">{{ number_format($item->biaya_pemeliharaan, 0, ',', '.') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" class="text-center">Tidak ada data pemeliharaan untuk periode ini.</td>
                </tr>
            @endforelse
            
            @if($pemeliharaan->count() > 0)
                <tr class="total-row">
                    <td colspan="7" class="text-right">TOTAL BIAYA:</td>
                    <td class="text-right">{{ number_format($totalBiaya, 0, ',', '.') }}</td>
                </tr>
            @endif
        </tbody>
    </table>

    <div class="footer">
        <p>Mengetahui,</p>
        <p><strong>Administrator</strong></p>
    </div>

</body>
</html>
