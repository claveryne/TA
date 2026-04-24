@extends('bar')

@section('title', 'Facility')

@push('styles')
<style>
    /* --- Facility Section --- */
    .facility-section {
        padding: 80px 0;
        background-color: var(--color-light);
    }
    
    /* --- Room Styling --- */
    .room-block {
        margin-bottom: 80px;
    }
    
    .room-title {
        color: #612713;
        font-weight: 700;
        font-size: 2rem;
        margin-bottom: 10px;
    }
    .room-desc {
        color: #6b4d3e;
        font-size: 1rem;
        max-width: 850px;
        margin: 0 auto 15px auto;
        line-height: 1.6;
    }
    .room-meta {
        color: #6b4d3e;
        font-weight: 600;
        font-size: 0.95rem;
        margin-bottom: 15px;
    }
    .room-meta span {
        margin: 0 15px;
    }
    
    .room-gallery img {
        width: 100%;
        height: 250px;
        object-fit: cover;
        border-radius: 16px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.08);
        transition: transform 0.3s ease;
    }
    .room-gallery img:hover {
        transform: translateY(-5px);
    }

    .facility-badge {
        display: inline-block;
        background-color: #FDF9F5;
        color: var(--color-primary);
        padding: 6px 14px;
        border-radius: 20px;
        font-size: 0.85rem;
        font-weight: 600;
        margin: 4px;
        border: 1px solid rgba(107, 36, 13, 0.15);
    }

    /* --- General Facility Styling --- */
    .section-divider {
        border-top: 2px dashed rgba(97, 39, 19, 0.2);
        margin: 80px 0;
    }
    
    .gen-facility-card {
        background-color: #ffffff;
        border-radius: 16px;
        overflow: hidden; /* Pastikan gambar mengikuti radius sudut kartu */
        box-shadow: 0 5px 15px rgba(0,0,0,0.05);
        border: 1px solid rgba(107, 36, 13, 0.05);
        transition: all 0.3s ease;
        height: 100%;
    }
    .gen-facility-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 30px rgba(107, 36, 13, 0.1);
        border-color: rgba(107, 36, 13, 0.2);
    }
    .gen-facility-card img {
        width: 100%;
        height: 200px; /* Tinggi gambar di dalam kartu fasilitas umum */
        object-fit: cover;
        border-bottom: 1px solid rgba(107, 36, 13, 0.05); /* Garis pemisah tipis di bawah gambar */
    }
    .gen-facility-card-body {
        padding: 20px;
    }
    .gen-facility-title {
        color: #612713;
        font-weight: 700;
        font-size: 1.25rem;
        margin-bottom: 12px;
    }
    .gen-facility-desc {
        color: #6b4d3e;
        font-size: 0.95rem;
        line-height: 1.6;
        margin-bottom: 0;
    }

    /* --- Interactive Additional Facility Cards --- */
    .add-facility-card {
        background-color: #ffffff;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 4px 20px rgba(0,0,0,0.06);
        border: 1px solid rgba(107, 36, 13, 0.05);
        height: 100%;
        transition: all 0.3s ease;
    }
    .add-facility-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 30px rgba(107, 36, 13, 0.12);
    }
    .add-facility-img-container {
        width: 100%;
        height: 220px;
        background-color: #f8f9fa; /* Warna dasar jika gambar telat loading */
        overflow: hidden;
    }
    .add-facility-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: opacity 0.3s ease-in-out; /* Animasi fade saat gambar ganti */
    }
    .add-facility-body {
        padding: 24px;
    }
    .add-facility-title {
        color: #612713;
        font-weight: 700;
        font-size: 1.25rem;
        margin-bottom: 16px;
    }
    .add-facility-badges {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
    }
    
    /* Tombol Badge Interaktif */
    .add-facility-badge {
        background-color: #FDF9F5;
        color: var(--color-primary);
        padding: 6px 14px;
        border-radius: 20px;
        font-size: 0.85rem;
        font-weight: 600;
        border: 1px solid rgba(107, 36, 13, 0.15);
        cursor: pointer;
        transition: all 0.2s ease;
        outline: none;
    }
    .add-facility-badge:hover {
        background-color: rgba(153, 77, 28, 0.1);
        transform: scale(1.05); /* Sedikit membesar saat di-hover */
    }
    
    /* Status Badge Saat Dipilih (Active) */
    .add-facility-badge.active {
        background-color: var(--color-primary);
        color: #ffffff;
        border-color: var(--color-primary);
        box-shadow: 0 4px 10px rgba(153, 77, 28, 0.25);
    }
</style>
@endpush

