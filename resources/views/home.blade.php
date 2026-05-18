@extends('bar')

@section('title', 'House of Legacy')

@push('styles')
<style>
    /* --- Hero Section --- */
    .hero-section {
        position: relative;
        background: url('{{ asset("images/crop.jpg") }}') center/cover no-repeat;
        height: 95vh;
        display: flex;
        align-items: center;
        justify-content: center;
        text-align: center;
        color: var(--color-text-light);
    }
    .hero-section::before {
        content: '';
        position: absolute;
        top: 0; left: 0; right: 0; bottom: 0;
        background: rgba(74, 43, 24, 0.7); /* Dark overlay matching primary color */
        z-index: 1;
    }
    .hero-content {
        position: relative;
        z-index: 2;
        max-width: 800px;
        padding: 20px;
    }
    .hero-content h1 {
        font-size: 4.5rem;
        margin-bottom: 20px;
        text-shadow: 2px 2px 8px rgba(0,0,0,0.5);
    }
    .hero-content p {
        font-size: 1.2rem;
        margin-bottom: 40px;
    }

    /* --- Tentang Kami --- */
    .tentang-kami-section {
        background-color: var(--color-secondary);
    }
    .tentang-text {
        text-align: center;
        max-width: 900px;
        margin: 0 auto 50px auto;
        line-height: 1.8;
        color: var(--color-primary);
        font-weight: 500;
        font-size: 1.1rem;
    }
    .feature-card {
        background: var(--color-light);
        border-radius: 12px;
        padding: 30px 20px;
        text-align: center;
        height: 100%;
        box-shadow: 0 5px 15px rgba(0,0,0,0.05);
        transition: transform 0.3s;
    }
    .feature-card:hover {
        transform: translateY(-10px);
    }
    .feature-icon {
        font-size: 3rem;
        color: var(--color-primary);
        margin-bottom: 20px;
    }
    .feature-card h4 {
        color: var(--color-primary);
        font-size: 1.2rem;
        margin-bottom: 15px;
    }
    .feature-card p {
        font-size: 0.9rem;
        color: var(--color-text-dark);
        margin-bottom: 0;
    }

    /* --- Video Tour --- */
    .video-tour-section {
        background-color: var(--color-light);
    }
    .video-container {
        position: relative;
        max-width: 900px;
        margin: 0 auto;
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 10px 30px rgba(0,0,0,0.15);
    }
    .video-container img {
        width: 100%;
        display: block;
    }
    .play-button {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 80px;
        height: 80px;
        background-color: rgba(255,255,255,0.8);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2rem;
        color: var(--color-primary);
        cursor: pointer;
        transition: all 0.3s;
    }
    .play-button:hover {
        background-color: var(--color-secondary);
        color: var(--color-light);
        transform: translate(-50%, -50%) scale(1.1);
    }

    /* --- Galeri Foto --- */
    .galeri-section {
        background-color: var(--color-light);
        padding-top: 0; /* Adjust spacing since it's same bg as video tour */
    }
    .galeri-item {
        border-radius: 10px;
        overflow: hidden;
        margin-bottom: 24px;
        box-shadow: 0 4px 10px rgba(0,0,0,0.1);
    }
    .galeri-item img {
        width: 100%;
        height: 250px;
        object-fit: cover;
        transition: transform 0.4s;
    }
    .galeri-item:hover img {
        transform: scale(1.1);
    }

    /* --- Pilihan Ruangan --- */
    .ruangan-section {
        background-color: var(--color-secondary);
    }
    .room-card {
        background-color: var(--color-primary);
        color: var(--color-light);
        border-radius: 15px;
        overflow: hidden;
        height: 100%;
        box-shadow: 0 10px 20px rgba(0,0,0,0.1);
    }
    .room-image {
        width: 100%;
        height: 250px;
        object-fit: cover;
    }
    .room-details {
        padding: 25px;
    }
    .room-title {
        color: var(--color-secondary);
        font-size: 1.5rem;
        margin-bottom: 15px;
    }
    .room-desc {
        font-size: 0.95rem;
        margin-bottom: 20px;
        line-height: 1.6;
        color: rgba(253, 246, 238, 0.9);
    }
    .room-tags {
        margin-bottom: 20px;
    }
    .room-tag {
        background-color: rgba(227, 185, 146, 0.2);
        padding: 5px 12px;
        border-radius: 20px;
        font-size: 0.8rem;
        margin-right: 5px;
        margin-bottom: 8px;
        display: inline-block;
        border: 1px solid rgba(227, 185, 146, 0.4);
    }

    /* --- Pilihan Fasilitas --- */
    .fasilitas-section {
        background-color: var(--color-secondary);
    }
    .fasilitas-card {
        display: flex;
        background-color: var(--color-primary);
        border-radius: 12px;
        overflow: hidden;
        margin-bottom: 20px;
        align-items: center;
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        height: calc(100% - 20px);
    }
    .fasilitas-img {
        width: 140px;
        height: 120px;
        object-fit: cover;
        border-right: 4px solid var(--color-secondary);
    }
    .fasilitas-info {
        padding: 15px 20px;
        flex-grow: 1;
    }
    .fasilitas-info h5 {
        color: var(--color-secondary);
        margin-bottom: 5px;
        font-size: 1.1rem;
    }
    .fasilitas-info p {
        color: rgba(253, 246, 238, 0.8);
        margin-bottom: 0;
        font-size: 0.85rem;
        line-height: 1.4;
    }

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
</style>
@endpush

