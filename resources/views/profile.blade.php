@extends('bar')

@section('title', 'Profile')

@push('styles')
    <style>
        /* --- Profile Section --- */
        .profile-section {
            padding: 80px 0;
            background-color: var(--color-light);
            min-height: 70vh;
        }

        .profile-card {
            background-color: #ffffff;
            border-radius: 20px;
            padding: 40px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            border: 1px solid rgba(107, 36, 13, 0.05);
        }

        .profile-info .info-item {
            display: flex;
            align-items: center;
            padding: 15px 0;
            border-bottom: 1px solid #f0f0f0;
        }

        .profile-info .info-item:last-child {
            border-bottom: none;
        }

        .profile-info .info-item i {
            font-size: 1.2rem;
            color: #994D1C;
            width: 30px;
        }

        .profile-info .info-item .label {
            font-size: 0.85rem;
            color: #666;
            display: block;
            margin-bottom: 2px;
        }

        .profile-info .info-item .value {
            font-size: 1rem;
            font-weight: 600;
            color: var(--color-primary);
        }

        .edit-btn {
            background-color: transparent;
            color: var(--color-primary);
            border: 2px solid var(--color-primary);
            border-radius: 12px;
            padding: 12px 26px;
            /* Dikurangi 2px dari sebelumnya untuk mengimbangi ketebalan border */
            font-weight: 600;
            font-size: 1rem;
            transition: all 0.3s ease;
            box-shadow: 0 8px 20px rgba(153, 77, 28, 0.15);
            /* Disesuaikan agar senada dengan warna #994D1C */
        }

        .edit-btn:hover {
            background-color: var(--color-primary);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 12px 25px rgba(153, 77, 28, 0.3);
        }

        .pindah-btn {
            background-color: var(--color-primary);
            color: white;
            border: none;
            border-radius: 12px;
            padding: 14px 28px;
            font-weight: 600;
            font-size: 1rem;
            transition: all 0.3s ease;
            box-shadow: 0 8px 20px rgba(220, 53, 69, 0.2);
        }

        .pindah-btn:hover {
            background-color: #5e200bff;
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 12px 25px rgba(220, 53, 69, 0.3);
        }

        .logout-btn {
            background-color: transparent;
            color: #dc3545;
            border: 2px solid #dc3545;
            border-radius: 12px;
            padding: 12px 26px;
            font-weight: 600;
            font-size: 1rem;
            transition: all 0.3s ease;
            box-shadow: 0 8px 20px rgba(220, 53, 69, 0.15);
        }

        .logout-btn:hover {
            background-color: #dc3545;
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 12px 25px rgba(220, 53, 69, 0.3);
        }
    </style>
@endpush