@section('content')
<section id="facility" class="facility-section">
    <div class="container">
        
        @php
            $rooms = [
                [
                    'name' => 'Mahacitta Hall',
                    'desc' => 'Ruang utama dengan fasilitas maksimal dan desain modern yang cocok untuk segala acara penuh makna. Dilengkapi dengan videotron, sound system, operator, dan lighting yang memukau.',
                    'capacity' => '200-300 orang',
                    'size' => '400 m²',
                    'details' => ['Videotron Absen 4x3m', 'Sound System Yamaha DZR', 'Lighting DMX 512', 'AC Daikin 5 PK (4 Unit)', 'Kursi Futura'],
                    'images' => [
                        'images/WhatsApp Image 2024-05-08 at 2.19.54 PM(1).jpeg', 
                        'images/WhatsApp Image 2024-05-08 at 2.19.54 PM.jpeg', 
                        'images/WhatsApp Image 2024-05-12 at 11.27.51 (1)-Photoroom.jpeg'
                    ]
                ],
                [
                    'name' => 'Vyria',
                    'desc' => 'Ruangan berukuran sedang yang sangat pas untuk intimate gathering, workshop, atau meeting eksklusif dengan privasi tinggi.',
                    'capacity' => '20-50 orang',
                    'size' => '200 m²',
                    'details' => ['Smart TV Samsung 65 Inch', 'Sound System Portable JBL', 'Whiteboard Kaca 2x1m', 'AC Panasonic 2 PK'],
                    'images' => [
                        'images/WhatsApp Image 2024-05-13 at 01.06.29.jpeg', 
                        'images/WhatsApp Image 2024-05-13 at 01.06.29 (2).jpeg', 
                        'images/WhatsApp Image 2024-05-13 at 01.06.29.jpeg'
                    ]
                ],
                [
                    'name' => 'Villasita',
                    'desc' => 'Ruangan yang didesain khusus untuk aktivitas kreatif dan anak-anak. Nyaman, terang, dan dilengkapi fasilitas pendukung pembelajaran.',
                    'capacity' => '20-50 orang',
                    'size' => '200 m²',
                    'details' => ['Proyektor Epson EB-X51', 'Screen 84 Inch', 'Kursi Anak Warna-warni', 'Sound System Standard'],
                    'images' => [
                        'images/WhatsApp Image 2024-05-13 at 01.06.30 (1).jpeg', 
                        'images/WhatsApp Image 2024-05-13 at 01.06.29 (3).jpeg', 
                        'images/WhatsApp Image 2024-05-13 at 01.06.30.jpeg'
                    ]
                ],
            ];

            // --- DATA FASILITAS UMUM ---
            $general_facilities = [
                [
                    'name' => 'Lahan Parkir Luas',
                    'image' => 'images/crop.jpg'
                ],
                [
                    'name' => 'High-Speed Wi-Fi',
                    'image' => 'images/moonbot (1).jpeg'
                ],
                [
                    'name' => 'Ruang VIP / Transit',
                    'image' => 'images/IMG_9934.JPG'
                ],
                [
                    'name' => 'Lift Pengunjung',
                    'image' => 'images/WhatsApp Image 2024-05-13 at 01.06.29.jpeg'
                ],
                [
                    'name' => 'Toilet Eksklusif',
                    'image' => 'images/WhatsApp Image 2024-05-12 at 11.27.48.jpeg'
                ],
                [
                    'name' => 'Keamanan Terpadu',
                    'image' => 'images/IMG_0013.JPG'
                ]
            ];

            // --- DATA FASILITAS TAMBAHAN ---
            $additional_facilities = [
                [
                    'name' => 'Multimedia',
                    'items' => [
                        ['label' => 'Videotron Absen 4x3m', 'img' => 'images/foto terbaru 1.jpeg'],
                        ['label' => 'Proyektor Epson EB-X51', 'img' => 'images/moonbot.jpeg'],
                        ['label' => 'Komputer Operator', 'img' => 'images/WhatsApp Image 2024-05-12 at 14.31.08.jpeg']
                    ]
                ],
                [
                    'name' => 'Sound System',
                    'items' => [
                        ['label' => 'Sound System Yamaha DZR', 'img' => 'images/WhatsApp Image 2024-05-12 at 14.31.10.jpeg'],
                        ['label' => 'Mic Wireless & Kabel', 'img' => 'images/WhatsApp Image 2024-05-12 at 14.31.06.jpeg'],
                        ['label' => 'Sound Portable', 'img' => 'images/WhatsApp Image 2024-05-13 at 01.06.29 (3).jpeg']
                    ]
                ],
                [
                    'name' => 'Stage Lighting',
                    'items' => [
                        ['label' => 'Lighting DMX 512', 'img' => 'images/WhatsApp Image 2024-06-02 at 19.26.56.jpeg'],
                        ['label' => 'Follow Spot', 'img' => 'images/WhatsApp Image 2024-06-02 at 19.26.57.jpeg'],
                        ['label' => 'Moving Head', 'img' => 'images/WhatsApp Image 2024-06-02 at 19.26.56 (1).jpeg']
                    ]
                ],
                [
                    'name' => 'Alat Musik',
                    'items' => [
                        ['label' => 'Keyboard Yamaha', 'img' => 'images/WhatsApp Image 2024-05-13 at 01.06.31 (1).jpeg'],
                        ['label' => 'Drum Digital Roland', 'img' => 'images/WhatsApp Image 2024-05-13 at 01.06.32.jpeg'],
                        ['label' => 'Gitar & Bass Yamaha', 'img' => 'images/WhatsApp Image 2024-06-02 at 19.26.57 (1).jpeg']
                    ]
                ],
                [
                    'name' => 'Meja & Kursi',
                    'items' => [
                        ['label' => 'Kursi Futura', 'img' => 'images/WhatsApp Image 2024-05-13 at 01.06.29 (2).jpeg'],
                        ['label' => 'Meja Bulat', 'img' => 'images/IMG_9870.JPG'],
                        ['label' => 'Cover & Pita Kursi', 'img' => 'images/IMG_0013.JPG']
                    ]
                ],
                [
                    'name' => 'Ruangan Tambahan',
                    'items' => [
                        ['label' => 'Vyria', 'img' => 'images/WhatsApp Image 2024-05-13 at 01.06.29.jpeg'],
                        ['label' => 'Villasita', 'img' => 'images/WhatsApp Image 2024-05-13 at 01.06.29 (3).jpeg']
                    ]
                ]
            ];
        @endphp

        @foreach($rooms as $room)
        <div class="room-block">
            <div class="text-center mb-4">
                <h3 class="room-title">{{ $room['name'] }}</h3>
                <p class="room-desc">{{ $room['desc'] }}</p>
                
                <div class="room-meta">
                    <span>Kapasitas: {{ $room['capacity'] }}</span>
                    <span>Luas: {{ $room['size'] }}</span>
                </div>

                <div class="mb-4">
                    @foreach($room['details'] as $detail)
                        <span class="facility-badge">{{ $detail }}</span>
                    @endforeach
                </div>
            </div>

            <div class="row g-4 room-gallery">
                @foreach($room['images'] as $img)
                <div class="col-md-4 col-sm-12">
                    <img src="{{ asset($img) }}" alt="Foto {{ $room['name'] }}">
                </div>
                @endforeach
            </div>
        </div>
        @endforeach

        <hr class="section-divider">

        <div class="text-center mb-5">
            <h3 class="room-title">Fasilitas Umum</h3>
            <p class="room-desc">Selain ruangan yang megah, kami juga menyediakan berbagai fasilitas umum untuk memaksimalkan kenyamanan Anda dan para tamu acara yang hadir.</p>
        </div>

        <div class="row g-4">
            @foreach($general_facilities as $facility)
            <div class="col-lg-4 col-md-6 col-12">
                <div class="gen-facility-card">
                    <img src="{{ asset($facility['image']) }}" alt="Foto {{ $facility['name'] }}">
                    <div class="gen-facility-card-body">
                      <h4 class="gen-facility-title">{{ $facility['name'] }}</h4>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <hr class="section-divider">

            <div class="text-center mb-5">
                <h3 class="room-title">Fasilitas Tambahan</h3>
                <p class="room-desc">Fasilitas tambahan juga disediakan untuk melengkapi segala kebutuhan acara Anda.</p>
            </div>

        <div class="row g-4 mb-5">
            @foreach($additional_facilities as $cardIndex => $facility)
            <div class="col-lg-4 col-md-6 col-12">
                <div class="add-facility-card">
                    <div class="add-facility-img-container">
                        <img src="{{ asset($facility['items'][0]['img']) }}" 
                             id="add-fac-img-{{ $cardIndex }}" 
                             class="add-facility-img" 
                             alt="{{ $facility['name'] }}">
                    </div>
                    
                    <div class="add-facility-body">
                        <h4 class="add-facility-title">{{ $facility['name'] }}</h4>
                        
                        <div class="add-facility-badges">
                            @foreach($facility['items'] as $itemIndex => $item)
                                <button type="button" 
                                    class="add-facility-badge {{ $itemIndex == 0 ? 'active' : '' }}" 
                                    data-target-img="add-fac-img-{{ $cardIndex }}"
                                    data-image-src="{{ asset($item['img']) }}"
                                    onclick="changeFacilityImage(this)">
                                    {{ $item['label'] }}
                                </button>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

    </div>
</section>
@endsection

<script>
    function changeFacilityImage(buttonElement) {
        // 1. Ambil ID gambar tujuan dan link gambar baru dari atribut data
        const targetImgId = buttonElement.getAttribute('data-target-img');
        const newImageSrc = buttonElement.getAttribute('data-image-src');
        const imgElement = document.getElementById(targetImgId);

        // 2. Beri efek animasi transisi (gambar meredup sebentar lalu ganti)
        imgElement.style.opacity = '0.3';
        
        setTimeout(() => {
            imgElement.src = newImageSrc;
            imgElement.style.opacity = '1';
        }, 200); // Ganti gambar setelah 200 milidetik (0.2 detik)

        // 3. Atur state "Active" pada badge
        // Cari elemen pembungkus (container) badge di dalam card ini
        const badgesContainer = buttonElement.closest('.add-facility-badges');
        
        // Hapus class 'active' dari semua badge di dalam container ini
        const allBadges = badgesContainer.querySelectorAll('.add-facility-badge');
        allBadges.forEach(badge => {
            badge.classList.remove('active');
        });

        // Tambahkan class 'active' HANYA ke badge yang baru saja diklik
        buttonElement.classList.add('active');
    }
</script>