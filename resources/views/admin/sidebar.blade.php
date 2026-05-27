<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'House of Legacy')</title>
    <!-- Favicon / Ikon Website di Tab Browser -->
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
    <link rel="icon" href="{{ asset('images/gambarLogo.png') }}" type="image/png">
    <link rel="apple-touch-icon" href="{{ asset('images/gambarLogo.png') }}">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
    <!-- Font Awesome untuk icon -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://db.onlinewebfonts.com/c/6e6762c1384229ee06b94e9385e2a9ab?family=CMG+Sans" rel="stylesheet">
    <!-- Sidebar -->
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
    <!-- Alert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!-- Calendar -->
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js'></script>
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/locales/id.js'></script>
    <link href='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css' rel='stylesheet' />
    <!-- Flatpickr -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://npmcdn.com/flatpickr/dist/l10n/id.js"></script>
    <!-- Ion Icon -->
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
    <!-- Stack for Child View Scripts -->
    @stack('scripts')

    <style>
        :root {
            --primary-clr: #6B240D;
            --secondary-clr: #994D1C;
            --secondary-clr2: #F5CCA0;
            --bg-clr: #FDF6EE;
            --white-bg: #fff;
            --dark-text-clr: #333333;
            --light-text-clr: #ffffff;
            --hover-clr: #f1f1f1;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: "CMG Sans", sans-serif;
        }

        body {
            min-height: 100vh;
            display: flex;
            background: var(--bg-clr);
            margin: 0;
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 10px;
            height: 60px;

        }

        .logo-a {
            width: 40px;
        }

        .logo-b {
            width: 150px;
            opacity: 0;
            transform: translateX(-10px);
            transition: all 0.3s ease;
            pointer-events: none;
        }

        .container.active .logo-b {
            opacity: 1;
            transform: translateX(0);
        }

        .container {
            top: 0;
            left: 0;
            min-height: 100vh;
            width: 85px;
            padding: 20px;
            background-color: var(--white-bg);
            overflow: hidden;
            transition: all 0.3s ease;
            border-top-right-radius: 10px;
            border-bottom-right-radius: 10px;
            box-shadow: 2px 0 10px rgba(0, 0, 0, 0.05);
        }

        .container.active {
            width: 250px;
        }

        .container .logo {
            width: 100%;
            margin-bottom: 30px;
        }

        .container ul {
            list-style: none;
            display: flex;
            flex-direction: column;
            gap: 10px;
            padding: 0;
        }

        .link-item a {
            display: flex;
            align-items: center;
            width: 100%;
            padding: 10px;
            border-radius: 10px;
            text-decoration: none;
            font-size: 16px;
            white-space: nowrap;
            text-transform: capitalize;
            color: var(--dark-text-clr);
        }

        .link-item a span {
            transition: transform 0.5s;
            transform: translateX(100px);
        }

        .link-item form {
            display: flex;
            align-items: center;
            width: 100%;
            padding: 10px;
            border-radius: 10px;
            text-decoration: none;
            font-size: 16px;
            white-space: nowrap;
            color: var(--dark-text-clr);
        }

        .link-item form span {
            transition: transform 0.5s;
            transform: translateX(100px);
        }

        .container.active .link-item a span {
            transition-delay: calc(0.02s * var(--i));
            transform: translateX(0px);
        }

        .link-item a:hover {
            background-color: var(--hover-clr);
        }

        .link-item.active a {
            color: var(--light-text-clr);
            background-color: var(--primary-clr);
        }

        .container.active .link-item form span {
            transition-delay: calc(0.02s * var(--i));
            transform: translateX(0px);
        }

        .link-item form:hover {
            background-color: var(--hover-clr);
        }

        .link-item.active form {
            color: var(--light-text-clr);
            background-color: var(--primary-clr);
        }

        .link-item ion-icon {
            min-width: 20px;
            min-height: 20px;
            margin-right: 20px;
            position: relative;
        }

        .link-item img {
            width: 25px;
            height: 25px;
            margin-right: 20px;
            border-radius: 50%;
            align-items: center;
            justify-content: center;
        }

        .link-item ion-icon.noti-icon::before {
            content: "";
            display: block;
            position: absolute;
            top: 3px;
            right: 2px;
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background-color: var(--primary-clr);
            border: 1px solid var(--white-bg);
        }

        .link-item a .num-noti {
            margin-left: 40px;
            font-size: 12px;
            color: var(--light-text-clr);
            background-color: var(--primary-clr);
            min-width: 15px;
            height: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
        }

        .link-item.active a .num-noti {
            color: var(--primary-clr);
            background-color: var(--white-bg);
        }

        .content-wrapper {
            flex: 1;
            padding: 30px;
            transition: margin-left 0.3s ease;
            background: #ffffff;
        }

        .btn-logout {
            background: none;
            border: none;
            color: inherit;
            font: inherit;
            width: 100%;
            text-align: left;
            display: flex;
            align-items: center;
            border-radius: 10px;
            cursor: pointer;
        }

        .btn-logout:hover {
            background-color: var(--hover-clr);
        }

        .link-item.active .btn-logout {
            background-color: var(--primary-clr);
            color: var(--light-text-clr);
        }

        /* --- Mobile Responsive Fix --- */
        @media (max-width: 768px) {
            .container {
                position: fixed;
                z-index: 999;
                height: 100vh;
            }
            .content-wrapper {
                margin-left: 85px; 
                width: calc(100vw - 85px);
                padding: 20px 15px;
                overflow-x: hidden;
            }
        }

        /* Custom Button Styles */
        .btn-primary-custom {
            background-color: var(--primary-clr);
            color: var(--light-text-clr);
            border: 1.5px solid var(--primary-clr);
            padding: 8px 20px;
            border-radius: 10px;
            font-weight: 600;
            font-size: 0.95rem;
            transition: all 0.3s ease;
        }
        .btn-primary-custom:hover {
            background-color: #511B0A;
            border-color: #511B0A;
            color: var(--light-text-clr);
        }

        .btn-outline-primary-custom {
            background-color: transparent;
            color: var(--primary-clr);
            border: 1.5px solid var(--primary-clr);
            padding: 8px 20px;
            border-radius: 10px;
            font-weight: 600;
            font-size: 0.95rem;
            transition: all 0.3s ease;
        }
        .btn-outline-primary-custom:hover {
            background-color: var(--primary-clr);
            color: var(--light-text-clr);
            border-color: var(--primary-clr);
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
    <div class="container">
        <div class="logo">
            <img src="{{ asset('images/gambarLogo.png') }}" class="logo-a" alt="Logo" width="50">
            <img src="{{ asset('images/tulisanLogo.png') }}" class="logo-b" alt="Legacy" width="50">
        </div>
        <ul>
            <li class="link-item {{ request()->is('dashboard') ? 'active' : '' }}">
                <a href="{{ route('dashboard') }}" class="link">
                    <ion-icon name="stats-chart-outline"></ion-icon>
                    <span style="--i: 2">Dashboard</span>
                </a>
            </li>
            <li class="link-item {{ request()->is('ruangan') ? 'active' : '' }}">
                <a href="{{ route('ruangan') }}" class="link">
                    <ion-icon name="cube-outline"></ion-icon>
                    <span style="--i: 3">Ruangan</span>
                </a>
            </li>
            <li class="link-item {{ request()->is('fasilitas') ? 'active' : '' }}">
                <a href="{{ route('fasilitas') }}" class="link"><ion-icon name="easel-outline"></ion-icon>
                    <span style="--i: 4">Fasilitas</span>
                </a>
            </li>
            <li class="link-item {{ request()->is('pemesanan') ? 'active' : '' }}">
                <a href="{{ route('pemesanan') }}" class="link">
                    <ion-icon name="calendar-outline"></ion-icon>
                    <span style="--i: 5">Pemesanan</span>
                </a>
            </li>
            <li class="link-item {{ request()->is('pemeliharaan') ? 'active' : '' }}">
                <a href="{{ route('pemeliharaan') }}" class="link">
                    <ion-icon name="construct-outline"></ion-icon>
                    <span style="--i: 6">Pemeliharaan</span>
                </a>
            </li>
            <li class="link-item {{ request()->is('pelanggan') ? 'active' : '' }}">
                <a href="{{ route('pelanggan') }}" class="link">
                    <ion-icon name="person-add-outline"></ion-icon>
                    <span style="--i: 7">Pelanggan</span>
                </a>
            </li>
            <li class="link-item {{ request()->is('karyawan') ? 'active' : '' }}">
                <a href="{{ route('karyawan') }}" class="link">
                    <ion-icon name="people-outline"></ion-icon>
                    <span style="--i: 8">Karyawan</span>
                </a>
            </li>
            <li class="link-item {{ request()->is('home') ? 'active' : '' }}">
                <a href="{{ url('home') }}" class="link">
                    <ion-icon name="home-outline"></ion-icon><span style="--i: 9">Home</span>
                </a>
            </li>
            <li class="link-item">
                <form action="{{ route('logout') }}" method="POST" class="link">
                    @csrf
                    <button type="submit" class="btn-logout">
                        <ion-icon name="log-out-outline" style="color: red;"></ion-icon>
                        <span style="--i: 10; color: red;">Logout</span>
                    </button>
                </form>
            </li>
        </ul>
    </div>

    <div class="content-wrapper">
        @yield('content')
    </div>

    <script>
        const container = document.querySelector(".container");
        const linkItems = document.querySelectorAll(".link-item");

        container.addEventListener("mouseenter", () => {
            container.classList.add("active");
        });

        container.addEventListener("mouseleave", () => {
            container.classList.remove("active");
        });

        for (let i = 0; i < linkItems.length; i++) {
            linkItems[i].addEventListener("click", (e) => {
                const link = linkItems[i].querySelector("a");

                if (link && link.hasAttribute("data-bs-toggle")) {
                    return;
                }

                linkItems.forEach((linkItem) => {
                    linkItem.classList.remove("active");
                });
                linkItems[i].classList.add("active");
            });
        }

        flatpickr('input[type="datetime-local"]', {
            enableTime: true,
            dateFormat: "Y-m-d\\ H:i",
            time_24hr: true,
            locale: "id",
            disableMobile: true
        });
    </script>

</body>

</html>