@section('content')
<!-- Hero Section -->
<section class="hero-section">
    <div class="hero-content">
        <h1><strong>House of Legacy</strong></h1>
        <p>Pesona Elegan untuk Segala Acara Anda</p>
        <a href="#booking" class="modern-btn" style="text-decoration: none;">Booking Sekarang</a>
    </div>
</section>

<!-- Tentang Kami -->
<section id="about" class="section-padding tentang-kami-section">
    <div class="container">
        <h2 class="section-title">Tentang Kami</h2>
        <p class="tentang-text">
            Gedung serbaguna yang menghadirkan kenyamanan dalam setiap momen istimewa Anda. Dirancang dengan sentuhan modern dan fasilitas premium, tempat ini menjadi ruang sempurna untuk mewujudkan acara yang penuh makna.
        </p>
        
        <div class="row g-4">
            <div class="col-md-3 col-sm-6">
                <div class="feature-card">
                    <i class="fa-solid fa-computer feature-icon"></i>
                    <h4>Fasilitas Modern</h4>
                    <p>Dilengkapi dengan teknologi dan peralatan terkini untuk mendukung berbagai jenis acara Anda</p>
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="feature-card">
                    <i class="fa-solid fa-arrows-up-down-left-right feature-icon"></i>
                    <h4>Layout Dinamis</h4>
                    <p>Dapat mengubah posisi meja maupun kursi secara bebas sesuai kebutuhan acara Anda</p>
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="feature-card">
                    <i class="fa-solid fa-hand-holding-heart feature-icon"></i>
                    <h4>Pelayanan Penuh</h4>
                    <p>Didukung oleh Tim Profesional yang siap membantu Anda dalam menyelenggarakan berbagai acara</p>
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="feature-card">
                    <i class="fa-solid fa-clock feature-icon"></i>
                    <h4>Waktu Fleksibel</h4>
                    <p>Diberikan kendali penuh dalam menentukan tanggal dan jam sesuai kebutuhan acara Anda</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Video Tour Virtual -->
<section id="tour" class="section-padding video-tour-section">
    <div class="container">
        <h2 class="section-title">Video Tur Virtual</h2>
        <p class="section-subtitle">Menampilkan seluruh area gedung, ruangan, fasilitas, dan dokumentasi dari berbagai acara.</p>
        
        <div class="video-container">
            <!-- Video Element -->
            <video id="videoLegacy" width="100%" poster="{{ asset('images/crop.jpg') }}">
                <source src="{{ asset('videos/video legacy.mp4') }}" type="video/mp4">
                Browser Anda tidak mendukung pemutar video.
            </video>
            <!-- Custom Play Button -->
            <div class="play-button" onclick="let v = document.getElementById('videoLegacy'); v.play(); v.setAttribute('controls', 'controls'); this.style.display='none';">
                <i class="fa-solid fa-play"></i>
            </div>
        </div>
    </div>
</section>