@section('content')
    <!-- Profile Section -->
    <section class="profile-section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <div class="profile-card p-4 shadow-sm">
                        <div class="avatar text-center mb-4">
                            @if(Auth::user()->avatar)
                                @if(filter_var(Auth::user()->avatar, FILTER_VALIDATE_URL))
                                    <img src="{{ Auth::user()->avatar }}" 
                                        alt="{{ Auth::user()->name }}" 
                                        style="width: 120px; height: 120px; object-fit: cover; border-radius: 50%;">
                                @else
                                    <img src="{{ asset('uploads/user/' . Auth::user()->avatar) }}"
                                        alt="{{ Auth::user()->name }}"
                                        style="width: 120px; height: 120px; object-fit: cover; border-radius: 50%;">
                                @endif
                            @else
                                <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=random&color=fff&size=120"
                                    alt="Default Avatar" class="rounded-circle shadow-sm"
                                    style="width: 120px; height: 120px; object-fit: cover; border-radius: 50%;">
                            @endif
                        </div>

                        <div class="profile-info mb-4">
                            <div class="row">
                                <div class="col-md-6 pe-md-4">
                                    <div class="info-item">
                                        <i class="fa-regular fa-user me-2"></i>
                                        <div class="d-inline-block">
                                            <span class="label">Nama Lengkap</span>
                                            <span class="value">{{ Auth::user()->name }}</span>
                                        </div>
                                    </div>
                                    <div class="info-item">
                                        <i class="fa-solid fa-phone me-2"></i>
                                        <div class="d-inline-block">
                                            <span class="label">Nomor Telepon</span>
                                            <span class="value">{{ Auth::user()->phone ?? '-' }}</span>
                                        </div>
                                    </div>
                                    <div class="info-item">
                                        <i class="fa-regular fa-envelope me-2"></i>
                                        <div class="d-inline-block">
                                            <span class="label">Email</span>
                                            <span class="value">{{ Auth::user()->email }}</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6 ps-md-4">
                                    <div class="info-item">
                                        <i class="fa-solid fa-location-dot me-2"></i>
                                        <div class="d-inline-block">
                                            <span class="label">Alamat Domisili</span>
                                            <span class="value">{{ Auth::user()->address ?? '-' }}</span>
                                        </div>
                                    </div>
                                    <div class="info-item">
                                        <i class="fa-solid fa-calendar-alt me-2"></i>
                                        <div class="d-inline-block">
                                            <span class="label">Bergabung Sejak</span>
                                            <span class="value">{{ Auth::user()->created_at->translatedFormat('d M Y') }}</span>
                                        </div>
                                    </div>
                                    <div class="info-item">
                                        <i class="fa-solid fa-calendar-alt me-2"></i>
                                        <div class="d-inline-block">
                                            <span class="label">Terakhir Diperbarui</span>
                                            <span class="value">{{ Auth::user()->updated_at->translatedFormat('d M Y H:i') }}
                                                WIB</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="alert alert-warning d-flex align-items-center mb-4" role="alert" style="border-radius: 12px; border: 1px solid #ffeeba;">
                            <i class="fa-solid fa-triangle-exclamation flex-shrink-0 me-3" style="font-size: 1.5rem;"></i>
                            <div>
                                Mohon lengkapi <strong>Nomor Telepon</strong> aktif Anda sebelum melakukan pemesanan.
                            </div>
                        </div>

                        <div class="row mt-2 g-3 justify-content-center">
                            <div class="col-12 col-md">
                                <button type="button" data-bs-toggle="modal" data-bs-target="#editProfileModal"
                                    class="btn edit-btn w-100 h-100 d-flex align-items-center justify-content-center py-2">
                                    <i class="fa-solid fa-pen-to-square me-2"></i>Edit Profile
                                </button>
                            </div>

                            @if(Auth::user()->role === 'Admin')
                                <div class="col-12 col-md">
                                    <a href="{{ route('dashboard') }}"
                                        class="btn pindah-btn w-100 h-100 d-flex align-items-center justify-content-center py-2">
                                        <i class="fa-solid fa-gauge-high me-2"></i>Tampilan Admin
                                    </a>
                                </div>
                            @endif

                            <div class="col-12 col-md">
                                <form method="POST" action="{{ route('logout') }}" class="m-0 h-100">
                                    @csrf
                                    <button type="submit"
                                        class="btn logout-btn w-100 h-100 d-flex align-items-center justify-content-center py-2">
                                        <i class="fa-solid fa-right-from-bracket me-2"></i>Logout
                                    </button>
                                </form>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Modal Edit Profile -->
    <div class="modal fade" id="editProfileModal" tabindex="-1" aria-labelledby="editProfileModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow" style="border-radius: 15px;">
                <div class="modal-header" style="background-color: var(--color-light); border-radius: 15px 15px 0 0; border-bottom: 2px solid rgba(153, 77, 28, 0.1);">
                    <h5 class="modal-title fw-bold" id="editProfileModalLabel" style="color: var(--color-primary);">Edit Profile</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('profile.update') }}" method="POST" id="formEditProfile" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body p-4">
                        <div class="mb-3 text-center">
                            @if(Auth::user()->avatar)
                                @if(filter_var(Auth::user()->avatar, FILTER_VALIDATE_URL))
                                    <img src="{{ Auth::user()->avatar }}" id="previewAvatar" alt="Preview" class="rounded-circle mb-3" style="width: 100px; height: 100px; object-fit: cover;">
                                @else
                                    <img src="{{ asset('uploads/user/' . Auth::user()->avatar) }}" id="previewAvatar" alt="Preview" class="rounded-circle mb-3" style="width: 100px; height: 100px; object-fit: cover;">
                                @endif
                            @else
                                <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=random&color=fff&size=100" id="previewAvatar" alt="Preview" class="rounded-circle mb-3 shadow-sm" style="width: 100px; height: 100px; object-fit: cover;">
                            @endif
                            <input class="form-control" type="file" id="avatar" name="avatar" accept="image/*" onchange="previewImage()">
                        </div>
                        <div class="mb-3">
                            <label for="name" class="form-label fw-bold">Nama Lengkap<span style="color: red;">*</span></label>
                            <input type="text" class="form-control" id="name" name="name" value="{{ Auth::user()->name }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="phone" class="form-label fw-bold">Nomor Telepon<span style="color: red;">*</span></label>
                            <input type="text" class="form-control" id="phone" name="phone" value="{{ Auth::user()->phone }}" oninput="this.value = this.value.replace(/[^0-9]/g, '');" required>
                        </div>
                        <div class="mb-1">
                            <label for="address" class="form-label fw-bold">Alamat Domisili<span style="color: red;">*</span></label>
                            <textarea class="form-control" id="address" name="address" rows="2" required>{{ Auth::user()->address }}</textarea>
                        </div>
                    </div>
                    <div class="modal-footer border-0 pb-4 pe-4">
                        <button type="submit" class="btn pindah-btn" style="padding: 8px 20px;">Simpan Perubahan</button>
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
    
    @push('scripts')
    <script>
        function previewImage() {
            const image = document.querySelector('#avatar');
            const imgPreview = document.querySelector('#previewAvatar');
            
            const oFReader = new FileReader();
            oFReader.readAsDataURL(image.files[0]);
            
            oFReader.onload = function(oFREvent) {
                imgPreview.src = oFREvent.target.result;
            }
        }
    </script>
    @endpush

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const editForm = document.getElementById('formEditProfile');

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
        });
    </script>
    
@endsection