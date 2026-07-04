@extends('admin.sidebar')

@section('title', 'Fasilitas | House of Legacy')

@push('styles')
    <style>
        /* --- Halaman Data Fasilitas --- */
        .fasilitas-title {
            color: #612713;
            font-weight: 700;
            font-size: 2rem;
            margin-bottom: 24px;
        }

        /* Card Wrapper */
        .data-card {
            background-color: #ffffff;
            border-radius: 16px;
            padding: 24px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
            border: 1px solid rgba(107, 36, 13, 0.05);
        }

        /* Toolbar (Atas Tabel) */
        .table-toolbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            flex-wrap: wrap;
            gap: 15px;
        }

        /* Tombol Tambah */
        .btn-tambah {
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

        .btn-tambah:hover {
            background-color: #6B240D;
            color: #ffffff;
            transform: translateY(-2px);
        }

        /* Filter */
        .filter-select {
            width: 200px;
            padding: 10px 40px 10px 15px;
            border-radius: 10px;
            border: 1.5px solid #e0e0e0;
            font-size: 0.95rem;
            outline: none;
            transition: border-color 0.3s ease;
            color: #333;
            appearance: none;
            -webkit-appearance: none;
            -moz-appearance: none;
            background-color: #fff;
            background-image: url("data:image/svg+xml;charset=UTF-8,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='%23333' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3e%3cpolyline points='6 9 12 15 18 9'%3e%3c/polyline%3e%3c/svg%3e");
            background-repeat: no-repeat;
            background-position: right 15px center;
            background-size: 16px;
            cursor: pointer;
        }

        .filter-select:focus {
            border-color: #6B240D;
            box-shadow: 0 0 0 0.25rem rgba(153, 77, 28, 0.1);
        }

        /* Search Box Modern */
        .search-box {
            position: relative;
            width: 100%;
            max-width: 250px;
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

        .search-box .fa-magnifying-glass {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #a0a0a0;
            font-size: 1rem;
        }

        /* Tabel Modern */
        .table-fasilitas {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
        }

        .table-fasilitas th {
            background-color: #fcf8f5;
            color: #612713;
            font-weight: 700;
            padding: 16px;
            border-bottom: 2px solid #f0e6e1;
            text-align: left;
        }

        .table-fasilitas th:first-child {
            border-top-left-radius: 10px;
        }

        .table-fasilitas th:last-child {
            border-top-right-radius: 10px;
            text-align: center;
        }

        .table-fasilitas td {
            padding: 16px;
            vertical-align: middle;
            color: #444;
            border-bottom: 1px solid #f0f0f0;
            transition: background-color 0.2s ease;
        }

        .table-fasilitas tbody tr:hover td {
            background-color: #fafafa;
        }

        /* Tombol Aksi */
        .action-btns {
            display: flex;
            justify-content: center;
            gap: 10px;
        }

        .btn-action {
            width: 35px;
            height: 35px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            border: none;
            transition: all 0.2s ease;
            text-decoration: none;
            cursor: pointer;
        }

        .btn-edit {
            background-color: #fcf8f5;
            color: #994D1C;
        }

        .btn-edit:hover {
            background-color: #6B240D;
            color: white;
        }

        @media (max-width: 576px) {
            .search-box {
                max-width: 100%;
            }

            .table-toolbar {
                flex-direction: column;
                align-items: stretch;
            }

            .btn-tambah {
                justify-content: center;
            }
        }

        .custom-input {
            border: 1.5px solid #e0e0e0;
            border-radius: 8px;
            padding: 10px;
            transition: all 0.3s ease;
        }

        .custom-input:focus {
            border-color: #6B240D;
            box-shadow: 0 0 0 0.25rem rgba(153, 77, 28, 0.1);
        }

        .fw-600 {
            font-weight: 600;
            color: #333;
        }

        .spesifikasi-section {
            background-color: #fcf8f5;
            border: 1px solid #f0e6e1;
            border-radius: 10px;
            padding: 16px;
        }

        .spesifikasi-section legend {
            font-size: 0.9rem;
            font-weight: 700;
            color: #612713;
            padding: 0 8px;
        }
    </style>
@endpush

@section('content')
    <h1 class="fasilitas-title">Data Fasilitas</h1>

    <div class="data-card">
        <div class="table-toolbar">
            <button class="btn-tambah" data-bs-toggle="modal" data-bs-target="#modalTambahFasilitas">
                <i class="fa-solid fa-plus"></i> Tambah Fasilitas
            </button>

            <div class="d-flex align-items-center gap-2 flex-wrap">
                <button class="btn-tambah" data-bs-toggle="modal" data-bs-target="#modalJenisFasilitas">
                    <i class="fa-solid fa-tags"></i> Jenis Fasilitas
                </button>

                <select id="filterJenis" class="filter-select">
                    <option value="" selected>Semua Jenis</option>
                    @foreach($jenisFasilitas as $jenis)
                        <option value="{{ $jenis->id_jenis }}" {{ request('jenis') == $jenis->id_jenis ? 'selected' : '' }}>
                            {{ $jenis->nama_jenis }}
                        </option>
                    @endforeach
                </select>

                <select id="filterStatus" class="filter-select">
                    <option value="" selected>Semua Status</option>
                    <option value="Tersedia" {{ request('status') == 'Tersedia' ? 'selected' : '' }}>Tersedia</option>
                    <option value="Terpakai" {{ request('status') == 'Terpakai' ? 'selected' : '' }}>Terpakai</option>
                </select>

                <div class="search-box ms-md-2">
                    <i class="fa-solid fa-magnifying-glass"></i>
                    <input type="text" id="searchInput" placeholder="Cari..." value="{{ request('search') }}">
                </div>
            </div>
        </div>

        <!-- TABEL DATA FASILITAS -->
        <div class="table-responsive">
            <table class="table-fasilitas">
                <thead>
                    <tr>
                        <th width="5%">No</th>
                        <th width="22%">Nama Fasilitas</th>
                        <th width="15%">Jenis</th>
                        <th width="10%">Unit</th>
                        <th width="15%">Status</th>
                        <th width="10%">Edit</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($fasilitas as $index => $item)
                        @php
                            $activePemeliharaan = \App\Models\Pemeliharaan::where('nama_pemeliharaan', 'Fasilitas - ' . $item->nama_fasilitas)
                                ->where('status_pemeliharaan', 'Berjalan')
                                ->sum('jumlah_pemeliharaan');
                            $spek = $item->detailSpesifikasi;
                        @endphp
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td style="font-weight: 600; color: #612713;">{{ $item->nama_fasilitas }}</td>
                            <td>{{ $item->jenisFasilitas->nama_jenis ?? '-' }}</td>
                            <td>{{ $item->jumlah_fasilitas }}</td>
                            <td>{{ $item->status_fasilitas }}</td>
                            <td>
                                <div class="action-btns">
                                    <button class="btn-action btn-edit" data-bs-toggle="modal"
                                        data-bs-target="#modalEditFasilitas"
                                        data-id="{{ $item->id_fasilitas }}"
                                        data-url="{{ route('fasilitas.update', $item->id_fasilitas) }}"
                                        data-nama="{{ $item->nama_fasilitas }}"
                                        data-status="{{ $item->status_fasilitas }}"
                                        data-idjenis="{{ $item->id_jenis }}"
                                        data-jumlah="{{ $item->jumlah_fasilitas }}"
                                        data-keterangan="{{ $item->keterangan_fasilitas }}"
                                        data-merk="{{ $spek->merk ?? '' }}"
                                        data-warna="{{ $spek->warna ?? '' }}"
                                        data-ukuran="{{ $spek->ukuran ?? '' }}"
                                        data-kapasitas="{{ $spek->kapasitas ?? '' }}"
                                        data-pemeliharaan="{{ $activePemeliharaan }}"
                                        data-foto="{{ $item->foto_fasilitas }}">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-5">
                                <div class="d-flex flex-column align-items-center justify-content-center">
                                    <i class="fa-solid fa-inbox mb-3" style="font-size: 3rem; color: #d0d0d0;"></i>
                                    <h5 class="fw-bold" style="color: #a0a0a0;">Belum Ada Data Fasilitas</h5>
                                    <p class="text-muted" style="font-size: 0.9rem;">
                                        Klik tombol "Tambah Fasilitas" di atas untuk menambahkan data baru.
                                    </p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- MODAL TAMBAH FASILITAS -->
    <div class="modal fade" id="modalTambahFasilitas" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content" style="border-radius: 16px; border: none; overflow: hidden;">
                <div class="modal-header text-white" style="background-color: #612713; border: none; padding: 20px;">
                    <h5 class="modal-title w-100 text-center fw-bold" style="font-size: 1.5rem;">Tambah Fasilitas</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <form action="{{ route('fasilitas.store') }}" method="POST" id="formTambahFasilitas" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body p-4" style="background-color: #ffffff;">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label fw-600">Nama<span style="color: red;">*</span></label>
                                <input type="text" name="nama_fasilitas" class="form-control custom-input"
                                    placeholder="Masukkan nama fasilitas" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-600">Jenis<span style="color: red;">*</span></label>
                                <select name="id_jenis" class="form-select custom-input" required>
                                    <option value="" selected disabled>Pilih Jenis</option>
                                    @foreach($jenisFasilitas as $jenis)
                                        <option value="{{ $jenis->id_jenis }}">{{ $jenis->nama_jenis }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-600">Jumlah Unit<span style="color: red;">*</span></label>
                                <input type="number" name="jumlah_fasilitas" class="form-control custom-input" min="1"
                                    placeholder="Contoh: 20" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-600">Status<span style="color: red;">*</span></label>
                                <select name="status_fasilitas" class="form-select custom-input" required>
                                    <option value="" selected disabled>Pilih Status</option>
                                    <option value="Tersedia">Tersedia</option>
                                    <option value="Terpakai">Terpakai</option>
                                    <option value="Berakhir">Berakhir</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-600">Foto</label>
                                <input type="file" name="foto_fasilitas" class="form-control custom-input" accept="image/*">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-600">Keterangan</label>
                                <input type="text" name="keterangan_fasilitas" class="form-control custom-input"
                                    placeholder="Tambahkan deskripsi fasilitas...">
                            </div>

                            <!-- Spesifikasi -->
                            <div class="col-12">
                                <fieldset class="spesifikasi-section">
                                    <legend>Detail Spesifikasi <small class="text-muted fw-normal">(isi sesuai yang ada)</small></legend>
                                    <div class="row g-3 mt-1">
                                        <div class="col-md-6">
                                            <label class="form-label fw-600">Merk</label>
                                            <input type="text" name="merk" class="form-control custom-input"
                                                placeholder="Contoh: Yamaha">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label fw-600">Warna</label>
                                            <input type="text" name="warna" class="form-control custom-input"
                                                placeholder="Contoh: Hitam">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label fw-600">Ukuran</label>
                                            <input type="text" name="ukuran" class="form-control custom-input"
                                                placeholder="Contoh: 120x60 cm">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label fw-600">Kapasitas (orang)</label>
                                            <input type="number" name="kapasitas" class="form-control custom-input" min="1"
                                                placeholder="Contoh: 50">
                                        </div>
                                    </div>
                                </fieldset>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer border-0 p-4 pt-0">
                        <button type="submit" class="btn w-100 text-white fw-bold py-2"
                            style="background-color: #612713; border-radius: 10px; font-size: 1.1rem;">
                            SIMPAN
                        </button>
                    </div>
                </form>

                <div class="modal-footer justify-content-between">
                    <div class="row">
                        <small><strong style="color: red;">* </strong>Wajib diisi</small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- MODAL EDIT FASILITAS -->
    <div class="modal fade" id="modalEditFasilitas" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content" style="border-radius: 16px; border: none; overflow: hidden;">
                <div class="modal-header text-white" style="background-color: #612713; border: none; padding: 20px;">
                    <h5 class="modal-title w-100 text-center fw-bold" style="font-size: 1.5rem;">Edit Fasilitas</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <form method="POST" id="formEditFasilitas" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body p-4" style="background-color: #ffffff;">
                        <div class="row g-3">
                            <input type="hidden" id="edit_id_fasilitas" name="id_fasilitas">
                            <div class="col-md-6">
                                <label class="form-label fw-600">Nama<span style="color: red;">*</span></label>
                                <input type="text" name="nama_fasilitas" id="edit_nama" class="form-control custom-input" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-600">Jenis<span style="color: red;">*</span></label>
                                <select name="id_jenis" id="edit_id_jenis" class="form-select custom-input" required>
                                    <option value="" disabled>Pilih Jenis</option>
                                    @foreach($jenisFasilitas as $jenis)
                                        <option value="{{ $jenis->id_jenis }}">{{ $jenis->nama_jenis }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-600">Jumlah Unit<span style="color: red;">*</span></label>
                                <input type="number" name="jumlah_fasilitas" id="edit_jumlah" class="form-control custom-input" min="1" required>
                                <div id="pemeliharaanInfoText" style="font-size: 13px; color:#994D1C; font-weight: 600;"></div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-600">Status<span style="color: red;">*</span></label>
                                <select name="status_fasilitas" id="edit_status" class="form-select custom-input" required>
                                    <option value="" disabled>Pilih Status</option>
                                    <option value="Tersedia">Tersedia</option>
                                    <option value="Terpakai">Terpakai</option>
                                    <option value="Berakhir">Berakhir</option>
                                    <option value="Pemeliharaan">Pemeliharaan</option>
                                </select>
                                <div style="font-size: 13px; color:grey;">Jika status "Berakhir", data fasilitas tidak akan tampil.</div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-600">Foto
                                    <a href="javascript:void(0)" id="linkPreviewFotoFasilitas"
                                        class="text-secondary text-decoration-underline ms-2"
                                        style="font-size: 0.85rem; display: none;">Lihat Foto</a>
                                </label>
                                <input type="file" name="foto_fasilitas" class="form-control custom-input" accept="image/*">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-600">Keterangan</label>
                                <input type="text" name="keterangan_fasilitas" id="edit_keterangan" class="form-control custom-input">
                            </div>

                            <!-- Spesifikasi -->
                            <div class="col-12">
                                <fieldset class="spesifikasi-section">
                                    <legend>Detail Spesifikasi <small class="text-muted fw-normal">(isi sesuai yang ada)</small></legend>
                                    <div class="row g-3 mt-1">
                                        <div class="col-md-6">
                                            <label class="form-label fw-600">Merk</label>
                                            <input type="text" name="merk" id="edit_merk" class="form-control custom-input"
                                                placeholder="Contoh: Yamaha">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label fw-600">Warna</label>
                                            <input type="text" name="warna" id="edit_warna" class="form-control custom-input"
                                                placeholder="Contoh: Hitam">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label fw-600">Ukuran</label>
                                            <input type="text" name="ukuran" id="edit_ukuran" class="form-control custom-input"
                                                placeholder="Contoh: 120x60 cm">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label fw-600">Kapasitas (orang)</label>
                                            <input type="number" name="kapasitas" id="edit_kapasitas" class="form-control custom-input" min="1"
                                                placeholder="Contoh: 50">
                                        </div>
                                    </div>
                                </fieldset>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer border-0 p-4 pt-0 d-flex justify-content-between gap-3">
                        <button type="button" id="btnHapusFasilitas" class="btn btn-outline-danger fw-bold py-2 flex-grow-1" style="border-radius: 10px; font-size: 1.1rem;">
                            HAPUS
                        </button>
                        <button type="submit" class="btn text-white fw-bold py-2 flex-grow-1"
                            style="background-color: #612713; border-radius: 10px; font-size: 1.1rem;">
                            SIMPAN
                        </button>
                    </div>
                </form>

                <div class="modal-footer justify-content-between">
                    <div class="row">
                        <small><strong style="color: red;">* </strong>Wajib diisi</small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- MODAL JENIS FASILITAS -->
    <div class="modal fade" id="modalJenisFasilitas" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content" style="border-radius: 16px; border: none; overflow: hidden;">
                <div class="modal-header text-white" style="background-color: #612713; border: none; padding: 20px;">
                    <h5 class="modal-title w-100 text-center fw-bold" style="font-size: 1.5rem;">Jenis Fasilitas</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                
                <div class="modal-body p-4" style="background-color: #ffffff;">
                    <div class="table-responsive">
                        <table class="table-fasilitas" id="tableJenis">
                            <thead>
                                <tr>
                                    <th width="10%">No</th>
                                    <th width="70%">Nama Jenis</th>
                                    <th width="20%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($jenisFasilitas as $jenis)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td style="font-weight: 600; color: #612713;">{{ $jenis->nama_jenis }}</td>
                                        <td>
                                            <div class="action-btns">
                                                <button class="btn-action btn-edit" 
                                                    data-bs-toggle="modal" 
                                                    data-bs-target="#modalEditJenis"
                                                    data-id="{{ $jenis->id_jenis }}"
                                                    data-nama="{{ $jenis->nama_jenis }}">
                                                    <i class="fa-solid fa-pen-to-square"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-center py-4">Belum ada data jenis fasilitas.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer border-0 p-4 pt-0">
                    <button class="btn w-100 text-white fw-bold py-2" data-bs-toggle="modal" data-bs-target="#modalTambahJenis" style="background-color: #612713; border-radius: 10px; font-size: 1.1rem;">
                        <i class="fa-solid fa-plus"></i> Tambah Jenis
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- MODAL TAMBAH JENIS -->
    <div class="modal fade" id="modalTambahJenis" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content" style="border-radius: 16px; border: none; overflow: hidden;">
                <div class="modal-header text-white" style="background-color: #612713; border: none; padding: 20px;">
                    <h5 class="modal-title w-100 text-center fw-bold" style="font-size: 1.5rem;">Tambah Jenis Fasilitas</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                
                <form action="{{ route('fasilitas.jenis.store') }}" method="POST" id="formTambahJenis">
                    @csrf
                    <div class="modal-body p-4" style="background-color: #ffffff;">
                        <div class="row g-3">
                            <div class="col-12">
                                <label class="form-label fw-600">Nama Jenis<span style="color: red;">*</span></label>
                                <input type="text" name="nama_jenis" class="form-control custom-input" placeholder="Nama Jenis Fasilitas" required>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer border-0 p-4 pt-0">
                        <button type="submit" class="btn w-100 text-white fw-bold py-2" style="background-color: #612713; border-radius: 10px; font-size: 1.1rem;">
                            SIMPAN
                        </button>
                        <button type="button" class="btn w-100 mt-2 text-white fw-bold py-2" style="background-color: #888; border-radius: 10px; font-size: 1.1rem;" data-bs-toggle="modal" data-bs-target="#modalJenisFasilitas">
                            KEMBALI KE LIST JENIS
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- MODAL EDIT JENIS -->
    <div class="modal fade" id="modalEditJenis" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content" style="border-radius: 16px; border: none; overflow: hidden;">
                <div class="modal-header text-white" style="background-color: #612713; border: none; padding: 20px;">
                    <h5 class="modal-title w-100 text-center fw-bold" style="font-size: 1.5rem;">Edit Jenis Fasilitas</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                
                <form action="" method="POST" id="formEditJenis">
                    @csrf
                    <div class="modal-body p-4" style="background-color: #ffffff;">
                        <div class="row g-3">
                            <div class="col-12">
                                <label class="form-label fw-600">Nama Jenis<span style="color: red;">*</span></label>
                                <input type="text" name="nama_jenis" id="edit_nama_jenis" class="form-control custom-input" required>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer border-0 p-4 pt-0 d-flex justify-content-between gap-3">
                        <button type="button" id="btnHapusJenis" class="btn btn-outline-danger fw-bold py-2 flex-grow-1" style="border-radius: 10px; font-size: 1.1rem;">
                            HAPUS
                        </button>
                        <button type="submit" class="btn text-white fw-bold py-2 flex-grow-1" style="background-color: #612713; border-radius: 10px; font-size: 1.1rem;">
                            SIMPAN
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

                <form id="formHapusJenis" method="POST" style="display: none;">
        @csrf
    </form>
    
    <form id="formHapusFasilitas" method="POST" style="display: none;">
        @csrf
    </form>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // === KONFIRMASI TAMBAH ===
            const tambahForm = document.getElementById('formTambahFasilitas');
            if (tambahForm) {
                tambahForm.addEventListener('submit', function (e) {
                    e.preventDefault();
                    Swal.fire({
                        title: 'Konfirmasi',
                        text: 'Apakah Anda yakin ingin menambah data?',
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
                            setTimeout(() => tambahForm.submit(), 300);
                        }
                    });
                });
            }

            // === KONFIRMASI EDIT ===
            const editForm = document.getElementById('formEditFasilitas');
            if (editForm) {
                editForm.addEventListener('submit', function (e) {
                    e.preventDefault();
                    Swal.fire({
                        title: 'Konfirmasi',
                        text: 'Apakah Anda yakin ingin mengubah data?',
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
                            setTimeout(() => editForm.submit(), 300);
                        }
                    });
                });
            }

            // === ISI MODAL EDIT ===
            var modalEditFasilitas = document.getElementById('modalEditFasilitas');
            modalEditFasilitas.addEventListener('show.bs.modal', function (event) {
                var button = event.relatedTarget;

                var url             = button.getAttribute('data-url');
                var nama            = button.getAttribute('data-nama');
                var status          = button.getAttribute('data-status');
                var idJenis         = button.getAttribute('data-idjenis');
                var jumlah          = button.getAttribute('data-jumlah');
                var keterangan      = button.getAttribute('data-keterangan');
                var merk            = button.getAttribute('data-merk');
                var warna           = button.getAttribute('data-warna');
                var ukuran          = button.getAttribute('data-ukuran');
                var kapasitas       = button.getAttribute('data-kapasitas');
                var activePemeliharaan = parseInt(button.getAttribute('data-pemeliharaan')) || 0;
                var foto            = button.getAttribute('data-foto');

                // Set action form
                document.getElementById('formEditFasilitas').action = url;

                // Isi field utama
                document.getElementById('edit_nama').value        = nama;
                document.getElementById('edit_jumlah').value      = jumlah;
                document.getElementById('edit_keterangan').value  = keterangan || '';

                // Set jenis
                document.getElementById('edit_id_jenis').value = idJenis;

                // Set status & kontrol opsi Pemeliharaan
                var selectStatus = document.getElementById('edit_status');
                selectStatus.value = status;
                Array.from(selectStatus.options).forEach(opt => {
                    if (status === 'Pemeliharaan') {
                        opt.disabled  = opt.value !== 'Pemeliharaan';
                        opt.style.display = opt.value !== 'Pemeliharaan' ? 'none' : '';
                    } else {
                        if (opt.value === 'Pemeliharaan') {
                            opt.disabled = true;
                            opt.style.display = 'none';
                        } else {
                            opt.disabled = false;
                            opt.style.display = '';
                        }
                    }
                });
                selectStatus.style.backgroundColor = status === 'Pemeliharaan' ? '#e9ecef' : '';
                selectStatus.style.pointerEvents   = status === 'Pemeliharaan' ? 'none' : 'auto';

                // Info pemeliharaan
                var pemeliharaanInfo = document.getElementById('pemeliharaanInfoText');
                if (activePemeliharaan > 0 && status === 'Tersedia') {
                    pemeliharaanInfo.style.display = 'block';
                    pemeliharaanInfo.innerHTML = 'Pemeliharaan: ' + activePemeliharaan + ' Unit';
                } else {
                    pemeliharaanInfo.style.display = 'none';
                }

                // Isi spesifikasi
                document.getElementById('edit_merk').value      = merk || '';
                document.getElementById('edit_warna').value     = warna || '';
                document.getElementById('edit_ukuran').value    = ukuran || '';
                document.getElementById('edit_kapasitas').value = kapasitas || '';

                var idFasilitas = button.getAttribute('data-id');
                var btnHapusFasilitas = document.getElementById('btnHapusFasilitas');
                if (btnHapusFasilitas) {
                    btnHapusFasilitas.setAttribute('data-id', idFasilitas);
                }

                // Preview foto
                var previewLink = document.getElementById('linkPreviewFotoFasilitas');
                if (foto) {
                    var photoUrl = "{{ asset('uploads/fasilitas/') }}/" + foto;
                    previewLink.style.display = 'inline-block';
                    previewLink.onclick = function () {
                        Swal.fire({
                            imageUrl: photoUrl,
                            imageAlt: 'Preview Foto',
                            showCloseButton: true,
                            showConfirmButton: false,
                            customClass: { image: 'img-fluid rounded' }
                        });
                    };
                } else {
                    previewLink.style.display = 'none';
                    previewLink.onclick = null;
                }
            });

            // === JENIS FASILITAS ===
            const tambahJenisForm = document.getElementById('formTambahJenis');
            if (tambahJenisForm) {
                tambahJenisForm.addEventListener('submit', function (e) {
                    e.preventDefault();
                    Swal.fire({
                        title: 'Konfirmasi',
                        text: 'Apakah Anda yakin ingin menambah jenis fasilitas?',
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
                            setTimeout(() => tambahJenisForm.submit(), 300);
                        }
                    });
                });
            }

            const editJenisForm = document.getElementById('formEditJenis');
            if (editJenisForm) {
                editJenisForm.addEventListener('submit', function (e) {
                    e.preventDefault();
                    Swal.fire({
                        title: 'Konfirmasi',
                        text: 'Apakah Anda yakin ingin mengubah jenis fasilitas?',
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
                            setTimeout(() => editJenisForm.submit(), 300);
                        }
                    });
                });
            }

            var modalEditJenis = document.getElementById('modalEditJenis');
            if (modalEditJenis) {
                modalEditJenis.addEventListener('show.bs.modal', function (event) {
                    var button = event.relatedTarget;
                    var id = button.getAttribute('data-id');
                    var nama = button.getAttribute('data-nama');

                    document.getElementById('formEditJenis').action = "{{ url('fasilitas/jenis/edit') }}/" + id;
                    document.getElementById('edit_nama_jenis').value = nama;

                    var btnHapusJenis = document.getElementById('btnHapusJenis');
                    if (btnHapusJenis) {
                        btnHapusJenis.setAttribute('data-id', id);
                    }
                });
            }

            var btnHapusJenis = document.getElementById('btnHapusJenis');
            if (btnHapusJenis) {
                btnHapusJenis.addEventListener('click', function() {
                    var id = this.getAttribute('data-id');
                    if (!id) return;

                    Swal.fire({
                        title: 'Konfirmasi',
                        text: 'Apakah Anda yakin ingin menghapus dari tampilan?',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Yakin',
                        cancelButtonText: 'Kembali',
                        reverseButtons: true,
                        confirmButtonColor: '#dc3545',
                        cancelButtonColor: '#6c757d'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            Swal.fire({
                                title: 'Menghapus...',
                                text: 'Mohon tunggu sebentar',
                                didOpen: () => Swal.showLoading(),
                                allowOutsideClick: false,
                                allowEscapeKey: false,
                                showConfirmButton: false
                            });
                            
                            var formHapus = document.getElementById('formHapusJenis');
                            formHapus.action = "{{ url('fasilitas/jenis/delete') }}/" + id;
                            setTimeout(() => formHapus.submit(), 300);
                        }
                    });
                });
            }

            var btnHapusFasilitas = document.getElementById('btnHapusFasilitas');
            if (btnHapusFasilitas) {
                btnHapusFasilitas.addEventListener('click', function() {
                    var id = this.getAttribute('data-id');
                    if (!id) return;

                    Swal.fire({
                        title: 'Konfirmasi',
                        text: 'Apakah Anda yakin ingin menghapus dari tampilan?',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Yakin',
                        cancelButtonText: 'Kembali',
                        reverseButtons: true,
                        confirmButtonColor: '#dc3545',
                        cancelButtonColor: '#6c757d'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            Swal.fire({
                                title: 'Menghapus...',
                                text: 'Mohon tunggu sebentar',
                                didOpen: () => Swal.showLoading(),
                                allowOutsideClick: false,
                                allowEscapeKey: false,
                                showConfirmButton: false
                            });
                            
                            var formHapus = document.getElementById('formHapusFasilitas');
                            formHapus.action = "{{ url('fasilitas/delete') }}/" + id;
                            setTimeout(() => formHapus.submit(), 300);
                        }
                    });
                });
            }


            // === FILTER & SEARCH (Fetch API) ===
            const searchInput  = document.getElementById('searchInput');
            const filterJenis  = document.getElementById('filterJenis');
            const filterStatus = document.getElementById('filterStatus');
            let searchTimer;

            function fetchFasilitas() {
                clearTimeout(searchTimer);
                searchTimer = setTimeout(() => {
                    const searchVal = searchInput  ? searchInput.value  : '';
                    const jenisVal  = filterJenis  ? filterJenis.value  : '';
                    const statusVal = filterStatus ? filterStatus.value : '';

                    const baseUrl = window.location.origin + window.location.pathname;
                    const params  = new URLSearchParams();
                    if (searchVal) params.append('search', searchVal);
                    if (jenisVal)  params.append('jenis',  jenisVal);
                    if (statusVal) params.append('status', statusVal);

                    const fetchUrl = [baseUrl, params.toString()].filter(Boolean).join('?');
                    window.history.pushState({ path: fetchUrl }, '', fetchUrl);

                    fetch(fetchUrl, { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
                        .then(response => response.text())
                        .then(html => {
                            const parser  = new DOMParser();
                            const doc     = parser.parseFromString(html, 'text/html');
                            const newTbody     = doc.querySelector('.table-fasilitas tbody');
                            const currentTbody = document.querySelector('.table-fasilitas tbody');
                            if (newTbody && currentTbody) {
                                currentTbody.innerHTML = newTbody.innerHTML;
                            }
                        })
                        .catch(err => console.error('Gagal memuat hasil pencarian:', err));
                }, 300);
            }

            if (searchInput)  searchInput.addEventListener('input',  fetchFasilitas);
            if (filterJenis)  filterJenis.addEventListener('change', fetchFasilitas);
            if (filterStatus) filterStatus.addEventListener('change', fetchFasilitas);
        });
    </script>

@endsection