<!-- Galeri Foto -->
<section class="section-padding galeri-section">
    <div class="container">
        <h2 class="section-title">Galeri Foto</h2>
        <p class="section-subtitle">Berbagai dokumentasi acara yang telah berhasil diselenggarakan di House of Legacy.</p>
        
        <div class="row g-4">
            <div class="col-md-4 col-sm-6">
                <div class="galeri-item">
                    <img src="{{ asset('images/IMG_0018.JPG') }}" alt="Event 1">
                </div>
            </div>
            <div class="col-md-4 col-sm-6">
                <div class="galeri-item">
                    <img src="{{ asset('images/foto terbaru 2.jpeg') }}" alt="Event 2">
                </div>
            </div>
            <div class="col-md-4 col-sm-6">
                <div class="galeri-item">
                    <img src="{{ asset('images/WhatsApp Image 2025-05-23 at 09.11.26 (1).jpeg') }}" alt="Event 3">
                </div>
            </div>
            <div class="col-md-4 col-sm-6">
                <div class="galeri-item">
                    <img src="{{ asset('images/IMG_9960.JPG') }}" alt="Event 4">
                </div>
            </div>
            <div class="col-md-4 col-sm-6">
                <div class="galeri-item">
                    <img src="{{ asset('images/WhatsApp Image 2024-06-02 at 19.26.56.jpeg') }}" alt="Event 5">
                </div>
            </div>
            <div class="col-md-4 col-sm-6">
                <div class="galeri-item">
                    <img src="{{ asset('images/moonbot 2.jpeg') }}" alt="Event 6">
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Pilihan Ruangan -->
<section id="ruangan" class="section-padding ruangan-section">
    <div class="container">
        <h2 class="section-title">Pilihan Ruangan</h2>
        <p class="section-subtitle" style="color:var(--color-primary)">Sesuaikan kebutuhan Anda dengan beragam pilihan ruangan elegan kami.</p>
        
        <div class="row g-4">
            <!-- Room 1 -->
            <div class="col-lg-4 col-md-6">
                <div class="room-card">
                    <img src="{{ asset('images/WhatsApp Image 2024-05-13 at 01.06.29.jpeg') }}" alt="Studio" class="room-image">
                    <div class="room-details">
                        <h3 class="room-title">Vyria</h3>
                        <p class="room-desc">Ruang medium dengan desain simple dan modern yang cocok digunakan untuk meeting maupun ruang transit.</p>
                        <div class="d-flex align-items-center mb-3" style="color: var(--color-secondary);">
                            <i class="fa-solid fa-people-group me-2"></i>
                            <span class="mb-0" style="font-weight: 500; padding-right: 30px;">11-30 orang</span>
                            <i class="fa-solid fa-ruler-combined me-2"></i>
                            <span class="mb-0" style="font-weight: 500;">32.5 m²</span>
                        </div>
                        <div class="room-tags">
                            <span class="room-tag"><i class="fa-solid fa-check"></i> AC</span>
                            <span class="room-tag"><i class="fa-solid fa-check"></i> Mic</span>
                            <span class="room-tag"><i class="fa-solid fa-check"></i> Meja</span>
                            <span class="room-tag"><i class="fa-solid fa-check"></i> Kursi</span>
                            <span class="room-tag"><i class="fa-solid fa-check"></i> Proyektor</span>
                            <span class="room-tag"><i class="fa-solid fa-check"></i> Layout</span>
                        </div>
                        <div class="text-end mt-4">
                            <a href="{{ route('facility') }}" class="text-decoration-none" style="color: #d5d5d5ff; font-weight: 500; font-size: 1.05rem;">
                                Lihat Detail <i class="fa-solid fa-arrow-right ms-1"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Room 2 -->
            <div class="col-lg-4 col-md-6">
                <div class="room-card">
                    <img src="{{ asset('images/WhatsApp Image 2024-05-08 at 2.19.54 PM(1).jpeg') }}" alt="Auditorium" class="room-image">
                    <div class="room-details">
                        <h3 class="room-title">Mahacitta Hall</h3>
                        <p class="room-desc">Ruang utama dengan fasilitas maksimal dan desain modern yang cocok untuk segala acara penuh makna.</p>
                        <div class="d-flex align-items-center mb-3" style="color: var(--color-secondary);">
                            <i class="fa-solid fa-people-group me-2"></i>
                            <span class="mb-0" style="font-weight: 500; padding-right: 30px;">200-250 orang</span>
                            <i class="fa-solid fa-ruler-combined me-2"></i>
                            <span class="mb-0" style="font-weight: 500;">200 m²</span>
                        </div>
                        <div class="room-tags">
                            <span class="room-tag"><i class="fa-solid fa-check"></i> AC</span>
                            <span class="room-tag"><i class="fa-solid fa-check"></i> Mic</span>
                            <span class="room-tag"><i class="fa-solid fa-check"></i> Meja</span>
                            <span class="room-tag"><i class="fa-solid fa-check"></i> Kursi</span>
                            <span class="room-tag"><i class="fa-solid fa-check"></i> Layout</span>
                            <span class="room-tag"><i class="fa-solid fa-check"></i> Lighting</span>
                            <span class="room-tag"><i class="fa-solid fa-check"></i> Videotron</span>
                        </div>
                        <div class="text-end mt-4">
                            <a href="{{ route('facility') }}" class="text-decoration-none" style="color: #d5d5d5ff; font-weight: 500; font-size: 1.05rem;">
                                Lihat Detail <i class="fa-solid fa-arrow-right ms-1"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Room 3 -->
            <div class="col-lg-4 col-md-6">
                <div class="room-card">
                    <img src="{{ asset('images/WhatsApp Image 2024-05-13 at 01.06.30 (1).jpeg') }}" alt="VIP Room" class="room-image">
                    <div class="room-details">
                        <h3 class="room-title">Villasita</h3>
                        <p class="room-desc">Ruang medium dengan desain simple dan modern yang cocok digunakan untuk meeting maupun ruang transit.</p>
                        <div class="d-flex align-items-center mb-3" style="color: var(--color-secondary);">
                            <i class="fa-solid fa-people-group me-2"></i>
                            <span class="mb-0" style="font-weight: 500; padding-right: 30px;">17-48 orang</span>
                            <i class="fa-solid fa-ruler-combined me-2"></i>
                            <span class="mb-0" style="font-weight: 500;">37.5 m²</span>
                        </div>
                        <div class="room-tags">
                            <span class="room-tag"><i class="fa-solid fa-check"></i> AC</span>
                            <span class="room-tag"><i class="fa-solid fa-check"></i> Mic</span>
                            <span class="room-tag"><i class="fa-solid fa-check"></i> Meja</span>
                            <span class="room-tag"><i class="fa-solid fa-check"></i> Kursi</span>
                            <span class="room-tag"><i class="fa-solid fa-check"></i> Proyektor</span>
                            <span class="room-tag"><i class="fa-solid fa-check"></i> Layout</span>
                        </div>
                        <div class="text-end mt-4">
                            <a href="{{ route('facility') }}" class="text-decoration-none" style="color: #d5d5d5ff; font-weight: 500; font-size: 1.05rem;">
                                Lihat Detail <i class="fa-solid fa-arrow-right ms-1"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Pilihan Fasilitas -->
