<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'House of Legacy')</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <!-- Font Awesome untuk icon -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://db.onlinewebfonts.com/c/6e6762c1384229ee06b94e9385e2a9ab?family=CMG+Sans" rel="stylesheet">
    <!-- Alert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Calendar -->
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js'></script>
    <link href='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css' rel='stylesheet' />
    <!-- Flatpickr -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://npmcdn.com/flatpickr/dist/l10n/id.js"></script>
    
    <style>
        :root {
            --color-primary: #6B240D; /* Coklat Tua */
            --color-secondary: #F5CCA0; /* Coklat Muda / Krem */
            --color-secondary2: #994D1C;
            --color-light: #FDF6EE; /* Latar Belakang Terang */
            --color-text-dark: #333333;
            --color-text-light: #FFFFFF;
        }

        body {
            font-family: 'CMG Sans', sans-serif;
            color: var(--color-text-dark);
            background-color: var(--color-light);
            overflow-x: hidden;
        }

        h1, h2, h3, h4, h5, h6, .navbar-brand {
            font-family: 'CMG Sans', serif;
        }

        /* --- Global Utilities --- */
        .section-padding {
            padding: 80px 0;
        }
        
        .section-title {
            color: var(--color-primary);
            text-align: center;
            font-weight: 700;
            font-size: 2.5rem;
            margin-bottom: 10px;
        }
        
        .section-subtitle {
            text-align: center;
            color: var(--color-text-dark);
            margin-bottom: 50px;
            font-size: 1rem;
            max-width: 800px;
            margin-left: auto;
            margin-right: auto;
        }

        /* --- Navbar --- */
        .navbar {
            background-color: rgba(107, 36, 13, 0.95); /* Semi-transparent Primary */
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            padding: 12px 0;
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
        }
        .navbar-brand img {
            transition: transform 0.3s ease;
        }
        .navbar-brand:hover img {
            transform: scale(1.05);
        }
        .navbar-nav {
            align-items: center;
        }
        .navbar-nav .nav-item {
            margin: 0 5px;
        }
        .navbar-nav .nav-link {
            color: rgba(253, 246, 238, 0.85) !important; /* Muted light color */
            font-weight: 500;
            font-size: 0.95rem;
            padding: 8px 16px;
            border-radius: 8px;
            transition: all 0.3s ease;
            position: relative;
        }
        .navbar-nav .nav-link::after {
            content: '';
            position: absolute;
            bottom: 4px;
            left: 50%;
            transform: translateX(-50%);
            width: 0;
            height: 2px;
            background-color: var(--color-secondary);
            transition: width 0.3s ease;
            border-radius: 2px;
        }
        .navbar-nav .nav-link:hover,
        .navbar-nav .nav-link.active {
            color: var(--color-secondary) !important;
            background-color: rgba(255,255,255,0.05);
        }
        .navbar-nav .nav-link:hover::after,
        .navbar-nav .nav-link.active::after {
            width: 60%;
        }
        .modern-btn-login {
            background-color: var(--color-secondary);
            color: var(--color-primary);
            font-weight: 600;
            font-size: 0.95rem;
            padding: 10px 24px;
            border-radius: 50px;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            transition: all 0.3s ease;
            box-shadow: 0 4px 10px rgba(245, 204, 160, 0.2);
        }
        .modern-btn-login:hover {
            background-color: var(--color-light);
            color: var(--color-primary);
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(245, 204, 160, 0.3);
        }
        .modern-btn-login.active {
            background-color: var(--color-light);
            color: var(--color-primary);
            box-shadow: 0 6px 15px rgba(245, 204, 160, 0.3);
        }
        /* Mobile adjustment for navbar */
        @media (max-width: 991px) {
            .navbar-nav {
                padding-top: 15px;
                padding-bottom: 15px;
            }
            .navbar-nav .nav-item {
                margin: 5px 0;
                width: 100%;
                text-align: center;
            }
            .navbar-nav .nav-link::after {
                display: none;
            }
            .modern-btn-login {
                justify-content: center;
                width: 200px;
                margin: 10px auto 0;
            }
        }

        /* --- Footer --- */
        footer {
            background-color: var(--color-primary);
            color: var(--color-light);
            padding: 60px 0 20px;
        }
        .footer-logo {
            color: var(--color-secondary);
            font-size: 2rem;
            margin-bottom: 20px;
            display: inline-block;
        }
        .footer-logo i {
            margin-right: 10px;
        }
        footer h5 {
            color: var(--color-secondary);
            margin-bottom: 20px;
            font-size: 1.2rem;
        }
        footer p, footer li {
            color: rgba(253, 246, 238, 0.8);
            font-size: 0.95rem;
            line-height: 1.8;
            margin-bottom: 10px;
        }
        footer ul {
            padding-left: 0;
            list-style: none;
        }
        footer a {
            color: rgba(253, 246, 238, 0.8);
            text-decoration: none;
            transition: color 0.3s;
        }
        footer a:hover {
            color: var(--color-secondary);
        }
        .social-links a {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            background-color: rgba(255,255,255,0.1);
            border-radius: 50%;
            margin-right: 10px;
            color: var(--color-secondary);
            transition: all 0.3s;
        }
        .social-links a:hover {
            background-color: var(--color-secondary);
            color: var(--color-primary);
            transform: translateY(-3px);
        }
        .footer-bottom {
            border-top: 1px solid rgba(255,255,255,0.1);
            padding-top: 20px;
            margin-top: 40px;
            text-align: center;
            font-size: 0.9rem;
            color: rgba(253, 246, 238, 0.6);
        }
    </style>
    @stack('styles')
