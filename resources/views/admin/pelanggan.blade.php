@extends('admin.sidebar')

@section('title', 'Pelanggan | House of Legacy')

@push('styles')
    <style>
        /* --- Halaman Data Pelanggan --- */
        .pelanggan-title {
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
        .table-pelanggan {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
        }

        .table-pelanggan th {
            background-color: #fcf8f5;
            color: #612713;
            font-weight: 700;
            padding: 16px;
            border-bottom: 2px solid #f0e6e1;
            text-align: left;
        }

        .table-pelanggan th:first-child {
            border-top-left-radius: 10px;
        }

        .table-pelanggan th:last-child {
            border-top-right-radius: 10px;
            text-align: center;
        }

        .table-pelanggan td {
            padding: 16px;
            vertical-align: middle;
            color: #444;
            border-bottom: 1px solid #f0f0f0;
            transition: background-color 0.2s ease;
        }

        .table-pelanggan tbody tr:hover td {
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

        .btn-edit:hover {
            background-color: #6B240D;
            color: white;
        }

        .btn-delete {
            background-color: #ffebee;
            color: #dc3545;
        }

        .btn-delete:hover {
            background-color: #dc3545;
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
            box-shadow: 0 0 0 0.25 margin-left: rgba(153, 77, 28, 0.1);
        }

        .fw-600 {
            font-weight: 600;
            color: #333;
        }
    </style>
@endpush

@section('content')
    <h1 class="pelanggan-title">Data Pelanggan</h1>

    <div class="data-card">
        <div class="table-toolbar">
            <button class="btn-tambah" data-bs-toggle="modal" data-bs-target="#modalTambahPelanggan">
                <i class="fa-solid fa-plus"></i> Tambah Pelanggan
            </button>

            <div class="search-box">
                <i class="fa-solid fa-magnifying-glass"></i>
                <input type="text" id="searchInput" placeholder="Cari..." value="{{ request('search') }}">
            </div>
        </div>

        <!-- TABEL DATA PELANGGAN -->
        <div class="table-responsive">
            <table class="table-pelanggan">
                <thead>
                    <tr>
                        <th width="5%">No</th>
                        <th width="20%">Nama Pelanggan</th>
                        <th width="15%">Email</th>
                        <th width="15%">Telepon</th>
                        <th width="20%">Alamat</th>
                        <th width="15%">Edit</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pelanggan->sortByDesc('updated_at') as $index => $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td style="font-weight: 600; color: #612713;">{{ $item->name }}</td>
                            <td>{{ $item->email }}</td>
                            <td>{{ $item->phone }}</td>
                            <td>{{ $item->address }}</td>
                            <td>
                                <div class="action-btns">
                                    <button class="btn-action btn-edit" data-bs-toggle="modal"
                                        data-bs-target="#modalEditPelanggan" data-id="{{ $item->id }}"
                                        data-url="{{ route('pelanggan.update', $item->id) }}" data-name="{{ $item->name }}"
                                        data-email="{{ $item->email }}" data-phone="{{ $item->phone }}"
                                        data-address="{{ $item->address }}" data-avatar="{{ $item->avatar }}"
                                        data-role="{{ $item->role }}" data-status="{{ $item->status }}">
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
                                    <h5 class="fw-bold" style="color: #a0a0a0;">Belum Ada Data Pelanggan</h5>
                                    <p class="text-muted" style="font-size: 0.9rem;">
                                        Klik tombol "Tambah Pelanggan" di atas untuk menambahkan data baru.
                                    </p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- MODAL TAMBAH pelanggan -->
    <div class="modal fade" id="modalTambahPelanggan" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content" style="border-radius: 16px; border: none; overflow: hidden;">
                <div class="modal-header text-white" style="background-color: #612713; border: none; padding: 20px;">
                    <h5 class="modal-title w-100 text-center fw-bold" style="font-size: 1.5rem;">Tambah Pelanggan</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>

                <form action="{{ route('pelanggan.store') }}" method="POST" id="formTambahPelanggan"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body p-4" style="background-color: #ffffff;">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label fw-600">Nama<span style="color: red;">*</span></label>
                                <input type="text" name="name" class="form-control custom-input"
                                    placeholder="Masukkan nama pelanggan" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-600">Email<span style="color: red;">*</span></label>
                                <input type="email" name="email" class="form-control custom-input"
                                    placeholder="Contoh: username@gmail.com" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-600">Foto<span style="color: red;">*</span></label>
                                <input type="file" name="avatar" class="form-control custom-input" accept="image/*"
                                    required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-600">Telepon<span style="color: red;">*</span></label>
                                <input type="text" name="phone" class="form-control custom-input"
                                    placeholder="Contoh: 08123456789" required>
                            </div>
                            <div class="col-12">
                                <label class="form-label fw-600">Alamat<span style="color: red;">*</span></label>
                                <textarea name="address" class="form-control custom-input" rows="3"
                                    placeholder="Tambahkan alamat pelanggan..." required></textarea>
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

    <!-- MODAL EDIT PELANGGAN -->
    <div class="modal fade" id="modalEditPelanggan" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content" style="border-radius: 16px; border: none; overflow: hidden;">
                <div class="modal-header text-white" style="background-color: #612713; border: none; padding: 20px;">
                    <h5 class="modal-title w-100 text-center fw-bold" style="font-size: 1.5rem;">Edit Pelanggan</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>

                <form method="POST" id="formEditPelanggan" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body p-4" style="background-color: #ffffff;">
                        <div class="row g-3">
                            <input type="hidden" id="id" name="id">
                            <div class="col-md-6">
                                <label class="form-label fw-600">Nama<span style="color: red;">*</span></label>
                                <input type="text" name="name" class="form-control custom-input" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-600">Email<span style="color: red;">*</span></label>
                                <input type="email" name="email" class="form-control custom-input" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-600">Foto <a href="javascript:void(0)"
                                        id="linkPreviewFotoPelanggan" class="text-secondary text-decoration-underline ms-2"
                                        style="font-size: 0.85rem; display: none;">Lihat Foto</a></label>
                                <input type="file" name="avatar" class="form-control custom-input" accept="image/*">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-600">Telepon<span style="color: red;">*</span></label>
                                <input type="text" name="phone" class="form-control custom-input" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-600">Status<span style="color: red;">*</span></label>
                                <select name="status" class="form-select custom-input" required>
                                    <option value="" selected disabled>Pilih Status</option>
                                    <option value="Aktif">Aktif</option>
                                    <option value="Berakhir">Berakhir</option>
                                </select>
                                <div style="font-size: 13px; color:grey;">Jika status "Berakhir", data tidak akan tampil.
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-600">Role</label>
                                <input type="text" name="role" class="form-control custom-input">
                                <div style="font-size: 13px; color:grey;">Jika role terisi, maka user menjadi Karyawan.
                                </div>
                            </div>
                            <div class="col-12">
                                <label class="form-label fw-600">Alamat<span style="color: red;">*</span></label>
                                <textarea name="address" class="form-control custom-input" rows="3" required></textarea>
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

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const tambahForm = document.getElementById('formTambahPelanggan');

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
            const editForm = document.getElementById('formEditPelanggan');

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
            var modalEditPelanggan = document.getElementById('modalEditPelanggan');

            // Ketika modal akan ditampilkan
            modalEditPelanggan.addEventListener('show.bs.modal', function (event) {
                // Tombol yang men-trigger modal
                var button = event.relatedTarget;

                // Ambil data dari atribut data-* di tombol
                var url = button.getAttribute('data-url');
                var id = button.getAttribute('data-id');
                var name = button.getAttribute('data-name');
                var status = button.getAttribute('data-status');
                var email = button.getAttribute('data-email');
                var phone = button.getAttribute('data-phone');
                var role = button.getAttribute('data-role');
                var address = button.getAttribute('data-address');

                // Update URL action form
                var form = document.getElementById('formEditPelanggan');
                form.action = url;

                // Isi nilai inputan di dalam modal
                modalEditPelanggan.querySelector('input[name="id"]').value = id;
                modalEditPelanggan.querySelector('input[name="name"]').value = name;
                modalEditPelanggan.querySelector('select[name="status"]').value = status;
                modalEditPelanggan.querySelector('input[name="email"]').value = email;
                modalEditPelanggan.querySelector('input[name="phone"]').value = phone;
                modalEditPelanggan.querySelector('input[name="role"]').value = role;
                modalEditPelanggan.querySelector('textarea[name="address"]').value = address;

                var avatar = button.getAttribute('data-avatar');
                var previewLink = modalEditPelanggan.querySelector('#linkPreviewFotoPelanggan');

                if (avatar) {
                    var photoUrl = avatar.startsWith('http') ? avatar : "{{ asset('uploads/user/') }}/" + avatar;
                    previewLink.style.display = 'inline-block';
                    previewLink.onclick = function () {
                        Swal.fire({
                            imageUrl: photoUrl,
                            imageAlt: 'Preview Foto',
                            showCloseButton: true,
                            showConfirmButton: false,
                            customClass: {
                                image: 'img-fluid rounded'
                            }
                        });
                    };
                } else {
                    previewLink.style.display = 'none';
                    previewLink.onclick = null;
                }
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
                        window.history.pushState({ path: fetchUrl }, '', fetchUrl);

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
                                const newTbody = doc.querySelector('.table-pelanggan tbody');
                                const currentTbody = document.querySelector('.table-pelanggan tbody');

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