<section id="fasilitas" class="section-padding fasilitas-section">
    <div class="container">
        <h2 class="section-title">Jenis Fasilitas</h2>
        <p class="section-subtitle" style="color:var(--color-primary)">Beragam perlengkapan pendukung acara Anda dengan standar operasional yang baik.</p>
        
        <div class="row g-4">
            <!-- Item 1 -->
            <div class="col-md-6">
                <div class="fasilitas-card">
                    <img src="{{ asset('images/WhatsApp Image 2024-05-12 at 11.27.51 (1)-Photoroom.jpeg') }}" alt="Infocus" class="fasilitas-img">
                    <div class="fasilitas-info">
                        <h5>Stage Lighting</h5>
                        <p>Pencahayaan memukau yang dapat disesuaikan untuk menciptakan atmosfer terbaik sesuai tema.</p>
                    </div>
                </div>
            </div>
            <!-- Item 2 -->
            <div class="col-md-6">
                <div class="fasilitas-card">
                    <img src="{{ asset('images/WhatsApp Image 2024-05-12 at 14.31.10 (1).jpeg') }}" alt="Sound System" class="fasilitas-img">
                    <div class="fasilitas-info">
                        <h5>Sound & Mic</h5>
                        <p>Audio profesional dan jumlah mic yang cukup untuk mendukung kejelasan suara di seluruh ruangan.</p>
                    </div>
                </div>
            </div>
            <!-- Item 3 -->
            <div class="col-md-6">
                <div class="fasilitas-card">
                    <img src="{{ asset('images/WhatsApp Image 2024-05-13 at 01.06.32.jpeg') }}" alt="Gitar" class="fasilitas-img">
                    <div class="fasilitas-info">
                        <h5>Alat Musik</h5>
                        <p>Instrument lengkap seperti gitar, bass, keyboard, piano, dan drum untuk live band.</p>
                    </div>
                </div>
            </div>
            <!-- Item 4 -->
            <div class="col-md-6">
                <div class="fasilitas-card">
                    <img src="{{ asset('images/WhatsApp Image 2024-05-12 at 14.31.08.jpeg') }}" alt="Mic" class="fasilitas-img">
                    <div class="fasilitas-info">
                        <h5>Multimedia</h5>
                        <p>Fasilitas lengkap seperti proyektor dan videotron resolusi tinggi disertai ruang operator untuk memastikan tampilan visual acara yang maksimal.</p>
                    </div>
                </div>
            </div>
            <!-- Item 5 -->
            <div class="col-md-6">
                <div class="fasilitas-card">
                    <img src="{{ asset('images/WhatsApp Image 2024-05-12 at 11.27.48.jpeg') }}" alt="Lighting" class="fasilitas-img">
                    <div class="fasilitas-info">
                        <h5>Umum</h5>
                        <p>Fasilitas penunjang kenyamanan tamu meliputi lift pengunjung, meja dan kursi yang beragam, area parkir kendaraan yang luas, serta toilet yang terawat.</p>
                    </div>
                </div>
            </div>
            <!-- Item 6 -->
            <div class="col-md-6">
                <div class="fasilitas-card">
                    <img src="{{ asset('images/WhatsApp Image 2024-05-13 at 01.06.29 (3).jpeg') }}" alt="Operator" class="fasilitas-img">
                    <div class="fasilitas-info">
                        <h5>Ruangan</h5>
                        <p>Ruangan tambahan dengan desain elegan yang didukung dengan AC sentral bersuhu sejuk serta fleksibilitas tata letak meja dan kursi sesuai konsep acara.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Booking Sekarang -->
