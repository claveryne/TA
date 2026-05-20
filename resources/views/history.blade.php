@extends('bar')

@section('title', 'Histori Pemesanan')

@push('styles')
<style>
    /* --- History Section --- */
    .history-section {
        padding: 80px 0;
        background-color: var(--bg-clr);
        min-height: 80vh; 
    }
    
    .history-container {
        margin: 0 auto;
    }

    .history-card {
        background-color: #ffffff;
        border-radius: 16px;
        margin-bottom: 24px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.05);
        border: 1px solid rgba(107, 36, 13, 0.08);
        transition: transform 0.2s ease, box-shadow 0.2s ease;
        overflow: hidden; 
    }
    .history-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 25px rgba(107, 36, 13, 0.12);
    }

    /* --- Bagian Gambar (Kiri) --- */
    .history-img-wrapper {
        height: 100%;
        min-height: 220px; 
    }
    .history-img-wrapper img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    /* --- Bagian Konten Teks (Kanan) --- */
    .history-content {
        padding: 24px 30px;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        height: 100%;
    }

    /* Header: No Pesanan & Status */
    .history-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        border-bottom: 1px dashed rgba(107, 36, 13, 0.15);
        padding-bottom: 15px;
        margin-bottom: 15px;
        flex-wrap: wrap; 
        gap: 10px;
    }
    .order-id {
        font-weight: 700;
        color: #612713;
        font-size: 1.15rem;
    }
    .order-date {
        font-size: 0.85rem;
        color: #888;
        display: block;
        margin-top: 4px;
    }

    /* Status Badges */
    .status-badge {
        padding: 6px 16px;
        border-radius: 20px;
        font-size: 0.85rem;
        font-weight: 600;
        white-space: nowrap;
    }
    .status-selesai { background-color: #d4edda; color: #155724; }
    .status-menunggu { background-color: #fff3cd; color: #856404; }
    .status-dibatalkan { background-color: #f8d7da; color: #721c24; }

    /* Body: Detail Ruangan */
    .history-body h4 {
        color: var(--color-primary);
        font-weight: 700;
        font-size: 1.35rem;
        margin-bottom: 10px;
    }
    .history-body p {
        color: #666;
        margin-bottom: 6px;
        font-size: 0.95rem;
    }

    /* Footer: Total & Tombol */
    .history-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: 20px;
        padding-top: 15px;
    }
    .total-price {
        font-weight: 700;
        font-size: 1.25rem;
        color: #612713;
    }
    
    .btn-detail {
        background-color: white;
        color: var(--color-primary);
        border: 2px solid var(--color-primary);
        padding: 8px 24px;
        border-radius: 10px;
        font-weight: 600;
        font-size: 0.95rem;
        text-decoration: none;
        transition: all 0.3s ease;
    }
    .btn-detail:hover {
        background-color: var(--color-primary);
        color: white;
    }

    /* Toolbar Tabs */
    .toolbar-history {
        display: flex;
        justify-content: flex-start;
        align-items: center;
        margin-bottom: 24px;
        flex-wrap: wrap;
        gap: 15px;
        background-color: #fff;
        padding: 15px 20px;
        border-radius: 12px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.02);
        border: 1px solid rgba(107, 36, 13, 0.08);
    }

    .tabs-container {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
    }

    .tab-link {
        text-decoration: none;
        color: #666;
        font-weight: 600;
        padding: 8px 16px;
        border-radius: 8px;
        transition: all 0.3s ease;
        font-size: 0.95rem;
        border: 1px solid transparent;
    }

    .tab-link.active {
        background-color: var(--color-primary, #612713);
        color: white;
        box-shadow: 0 4px 10px rgba(107, 36, 13, 0.2);
    }

    .tab-link:hover:not(.active) {
        background-color: #fcf8f5;
        color: var(--color-primary, #612713);
        border-color: #f0e6e1;
    }

    /* Status Badges */
    .status-badge {
        padding: 6px 16px;
        border-radius: 20px;
        font-size: 0.85rem;
        font-weight: 600;
        white-space: nowrap;
    }

    .status-disetujui {
        background-color: #d4edda;
        color: #155724;
    }

    .status-selesai {
        background-color: #d4dfedff;
        color: #153057ff;
    }

    .status-menunggu {
        background-color: #fff3cd;
        color: #856404;
    }

    .status-dibatalkan, .status-ditolak {
        background-color: #f8d7da;
        color: #881622ff;
    }

    /* Responsivitas untuk layar kecil (HP) */
    @media (max-width: 768px) {
        .history-header {
            flex-direction: column-reverse; 
        }
        .status-badge {
            margin-bottom: 5px;
        }
        .history-content {
            padding: 20px;
        }
        
        .tabs-container {
            flex-wrap: nowrap;
            overflow-x: auto;
            padding-bottom: 5px;
            width: 100%;
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
        .tabs-container::-webkit-scrollbar {
            display: none;
        }
    }
</style>
@endpush

@section('content')
<section class="history-section">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="section-title">Histori Pemesanan</h2>
            <p class="section-subtitle">Daftar riwayat penyewaan ruangan Anda di House of Legacy.</p>
        </div>

        <div class="toolbar-history">
            <div class="tabs-container">
                <a href="{{ route('history', ['tab' => 'semua']) }}"
                    class="tab-link {{ isset($activeTab) && $activeTab == 'semua' ? 'active' : '' }}">Semua</a>
                <a href="{{ route('history', ['tab' => 'menunggu']) }}"
                    class="tab-link {{ isset($activeTab) && $activeTab == 'menunggu' ? 'active' : '' }}">Menunggu</a>
                <a href="{{ route('history', ['tab' => 'disetujui']) }}"
                    class="tab-link {{ isset($activeTab) && $activeTab == 'disetujui' ? 'active' : '' }}">Disetujui</a>
                <a href="{{ route('history', ['tab' => 'selesai']) }}"
                    class="tab-link {{ isset($activeTab) && $activeTab == 'selesai' ? 'active' : '' }}">Selesai</a>
                <a href="{{ route('history', ['tab' => 'dibatalkan']) }}"
                    class="tab-link {{ isset($activeTab) && $activeTab == 'dibatalkan' ? 'active' : '' }}">Dibatalkan / Ditolak</a>
            </div>
        </div>

        <div class="history-container">
            @if(count($histories) > 0)
                
                @foreach($histories as $item)
                @php
                    // Mapping status to CSS class
                    $statusClass = 'status-menunggu';
                    $statusText = $item->status_pemesanan;
                    $statusLower = strtolower($statusText);

                    if ($statusLower === 'selesai') {
                        $statusClass = 'status-selesai';
                    } elseif ($statusLower === 'disetujui') {
                        $statusClass = 'status-disetujui';
                    } elseif ($statusLower === 'dibatalkan' || $statusLower === 'ditolak') {
                        $statusClass = 'status-dibatalkan';
                    } elseif ($statusLower === 'menunggu') {
                        $statusClass = 'status-menunggu';
                    }

                    // Image Source
                    $imageSrc = asset('images/gambarLogo.png');
                    if ($item->ruangan && $item->ruangan->foto_ruangan) {
                        $imageSrc = asset('uploads/ruangan/' . $item->ruangan->foto_ruangan);
                    }

                    // Room Name
                    $roomName = $item->ruangan ? $item->ruangan->nama_ruangan : 'Pemesanan Fasilitas';

                    // Dates
                    $tglPesan = \Carbon\Carbon::parse($item->tgl_pesan)->translatedFormat('d F Y');
                    $tglMulai = \Carbon\Carbon::parse($item->tgl_mulai)->translatedFormat('d F Y, H:i');
                    $tglSelesai = \Carbon\Carbon::parse($item->tgl_selesai)->translatedFormat('d F Y, H:i');
                    $tglAcara = ($tglMulai == $tglSelesai) ? $tglMulai : $tglMulai . ' - ' . $tglSelesai;
                @endphp
                <div class="history-card">
                    <div class="row g-0">
                        
                        <div class="col-md-4 col-lg-3 col-12">
                            <div class="history-img-wrapper" style="background-color: #f8f9fa;">
                                <img src="{{ $imageSrc }}" alt="{{ $roomName }}" onerror="this.src='{{ asset('images/gambarLogo.png') }}'">
                            </div>
                        </div>

                        <div class="col-md-8 col-lg-9 col-12">
                            <div class="history-content">
                                
                                <div>
                                    <div class="history-header">
                                        <div>
                                            <span class="order-id">{{ $item->no_nota }}</span>
                                            <span class="order-date">Dipesan pada: {{ $tglPesan }}</span>
                                        </div>
                                        <div>
                                            <span class="status-badge {{ $statusClass }}">
                                                {{ $statusText }}
                                            </span>
                                        </div>
                                    </div>

                                    <div class="history-body">
                                        <h4>{{ $roomName }}</h4>
                                        <div class="d-flex flex-column flex-md-row justify-content-md-between align-items-start align-items-md-end mt-2">
                                            <div class="detail-info">
                                                <p class="mb-1"><i class="fas fa-calendar-alt me-2" style="color: var(--color-primary); width: 20px;"></i> Tanggal: <strong>{{ $tglAcara }}</strong></p>
                                                <p class="mb-0"><i class="fas fa-info-circle me-2" style="color: var(--color-primary); width: 20px;"></i> Kegiatan: {{ $item->nama_acara }}</p>
                                            </div>
                                            <div class="mt-3 mt-md-0 align-self-end align-self-md-auto">
                                                <a href="#" class="btn-detail" data-bs-toggle="modal" data-bs-target="#modalDetail{{ $item->id_pemesanan }}">Lihat Detail</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                        
                    </div>
                </div>
                
                <!-- Modal Detail -->
                <div class="modal fade" id="modalDetail{{ $item->id_pemesanan }}" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-lg modal-dialog-centered">
                        <div class="modal-content" style="border-radius: 16px; border: none; overflow: hidden;">
                            <div class="modal-header text-white" style="background-color: #612713; border: none; padding: 20px;">
                                <h5 class="modal-title w-100 text-center fw-bold" style="font-size: 1.5rem;">Detail Pemesanan</h5>
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            
                            <div class="modal-body p-4" style="background-color: #ffffff;">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="text-muted small">No Pesanan</label>
                                        <p class="fw-bold mb-0">{{ $item->no_nota }}</p>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="text-muted small">Status</label>
                                        <p class="fw-bold mb-0"><span class="badge {{ $statusClass }}">{{ $statusText }}</span></p>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="text-muted small">Nama Pemesan</label>
                                        <p class="fw-bold mb-0">{{ $item->nama_pemesan }}</p>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="text-muted small">Kontak Pemesan</label>
                                        <p class="fw-bold mb-0">{{ $item->telp_pemesan }} | {{ $item->email_pemesan }}</p>
                                    </div>
                                    
                                    <div class="col-md-6 mb-3">
                                        <label class="text-muted small">Waktu Acara</label>
                                        <p class="fw-bold mb-0">{{ $tglAcara }}</p>
                                    </div>
                                    
                                    <div class="col-md-6 mb-3">
                                        <label class="text-muted small">Instansi - Acara</label>
                                        <p class="fw-bold mb-0">{{ $item->nama_acara }}</p>
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label class="text-muted small">Ruangan</label>
                                        <p class="fw-bold mb-0">{{ $roomName }}</p>
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label class="text-muted small">Jumlah Orang</label>
                                        <p class="fw-bold mb-0">{{ $item->jumlah_orang }}</p>
                                    </div>

                                    @if($item->keterangan_pemesanan)
                                    <div class="col-md-12 mb-3">
                                        <label class="text-muted small">Keterangan Khusus</label>
                                        <p class="fw-bold mb-0">{{ $item->keterangan_pemesanan }}</p>
                                    </div>
                                    @endif

                                    @if($item->detailF && count($item->detailF) > 0)
                                    <div class="col-md-12 mb-3">
                                        <label class="text-muted small">Fasilitas Tambahan</label>
                                        <ul class="mb-0 overflow-auto" style="max-height: 150px;">
                                            @foreach($item->detailF as $detail)
                                                <li>{{ $detail->fasilitas->nama_fasilitas ?? 'Fasilitas Tidak Diketahui' }} (Qty: {{ $detail->jumlah_fasilitas }})</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                    @endif
                                </div>
                            </div>

                            <div class="modal-footer" style="background-color: #fcf8f5; border-top: 1px solid #f0e6e1;">
                                @if(strtolower($item->status_pemesanan) == 'menunggu')
                                    <form action="{{ route('pemesanan.batal', $item->id_pemesanan) }}" method="POST" class="d-inline form-batal">
                                        @csrf
                                        <button type="submit" class="btn btn-danger">Batal</button>
                                    </form>
                                @elseif(strtolower($item->status_pemesanan) == 'disetujui' || strtolower($item->status_pemesanan) == 'selesai')
                                    <form action="{{ route('pemesanan.nota', $item->id_pemesanan) }}" method="POST" class="d-inline form-nota" target="_blank">
                                        @csrf
                                        <button type="submit" class="btn btn-success">Lihat Nota</button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach

            @else
                <div class="text-center" style="padding: 60px 20px; background: white; border-radius: 16px; border: 1px dashed #ccc;">
                    <h4 style="color: #612713; font-weight: bold;">Belum ada histori pemesanan</h4>
                    <p style="color: #666;">Anda belum pernah melakukan pemesanan ruangan. Yuk, mulai pesan sekarang!</p>
                    <a href="{{ url('/facility') }}" class="btn-detail mt-3" style="display: inline-block;">Lihat Fasilitas</a>
                </div>
            @endif

        </div>
    </div>
</section>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const batalForms = document.querySelectorAll('.form-batal');

        batalForms.forEach(form => {
            form.addEventListener('submit', function (e) {
                e.preventDefault();

                Swal.fire({
                    title: 'Konfirmasi',
                    text: 'Apakah Anda yakin ingin membatalkan pemesanan ini?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, Batalkan',
                    cancelButtonText: 'Tidak',
                    reverseButtons: true,
                    confirmButtonColor: '#881622ff',
                    cancelButtonColor: '#6c757d'
                }).then((result) => {
                    if (result.isConfirmed) {
                        Swal.fire({
                            title: 'Mohon tunggu...',
                            didOpen: () => Swal.showLoading(),
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            showConfirmButton: false
                        });
                        setTimeout(() => form.submit(), 300);
                    }
                });
            });
        });

        const notaForms = document.querySelectorAll('.form-nota');

        notaForms.forEach(form => {
            form.addEventListener('submit', function (e) {
                e.preventDefault();

                Swal.fire({
                    title: 'Buka Nota?',
                    text: 'Nota akan dibuka di tab baru sebagai preview.',
                    icon: 'info',
                    showCancelButton: true,
                    confirmButtonText: 'Lihat Nota',
                    cancelButtonText: 'Batal',
                    reverseButtons: true,
                    confirmButtonColor: '#155724',
                    cancelButtonColor: '#6c757d'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });
    });
</script>

@endsection