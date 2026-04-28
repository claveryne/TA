<!DOCTYPE html>
<html>
<head>
    <title>Update Status Pesanan Anda</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333;">
    <div style="max-width: 600px; margin: 0 auto; padding: 20px; border: 1px solid #ddd; border-radius: 5px;">
        <h2 style="color: {{ strtolower($status) === 'disetujui' ? '#4CAF50' : '#F44336' }};">
            Pemesanan Anda {{ ucfirst($status) }}
        </h2>
        
        <p>Halo {{ $pemesanan->nama_pemesan }},</p>
        
        <p>Kami memberitahukan bahwa pemesanan Anda dengan nomor nota <strong>{{ $pemesanan->no_nota }}</strong> telah <strong>{{ strtolower($status) }}</strong> oleh Admin.</p>
        
        <table style="width: 100%; border-collapse: collapse; margin-bottom: 20px;">
            <tr>
                <td style="padding: 8px; border: 1px solid #ddd; font-weight: bold; width: 35%;">No Nota</td>
                <td style="padding: 8px; border: 1px solid #ddd;">{{ $pemesanan->no_nota }}</td>
            </tr>
            <tr>
                <td style="padding: 8px; border: 1px solid #ddd; font-weight: bold;">Nama Acara</td>
                <td style="padding: 8px; border: 1px solid #ddd;">{{ $pemesanan->nama_acara }}</td>
            </tr>
            <tr>
                <td style="padding: 8px; border: 1px solid #ddd; font-weight: bold;">Waktu Mulai</td>
                <td style="padding: 8px; border: 1px solid #ddd;">{{ \Carbon\Carbon::parse($pemesanan->tgl_mulai)->format('d M Y, H:i') }}</td>
            </tr>
            <tr>
                <td style="padding: 8px; border: 1px solid #ddd; font-weight: bold;">Waktu Selesai</td>
                <td style="padding: 8px; border: 1px solid #ddd;">{{ \Carbon\Carbon::parse($pemesanan->tgl_selesai)->format('d M Y, H:i') }}</td>
            </tr>
        </table>
        
        @if(strtolower($status) === 'disetujui')
            <p>Terlampir invoice/nota pemesanan Anda. Harap simpan dokumen ini sebagai bukti pemesanan yang sah.</p>
        @elseif(strtolower($status) === 'ditolak')
            <p>Mohon maaf, pemesanan Anda tidak dapat kami proses saat ini. Silakan hubungi admin untuk informasi lebih lanjut.</p>
        @endif
        
        <br>
        <p>Terima kasih,</p>
        <p>Sistem Informasi House of Legacy</p><br>
        <small>Pesan dikirim secara otomatis. Mohon untuk tidak membalas pesan ini.</small>
    </div>
</body>
</html>
