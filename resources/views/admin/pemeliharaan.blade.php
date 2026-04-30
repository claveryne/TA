@extends('admin.sidebar')

@section('title', 'Pemeliharaan | House of Legacy')

@push('styles')
<style>
    /* --- Halaman Data Pemeliharaan --- */
    .pemeliharaan-title {
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
    .table-pemeliharaan {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
    }
    .table-pemeliharaan th {
        background-color: #fcf8f5;
        color: #612713;
        font-weight: 700;
        padding: 16px;
        border-bottom: 2px solid #f0e6e1;
        text-align: left;
    }
    .table-pemeliharaan th:first-child { border-top-left-radius: 10px; }
    .table-pemeliharaan th:last-child { border-top-right-radius: 10px; text-align: center; }

    .table-pemeliharaan td {
        padding: 16px;
        vertical-align: middle;
        color: #444;
        border-bottom: 1px solid #f0f0f0;
        transition: background-color 0.2s ease;
    }
    .table-pemeliharaan tbody tr:hover td {
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
<h1 class="pemeliharaan-title">Data Pemeliharaan</h1>

<div class="data-card">
    <div class="table-toolbar">
        <button class="btn-tambah" data-bs-toggle="modal" data-bs-target="#modalTambahPemeliharaan">
            <i class="fa-solid fa-plus"></i> Tambah Pemeliharaan
        </button>

        <div class="d-flex justify-content-end gap-3">
            <button class="btn-tambah" data-bs-toggle="modal" data-bs-target="#modalJadwalKaryawan">
                <i class="fa-solid fa-file-pdf"></i> Laporan Pemeliharaan
            </button>
            <div class="search-box">
                <i class="fa-solid fa-magnifying-glass"></i>
                <input type="text" id="searchInput" placeholder="Cari..." value="{{ request('search') }}">
            </div>
        </div>
    </div>

    <!-- TABEL DATA PEMELIHARAAN -->
    <div class="table-responsive">
        <table class="table-pemeliharaan">
            <thead>
                <tr>
                    <th width="5%">No</th>
                    <th width="20%">Bukti Pemeliharaan</th>
                    <th width="20%">Nama Pemeliharaan</th>
                    <th width="10%">Jumlah</th>
                    <th width="15%">Biaya (Rp)</th>
                    <th width="10%">Status</th>
                    <th width="10%">Edit</th>
                </tr>
            </thead>
            <tbody>
                @forelse($pemeliharaan->sortByDesc('updated_at') as $index => $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>
                            @if($item->foto_pemeliharaan)
                                <img src="{{ asset('uploads/pemeliharaan/' . $item->foto_pemeliharaan) }}" 
                                     alt="{{ $item->nama_pemeliharaan }}" 
                                     style="width: 180px; height: 100px; object-fit: cover; border-radius: 8px;">
                            @else
                                <span style="color: #999;">No Image</span>
                            @endif
                        </td>
                        <td style="font-weight: 600; color: #612713;">{{ $item->nama_pemeliharaan }}</td>
                        <td>{{ $item->jumlah_pemeliharaan }}</td>
                        <td>{{ number_format($item->biaya_pemeliharaan, 0, ',', '.') }}</td>
                        <td>{{ $item->status_pemeliharaan }}</td>
                        <td>
                            <div class="action-btns">
                                <button class="btn-action btn-edit" 
                                    data-bs-toggle="modal" 
                                    data-bs-target="#modalEditPemeliharaan"
                                    data-id="{{ $item->id_pemeliharaan }}"
                                    data-url="{{ route('pemeliharaan.update', $item->id_pemeliharaan) }}"
                                    data-nama="{{ $item->nama_pemeliharaan }}"
                                    data-status="{{ $item->status_pemeliharaan }}"
                                    data-biaya="{{ $item->biaya_pemeliharaan }}"
                                    data-jenis="{{ $item->jenis_pemeliharaan }}"
                                    data-jumlah="{{ $item->jumlah_pemeliharaan }}"
                                    data-mulai="{{ $item->tglMulai_pemeliharaan }}"
                                    data-selesai="{{ $item->tglSelesai_pemeliharaan }}"
                                    data-keterangan="{{ $item->keterangan_pemeliharaan }}">
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
                                <h5 class="fw-bold" style="color: #a0a0a0;">Belum Ada Data Pemeliharaan</h5>
                                <p class="text-muted" style="font-size: 0.9rem;">
                                    Klik tombol "Tambah Pemeliharaan" di atas untuk menambahkan data baru.
                                </p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- MODAL TAMBAH PEMELIHARAAN -->
<div class="modal fade" id="modalTambahPemeliharaan" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content" style="border-radius: 16px; border: none; overflow: hidden;">
            <div class="modal-header text-white" style="background-color: #612713; border: none; padding: 20px;">
                <h5 class="modal-title w-100 text-center fw-bold" style="font-size: 1.5rem;">Tambah Pemeliharaan</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <form action="{{ route('pemeliharaan.store') }}" method="POST" id="formTambahPemeliharaan" enctype="multipart/form-data">
                @csrf
                <div class="modal-body p-4" style="background-color: #ffffff;">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-600">Nama Pemeliharaan<span style="color: red;">*</span></label>
                            <select name="nama_pemeliharaan" class="form-select custom-input" required>
                                <option value="" selected disabled>Pilih Ruangan/Fasilitas</option>
                                @foreach($ruangan as $r)
                                    <option value="Ruangan - {{ $r->nama_ruangan }}">Ruangan - {{ $r->nama_ruangan }}</option>
                                @endforeach
                                @foreach($fasilitas as $f)
                                    <option value="Fasilitas - {{ $f->nama_fasilitas }}">Fasilitas - {{ $f->nama_fasilitas }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-600">Jumlah</label>
                            <input type="number" name="jumlah_pemeliharaan" class="form-control custom-input" placeholder="Contoh: 10">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-600">Tanggal Mulai<span style="color: red;">*</span></label>
                            <input type="date" name="tglMulai_pemeliharaan" class="form-control custom-input" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-600">Tanggal Selesai</label>
                            <input type="date" name="tglSelesai_pemeliharaan" class="form-control custom-input">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-600">Jenis<span style="color: red;">*</span></label>
                            <select name="jenis_pemeliharaan" class="form-select custom-input" required>
                                <option value="" selected disabled>Pilih Jenis</option>
                                <option value="Service Rutin">Service Rutin</option>
                                <option value="Perbaikan">Perbaikan</option>
                                <option value="Pembersihan">Pembersihan</option>
                                <option value="Lainnya">Lainnya</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-600">Status<span style="color: red;">*</span></label>
                            <select name="status_pemeliharaan" class="form-select custom-input" required>
                                <option value="" selected disabled>Pilih Status</option>
                                <option value="Berjalan">Berjalan</option>
                                <option value="Selesai">Selesai</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-600">Biaya</label>
                            <input type="number" name="biaya_pemeliharaan" class="form-control custom-input" placeholder="Contoh: 100000">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-600">Bukti Pemeliharaan</label>
                            <input type="file" name="foto_pemeliharaan" class="form-control custom-input" accept="image/*">
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-600">Keterangan</label>
                            <textarea name="keterangan_pemeliharaan" class="form-control custom-input" rows="3" placeholder="Tambahkan deskripsi pemeliharaan..."></textarea>
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
                    <small>Format tanggal <strong>mm/dd/yyyy</strong></small>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- MODAL EDIT PEMELIHARAAN -->
<div class="modal fade" id="modalEditPemeliharaan" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content" style="border-radius: 16px; border: none; overflow: hidden;">
            <div class="modal-header text-white" style="background-color: #612713; border: none; padding: 20px;">
                <h5 class="modal-title w-100 text-center fw-bold" style="font-size: 1.5rem;">Edit Pemeliharaan</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <form method="POST" id="formEditPemeliharaan" enctype="multipart/form-data">
                @csrf
                <div class="modal-body p-4" style="background-color: #ffffff;">
                    <div class="row g-3">
                        <input type="hidden" id="id_pemeliharaan" name="id_pemeliharaan">
                        <div class="col-md-6">
                            <label class="form-label fw-600">Nama Pemeliharaan<span style="color: red;">*</span></label>
                            <select name="nama_pemeliharaan" class="form-select custom-input" required>
                                <option value="" selected disabled>Pilih Ruangan/Fasilitas</option>
                                @foreach($ruangan as $r)
                                    <option value="Ruangan - {{ $r->nama_ruangan }}">Ruangan - {{ $r->nama_ruangan }}</option>
                                @endforeach
                                @foreach($fasilitas as $f)
                                    <option value="Fasilitas - {{ $f->nama_fasilitas }}">Fasilitas - {{ $f->nama_fasilitas }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-600">Jumlah</label>
                            <input type="number" name="jumlah_pemeliharaan" class="form-control custom-input" placeholder="Contoh: 10">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-600">Tanggal Mulai<span style="color: red;">*</span></label>
                            <input type="date" name="tglMulai_pemeliharaan" class="form-control custom-input" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-600">Tanggal Selesai</label>
                            <input type="date" name="tglSelesai_pemeliharaan" class="form-control custom-input">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-600">Jenis<span style="color: red;">*</span></label>
                            <select name="jenis_pemeliharaan" class="form-select custom-input" required>
                                <option value="" selected disabled>Pilih Jenis</option>
                                <option value="Service Rutin">Service Rutin</option>
                                <option value="Perbaikan">Perbaikan</option>
                                <option value="Pembersihan">Pembersihan</option>
                                <option value="Lainnya">Lainnya</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-600">Status<span style="color: red;">*</span></label>
                            <select name="status_pemeliharaan" class="form-select custom-input" required>
                                <option value="" selected disabled>Pilih Status</option>
                                <option value="Berjalan">Berjalan</option>
                                <option value="Selesai">Selesai</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-600">Biaya</label>
                            <input type="number" name="biaya_pemeliharaan" class="form-control custom-input" placeholder="Contoh: 100000">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-600">Bukti Pemeliharaan</label>
                            <input type="file" name="foto_pemeliharaan" class="form-control custom-input" accept="image/*">
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-600">Keterangan</label>
                            <textarea name="keterangan_pemeliharaan" class="form-control custom-input" rows="3" placeholder="Tambahkan deskripsi pemeliharaan..."></textarea>
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
                    <small>Format tanggal <strong>mm/dd/yyyy</strong></small>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- MODAL CETAK LAPORAN PEMELIHARAAN -->
<div class="modal fade" id="modalJadwalKaryawan" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius: 16px; border: none; overflow: hidden;">
            <div class="modal-header text-white" style="background-color: #612713; border: none; padding: 20px;">
                <h5 class="modal-title w-100 text-center fw-bold" style="font-size: 1.5rem;">Cetak Laporan Pemeliharaan</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <form action="{{ route('pemeliharaan.laporan') }}" method="POST" id="formCetakLaporan" target="_blank">
                @csrf
                <div class="modal-body p-4" style="background-color: #ffffff;">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-600">Bulan<span style="color: red;">*</span></label>
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
                            <label class="form-label fw-600">Tahun<span style="color: red;">*</span></label>
                            <select name="tahun" class="form-select custom-input" required>
                                <option value="" selected disabled>Pilih Tahun</option>
                                @for($i = date('Y'); $i >= date('Y') - 5; $i--)
                                    <option value="{{ $i }}">{{ $i }}</option>
                                @endfor
                            </select>
                        </div>
                        <div class="col-12 text-center text-muted mt-3">
                            <small>Laporan akan merekap semua data pemeliharaan yang telah <b>Selesai</b> atau <b>Berjalan</b> pada periode yang dipilih.</small>
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
        const tambahForm = document.getElementById('formTambahPemeliharaan');

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
        const editForm = document.getElementById('formEditPemeliharaan');

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
    document.addEventListener('DOMContentLoaded', function () {
        // Tangkap modalnya
        var modalEditPemeliharaan = document.getElementById('modalEditPemeliharaan');
        
        // Ketika modal akan ditampilkan
        modalEditPemeliharaan.addEventListener('show.bs.modal', function (event) {
            // Tombol yang men-trigger modal
            var button = event.relatedTarget;
            
            // Ambil data dari atribut data-* di tombol
            var url = button.getAttribute('data-url');
            var id = button.getAttribute('data-id');
            var nama = button.getAttribute('data-nama');
            var status = button.getAttribute('data-status');
            var biaya = button.getAttribute('data-biaya');
            var jenis = button.getAttribute('data-jenis');
            var jumlah = button.getAttribute('data-jumlah');
            var tglMulai = button.getAttribute('data-mulai');
            var tglSelesai = button.getAttribute('data-selesai');
            var keterangan = button.getAttribute('data-keterangan');
            
            // Update URL action form
            var form = document.getElementById('formEditPemeliharaan');
            form.action = url;
            
            // Isi nilai inputan di dalam modal
            modalEditPemeliharaan.querySelector('input[name="id_pemeliharaan"]').value = id;
            modalEditPemeliharaan.querySelector('select[name="nama_pemeliharaan"]').value = nama;
            modalEditPemeliharaan.querySelector('select[name="status_pemeliharaan"]').value = status;
            modalEditPemeliharaan.querySelector('input[name="biaya_pemeliharaan"]').value = biaya;
            modalEditPemeliharaan.querySelector('select[name="jenis_pemeliharaan"]').value = jenis;
            modalEditPemeliharaan.querySelector('input[name="jumlah_pemeliharaan"]').value = jumlah;
            modalEditPemeliharaan.querySelector('input[name="tglMulai_pemeliharaan"]').value = tglMulai;
            modalEditPemeliharaan.querySelector('input[name="tglSelesai_pemeliharaan"]').value = tglSelesai;
            modalEditPemeliharaan.querySelector('textarea[name="keterangan_pemeliharaan"]').value = keterangan;
        });
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const searchInput = document.getElementById('searchInput');
        let searchTimer;

        if (searchInput) {
            searchInput.addEventListener('input', function () {
                clearTimeout(searchTimer);
                const searchVal = this.value;

                searchTimer = setTimeout(() => {
                    const baseUrl = window.location.origin + window.location.pathname;
                    const fetchUrl = searchVal ? `${baseUrl}?search=${encodeURIComponent(searchVal)}` : baseUrl;

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
                        const newTbody = doc.querySelector('.table-pemeliharaan tbody');
                        const currentTbody = document.querySelector('.table-pemeliharaan tbody');
                        
                        if (newTbody && currentTbody) {
                            // Ganti isi tbody saat ini dengan yang baru
                            currentTbody.innerHTML = newTbody.innerHTML;
                        }
                    })
                    .catch(err => console.error('Gagal memuat hasil pencarian:', err));
                }, 300); // Timeout 300ms
            });
        }
    });
</script>

@endsection