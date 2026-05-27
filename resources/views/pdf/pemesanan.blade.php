<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Pemesanan {{ $bulanNama }} {{ $tahun }}</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; color: #333; }
        .header { text-align: center; border-bottom: 2px solid #612713; padding-bottom: 10px; margin-bottom: 20px; }
        .header h1 { margin: 0; color: #612713; font-size: 20px; text-transform: uppercase; }
        .header p { margin: 5px 0 0; color: #666; font-size: 14px; }
        .section-title { font-size: 16px; color: #612713; margin-top: 20px; margin-bottom: 10px; font-weight: bold; }
        .data-table { width: 100%; border-collapse: collapse; margin-bottom: 10px; }
        .data-table th, .data-table td { border: 1px solid #ddd; padding: 8px; text-align: left; vertical-align: top; }
        .data-table th { background-color: #fcf8f5; color: #612713; font-weight: bold; text-align: center; }
        .data-table td.text-center { text-align: center; }
        .footer { text-align: center; margin-top: 30px; font-size: 10px; color: #888; border-top: 1px solid #ddd; padding-top: 10px; }
        .no-data { text-align: center; font-style: italic; color: #999; padding: 20px; border: 1px dashed #ddd; margin-bottom: 10px; }
        ul { margin: 0; padding-left: 15px; }
    </style>
</head>
<body>
    <div class="header">
        <h1>LAPORAN PEMESANAN RUANGAN & FASILITAS</h1>
        <p>Periode: {{ $bulanNama }} {{ $tahun }}</p>
    </div>

    @foreach(['Mahacitta' => $mahacitta, 'Vyria' => $vyria, 'Villasita' => $villasita] as $namaRuangan => $data)
    <div class="section-title">Rekap Pemesanan Ruangan {{ $namaRuangan }}</div>
    @if(count($data) > 0)
    <table class="data-table">
        <thead>
            <tr>
                <th style="width: 5%;">No</th>
                <th style="width: 15%;">No Nota</th>
                <th style="width: 20%;">Nama Pemesan</th>
                <th style="width: 20%;">Status</th>
                <th style="width: 25%;">Waktu Acara</th>
                <th style="width: 35%;">Fasilitas Tambahan</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $index => $item)
            <tr>
                <td class="text-center">{{ $loop->iteration }}</td>
                <td class="text-center">{{ $item->no_nota }}</td>
                <td>{{ $item->nama_pemesan }}</td>
                <td>{{ $item->status_pemesanan }}</td>
                <td>
                    {{ \Carbon\Carbon::parse($item->tgl_mulai)->translatedFormat('d M Y, H:i') }}<br>
                    s/d<br>
                    {{ \Carbon\Carbon::parse($item->tgl_selesai)->translatedFormat('d M Y, H:i') }}
                </td>
                <td>
                    @if($item->detailF && count($item->detailF) > 0)
                        <ul>
                            @foreach($item->detailF as $detail)
                                <li>{{ $detail->fasilitas->nama_fasilitas }} (Qty: {{ $detail->jumlah_fasilitas }})</li>
                            @endforeach
                        </ul>
                    @else
                        -
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <p style="font-weight: bold; text-align: right; margin-top: 0;">Total Pemesanan {{ $namaRuangan }}: {{ count($data) }}</p>
    @else
    <div class="no-data">Tidak ada pemesanan untuk ruangan {{ $namaRuangan }} pada bulan {{ $bulanNama }} {{ $tahun }}.</div>
    @endif
    @endforeach

    <div class="footer">
        Dicetak pada: {{ now()->translatedFormat('d F Y H:i:s') }} oleh Sistem Informasi House of Legacy
    </div>
</body>
</html>
