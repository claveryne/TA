@extends('admin.sidebar')

@section('title', 'Dashboard | House of Legacy')

@push('styles')
<style>
    .dashboard-title {
        color: var(--primary-clr);
        font-weight: 700;
        margin-bottom: 24px;
        font-size: 2rem;
    }

    .dash-card {
        background-color: var(--white-bg);
        border-radius: 16px;
        padding: 24px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.05);
        border: 1px solid rgba(107, 36, 13, 0.08);
        height: 100%;
        display: flex;
        flex-direction: column;
        position: relative;
    }

    .dash-card-title {
        font-size: 1.1rem;
        font-weight: 700;
        color: #000;
        margin-bottom: 15px;
    }

    .big-number {
        font-size: 3.5rem;
        font-weight: bold;
        color: var(--primary-clr);
        margin-top: auto;
        margin-bottom: 15px;
        line-height: 1;
    }

    .action-btn-circle {
        position: absolute;
        bottom: 24px;
        right: 24px;
        width: 40px;
        height: 40px;
        background-color: var(--primary-clr);
        color: white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        text-decoration: none;
        transition: 0.3s;
    }
    .action-btn-circle:hover {
        background-color: var(--secondary-clr);
        color: white;
    }
    .action-btn-circle i {
        transform: rotate(-45deg);
    }

    .pb-stats-container {
        display: flex;
        align-items: center;
        justify-content: space-around;
        height: 100%;
        padding: 0 10px;
    }
    .pb-stat-item {
        text-align: center;
    }
    .pb-stat-num {
        font-size: 3rem;
        font-weight: bold;
        color: #333;
        line-height: 1;
    }
    .pb-stat-label {
        font-size: 1.2rem;
        color: #666;
        margin-top: 8px;
    }
    
    .chart-container {
        position: relative;
        width: 150px;
        height: 150px;
        margin: 0 auto;
    }
    .chart-container-lg {
        width: 150px;
        height: 150px;
    }
    .chart-center-text {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        font-size: 1.25rem;
        font-weight: 700;
        color: #333;
    }

    .dash-list {
        list-style: none;
        padding: 0;
        margin: 0;
    }
    .dash-list-item {
        margin-bottom: 14px;
        font-size: 1rem;
        color: #888;
        display: flex;
        align-items: flex-start;
    }
    .dash-list-item .dot {
        font-size: 2rem;
        line-height: 0.7;
        margin-right: 8px;
        font-weight: bold;
    }
    .dash-list-item strong {
        color: #333;
        font-size: 1.1rem;
        display: block;
    }

    .flex-row-center {
        display: flex;
        align-items: center;
        justify-content: space-between;
        height: 100%;
        padding-right: 15px;
    }
    
    @media (max-width: 991px) {
        .pb-stats-container {
            flex-wrap: wrap;
            gap: 20px;
        }
    }

    .modern-calendar-box {
        background: linear-gradient(145deg, var(--secondary-clr), #3b1304);
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
    
    #calendarTabs .nav-link.active {
        background-color: rgba(255, 255, 255, 0.2) !important;
        color: #fff !important;
    }
    #calendarTabs .nav-link:hover {
        background-color: rgba(255, 255, 255, 0.1);
    }
</style>
@endpush

@section('content')
<h1 class="dashboard-title">Dashboard</h1>

