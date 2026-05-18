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
                    'capacity' => '200-250 orang',
                    'size' => '200 m²',
                    'details' => ['Classroom', 'Boardroom', 'U-Shape', 'Theater'],
                    'facility' => ['AC', 'Wifi', 'Kursi', 'Air Mineral', 'Proyektor', 'Kabel HDMI', 'Kabel VGA', 'Sound System (2 Mic)', 'Pensil', 'Notes', 'Parkir'],
                    'images' => [
                        'images/WhatsApp Image 2024-05-08 at 2.19.54 PM(1).jpeg', 
                        'images/WhatsApp Image 2024-05-08 at 2.19.54 PM.jpeg', 
                        'images/WhatsApp Image 2024-05-12 at 11.27.51 (1)-Photoroom.jpeg'
                    ]
                ],
                [
                    'name' => 'Vyria',
                    'desc' => 'Ruangan berukuran sedang yang sangat pas untuk intimate gathering, workshop, atau meeting eksklusif dengan privasi tinggi.',
                    'capacity' => '11-30 orang',
                    'size' => '32.5 m²',
                    'details' => ['Classroom 24 orang', 'Boardroom 16 orang', 'U-Shape 11 orang', 'Theater 30 orang'],
                    'facility' => ['AC', 'Wifi', 'Kursi', 'Air Mineral', 'Proyektor', 'Kabel HDMI', 'Kabel VGA', 'Sound System (2 Mic)', 'Pensil', 'Notes', 'Parkir'],
                    'images' => [
                        'images/WhatsApp Image 2024-05-13 at 01.06.29.jpeg', 
                        'images/WhatsApp Image 2024-05-13 at 01.06.29 (2).jpeg', 
                        'images/WhatsApp Image 2024-05-13 at 01.06.29.jpeg'
                    ]
                ],
                [
                    'name' => 'Villasita',
                    'desc' => 'Ruangan yang didesain khusus untuk aktivitas kreatif dan anak-anak. Nyaman, terang, dan dilengkapi fasilitas pendukung pembelajaran.',
                    'capacity' => '17-48 orang',
                    'size' => '37.5 m²',
                    'details' => ['Classroom 32 orang', 'Boardroom 20 orang', 'U-Shape 17 orang', 'Theater 48 orang'],
                    'facility' => ['AC', 'Wifi', 'Kursi', 'Air Mineral', 'Proyektor', 'Kabel HDMI', 'Kabel VGA', 'Sound System (2 Mic)', 'Pensil', 'Notes', 'Parkir'],
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
            $db_fasilitas = \App\Models\Fasilitas::all()->groupBy('jenis_fasilitas');
            
            $additional_facilities = [];
            $order = ['Multimedia', 'Sound System', 'Lighting', 'Alat Musik', 'Umum', 'Ruangan'];
            
            foreach($order as $jenis) {
                if(isset($db_fasilitas[$jenis]) && $db_fasilitas[$jenis]->count() > 0) {
                    $items = [];
                    foreach($db_fasilitas[$jenis] as $f) {
                        $items[] = [
                            'label' => $f->nama_fasilitas,
                            'img' => $f->foto_fasilitas ? 'uploads/fasilitas/' . $f->foto_fasilitas : 'images/crop.jpg'
                        ];
                    }
                    $additional_facilities[] = [
                        'name' => $jenis,
                        'items' => $items
                    ];
                }
            }
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
                        @php
                            $layoutName = strtolower(explode(' ', trim($detail))[0]); 
                            $layoutImg = asset('images/layout-' . $layoutName . '.png');
                        @endphp
                        <button type="button" class="add-facility-badge me-1" 
                                onclick="showLayoutModal('{{ $detail }}', '{{ $layoutImg }}')">
                            <i class="fa-solid fa-border-all me-1"></i>{{ $detail }}
                        </button>
                    @endforeach
                </div>

                <div class="mb-1">
                    @foreach($room['facility'] as $facility)
                        <span class="facility-badge">{{ $facility }}</span>
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

<!-- Layout Modal -->
<div class="modal fade" id="layoutModal" tabindex="-1" aria-labelledby="layoutModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content border-0 shadow-lg">
      <div class="modal-header border-0 pb-0">
        <h5 class="modal-title" id="layoutModalLabel" style="color: var(--color-primary); font-weight: 700;">Layout Detail</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body text-center pt-2">
        <p id="layoutModalDesc" class="text-muted mb-3" style="font-size: 0.95rem;"></p>
        <img src="" id="layoutModalImg" class="img-fluid rounded shadow-sm w-100" alt="Layout Image" onerror="this.src='{{ asset('images/crop.jpg') }}'">
      </div>
    </div>
  </div>
</div>
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

    function showLayoutModal(title, imgSrc) {
        document.getElementById('layoutModalLabel').innerText = 'Layout: ' + title;
        document.getElementById('layoutModalDesc').innerText = 'Ilustrasi untuk tata letak ' + title + '.';
        document.getElementById('layoutModalImg').src = imgSrc;
        
        var layoutModal = new bootstrap.Modal(document.getElementById('layoutModal'));
        layoutModal.show();
    }
</script>