@extends('admin.sidebar')

@section('title', 'Pemesanan | House of Legacy')

@push('styles')
    <style>
        /* Tombol Cetak */
        .btn-cetak {
            background-color: transparent;
            color: #994D1C;
            border: 1.5px solid #6B240D;
            padding: 8px 20px;
            border-radius: 10px;
            font-weight: 600;
            font-size: 0.95rem;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            text-decoration: none;
        }
        .btn-cetak:hover {
            background-color: #6B240D;
            color: #ffffff;
            transform: translateY(-2px);
        }

        .pemesanan-title {
            color: #612713;
            font-weight: 700;
            font-size: 2rem;
            margin-bottom: 24px;
        }

        .pemesanan-section {
            padding: 80px 0;
            background-color: var(--bg-clr);
            min-height: 80vh;
        }

        .pemesanan-container {
            max-width: 1200px;
            margin: 0 auto;
        }

        .pemesanan-card {
            background-color: #ffffff;
            border-radius: 16px;
            margin-bottom: 24px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
            border: 1px solid rgba(107, 36, 13, 0.08);
            transition: transform 0.2s ease, box-shadow 0.2s ease;
            overflow: hidden;
        }

        .pemesanan-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(107, 36, 13, 0.12);
        }

        /* --- Bagian Gambar (Kiri) --- */
        .pemesanan-img-wrapper {
            height: 180px;
            min-height: 180px;
        }

        .pemesanan-img-wrapper img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        /* --- Bagian Konten Teks (Kanan) --- */
        .pemesanan-content {
            padding: 15px 20px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            height: 100%;
        }

        /* Header: No Pesanan & Status */
        .pemesanan-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            border-bottom: 1px dashed rgba(107, 36, 13, 0.15);
            padding-bottom: 8px;
            margin-bottom: 8px;
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

        .status-dibatalkan {
            background-color: #f8d7da;
            color: #881622ff;
        }

        /* Body: Detail Ruangan */
        .pemesanan-body h4 {
            color: var(--primary-clr);
            font-weight: 700;
            font-size: 1.25rem;
            margin-bottom: 5px;
        }

        .pemesanan-body p {
            color: #666;
            margin-bottom: 4px;
            font-size: 0.9rem;
        }

        .pemesanan-detail {
            display: flex;
            justify-content: right;
            align-items: right;
        }

        /* Footer: Total & Tombol */
        .pemesanan-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 5px;
            padding-top: 5px;
        }

        .total-price {
            font-weight: 700;
            font-size: 1.25rem;
            color: #612713;
        }

        .btn-detail {
            background-color: white;
            color: var(--primary-clr);
            border: 2px solid var(--primary-clr);
            padding: 8px 24px;
            border-radius: 10px;
            font-weight: 600;
            font-size: 0.95rem;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .btn-detail:hover {
            background-color: var(--primary-clr);
            color: white;
        }

        /* Toolbar Tabs & Search */
        .toolbar-pemesanan {
            display: flex;
            justify-content: space-between;
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
            background-color: #612713;
            color: white;
            box-shadow: 0 4px 10px rgba(107, 36, 13, 0.2);
        }

        .tab-link:hover:not(.active) {
            background-color: #fcf8f5;
            color: #612713;
            border-color: #f0e6e1;
        }

        .search-box {
            position: relative;
            width: 100%;
            max-width: 180px;
        }

        .search-box input {
            width: 100%;
            padding: 10px 15px 10px 40px;
            border-radius: 10px;
            border: 1.5px solid #e0e0e0;
            font-size: 0.95rem;
            outline: none;
            transition: border-color 0.3s ease;
        }

        .search-box input:focus {
            border-color: #6B240D;
        }

        .search-box i {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #a0a0a0;
            font-size: 1rem;
        }

        /* Responsivitas untuk layar kecil (HP) */
        @media (max-width: 768px) {
            .pemesanan-header {
                flex-direction: column-reverse;
            }

            .status-badge {
                margin-bottom: 5px;
            }

            .pemesanan-content {
                padding: 20px;
            }

            .toolbar-pemesanan {
                flex-direction: column;
                align-items: stretch;
            }

            .search-box {
                max-width: 100%;
            }

            .tabs-container {
                display: flex;
                flex-wrap: nowrap;
                overflow-x: auto;
                -webkit-overflow-scrolling: touch;
                padding-bottom: 5px;
                width: 100%;
                /* Hide scrollbar for clean look */
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
    <h1 class="pemesanan-title">Pemesanan</h1>

    <div class="pemesanan-container">

        <div class="toolbar-pemesanan">
            <div class="tabs-container">
                <a href="{{ route('pemesanan', ['tab' => 'semua', 'search' => request('search')]) }}"
                    class="tab-link {{ $activeTab == 'semua' ? 'active' : '' }}">Semua</a>
                <a href="{{ route('pemesanan', ['tab' => 'menunggu', 'search' => request('search')]) }}"
                    class="tab-link {{ $activeTab == 'menunggu' ? 'active' : '' }}">Menunggu</a>
                <a href="{{ route('pemesanan', ['tab' => 'disetujui', 'search' => request('search')]) }}"
                    class="tab-link {{ $activeTab == 'disetujui' ? 'active' : '' }}">Disetujui</a>
                <a href="{{ route('pemesanan', ['tab' => 'selesai', 'search' => request('search')]) }}"
                    class="tab-link {{ $activeTab == 'selesai' ? 'active' : '' }}">Selesai</a>
                <a href="{{ route('pemesanan', ['tab' => 'dibatalkan', 'search' => request('search')]) }}"
                    class="tab-link {{ $activeTab == 'dibatalkan' ? 'active' : '' }}">Dibatalkan / Ditolak</a>
            </div>

            <div class="d-flex justify-content-end gap-3">
                <button class="btn-cetak" data-bs-toggle="modal" data-bs-target="#modalCetakLaporan">
                    <i class="fa-solid fa-file-pdf"></i> Laporan Pemesanan
                </button>
                <form action="{{ route('pemesanan') }}" method="GET" class="search-box">
                    <input type="hidden" name="tab" value="{{ $activeTab }}">
                    <i class="fa-solid fa-magnifying-glass"></i>
                    <input type="text" name="search" placeholder="Cari..." value="{{ request('search') }}">
                </form>
            </div>
        </div>

        @if(count($pemesanans) > 0)

            @foreach($pemesanans as $item)
                @php
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

                    $roomName = $item->ruangan ? $item->ruangan->nama_ruangan : 'Pemesanan Fasilitas';

                    if (stripos($roomName, 'Vyria') !== false) {
                        $imageSrc = asset('images/WhatsApp Image 2024-05-13 at 01.06.29.jpg');
                    } elseif (stripos($roomName, 'Mahacitta') !== false) {
                        $imageSrc = asset('images/WhatsApp Image 2024-05-08 at 2.19.54 PM(1).jpg');
                    } elseif (stripos($roomName, 'Villasita') !== false) {
                        $imageSrc = asset('images/WhatsApp Image 2024-05-13 at 01.06.30 (1).jpg');
                    } else {
                        $imageSrc = asset('images/gambarLogo.png');
                    }

                    $tglPesan = \Carbon\Carbon::parse($item->tgl_pesan)->translatedFormat('d F Y');
                    $tglMulai = \Carbon\Carbon::parse($item->tgl_mulai)->translatedFormat('d F Y, H:i');
                    $tglSelesai = \Carbon\Carbon::parse($item->tgl_selesai)->translatedFormat('d F Y, H:i');
                    $tglAcara = ($tglMulai == $tglSelesai) ? $tglMulai : $tglMulai . ' - ' . $tglSelesai;
                @endphp
                <div class="pemesanan-card">
                    <div class="row g-0">

                        <div class="col-md-4 col-lg-3 col-12">
                            <div class="pemesanan-img-wrapper" style="background-color: #f8f9fa;">
                                <img src="{{ $imageSrc }}" alt="{{ $roomName }}"
                                    style="object-fit: cover; width:100%; height:100%; min-height: 120px;"
                                    onerror="this.src='{{ asset('images/gambarLogo.png') }}'">
                            </div>
                        </div>

                        <div class="col-md-8 col-lg-9 col-12">
                            <div class="pemesanan-content">

                                <div>
                                    <div class="pemesanan-header">
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

                                    <div class="pemesanan-body">
                                        <h4>{{ $roomName }}</h4>
                                        <div class="d-flex flex-column flex-md-row justify-content-md-between align-items-start align-items-md-end mt-2">
                                            <div class="detail-info">
                                                <p class="mb-1"><i class="fas fa-calendar-alt me-2"
                                                        style="color: var(--primary-clr); width: 20px;"></i> Tanggal:
                                                    <strong>{{ $tglAcara }}</strong>
                                                </p>
                                                <p class="mb-0"><i class="fas fa-user me-2"
                                                        style="color: var(--primary-clr); width: 20px;"></i> Pemesan:
                                                    <strong>{{ $item->nama_pemesan }} ({{ $item->telp_pemesan }})</strong>
                                                </p>
                                            </div>
                                            <div class="pemesanan-detail mt-3 mt-md-0 align-self-end align-self-md-auto">
                                                <button type="button" class="btn-detail" data-bs-toggle="modal" data-bs-target="#modalDetail{{ $item->id_pemesanan }}">Lihat Detail</button>
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

                                    @if($item->bukti_pemesanan)
                                    <div class="col-md-6 mb-3">
                                        <label class="text-muted small">Bukti Pemesanan</label>
                                        <p class="fw-bold mb-0">
                                            <a href="{{ asset('uploads/bukti/' . $item->bukti_pemesanan) }}" target="_blank" class="text-decoration-none text-primary">
                                                <i class="fas fa-image me-1"></i> Lihat Bukti
                                            </a>
                                        </p>
                                    </div>
                                    @endif

                                    @if($item->keterangan_pemesanan)
                                    <div class="col-md-12 mb-3">
                                        <label class="text-muted small">Catatan</label>
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
                                    <form action="{{ route('pemesanan.status', $item->id_pemesanan) }}" method="POST" class="d-inline form-tolak">
                                        @csrf
                                        <input type="hidden" name="action" value="tolak">
                                        <button type="submit" class="btn btn-outline-primary-custom">Tolak</button>
                                    </form>
                                    <form action="{{ route('pemesanan.status', $item->id_pemesanan) }}" method="POST" class="d-inline form-setujui">
                                        @csrf
                                        <input type="hidden" name="action" value="setuju">
                                        <button type="submit" class="btn btn-primary-custom">Setujui</button>
                                    </form>
                                @elseif(strtolower($item->status_pemesanan) == 'disetujui')
                                    <form action="{{ route('pemesanan.status', $item->id_pemesanan) }}" method="POST" class="d-inline form-batal-admin">
                                        @csrf
                                        <input type="hidden" name="action" value="batal">
                                        <button type="submit" class="btn btn-outline-danger" style="border-radius: 10px; padding: 8px 20px; font-weight: 600; font-size: 0.95rem;">Batal</button>
                                    </form>
                                    <button type="button" class="btn btn-outline-primary-custom" data-bs-toggle="modal" data-bs-target="#modalEdit{{ $item->id_pemesanan }}" 
                                        data-bs-dismiss="modal">Ubah Detail</button>
                                    <form action="{{ route('pemesanan.status', $item->id_pemesanan) }}" method="POST" class="d-inline form-selesai">
                                        @csrf
                                        <input type="hidden" name="action" value="selesai">
                                        <button type="submit" class="btn btn-primary-custom">Selesaikan Pesanan</button>
                                    </form>
                                @elseif(strtolower($item->status_pemesanan) == 'selesai')
                                    <button type="button" class="btn btn-outline-primary-custom" data-bs-toggle="modal" data-bs-target="#modalEdit{{ $item->id_pemesanan }}" 
                                        data-bs-dismiss="modal">Ubah Detail</button>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal Edit -->
                <div class="modal fade" id="modalEdit{{ $item->id_pemesanan }}" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-xl modal-dialog-centered">
                        <div class="modal-content" style="border-radius: 16px; border: none; overflow: hidden;">
                            <div class="modal-header text-white" style="background-color: #612713; border: none; padding: 20px;">
                                <h5 class="modal-title w-100 text-center fw-bold" style="font-size: 1.5rem;">Ubah Detail Pemesanan</h5>
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <form action="{{ route('pemesanan.edit', $item->id_pemesanan) }}" method="POST" class="form-edit" enctype="multipart/form-data">
                                @csrf
                                @php
                                    $isFailed = session('failed_booking_id') == $item->id_pemesanan;
                                @endphp
                                <div class="modal-body p-4" style="background-color: #ffffff;">
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <label class="form-label text-muted small">Nama Pemesan <span class="text-danger">*</span></label>
                                            <input type="text" name="nama_pemesan" class="form-control" value="{{ $isFailed ? old('nama_pemesan', $item->nama_pemesan) : $item->nama_pemesan }}" required>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label text-muted small">Nomor Telepon <span class="text-danger">*</span></label>
                                            <input type="tel" name="telp_pemesan" class="form-control" value="{{ $isFailed ? old('telp_pemesan', $item->telp_pemesan) : $item->telp_pemesan }}" required>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label text-muted small">Email Aktif <span class="text-danger">*</span></label>
                                            <input type="email" name="email_pemesan" class="form-control" value="{{ $isFailed ? old('email_pemesan', $item->email_pemesan) : $item->email_pemesan }}" required>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label text-muted small">Alamat Lengkap <span class="text-danger">*</span></label>
                                            <input type="text" name="alamat_pemesan" class="form-control" value="{{ $isFailed ? old('alamat_pemesan', $item->alamat_pemesan) : $item->alamat_pemesan }}" required>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label text-muted small">Instansi - Acara <span class="text-danger">*</span></label>
                                            <input type="text" name="nama_acara" class="form-control" value="{{ $isFailed ? old('nama_acara', $item->nama_acara) : $item->nama_acara }}" required>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label text-muted small">Bukti Pemesanan</label>
                                            <input type="file" name="bukti_pemesanan" class="form-control" accept="image/*">
                                            @if($item->bukti_pemesanan)
                                                <small class="text-muted d-block mt-1">Saat ini: <a href="{{ asset('uploads/bukti/' . $item->bukti_pemesanan) }}" target="_blank">Lihat Bukti</a></small>
                                            @endif
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label text-muted small">Jumlah Orang <span class="text-danger">*</span></label>
                                            <input type="number" name="jumlah_orang" class="form-control" value="{{ $isFailed ? old('jumlah_orang', $item->jumlah_orang) : $item->jumlah_orang }}" required>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label text-muted small">Pilih Ruangan <span class="text-danger">*</span></label>
                                            <select name="id_ruangan" class="form-select select-ruangan-admin" style="cursor: pointer;" required>
                                                <option value="" selected disabled>Pilih opsi...</option>
                                                @foreach($ruangans as $ruangan)
                                                    <option value="{{ $ruangan->id_ruangan }}" data-nama="{{ $ruangan->nama_ruangan }}" {{ ($isFailed ? old('id_ruangan', $item->id_ruangan) : $item->id_ruangan) == $ruangan->id_ruangan ? 'selected' : '' }}>
                                                        {{ $ruangan->nama_ruangan }} - {{ $ruangan->kapasitas_ruangan }} orang
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label text-muted small">Waktu Mulai <span class="text-danger">*</span></label>
                                            <input type="datetime-local" name="tgl_mulai" class="form-control" value="{{ $isFailed ? old('tgl_mulai', date('Y-m-d\TH:i', strtotime($item->tgl_mulai))) : date('Y-m-d\TH:i', strtotime($item->tgl_mulai)) }}" required>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label text-muted small">Waktu Selesai <span class="text-danger">*</span></label>
                                            <input type="datetime-local" name="tgl_selesai" class="form-control" value="{{ $isFailed ? old('tgl_selesai', date('Y-m-d\TH:i', strtotime($item->tgl_selesai))) : date('Y-m-d\TH:i', strtotime($item->tgl_selesai)) }}" required>
                                        </div>
                                        <div class="col-12 mt-4">
                                            <label class="form-label text-muted fw-bold mb-3">Fasilitas Tambahan</label>
                                            <div class="row g-4">
                                                @php
                                                    $itemFasilitas = $item->detailF ? $item->detailF->pluck('jumlah_fasilitas', 'id_fasilitas')->toArray() : [];
                                                @endphp
                                                @foreach($fasilitases as $jenis => $fasItems)
                                                    <div class="col-md-4 col-sm-6 group-facility-admin-container" id="group-facility-admin-{{ Str::slug($jenis) }}-{{ $item->id_pemesanan }}" data-jenis="{{ Str::slug($jenis) }}">
                                                        <div class="facility-group">
                                                            <h6 class="text-primary mb-2" style="color: #612713 !important;"><strong>{{ $jenis }}</strong></h6>
                                                            <div class="child-facilities ms-2 border-start ps-2 mt-1">
                                                                @foreach($fasItems as $fas)
                                                                    @php
                                                                        $isChecked = $isFailed ? (is_array(old('fasilitas')) && in_array($fas->id_fasilitas, old('fasilitas'))) : array_key_exists($fas->id_fasilitas, $itemFasilitas);
                                                                        $qty = $isFailed ? old('qty_fasilitas.' . $fas->id_fasilitas, (array_key_exists($fas->id_fasilitas, $itemFasilitas) ? $itemFasilitas[$fas->id_fasilitas] : 1)) : (array_key_exists($fas->id_fasilitas, $itemFasilitas) ? $itemFasilitas[$fas->id_fasilitas] : 1);
                                                                    @endphp
                                                                    <div class="form-check mb-2 d-flex align-items-center facility-item-row-admin" data-nama-fasilitas="{{ $fas->nama_fasilitas }}">
                                                                        <div>
                                                                            <input class="form-check-input child-checkbox-admin" name="fasilitas[]" type="checkbox" value="{{ $fas->id_fasilitas }}" id="item_{{ $fas->id_fasilitas }}_{{ $item->id_pemesanan }}" {{ $isChecked ? 'checked' : '' }}>
                                                                            <label class="form-check-label text-muted" style="font-size: 0.85rem;" for="item_{{ $fas->id_fasilitas }}_{{ $item->id_pemesanan }}">{{ $fas->nama_fasilitas }}</label>
                                                                        </div>
                                                                        @if($fas->jumlah_fasilitas > 1)
                                                                            <input type="number" name="qty_fasilitas[{{ $fas->id_fasilitas }}]" class="form-control form-control-sm ms-auto qty-input-field" style="width: 70px; padding: 0.2rem 0.5rem; font-size: 0.8rem;" min="1" max="{{ $fas->jumlah_fasilitas }}" placeholder="Jml" value="{{ $qty }}">
                                                                        @endif
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <label class="form-label text-muted small">Catatan</label>
                                            <textarea name="keterangan_pemesanan" class="form-control" rows="3" style="resize: none;">{{ $isFailed ? old('keterangan_pemesanan', $item->keterangan_pemesanan) : $item->keterangan_pemesanan }}</textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer" style="background-color: #fcf8f5; border-top: 1px solid #f0e6e1;">
                                    <button type="submit" class="btn btn-primary-custom">Simpan Perubahan</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                @if($isFailed)
                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        var myModal = new bootstrap.Modal(document.getElementById('modalEdit{{ $item->id_pemesanan }}'));
                        myModal.show();
                    });
                </script>
                @endif

            @endforeach

        @else
            <div class="d-flex flex-column align-items-center justify-content-center">
                <i class="fa-solid fa-inbox mt-3 mb-3" style="font-size: 3rem; color: #d0d0d0;"></i>
                <h5 class="fw-bold" style="color: #a0a0a0;">Belum Ada Data Pemesanan</h5>
            </div>
        @endif

    </div>

    <!-- MODAL CETAK LAPORAN PEMESANAN -->
    <div class="modal fade" id="modalCetakLaporan" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content" style="border-radius: 16px; border: none; overflow: hidden;">
                <div class="modal-header text-white" style="background-color: #612713; border: none; padding: 20px;">
                    <h5 class="modal-title w-100 text-center fw-bold" style="font-size: 1.5rem;">Cetak Laporan Pemesanan</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                
                <form action="{{ route('pemesanan.laporan') }}" method="POST" target="_blank">
                    @csrf
                    <div class="modal-body p-4" style="background-color: #ffffff;">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Bulan<span style="color: red;">*</span></label>
                                <select name="bulan" class="form-select custom-input" required>
                                    <option value="" selected disabled>Pilih Bulan</option>
                                    <option value="01">Januari</option>
                                    <option value="02">Februari</option>
                                    <option value="03">Maret</option>
                                    <option value="04">April</option>
                                    <option value="05">Mei</option>
                                    <option value="06">Juni</option>
                                    <option value="07">Juli</option>
                                    <option value="08">Agustus</option>
                                    <option value="09">September</option>
                                    <option value="10">Oktober</option>
                                    <option value="11">November</option>
                                    <option value="12">Desember</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Tahun<span style="color: red;">*</span></label>
                                <select name="tahun" class="form-select custom-input" required>
                                    <option value="" selected disabled>Pilih Tahun</option>
                                    @for($i = date('Y'); $i >= date('Y') - 5; $i--)
                                        <option value="{{ $i }}">{{ $i }}</option>
                                    @endfor
                                </select>
                            </div>
                            <div class="col-12 text-center text-muted mt-3">
                                <small>Laporan akan merekap semua data pemesanan yang telah <b>Disetujui</b>, <b>Ditolak</b>, <b>Dibatalkan</b>, atau <b>Selesai</b> pada periode yang dipilih.</small>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer border-0 p-4 pt-0">
                        <button type="submit" class="btn w-100 text-white fw-bold py-2" style="background-color: #612713; border-radius: 10px; font-size: 1.1rem;">
                            <i class="fa-solid fa-print"></i> CETAK LAPORAN
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.form-tolak').forEach(function(form) {
            form.addEventListener('submit', function (e) {
                e.preventDefault();

                Swal.fire({
                    title: 'Konfirmasi',
                    text: 'Apakah Anda yakin ingin menolak pemesanan?',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: 'Yakin',
                    cancelButtonText: 'Kembali',
                    reverseButtons: true,
                    confirmButtonColor: '#6B240D',
                    cancelButtonColor: '#6c757d'
                }).then((result) => {
                    if (result.isConfirmed) {
                        Swal.fire({
                            title: 'Menyimpan...',
                            text: 'Mohon tunggu sebentar',
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

        document.querySelectorAll('.form-setujui').forEach(function(form) {
            form.addEventListener('submit', function (e) {
                e.preventDefault();

                Swal.fire({
                    title: 'Konfirmasi',
                    text: 'Apakah Anda yakin ingin menyetujui pemesanan?',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: 'Yakin',
                    cancelButtonText: 'Kembali',
                    reverseButtons: true,
                    confirmButtonColor: '#6B240D',
                    cancelButtonColor: '#6c757d'
                }).then((result) => {
                    if (result.isConfirmed) {
                        Swal.fire({
                            title: 'Menyimpan...',
                            text: 'Mohon tunggu sebentar',
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

        document.querySelectorAll('.form-selesai').forEach(function(form) {
            form.addEventListener('submit', function (e) {
                e.preventDefault();

                Swal.fire({
                    title: 'Konfirmasi',
                    text: 'Apakah Anda yakin ingin menyelesaikan pemesanan?',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: 'Yakin',
                    cancelButtonText: 'Kembali',
                    reverseButtons: true,
                    confirmButtonColor: '#6B240D',
                    cancelButtonColor: '#6c757d'
                }).then((result) => {
                    if (result.isConfirmed) {
                        Swal.fire({
                            title: 'Menyimpan...',
                            text: 'Mohon tunggu sebentar',
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

        document.querySelectorAll('.form-batal-admin').forEach(function(form) {
            form.addEventListener('submit', function (e) {
                e.preventDefault();

                Swal.fire({
                    title: 'Konfirmasi',
                    text: 'Apakah Anda yakin ingin membatalkan pemesanan?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Batalkan',
                    cancelButtonText: 'Kembali',
                    reverseButtons: true,
                    confirmButtonColor: '#dc3545',
                    cancelButtonColor: '#6c757d'
                }).then((result) => {
                    if (result.isConfirmed) {
                        Swal.fire({
                            title: 'Menyimpan...',
                            text: 'Mohon tunggu sebentar',
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

        document.querySelectorAll('.form-edit').forEach(function(form) {
            form.addEventListener('submit', function (e) {
                e.preventDefault();

                Swal.fire({
                    title: 'Konfirmasi',
                    text: 'Apakah Anda yakin ingin mengubah detail pemesanan?',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: 'Yakin',
                    cancelButtonText: 'Kembali',
                    reverseButtons: true,
                    confirmButtonColor: '#6B240D',
                    cancelButtonColor: '#6c757d'
                }).then((result) => {
                    if (result.isConfirmed) {
                        Swal.fire({
                            title: 'Menyimpan...',
                            text: 'Mohon tunggu sebentar',
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

        // Filter room facilities in admin edit modals
        function updateRoomFacilitiesAdmin(form) {
            const selectRoom = form.querySelector('.select-ruangan-admin');
            if (!selectRoom) return;

            const selectedOption = selectRoom.options[selectRoom.selectedIndex];
            const selectedRoomName = selectedOption ? (selectedOption.getAttribute('data-nama') || '').toLowerCase() : '';

            const groupContainer = form.querySelector('.group-facility-admin-container[data-jenis="ruangan"]');
            if (!groupContainer) return;

            const itemRows = groupContainer.querySelectorAll('.facility-item-row-admin');
            
            let visibleCount = 0;

            itemRows.forEach(row => {
                const facilityName = (row.getAttribute('data-nama-fasilitas') || '').toLowerCase();
                let shouldShow = true;

                if (selectedRoomName.includes('vyria')) {
                    if (facilityName.includes('vyria') || facilityName.includes('mahacitta')) {
                        shouldShow = false;
                    }
                } else if (selectedRoomName.includes('vilasita') || selectedRoomName.includes('villasita')) {
                    if (facilityName.includes('vilasita') || facilityName.includes('villasita') || facilityName.includes('mahacitta')) {
                        shouldShow = false;
                    }
                } else if (selectedRoomName.includes('mahacitta')) {
                    if (facilityName.includes('mahacitta')) {
                        shouldShow = false;
                    }
                } else {
                    shouldShow = false;
                }

                if (shouldShow) {
                    row.style.setProperty('display', 'flex', 'important');
                    visibleCount++;
                } else {
                    row.style.setProperty('display', 'none', 'important');
                    const checkbox = row.querySelector('.child-checkbox-admin, input[type="checkbox"]');
                    if (checkbox && checkbox.checked) {
                        checkbox.checked = false;
                    }
                    const qtyField = row.querySelector('.qty-input-field');
                    if (qtyField) {
                        qtyField.value = 1;
                    }
                }
            });

            if (visibleCount > 0) {
                groupContainer.style.setProperty('display', 'block', 'important');
            } else {
                groupContainer.style.setProperty('display', 'none', 'important');
            }
        }

        document.querySelectorAll('.form-edit').forEach(function(form) {
            const selectRoom = form.querySelector('.select-ruangan-admin');
            if (selectRoom) {
                selectRoom.addEventListener('change', function() {
                    updateRoomFacilitiesAdmin(form);
                });
                updateRoomFacilitiesAdmin(form);
            }
        });
    });
</script>

@endsection