</head>

@if(session('success'))
    <div class="toast-container position-fixed top-0 end-0 p-3">
        <div class="toast align-items-center text-white bg-success border-0 show" role="alert">
            <div class="d-flex">
                <div class="toast-body">{{ session('success') }}</div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
    </div>
    @endif

    @if(session('error'))
    <div class="toast-container position-fixed top-0 end-0 p-3">
        <div class="toast align-items-center text-white bg-danger border-0 show" role="alert">
            <div class="d-flex">
                <div class="toast-body">{{ session('error') }}</div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
    </div>
@endif

<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg sticky-top">
        <div class="container">
            <a class="navbar-brand" href="{{ route('home') }}">
                <img src="{{ asset('images/logo Legacy warna 1.png') }}" alt="Logo" width="150">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation" style="background-color: var(--color-secondary); border: none;">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('gallery') ? 'active' : '' }}" href="{{ route('gallery') }}">Gallery</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('facility') ? 'active' : '' }}" href="{{ route('facility') }}">Facility</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('booking') ? 'active' : '' }}" href="{{ route('booking') }}">Booking</a>
                    </li>
                    @if(Auth::check())
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('history') ? 'active' : '' }}" href="{{ route('history') }}">History</a>
                        </li>
                        <li class="nav-item ms-lg-3 mt-3 mt-lg-0">
                            <a class="modern-btn-login {{ request()->routeIs('profile') ? 'active' : '' }}" href="{{ route('profile') }}">
                                <i class="fa-regular fa-user me-2"></i>Profile
                            </a>
                        </li>
                    @else
                        <li class="nav-item ms-lg-3 mt-3 mt-lg-0">
                            <a class="modern-btn-login {{ request()->routeIs('login') ? 'active' : '' }}" href="{{ route('login') }}">
                                <i class="fa-regular fa-user me-2"></i>Login
                            </a>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </nav>
    
    @yield('content')

    <!-- Footer -->
    <footer>
        <div class="container">
            <div class="row g-5">
                <div class="col-lg-4 col-md-6">
                    <a href="#" class="footer-logo">
                        <img src="{{ asset('images/logo Legacy warna 1.png') }}" alt="Logo" width="250">
                    </a>
                    <p>House of Legacy menghadirkan kenyamanan dalam setiap momen istimewa Anda. Dirancang dengan sentuhan modern dan fasilitas premium, tempat ini menjadi ruang sempurna untuk mewujudkan acara yang penuh makna.</p>
                    <div class="social-links mt-4">
                        <a href="https://www.instagram.com/legacy.jogja/"><i class="fa-brands fa-instagram"></i></a>
                        <a href="https://www.tiktok.com/@legacy.jogja"><i class="fa-brands fa-tiktok"></i></a>
                        <a href="https://www.facebook.com/legacy.jogja/"><i class="fa-brands fa-facebook-f"></i></a>
                        <a href="https://www.youtube.com/@LegacyJogja"><i class="fa-brands fa-youtube"></i></a>
                    </div>
                </div>
                
                <div class="col-lg-2 col-md-6">
                    <h5>Navigasi</h5>
                    <ul>
                        <li><a href="{{ route('home') }}">Home</a></li>
                        <li><a href="{{ route('gallery') }}">Gallery</a></li>
                        <li><a href="{{ route('facility') }}">Facility</a></li>
                        <li><a href="{{ route('booking') }}">Booking</a></li>
                    </ul>
                </div>

                <div class="col-lg-3 col-md-6">
                    <h5>Hubungi Kami</h5>
                    <ul>
                        <li><a href="Https://wa.me/6285369369365"><i class="fa-solid fa-brands fa-whatsapp me-2"></i> 085 369 369 365</li></a>
                        <li><a href="mailto:[legacyjogja@gmail.com]"><i class="fa-solid fa-envelope me-2"></i> legacyjogja@gmail.com</li></a>
                    </ul>
                </div>

                <div class="col-lg-3 col-md-6">
                    <h5>Lokasi</h5>
                    <p><i class="fa-solid fa-location-dot me-2"></i><a href="https://maps.app.goo.gl/bqDfCP4dTZKQLt4X6">Jl. Cempaka Baru 9, Condongcatur, Sleman, Yogyakarta.</a></p>
                </div>
            </div>
            
            <div class="footer-bottom">
                <p class="mb-0">&copy; 2026 House of Legacy. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            flatpickr('input[type="datetime-local"]', {
                enableTime: true,
                dateFormat: "Y-m-d\\ H:i",
                time_24hr: true,
                locale: "id",
                disableMobile: true
            });
        });
    </script>

    @stack('scripts')
</body>
</html>
