<!DOCTYPE html>
<html>
<head>
    <title>Notifikasi Admin - {{ $action === 'baru' ? 'Pesanan Baru' : 'Pesanan Dibatalkan' }}</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333;">
    <div style="max-width: 600px; margin: 0 auto; padding: 20px; border: 1px solid #ddd; border-radius: 5px;">
        <h2 style="color: {{ $action === 'baru' ? '#4CAF50' : '#F44336' }};">
            {{ $action === 'baru' ? 'Pesanan Baru Masuk' : 'Pesanan Dibatalkan' }}
        </h2>
        
        <p>Halo Admin,</p>
        
        <p>Sistem menerima pembaruan terkait pemesanan dengan detail berikut:</p>
        
        <table style="width: 100%; border-collapse: collapse; margin-bottom: 20px;">
            <tr>
                <td style="padding: 8px; border: 1px solid #ddd; font-weight: bold; width: 35%;">No Nota</td>
                <td style="padding: 8px; border: 1px solid #ddd;">{{ $pemesanan->no_nota }}</td>
            </tr>
            <tr>
                <td style="padding: 8px; border: 1px solid #ddd; font-weight: bold;">Nama Pemesan</td>
                <td style="padding: 8px; border: 1px solid #ddd;">{{ $pemesanan->nama_pemesan }}</td>
            </tr>
            <tr>
                <td style="padding: 8px; border: 1px solid #ddd; font-weight: bold;">Nama Acara</td>
                <td style="padding: 8px; border: 1px solid #ddd;">{{ $pemesanan->nama_acara }}</td>
            </tr>
            <tr>
                <td style="padding: 8px; border: 1px solid #ddd; font-weight: bold;">Tanggal Mulai</td>
                <td style="padding: 8px; border: 1px solid #ddd;">{{ \Carbon\Carbon::parse($pemesanan->tgl_mulai)->format('d M Y') }}</td>
            </tr>
            <tr>
                <td style="padding: 8px; border: 1px solid #ddd; font-weight: bold;">Tanggal Selesai</td>
                <td style="padding: 8px; border: 1px solid #ddd;">{{ \Carbon\Carbon::parse($pemesanan->tgl_selesai)->format('d M Y') }}</td>
            </tr>
        </table>
        
        @if($action === 'baru')
            <p>Silakan login ke sistem untuk melakukan peninjauan dan mengubah status pemesanan.</p>
        @else
            <p>Pemesanan ini telah dibatalkan oleh pemesan.</p>
        @endif
        
        <br>
        <p>Terima kasih,</p>
        <p>Sistem Informasi House of Legacy</p>
    </div>
</body>
</html>