<div class="row g-4">
    <!-- Row 1 -->
    <div class="col-lg-3 col-md-4">
        <div class="dash-card">
            <div class="dash-card-title">Pesanan Baru</div>
            <div class="big-number">{{ $pesananBaruCount }}</div>
            <a href="{{ route('pemesanan', ['tab' => 'menunggu']) }}" class="action-btn-circle"><i class="fas fa-arrow-right"></i></a>
        </div>
    </div>
    
    <div class="col-lg-9 col-md-8">
        <div class="dash-card">
            <div class="dash-card-title">Pesanan Berjalan</div>
            <div class="pb-stats-container">
                @forelse($pesananBerjalanStats as $label => $count)
                <div class="pb-stat-item">
                    <div class="pb-stat-num">{{ $count }}</div>
                    <div class="pb-stat-label">{{ $label }}</div>
                </div>
                @empty
                <div class="pb-stat-item w-100 text-center text-muted">Belum ada pesanan berjalan</div>
                @endforelse
                
                @if($pesananBerjalanStats->count() > 0)
                <div class="pb-stat-item">
                    <div class="chart-container chart-container-lg">
                        <canvas id="pesananChart"></canvas>
                        <div class="chart-center-text">{{ $pesananBerjalanCount }}</div>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Row 2 -->
    <div class="col-lg-3 col-md-4">
        <div class="dash-card">
            <div class="dash-card-title">Pesanan Selesai</div>
            <div class="big-number">{{ $pesananSelesaiCount }}</div>
            <a href="{{ route('pemesanan', ['tab' => 'selesai']) }}" class="action-btn-circle"><i class="fas fa-arrow-right"></i></a>
        </div>
    </div>

    <div class="col-lg-4 col-md-4">
        <div class="dash-card">
            <div class="dash-card-title">Jenis Fasilitas</div>
            <div class="flex-row-center">
                <ul class="dash-list">
                    <li class="dash-list-item">
                        <span class="dot" style="color: var(--primary-clr);">&bull;</span>
                        <div>
                            <strong>{{ $fasilitasElektronik }}</strong>
                            Elektronik
                        </div>
                    </li>
                    <li class="dash-list-item">
                        <span class="dot" style="color: var(--secondary-clr);">&bull;</span>
                        <div>
                            <strong>{{ $fasilitasNonElektronik }}</strong>
                            Non-Elektronik
                        </div>
                    </li>
                </ul>
                <div class="chart-container">
                    <canvas id="jenisChart"></canvas>
                    <div class="chart-center-text">{{ $totalJenisFasilitas }}</div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-5 col-md-4">
        <div class="dash-card">
            <div class="dash-card-title">Status Fasilitas</div>
            <div class="flex-row-center">
                <ul class="dash-list">
                    <li class="dash-list-item">
                        <span class="dot" style="color: var(--primary-clr);">&bull;</span>
                        <div>
                            <strong>{{ $fasTersedia }}</strong>
                            Tersedia
                        </div>
                    </li>
                    <li class="dash-list-item">
                        <span class="dot" style="color: var(--secondary-clr);">&bull;</span>
                        <div>
                            <strong>{{ $fasTerpakai }}</strong>
                            Terpakai
                        </div>
                    </li>
                    <li class="dash-list-item">
                        <span class="dot" style="color: var(--secondary-clr2);">&bull;</span>
                        <div>
                            <strong>{{ $fasPemeliharaan }}</strong>
                            Pemeliharaan
                        </div>
                    </li>
                </ul>
                <div class="chart-container">
                    <canvas id="statusChart"></canvas>
                    <div class="chart-center-text">{{ $totalStatusFasilitas }}</div>
                </div>
            </div>
        </div>
    </div>

    <div class="g-4 mt-4">
        <div class="col-12">
            <div class="modern-calendar-box" style="padding: 30px; min-height: 280px; text-align: center;">
                <h3 class="mb-3" style="font-family: 'CMG Sans', serif; font-weight: 700; position: relative; z-index: 1;">
                    Kalender
                </h3>
                
                <ul class="nav nav-pills justify-content-center mb-4" id="calendarTabs" role="tablist" style="position: relative; z-index: 1;">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="tab-booking" data-bs-toggle="pill" data-bs-target="#pane-booking" type="button" role="tab" style="color: #fff; font-weight: bold; padding: 10px 20px; border-radius: 20px;">Booking</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="tab-pemeliharaan" data-bs-toggle="pill" data-bs-target="#pane-pemeliharaan" type="button" role="tab" style="color: #fff; font-weight: bold; padding: 10px 20px; border-radius: 20px;">Pemeliharaan</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="tab-karyawan" data-bs-toggle="pill" data-bs-target="#pane-karyawan" type="button" role="tab" style="color: #fff; font-weight: bold; padding: 10px 20px; border-radius: 20px;">Karyawan</button>
                    </li>
                </ul>
                
                <div class="tab-content" id="calendarTabContent" style="position: relative; z-index: 1;">
                    <div class="tab-pane fade show active" id="pane-booking" role="tabpanel">
                        <div id="calendar-booking" class="mx-auto" style="max-width: 1500px; background: #FDF9F5; padding: 20px; border-radius: 16px; color: #333; text-align: left;"></div>
                    </div>
                    <div class="tab-pane fade" id="pane-pemeliharaan" role="tabpanel">
                        <div id="calendar-pemeliharaan" class="mx-auto" style="max-width: 1500px; background: #FDF9F5; padding: 20px; border-radius: 16px; color: #333; text-align: left;"></div>
                    </div>
                    <div class="tab-pane fade" id="pane-karyawan" role="tabpanel">
                        <div id="calendar-karyawan" class="mx-auto" style="max-width: 1500px; background: #FDF9F5; padding: 20px; border-radius: 16px; color: #333; text-align: left;"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const primaryClr = getComputedStyle(document.documentElement).getPropertyValue('--primary-clr').trim();
        const secondaryClr = getComputedStyle(document.documentElement).getPropertyValue('--secondary-clr').trim();
        const secondaryClr2 = getComputedStyle(document.documentElement).getPropertyValue('--secondary-clr2').trim();

        const commonOptions = {
            responsive: true,
            maintainAspectRatio: false,
            cutout: '75%',
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    enabled: false
                }
            }
        };

        @if($pesananBerjalanStats->count() > 0)
        new Chart(document.getElementById('pesananChart'), {
            type: 'doughnut',
            data: {
                labels: {!! json_encode($pesananBerjalanStats->keys()) !!},
                datasets: [{
                    data: {!! json_encode($pesananBerjalanStats->values()) !!},
                    backgroundColor: [primaryClr, secondaryClr, secondaryClr2, '#ccc', '#999'],
                    borderWidth: 0
                }]
            },
            options: commonOptions
        });
        @endif

        new Chart(document.getElementById('jenisChart'), {
            type: 'doughnut',
            data: {
                labels: ['Elektronik', 'Non-Elektronik'],
                datasets: [{
                    data: [{{ $fasilitasElektronik }}, {{ $fasilitasNonElektronik }}],
                    backgroundColor: [primaryClr, secondaryClr],
                    borderWidth: 0
                }]
            },
            options: commonOptions
        });

        new Chart(document.getElementById('statusChart'), {
            type: 'doughnut',
            data: {
                labels: ['Tersedia', 'Terpakai', 'Pemeliharaan'],
                datasets: [{
                    data: [{{ $fasTersedia }}, {{ $fasTerpakai }}, {{ $fasPemeliharaan }}],
                    backgroundColor: [primaryClr, secondaryClr, secondaryClr2],
                    borderWidth: 0
                }]
            },
            options: commonOptions
        });
    });

    document.addEventListener('DOMContentLoaded', function() {
        function initCalendar(elId, eventsData) {
            var el = document.getElementById(elId);
            if (!el) return null;
            var cal = new FullCalendar.Calendar(el, {
                initialView: 'dayGridMonth',
                events: eventsData,
                height: 'auto',
                headerToolbar: {
                    left: 'prev,next',
                    center: 'title',
                    right: 'today',
                }
            });
            cal.render();
            return cal;
        }

        var calBooking = initCalendar('calendar-booking', @json($events));
        var calPemeliharaan = initCalendar('calendar-pemeliharaan', @json($pemeliharaanEvents));
        var calKaryawan = initCalendar('calendar-karyawan', @json($karyawanEvents));

        var tabEls = document.querySelectorAll('button[data-bs-toggle="pill"]');
        tabEls.forEach(function(btn) {
            btn.addEventListener('shown.bs.tab', function(e) {
                if(e.target.id === 'tab-booking') {
                    calBooking.render();
                } else if(e.target.id === 'tab-pemeliharaan') {
                    calPemeliharaan.render();
                } else if(e.target.id === 'tab-karyawan') {
                    calKaryawan.render();
                }
            });
        });
    });
</script>
@endpush