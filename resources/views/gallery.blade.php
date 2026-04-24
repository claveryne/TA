@extends('bar')

@section('title', 'Gallery')

@push('styles')
<style>
    /* --- Gallery Section --- */
    .gallery-section {
        padding: 80px 0;
        background-color: var(--color-light);
    }
    .gallery-card {
        border-radius: 16px; /* Radius sudut disesuaikan dengan referensi gambar */
        overflow: hidden;
        box-shadow: 0 5px 15px rgba(0,0,0,0.08);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        height: 100%;
        cursor: pointer;
    }
    .gallery-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0,0,0,0.15);
    }
    .gallery-card img {
        width: 100%;
        height: 300px;
        object-fit: cover;
        transition: transform 0.5s ease;
        display: block;
    }
    .gallery-card:hover img {
        transform: scale(1.05);
    }
</style>
@endpush

@section('content')
<section id="gallery" class="gallery-section">
    <div class="container">
        <h2 class="section-title text-center">Galeri</h2>
        <p class="section-subtitle text-center">Berbagai dokumentasi acara yang telah berhasil diselenggarakan di House of Legacy.</p>

        @php
            $galleries = [
                'images/foto terbaru 1.jpeg',
                'images/foto terbaru 2.jpeg',
                'images/WhatsApp Image 2024-06-02 at 19.26.56.jpeg',
                'images/moonbot 2.jpeg',
                'images/WhatsApp Image 2025-02-10 at 09.31.46.jpeg',
                'images/IMG_9960.JPG',
                'images/WhatsApp Image 2024-05-13 at 19.07.04.jpeg',
                'images/WhatsApp Image 2024-06-02 at 19.26.57.jpeg',
                'images/IMG_0018.JPG',
                'images/IMG_0007.JPG',
                'images/IMG_9859.JPG',
                'images/moonbot3.jpeg',
                'images/IMG_9934.JPG',
                'images/IMG_0010.JPG',
                'images/WhatsApp Image 2025-02-03 at 09.13.17.jpeg',
            ];
        @endphp

        <div class="row g-4 mt-4">
            @foreach($galleries as $index => $image)
                @php
                    // Logika Pola 2-3-2-3
                    // Jika urutan (0,1) masuk ke col-md-6 (2 kolom)
                    // Jika (2,3,4) masuk col-md-4 (3 kolom)
                    $colClass = ($index % 5 < 2) ? 'col-md-6' : 'col-md-4';
                @endphp
                
                <div class="col-12 {{ $colClass }}">
                    <div class="gallery-card">
                        <img src="{{ asset($image) }}" alt="Gallery Image {{ $index + 1 }}">
                    </div>
                </div>
            @endforeach
        </div>

    </div>
</section>
@endsection