<section id="booking" class="section-padding booking-section">
    <div class="container">
        <h2 class="section-title">Booking Sekarang</h2>
        @if(Auth::check())
            <p class="section-subtitle mb-0">Silahkan <a href="{{ route('profile') }}" style="font-weight: bold; text-decoration: underline; color: var(--color-primary);">Login</a> untuk melihat histori data pemesanan Anda.</p>
        @else
            <p class="section-subtitle mb-0">Silahkan <a href="{{ route('login') }}" style="font-weight: bold; text-decoration: underline; color: var(--color-primary);">Login</a> untuk melihat histori data pemesanan Anda.</p>
        @endif
        
        <div class="row g-4 mt-2">
            <!-- Top: Calendar Info Box -->
            <div class="col-12">
                <div class="modern-calendar-box" style="padding: 30px; min-height: 280px; text-align: center;">
                    <h3 class="mb-3" style="font-family: 'CMG Sans', serif; font-weight: 700; position: relative; z-index: 1;">
                        Jadwal Booking
                    </h3>
                    <p style="color: rgba(255,255,255,0.8); margin-bottom: 25px; position: relative; z-index: 1; font-size: 0.95rem; line-height: 1.6; max-width: 800px; margin-left: auto; margin-right: auto;">
                        Kalender booking untuk mengecek ketersediaan seluruh ruangan secara mandiri dan real-time.
                    </p>
                    
                    <div id="calendar" class="mx-auto" style="max-width: 1500px; background: #FDF9F5; padding: 20px; border-radius: 16px; color: #333; text-align: left;"></div>
                </div>
            </div>

            <!-- Bottom: Form Input -->
            <div class="col-12">
                <div class="modern-booking-card">
                    <form action="{{ route('booking.store') }}" method="POST">
                        @csrf
                        @if(!Auth::check())
                            <h4>Informasi Pemesan</h4>
                            <div class="row g-3 mb-4">
                                <div class="col-md-6">
                                    <label class="modern-label">Nama Lengkap<span class="text-danger">*</span></label>
                                    <input type="text" name="nama_pemesan" class="modern-input" placeholder="Mis. Budi Santoso" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="modern-label">Nomor Telepon<span class="text-danger">*</span></label>
                                    <input type="tel" name="telp_pemesan" class="modern-input" placeholder="08xxxxxxxxxx" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="modern-label">Email Aktif<span class="text-danger">*</span></label>
                                    <input type="email" name="email_pemesan" class="modern-input" placeholder="email@contoh.com" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="modern-label">Alamat Lengkap<span class="text-danger">*</span></label>
                                    <input type="text" name="alamat_pemesan" class="modern-input" placeholder="Alamat domisili atau instansi..." required></input>
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
                                <input type="text" name="nama_acara" class="modern-input" placeholder="Nama Instansi - Nama Acara" required>
                            </div>
                            <div class="col-md-6">
                                <label class="modern-label">Jumlah Orang<span class="text-danger">*</span></label>
                                <input type="number" name="jumlah_orang" class="modern-input" placeholder="Kapasitas" required>
                            </div>
                            <div class="col-md-6">
                                <label class="modern-label">Pilih Ruangan<span class="text-danger">*</span></label>
                                <select name="id_ruangan" class="modern-input form-select" style="cursor: pointer;" required>
                                    <option value="" selected disabled>Pilih opsi...</option>
                                    @foreach($ruangans as $ruangan)
                                        <option value="{{ $ruangan->id_ruangan }}">{{ $ruangan->nama_ruangan }} - {{ $ruangan->kapasitas_ruangan }} orang</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="modern-label">Waktu Mulai<span class="text-danger">*</span></label>
                                <input type="datetime-local" name="tgl_mulai" placeholder="Pilih Tanggal dan Jam" class="modern-input" required>
                            </div>
                            <div class="col-md-6">
                                <label class="modern-label">Waktu Selesai<span class="text-danger">*</span><small style="margin-left: 10px; color: #9e9e9e;">Minimal 1 Jam</small></label>
                                <input type="datetime-local" name="tgl_selesai" placeholder="Pilih Tanggal dan Jam" class="modern-input" required>
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
                                        <div class="col-md-4 col-sm-6">
                                            <div class="facility-group">
                                                <input type="checkbox" id="cat_{{ $safe_jenis }}" class="facility-checkbox parent-checkbox" data-target=".child-{{ $safe_jenis }}">
                                                <label for="cat_{{ $safe_jenis }}" class="facility-pill w-100 text-start mb-2"><i class="fa-solid {{ $icon }} me-2"></i>{{ $jenis }}</label>
                                                <div class="child-facilities ms-3 border-start ps-3 mt-1">
                                                    @foreach($items as $item)
                                                        <div class="form-check mb-1 d-flex align-items-center">
                                                            <div>
                                                                <input class="form-check-input child-checkbox child-{{ $safe_jenis }}" name="fasilitas[]" type="checkbox" value="{{ $item->id_fasilitas }}" id="item_{{ $item->id_fasilitas }}" data-parent="#cat_{{ $safe_jenis }}">
                                                                <label class="form-check-label text-muted" style="font-size: 0.85rem;" for="item_{{ $item->id_fasilitas }}">
                                                                    {{ $item->nama_fasilitas }}
                                                                    @if($item->jumlah_fasilitas > 1)
                                                                        <span style="font-size: 0.75rem; opacity: 0.8;">(Tersedia: {{ $item->jumlah_fasilitas }})</span>
                                                                    @endif
                                                                </label>
                                                            </div>
                                                            @if($item->jumlah_fasilitas > 1)
                                                                <input type="number" name="qty_fasilitas[{{ $item->id_fasilitas }}]" class="form-control form-control-sm ms-auto" style="width: 70px; padding: 0.2rem 0.5rem; font-size: 0.8rem;" min="1" max="{{ $item->jumlah_fasilitas }}" placeholder="Jml" value="1">
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
                                <textarea name="keterangan_pemesanan" class="modern-input" rows="3" style="resize: none;" placeholder="Permintaan khusus lainnya..."></textarea>
                            </div>
                        </div>

                        <div class="mt-4 pt-4 d-flex flex-column flex-md-row justify-content-between align-items-center gap-3 border-top" style="border-top-color: rgba(107,36,13,0.1) !important;">
                            <p class="mb-0 text-muted" style="font-size: 0.85rem; max-width: 500px; line-height: 1.5;">
                                <i class="fa-solid fa-circle-info me-1" style="color: var(--color-primary);"></i> Mohon cek <strong>notifikasi email</strong> untuk update status booking Anda.
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
    });
</script>
@endpush
