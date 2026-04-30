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
        width: 200px; /* Lebar tetap 200px sesuai keinginanmu */
        padding: 10px 40px 10px 15px; /* Padding kanan diperbesar (40px) agar teks tidak menabrak panah */
        border-radius: 10px;
        border: 1.5px solid #e0e0e0;
        font-size: 0.95rem;
        outline: none;
        transition: border-color 0.3s ease;
        color: #333;
        
        /* 1. Menghilangkan panah bawaan browser */
        appearance: none;
        -webkit-appearance: none;
        -moz-appearance: none;

        /* 2. Menambahkan panah kustom (ikon SVG) */
        background-color: #fff;
        background-image: url("data:image/svg+xml;charset=UTF-8,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='%23333' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3e%3cpolyline points='6 9 12 15 18 9'%3e%3c/polyline%3e%3c/svg%3e");
        background-repeat: no-repeat;
        
        /* 3. Mengatur posisi panah agar tidak mepet kanan (jarak 15px dari kanan) */
        background-position: right 15px center;
        background-size: 16px; /* Ukuran panahnya */
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
    .table-fasilitas th:first-child { border-top-left-radius: 10px; }
    .table-fasilitas th:last-child { border-top-right-radius: 10px; text-align: center; }

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

    /* Tombol Aksi (Edit & Hapus) */
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
    .btn-edit:hover { background-color: #6B240D; color: white; }
    
    .btn-delete {
        background-color: #ffebee;
        color: #dc3545;
    }
    .btn-delete:hover { background-color: #dc3545; color: white; }

    @media (max-width: 576px) {
        .search-box { max-width: 100%; }
        .table-toolbar { flex-direction: column; align-items: stretch; }
        .btn-tambah { justify-content: center; }
    }

    .custom-input {
        border: 1.5px solid #e0e0e0;
        border-radius: 8px;
        padding: 10px;
        transition: all 0.3s ease;
    }
    .custom-input:focus {
        border-color: #6B240D;
        box-shadow: 0 0 0 0.25 margin-left: rgba(153, 77, 28, 0.1);
    }
    .fw-600 { 
        font-weight: 600; color: #333; 
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
            <select id="filterJenis" class="filter-select">
                <option value="" selected>Semua Jenis</option>
                <option value="Multimedia" {{ request('jenis') == 'Multimedia' ? 'selected' : '' }}>Multimedia</option>
                <option value="Sound System" {{ request('jenis') == 'Sound System' ? 'selected' : '' }}>Sound System</option>
                <option value="Lighting" {{ request('jenis') == 'Lighting' ? 'selected' : '' }}>Lighting</option>
                <option value="Alat Musik" {{ request('jenis') == 'Alat Musik' ? 'selected' : '' }}>Alat Musik</option>
                <option value="Ruangan" {{ request('jenis') == 'Ruangan' ? 'selected' : '' }}>Ruangan</option>
                <option value="Umum" {{ request('jenis') == 'Umum' ? 'selected' : '' }}>Umum</option>
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
                    <th width="20%">Foto Fasilitas</th>
                    <th width="20%">Nama Fasilitas</th>
                    <th width="15%">Jenis</th>
                    <th width="10%">Unit</th>
                    <th width="15%">Status</th>
                    <th width="10%">Edit</th>
                </tr>
            </thead>
            <tbody>
                @forelse($fasilitas as $index => $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>
                            @if($item->foto_fasilitas)
                                <img src="{{ asset('uploads/fasilitas/' . $item->foto_fasilitas) }}" 
                                     alt="{{ $item->nama_fasilitas }}" 
                                     style="width: 180px; height: 100px; object-fit: cover; border-radius: 8px;">
                            @else
                                <span style="color: #999;">No Image</span>
                            @endif
                        </td>
                        <td style="font-weight: 600; color: #612713;">{{ $item->nama_fasilitas }}</td>
                        <td>{{ $item->jenis_fasilitas }}</td>
                        <td>{{ $item->jumlah_fasilitas }}</td>
                        <td>{{ $item->status_fasilitas }}</td>
                        <td>
                            <div class="action-btns">
                                <button class="btn-action btn-edit" 
                                    data-bs-toggle="modal" 
                                    data-bs-target="#modalEditFasilitas"
                                    data-id="{{ $item->id_fasilitas }}"
                                    data-url="{{ route('fasilitas.update', $item->id_fasilitas) }}"
                                    data-nama="{{ $item->nama_fasilitas }}"
                                    data-status="{{ $item->status_fasilitas }}"
                                    data-merk="{{ $item->merk_fasilitas }}"
                                    data-jenis="{{ $item->jenis_fasilitas }}"
                                    data-jumlah="{{ $item->jumlah_fasilitas }}"
                                    data-keterangan="{{ $item->keterangan_fasilitas }}"
                                    data-warnamm="{{ $item->detailMM->warnaMM ?? '' }}"
                                    data-warnas="{{ $item->detailS->warnaS ?? '' }}"
                                    data-warnal="{{ $item->detailL->warnaL ?? '' }}"
                                    data-warnam="{{ $item->detailM->warnaM ?? '' }}"
                                    data-warnau="{{ $item->detailU->warnaU ?? '' }}"
                                    data-ukuranu="{{ $item->detailU->ukuranU ?? '' }}"
                                    data-ukuranr="{{ $item->detailR->ukuranR ?? '' }}"
                                    data-kapasitasr="{{ $item->detailR->kapasitasR ?? '' }}">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center py-5">
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
                            <input type="text" name="nama_fasilitas" class="form-control custom-input" placeholder="Masukkan nama fasilitas" required>
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
                            <label class="form-label fw-600">Jumlah Unit<span style="color: red;">*</span></label>
                            <input type="number" name="jumlah_fasilitas" class="form-control custom-input" placeholder="Contoh: 20" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-600">Foto<span style="color: red;">*</span></label>
                            <input type="file" name="foto_fasilitas" class="form-control custom-input" accept="image/*">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-600">Merk<span style="color: red;">*</span></label>
                            <input type="text" name="merk_fasilitas" class="form-control custom-input" placeholder="Contoh: Yamaha" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-600">Jenis<span style="color: red;">*</span></label>
                            <select name="jenis_fasilitas" class="form-select custom-input" required>
                                <option value="" selected disabled>Pilih Jenis</option>
                                <option value="Multimedia">Multimedia</option>
                                <option value="Sound System">Sound System</option>
                                <option value="Lighting">Lighting</option>
                                <option value="Alat Musik">Alat Musik</option>
                                <option value="Ruangan">Ruangan</option>
                                <option value="Umum">Umum</option>
                            </select>
                        </div>
                        <div id="dynamicFieldsContainerTambah" class="col-12 mt-3" style="display: none;"></div>
                        <div class="col-12">
                            <label class="form-label fw-600">Keterangan</label>
                            <textarea name="keterangan_fasilitas" class="form-control custom-input" rows="3" placeholder="Tambahkan deskripsi fasilitas..."></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0 p-4 pt-0">
                    <button type="submit" class="btn w-100 text-white fw-bold py-2" style="background-color: #612713; border-radius: 10px; font-size: 1.1rem;">
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
                        <input type="hidden" id="id_fasilitas" name="id_fasilitas">
                        <div class="col-md-6">
                            <label class="form-label fw-600">Nama<span style="color: red;">*</span></label>
                            <input type="text" name="nama_fasilitas" class="form-control custom-input" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-600">Status<span style="color: red;">*</span></label>
                            <select name="status_fasilitas" class="form-select custom-input" required>
                                <option value="" selected disabled>Pilih Status</option>
                                <option value="Tersedia">Tersedia</option>
                                <option value="Terpakai">Terpakai</option>
                                <option value="Berakhir">Berakhir</option>
                            </select>
                            <div style="font-size: 13px; color:grey;">Jika status "Berakhir", data fasilitas tidak akan tampil.</div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-600">Jumlah Unit<span style="color: red;">*</span></label>
                            <input type="number" name="jumlah_fasilitas" class="form-control custom-input" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-600">Foto</label>
                            <input type="file" name="foto_fasilitas" class="form-control custom-input" accept="image/*">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-600">Merk<span style="color: red;">*</span></label>
                            <input type="text" name="merk_fasilitas" class="form-control custom-input" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-600">Jenis<span style="color: red;">*</span></label>
                            <select name="jenis_fasilitas" class="form-select custom-input" required>
                                <option value="" selected disabled>Pilih Jenis</option>
                                <option value="Multimedia">Multimedia</option>
                                <option value="Sound System">Sound System</option>
                                <option value="Lighting">Lighting</option>
                                <option value="Alat Musik">Alat Musik</option>
                                <option value="Ruangan">Ruangan</option>
                                <option value="Umum">Umum</option>
                            </select>
                        </div>
                        <div id="dynamicFieldsContainerEdit" class="col-12 mt-3" style="display: none;"></div>
                        <div class="col-12">
                            <label class="form-label fw-600">Keterangan</label>
                            <textarea name="keterangan_fasilitas" class="form-control custom-input" rows="3"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0 p-4 pt-0">
                    <button type="submit" class="btn w-100 text-white fw-bold py-2" style="background-color: #612713; border-radius: 10px; font-size: 1.1rem;">
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

<script>
    document.addEventListener('DOMContentLoaded', function () {
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
                    cancelButtonText: 'Tidak',
                    reverseButtons: true,
                    confirmButtonColor: '#994D1C',
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
    });

    document.addEventListener('DOMContentLoaded', function () {
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
                    cancelButtonText: 'Tidak',
                    reverseButtons: true,
                    confirmButtonColor: '#994D1C',
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
    });
</script>

<script>
    const formTambahFasilitas = document.getElementById('formTambahFasilitas');
    if(formTambahFasilitas) {
        formTambahFasilitas.addEventListener('submit', function(e) {
            e.preventDefault(); 
            
            Swal.fire({
                title: 'Konfirmasi Simpan',
                text: "Apakah data yang Anda masukkan sudah benar?",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#994D1C',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, Simpan!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    this.submit(); 
                }
            });
        });
    }

    const formEditFasilitas = document.getElementById('formEditFasilitas');
    if(formEditFasilitas) {
        formEditFasilitas.addEventListener('submit', function(e) {
            e.preventDefault(); 
            
            Swal.fire({
                title: 'Konfirmasi Simpan',
                text: "Apakah data yang Anda ubah sudah benar?",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#994D1C',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, Simpan!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    this.submit(); 
                }
            });
        });
    }
</script>

<script>
    function renderDynamicFields(jenis, containerId, data = {}) {
        const container = document.getElementById(containerId);
        if (!container) return;
        
        container.innerHTML = '';
        container.style.display = 'block';

        let html = '<div class="row g-3">';
        
        if (jenis === 'Multimedia') {
            html += `<div class="col-md-12">
                <label class="form-label fw-600">Warna<span style="color: red;">*</span></label>
                <input type="text" name="warnaMM" class="form-control custom-input" value="${data.warnaMM || ''}" placeholder="Warna atau deskripsi multimedia" required>
            </div>`;
        } else if (jenis === 'Sound System') {
            html += `<div class="col-md-12">
                <label class="form-label fw-600">Warna<span style="color: red;">*</span></label>
                <input type="text" name="warnaS" class="form-control custom-input" value="${data.warnaS || ''}" placeholder="Warna atau deskripsi sound system" required>
            </div>`;
        } else if (jenis === 'Lighting') {
            html += `<div class="col-md-12">
                <label class="form-label fw-600">Warna<span style="color: red;">*</span></label>
                <input type="text" name="warnaL" class="form-control custom-input" value="${data.warnaL || ''}" placeholder="Warna atau deskripsi lighting" required>
            </div>`;
        } else if (jenis === 'Alat Musik') {
            html += `<div class="col-md-12">
                <label class="form-label fw-600">Warna<span style="color: red;">*</span></label>
                <input type="text" name="warnaM" class="form-control custom-input" value="${data.warnaM || ''}" placeholder="Warna alat musik" required>
            </div>`;
        } else if (jenis === 'Umum') {
            html += `<div class="col-md-6">
                <label class="form-label fw-600">Warna<span style="color: red;">*</span></label>
                <input type="text" name="warnaU" class="form-control custom-input" value="${data.warnaU || ''}" placeholder="Warna" required>
            </div>
            <div class="col-md-6">
                <label class="form-label fw-600">Ukuran (cm)<span style="color: red;">*</span></label>
                <input type="text" name="ukuranU" class="form-control custom-input" value="${data.ukuranU || ''}" placeholder="Ukuran" required>
            </div>`;
        } else if (jenis === 'Ruangan') {
            html += `<div class="col-md-6">
                <label class="form-label fw-600">Ukuran (m²)<span style="color: red;">*</span></label>
                <input type="text" name="ukuranR" class="form-control custom-input" value="${data.ukuranR || ''}" placeholder="Ukuran ruangan" required>
            </div>
            <div class="col-md-6">
                <label class="form-label fw-600">Kapasitas (orang)<span style="color: red;">*</span></label>
                <input type="number" name="kapasitasR" class="form-control custom-input" value="${data.kapasitasR || ''}" placeholder="Kapasitas ruangan" required>
            </div>`;
        } else {
            container.style.display = 'none';
        }

        html += '</div>';
        container.innerHTML = html;
    }

    document.addEventListener('DOMContentLoaded', function () {
        // Event listener untuk Tambah Fasilitas (ketika jenis dipilih)
        const selectJenisTambah = document.querySelector('#modalTambahFasilitas select[name="jenis_fasilitas"]');
        if (selectJenisTambah) {
            selectJenisTambah.addEventListener('change', function() {
                renderDynamicFields(this.value, 'dynamicFieldsContainerTambah');
            });
        }

        // Event listener untuk Edit Fasilitas (ketika jenis dipilih)
        const selectJenisEdit = document.querySelector('#modalEditFasilitas select[name="jenis_fasilitas"]');
        if (selectJenisEdit) {
            selectJenisEdit.addEventListener('change', function() {
                renderDynamicFields(this.value, 'dynamicFieldsContainerEdit');
            });
        }

        // Tangkap modalnya
        var modalEditFasilitas = document.getElementById('modalEditFasilitas');
        
        // Ketika modal akan ditampilkan
        modalEditFasilitas.addEventListener('show.bs.modal', function (event) {
            // Tombol yang men-trigger modal
            var button = event.relatedTarget;
            
            // Ambil data dari atribut data-* di tombol
            var url = button.getAttribute('data-url');
            var id = button.getAttribute('data-id');
            var nama = button.getAttribute('data-nama');
            var status = button.getAttribute('data-status');
            var jumlah = button.getAttribute('data-jumlah');
            var merk = button.getAttribute('data-merk');
            var jenis = button.getAttribute('data-jenis');
            var keterangan = button.getAttribute('data-keterangan');

            // Ambil detail dinamis
            var dataDetail = {
                warnaMM: button.getAttribute('data-warnamm'),
                warnaS: button.getAttribute('data-warnas'),
                warnaL: button.getAttribute('data-warnal'),
                warnaM: button.getAttribute('data-warnam'),
                warnaU: button.getAttribute('data-warnau'),
                ukuranU: button.getAttribute('data-ukuranu'),
                ukuranR: button.getAttribute('data-ukuranr'),
                kapasitasR: button.getAttribute('data-kapasitasr')
            };
            
            // Update URL action form
            var form = document.getElementById('formEditFasilitas');
            form.action = url;
            
            // Isi nilai inputan di dalam modal
            modalEditFasilitas.querySelector('input[name="id_fasilitas"]').value = id;
            modalEditFasilitas.querySelector('input[name="nama_fasilitas"]').value = nama;
            modalEditFasilitas.querySelector('select[name="status_fasilitas"]').value = status;
            modalEditFasilitas.querySelector('input[name="jumlah_fasilitas"]').value = jumlah;
            modalEditFasilitas.querySelector('input[name="merk_fasilitas"]').value = merk;
            modalEditFasilitas.querySelector('select[name="jenis_fasilitas"]').value = jenis;
            modalEditFasilitas.querySelector('textarea[name="keterangan_fasilitas"]').value = keterangan;

            // Render form dinamis untuk nilai edit
            renderDynamicFields(jenis, 'dynamicFieldsContainerEdit', dataDetail);
        });
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const searchInput = document.getElementById('searchInput');
        const filterJenis = document.getElementById('filterJenis');
        const filterStatus = document.getElementById('filterStatus');
        const filterNama = document.getElementById('filterNama');
        let searchTimer;

        function fetchFasilitas() {
            clearTimeout(searchTimer);
            
            searchTimer = setTimeout(() => {
                const searchVal = searchInput ? searchInput.value : '';
                const jenisVal = filterJenis ? filterJenis.value : '';
                const statusVal = filterStatus ? filterStatus.value : '';
                const sortNamaVal = filterNama ? filterNama.value : '';

                const baseUrl = window.location.origin + window.location.pathname;
                
                const params = new URLSearchParams();
                if (searchVal) params.append('search', searchVal);
                if (jenisVal) params.append('jenis', jenisVal);
                if (statusVal) params.append('status', statusVal);
                if (sortNamaVal) params.append('sort_nama', sortNamaVal);
                
                const fetchUrl = [baseUrl, params.toString()].filter(Boolean).join('?');

                // Update URL browser tanpa memicu reload
                window.history.pushState({path: fetchUrl}, '', fetchUrl);

                // Ambil HTML baru menggunakan Fetch API
                fetch(fetchUrl, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => response.text())
                .then(html => {
                    const parser = new DOMParser();
                    const doc = parser.parseFromString(html, 'text/html');
                    
                    // Cari bagian tbody dari respons HTML
                    const newTbody = doc.querySelector('.table-fasilitas tbody');
                    const currentTbody = document.querySelector('.table-fasilitas tbody');
                    
                    if (newTbody && currentTbody) {
                        // Ganti isi tbody saat ini dengan yang baru
                        currentTbody.innerHTML = newTbody.innerHTML;
                    }
                })
                .catch(err => console.error('Gagal memuat hasil pencarian:', err));
            }, 300); // Timeout 300ms
        }

        if (searchInput) searchInput.addEventListener('input', fetchFasilitas);
        if (filterJenis) filterJenis.addEventListener('change', fetchFasilitas);
        if (filterStatus) filterStatus.addEventListener('change', fetchFasilitas);
        if (filterNama) filterNama.addEventListener('change', fetchFasilitas);
    });
</script>

@endsection