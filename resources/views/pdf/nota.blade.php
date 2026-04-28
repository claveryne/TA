<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Nota Pemesanan {{ $pemesanan->no_nota }}</title>
    <style>
        body { font-family: sans-serif; font-size: 14px; color: #333; }
        .header { text-align: center; border-bottom: 2px solid #612713; padding-bottom: 10px; margin-bottom: 20px; }
        .header h1 { margin: 0; color: #612713; font-size: 24px; }
        .header p { margin: 5px 0 0; color: #666; font-size: 12px; }
        .info-table { width: 100%; margin-bottom: 20px; border-collapse: collapse; }
        .info-table th, .info-table td { text-align: left; padding: 5px; vertical-align: top; }
        .info-table th { width: 20%; color: #612713; }
        .details-table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        .details-table th, .details-table td { border: 1px solid #ddd; padding: 10px; text-align: left; }
        .details-table th { background-color: #fcf8f5; color: #612713; }
        .footer { text-align: center; margin-top: 50px; font-size: 12px; color: #888; border-top: 1px solid #ddd; padding-top: 10px; }
        .status-badge { display: inline-block; padding: 4px 10px; border-radius: 4px; font-weight: bold; font-size: 12px; }
        .status-disetujui { background: #d4edda; color: #155724; }
        .status-selesai { background: #cce5ff; color: #004085; }
    </style>
</head>
<body>
    <div class="header">
        <h1>HOUSE OF LEGACY</h1>
        <p>Bukti Pemesanan Ruangan & Fasilitas</p>
    </div>

    @php
        $statusClass = 'status-disetujui';
        if (strtolower($pemesanan->status_pemesanan) == 'selesai') $statusClass = 'status-selesai';
    @endphp

    <table class="info-table">
        <tr>
            <th>No Nota</th>
            <td>: <strong>{{ $pemesanan->no_nota }}</strong></td>
            <th>Status</th>
            <td>: <span class="status-badge {{ $statusClass }}">{{ strtoupper($pemesanan->status_pemesanan) }}</span></td>
        </tr>
        <tr>
            <th>Tanggal Pesan</th>
            <td>: {{ \Carbon\Carbon::parse($pemesanan->tgl_pesan)->translatedFormat('d F Y') }}</td>
            <th>Nama Pemesan</th>
            <td>: {{ $pemesanan->nama_pemesan }}</td>
        </tr>
        <tr>
            <th>Kontak</th>
            <td>: {{ $pemesanan->telp_pemesan }} <br> &nbsp; {{ $pemesanan->email_pemesan }}</td>
            <th>Alamat</th>
            <td>: {{ $pemesanan->alamat_pemesan }}</td>
        </tr>
    </table>

    <table class="details-table">
        <thead>
            <tr>
                <th style="width: 30%;">Keterangan</th>
                <th>Detail</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><strong>Instansi / Acara</strong></td>
                <td>{{ $pemesanan->nama_acara }}</td>
            </tr>
            <tr>
                <td><strong>Waktu Acara</strong></td>
                <td>
                    {{ \Carbon\Carbon::parse($pemesanan->tgl_mulai)->translatedFormat('d F Y, H:i') }}
                    @if($pemesanan->tgl_mulai != $pemesanan->tgl_selesai)
                        - {{ \Carbon\Carbon::parse($pemesanan->tgl_selesai)->translatedFormat('d F Y, H:i') }}
                    @endif
                </td>
            </tr>
            <tr>
                <td><strong>Jumlah Peserta</strong></td>
                <td>{{ $pemesanan->jumlah_orang }} Orang</td>
            </tr>
            <tr>
                <td><strong>Ruangan</strong></td>
                <td>{{ $pemesanan->ruangan ? $pemesanan->ruangan->nama_ruangan : '-' }}</td>
            </tr>
            <tr>
                <td><strong>Fasilitas Tambahan</strong></td>
                <td>
                    @if($pemesanan->detailF && count($pemesanan->detailF) > 0)
                        <ul style="margin: 0; padding-left: 20px;">
                            @foreach($pemesanan->detailF as $detail)
                                <li>{{ $detail->fasilitas->nama_fasilitas }} (Qty: {{ $detail->jumlah_fasilitas }})</li>
                            @endforeach
                        </ul>
                    @else
                        -
                    @endif
                </td>
            </tr>
            @if($pemesanan->keterangan_pemesanan)
            <tr>
                <td><strong>Keterangan Khusus</strong></td>
                <td>{{ $pemesanan->keterangan_pemesanan }}</td>
            </tr>
            @endif
        </tbody>
    </table>

    <div class="footer">
        Dicetak pada: {{ now()->translatedFormat('d F Y H:i:s') }} <br>
        Ini adalah bukti pemesanan yang sah dari sistem House of Legacy.<br>
        Unduh nota ini sebagai referensi untuk keperluan konfirmasi di kemudian hari.
    </div>
</body>
</html>
