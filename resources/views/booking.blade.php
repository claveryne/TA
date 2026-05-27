@extends('bar')

@section('title', 'House of Legacy')

@push('styles')
<style>
    /* --- Booking Section --- */
    /* --- Modern Booking Section --- */
    .booking-section {
        background-color: var(--color-light);
        position: relative;
    }
    .modern-booking-card {
        background: #ffffff;
        border-radius: 20px;
        padding: 40px;
        box-shadow: 0 15px 35px rgba(107, 36, 13, 0.05);
        border: 1px solid rgba(107, 36, 13, 0.05);
    }
    .modern-booking-card h4 {
        color: var(--color-primary);
        font-weight: 700;
        margin-bottom: 25px;
        font-size: 1.4rem;
        position: relative;
        padding-bottom: 10px;
        font-family: 'CMG Sans', sans-serif;
    }
    .modern-booking-card h4::after {
        content: '';
        position: absolute;
        left: 0;
        bottom: 0;
        height: 3px;
        width: 40px;
        background-color: var(--color-secondary);
        border-radius: 2px;
    }
    .modern-input {
        background-color: #FDF9F5;
        border: 1px solid rgba(107, 36, 13, 0.1);
        border-radius: 12px;
        padding: 14px 18px;
        color: var(--color-primary);
        font-size: 0.95rem;
        width: 100%;
        transition: all 0.3s ease;
    }
    .modern-input:focus {
        outline: none;
        background-color: #FFFFFF;
        border-color: var(--color-secondary);
        box-shadow: 0 0 0 4px rgba(245, 204, 160, 0.3);
    }
    .modern-input::placeholder {
        color: rgba(107, 36, 13, 0.4);
    }
    .modern-label {
        font-weight: 600;
        font-size: 0.85rem;
        color: rgba(107, 36, 13, 0.85);
        margin-bottom: 8px;
        display: block;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    .modern-btn {
        background: linear-gradient(135deg, var(--color-primary), #4A1707);
        color: var(--color-light);
        border: none;
        border-radius: 12px;
        padding: 14px 28px;
        font-weight: 600;
        font-size: 1rem;
        transition: all 0.3s ease;
        box-shadow: 0 8px 20px rgba(107, 36, 13, 0.2);
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }
    .modern-btn:hover {
        transform: translateY(-3px);
        box-shadow: 0 12px 25px rgba(107, 36, 13, 0.3);
        color: var(--color-secondary);
    }
        /* --- Facility Checkbox Pills --- */
    .facility-pill-wrapper {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
    }
    .facility-checkbox {
        display: none;
    }
    .facility-pill {
        display: inline-block;
        background-color: #FDF9F5;
        border: 1px solid rgba(107, 36, 13, 0.1);
        color: var(--color-primary);
        padding: 10px 18px;
        border-radius: 50px;
        font-size: 0.85rem;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.3s ease;
        user-select: none;
    }
    .facility-checkbox:checked + .facility-pill {
        background-color: var(--color-primary);
        color: var(--color-light);
        border-color: var(--color-primary);
        box-shadow: 0 4px 10px rgba(107, 36, 13, 0.2);
        transform: translateY(-2px);
    }
    .facility-pill:hover {
        border-color: var(--color-secondary);
        background-color: #ffffff;
    }

    .modern-calendar-box {
        background: linear-gradient(145deg, var(--color-secondary2), #3b1304);
        border-radius: 20px;
        padding: 40px;
        color: #ffffff;
        height: 100%;
        display: flex;
        flex-direction: column;
        box-shadow: 0 15px 35px rgba(107, 36, 13, 0.2);
        position: relative;
        overflow: hidden;
    }
    .modern-calendar-box::before {
        content: '';
        position: absolute;
        top: -50px;
        right: -50px;
        width: 250px;
        height: 250px;
        background: radial-gradient(circle, rgba(245, 204, 160, 0.15) 0%, rgba(245, 204, 160, 0) 70%);
        border-radius: 50%;
    }
    .calendar-mockup-modern {
        background: rgba(255, 255, 255, 0.05);
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-direction: column;
        text-align: center;
        backdrop-filter: blur(10px);
        padding: 30px;
        z-index: 1;
    }
    .calendar-mockup-modern i {
        color: var(--color-secondary);
        margin-bottom: 20px;
    }
    .calendar-mockup-modern h5 {
        color: #ffffff;
        font-weight: 600;
        margin-bottom: 10px;
        font-family: 'CMG Sans', serif;
    }
    .calendar-mockup-modern p {
        color: rgba(253, 246, 238, 0.8);
        font-size: 0.9rem;
        line-height: 1.6;
    }
</style>
@endpush

@section('content')
<!-- Booking Sekarang -->
<section id="booking" class="section-padding booking-section">
    <div class="container">
        <h2 class="section-title">Booking Sekarang</h2>
        @if(Auth::check())
            <p class="section-subtitle mb-0">Silahkan <a href="{{ route('profile') }}" 
                style="font-weight: bold; text-decoration: underline; color: var(--color-primary);">Login</a> 
                untuk melihat histori data pemesanan Anda.</p>
        @else
            <p class="section-subtitle mb-0">Silahkan <a href="{{ route('login') }}" 
                style="font-weight: bold; text-decoration: underline; color: var(--color-primary);">Login</a> 
                untuk melihat histori data pemesanan Anda.</p>
        @endif
        
        <div class="row g-4 mt-2">
            <!-- Top: Calendar Info Box -->
            <div class="col-12">
                <div class="modern-calendar-box" style="padding: 30px; min-height: 280px; text-align: center;">
                    <h3 class="mb-3" style="font-family: 'CMG Sans', serif; font-weight: 700; position: relative; z-index: 1;">
                        Jadwal Booking
                    </h3>
                    <p style="color: rgba(255,255,255,0.8); margin-bottom: 25px; position: relative; z-index: 1; 
                            font-size: 0.95rem; line-height: 1.6; max-width: 800px; margin-left: auto; margin-right: auto;">
                        Kalender booking untuk mengecek ketersediaan seluruh ruangan secara mandiri dan real-time.
                    </p>

                    
                    <div id="calendar" class="mx-auto" style="max-width: 1500px; background: #FDF9F5; padding: 20px; 
                            border-radius: 16px; color: #333; text-align: left;"></div>
                </div>
            </div>
    
            <!-- Bottom: Form Input -->
            <div class="col-12">
                <div class="modern-booking-card">
                    <form action="{{ route('booking.store') }}" method="POST" class="booking-form">
                        @csrf
                        @if(!Auth::check())
                            <h4>Informasi Pemesan</h4>
                            <div class="row g-3 mb-4">
                                <div class="col-md-6">
                                    <label class="modern-label">Nama Lengkap<span class="text-danger">*</span></label>
                                    <input type="text" name="nama_pemesan" class="modern-input" placeholder="Mis. Budi Santoso" value="{{ old('nama_pemesan') }}" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="modern-label">Nomor Telepon<span class="text-danger">*</span></label>
                                    <input type="tel" name="telp_pemesan" class="modern-input" placeholder="08xxxxxxxxxx" value="{{ old('telp_pemesan') }}" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="modern-label">Email Aktif<span class="text-danger">*</span></label>
                                    <input type="email" name="email_pemesan" class="modern-input" placeholder="email@contoh.com" value="{{ old('email_pemesan') }}" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="modern-label">Alamat Lengkap<span class="text-danger">*</span></label>
                                    <input type="text" name="alamat_pemesan" class="modern-input" placeholder="Alamat domisili atau instansi..." value="{{ old('alamat_pemesan') }}" required>
                                </div>
                            </div>
                        @else
                            <input type="hidden" name="nama_pemesan" value="{{ Auth::user()->name }}">
                            <input type="hidden" name="telp_pemesan" value="{{ Auth::user()->phone ?? '-' }}">
                            <input type="hidden" name="email_pemesan" value="{{ Auth::user()->email }}">
                            <input type="hidden" name="alamat_pemesan" value="{{ Auth::user()->address ?? '-' }}">
                        @endif

                        <h4>Detail Reservasi</h4>
                        <div class="row g-3">
                            <div class="col-md-12">
                                <label class="modern-label">Instansi - Acara<span class="text-danger">*</span></label>
                                <input type="text" name="nama_acara" class="modern-input" placeholder="Nama Instansi - Nama Acara" value="{{ old('nama_acara') }}" required>
                            </div>
                            <div class="col-md-6">
                                <label class="modern-label">Jumlah Orang<span class="text-danger">*</span></label>
                                <input type="number" name="jumlah_orang" class="modern-input" placeholder="Kapasitas" value="{{ old('jumlah_orang') }}" required>
                            </div>
                            <div class="col-md-6">
                                <label class="modern-label">Pilih Ruangan<span class="text-danger">*</span></label>
                                <select name="id_ruangan" class="modern-input form-select" style="cursor: pointer;" required>
                                    <option value="" selected disabled>Pilih opsi...</option>
                                    @foreach($ruangans as $ruangan)
                                        <option value="{{ $ruangan->id_ruangan }}" data-nama="{{ $ruangan->nama_ruangan }}" {{ old('id_ruangan') == $ruangan->id_ruangan ? 'selected' : '' }}>{{ $ruangan->nama_ruangan }} - {{ $ruangan->kapasitas_ruangan }} orang</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="modern-label">Waktu Mulai<span class="text-danger">*</span></label>
                                <input type="datetime-local" name="tgl_mulai" placeholder="Pilih Tanggal dan Jam" class="modern-input" value="{{ old('tgl_mulai') }}" required>
                            </div>
                            <div class="col-md-6">
                                <label class="modern-label">Waktu Selesai<span class="text-danger">*</span>
                                    <small style="margin-left: 10px; color: #9e9e9e;">Minimal 1 Jam</small></label>
                                <input type="datetime-local" name="tgl_selesai" placeholder="Pilih Tanggal dan Jam" class="modern-input" value="{{ old('tgl_selesai') }}" required>
                            </div>
                            <div class="col-12 mt-4">
                                <label class="modern-label mb-3">Fasilitas Tambahan (Opsional)</label>
                                <div class="row g-4">
                                    @php
                                        $icons = [
                                            'Multimedia' => 'fa-desktop',
                                            'Sound System' => 'fa-microphone',
                                            'Stage Lighting' => 'fa-lightbulb',
                                            'Lighting' => 'fa-lightbulb',
                                            'Alat Musik' => 'fa-guitar',
                                            'Meja & Kursi' => 'fa-chair',
                                            'Umum' => 'fa-chair',
                                            'Ruangan' => 'fa-door-open',
                                            'Ruangan VIP' => 'fa-door-open'
                                        ];
                                    @endphp
                                    @foreach($fasilitas as $jenis => $items)
                                        @php
                                            $safe_jenis = Str::slug($jenis);
                                            $icon = $icons[$jenis] ?? 'fa-check';
                                        @endphp
                                        <div class="col-md-4 col-sm-6 group-facility-container" id="group-facility-{{ $safe_jenis }}" data-jenis="{{ $safe_jenis }}">
                                            <div class="facility-group">
                                                <input type="checkbox" id="cat_{{ $safe_jenis }}" class="facility-checkbox parent-checkbox" 
                                                    data-target=".child-{{ $safe_jenis }}"
                                                    {{ is_array(old('fasilitas')) && count(array_intersect($items->pluck('id_fasilitas')->toArray(), old('fasilitas'))) == count($items) ? 'checked' : '' }}>
                                                <label for="cat_{{ $safe_jenis }}" class="facility-pill w-100 text-start mb-2"><i 
                                                    class="fa-solid {{ $icon }} me-2"></i>{{ $jenis }}</label>
                                                <div class="child-facilities ms-3 border-start ps-3 mt-1">
                                                    @foreach($items as $item)
                                                        <div class="form-check mb-1 d-flex align-items-center facility-item-row" data-nama-fasilitas="{{ $item->nama_fasilitas }}">
                                                            <div>
                                                                <input class="form-check-input child-checkbox child-{{ $safe_jenis }}" 
                                                                    name="fasilitas[]" type="checkbox" value="{{ $item->id_fasilitas }}" 
                                                                    id="item_{{ $item->id_fasilitas }}" data-parent="#cat_{{ $safe_jenis }}"
                                                                    {{ is_array(old('fasilitas')) && in_array($item->id_fasilitas, old('fasilitas')) ? 'checked' : '' }}>
                                                                <label class="form-check-label text-muted" style="font-size: 0.85rem;" 
                                                                        for="item_{{ $item->id_fasilitas }}">
                                                                    {{ $item->nama_fasilitas }}
                                                                    @if($item->jumlah_fasilitas > 1)
                                                                        <span style="font-size: 0.75rem; opacity: 0.8;">(Tersedia: {{ $item->jumlah_fasilitas }})</span>
                                                                    @endif
                                                                </label>
                                                            </div>
                                                            @if($item->jumlah_fasilitas > 1)
                                                                <input type="number" name="qty_fasilitas[{{ $item->id_fasilitas }}]" 
                                                                    class="form-control form-control-sm ms-auto qty-input-field" 
                                                                    style="width: 70px; padding: 0.2rem 0.5rem; font-size: 0.8rem;" 
                                                                    min="1" max="{{ $item->jumlah_fasilitas }}" 
                                                                    placeholder="Jml" value="{{ old('qty_fasilitas.' . $item->id_fasilitas, 1) }}">
                                                            @endif
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="col-12 mt-4">
                                <label class="modern-label">Catatan</label>
                                <textarea name="keterangan_pemesanan" class="modern-input" rows="3" style="resize: none;" 
                                    placeholder="Permintaan khusus lainnya...">{{ old('keterangan_pemesanan') }}</textarea>
                            </div>
                        </div>

                        <div class="mt-4 pt-4 d-flex flex-column flex-md-row justify-content-between align-items-center gap-3 border-top" 
                            style="border-top-color: rgba(107,36,13,0.1) !important;">
                            <p class="mb-0 text-muted" style="font-size: 0.85rem; max-width: 500px; line-height: 1.5;">
                                <i class="fa-solid fa-circle-info me-1" style="color: var(--color-primary);"></i> 
                                    Mohon cek <strong>notifikasi email</strong> untuk update status booking Anda.
                            </p>
                            <button type="submit" class="modern-btn mt-2 mt-md-0 w-50 w-md-auto">
                                Kirim Jadwal Booking
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');
        var calendar = new FullCalendar.Calendar(calendarEl, {
            locale: 'id',
            initialView: 'dayGridMonth',
            events: @json($events),
            height: 'auto',
            headerToolbar: {
                left: 'prev,next',
                center: 'title',
                right: 'today',
            },
            eventTimeFormat: {
                hour: '2-digit',
                minute: '2-digit',
                hour12: false
            }
        });
        calendar.render();

        // Parent checkbox state synchronization
        document.querySelectorAll('.parent-checkbox').forEach(function(parent) {
            parent.addEventListener('change', function() {
                const isChecked = this.checked;
                const targetSelector = this.getAttribute('data-target');
                const children = document.querySelectorAll(targetSelector);
                
                children.forEach(function(child) {
                    child.checked = isChecked;
                });
            });
        });

        // Child checkbox state synchronization
        document.querySelectorAll('.child-checkbox').forEach(function(child) {
            child.addEventListener('change', function() {
                const parentSelector = this.getAttribute('data-parent');
                const parent = document.querySelector(parentSelector);
                const targetClass = parent.getAttribute('data-target');
                const siblings = document.querySelectorAll(targetClass);
                
                let allChecked = true;
                let someChecked = false;
                
                siblings.forEach(function(sib) {
                    if (sib.checked) {
                        someChecked = true;
                    } else {
                        allChecked = false;
                    }
                });
                
                parent.checked = allChecked;
                if (someChecked && !allChecked) {
                    parent.indeterminate = true;
                } else {
                    parent.indeterminate = false;
                }
            });
        });

        // AJAX form submission
        document.querySelectorAll('.booking-form').forEach(function(form) {
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                
                Swal.fire({
                    title: 'Mengirim...',
                    text: 'Mohon tunggu sebentar',
                    didOpen: () => Swal.showLoading(),
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    showConfirmButton: false
                });

                let formData = new FormData(form);

                fetch(form.action, {
                    method: 'POST',
                    headers: {
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: formData
                })
                .then(response => response.json().then(data => ({ status: response.status, body: data })))
                .then(res => {
                    if (res.body.success) {
                        Swal.fire({
                            title: 'Berhasil!',
                            text: res.body.message,
                            icon: 'success',
                            confirmButtonColor: '#6B240D'
                        }).then(() => {
                            window.location.reload();
                        });
                    } else {
                        let errorMsg = res.body.message || 'Terjadi kesalahan.';
                        if (res.body.errors && Array.isArray(res.body.errors)) {
                            errorMsg = res.body.errors.join('<br>');
                        }
                        Swal.fire({
                            title: 'Gagal!',
                            html: errorMsg,
                            icon: 'error',
                            confirmButtonColor: '#6B240D'
                        });
                    }
                })
                .catch(err => {
                    Swal.fire({
                        title: 'Error!',
                        text: 'Terjadi kesalahan koneksi atau server.',
                        icon: 'error',
                        confirmButtonColor: '#6B240D'
                    });
                });
            });
        });

        // Room facilities filtering logic
        function updateRoomFacilities(form) {
            const selectRoom = form.querySelector('select[name="id_ruangan"]');
            if (!selectRoom) return;

            const selectedOption = selectRoom.options[selectRoom.selectedIndex];
            const selectedRoomName = selectedOption ? (selectedOption.getAttribute('data-nama') || '').toLowerCase() : '';

            const groupContainer = form.querySelector('#group-facility-ruangan');
            if (!groupContainer) return;

            const itemRows = groupContainer.querySelectorAll('.facility-item-row');
            
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
                    const checkbox = row.querySelector('.child-checkbox, input[type="checkbox"]');
                    if (checkbox && checkbox.checked) {
                        checkbox.checked = false;
                        checkbox.dispatchEvent(new Event('change'));
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
                const parentCheckbox = groupContainer.querySelector('.parent-checkbox');
                if (parentCheckbox && parentCheckbox.checked) {
                    parentCheckbox.checked = false;
                }
            }
        }

        document.querySelectorAll('.booking-form').forEach(function(form) {
            const selectRoom = form.querySelector('select[name="id_ruangan"]');
            if (selectRoom) {
                selectRoom.addEventListener('change', function() {
                    updateRoomFacilities(form);
                });
                updateRoomFacilities(form);
            }
        });
    });
</script>
@endpush
