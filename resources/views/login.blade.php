@extends('bar')

@section('title', 'Login')

@push('styles')
<style>
    /* --- Login Section --- */
    .login-section {
        padding: 80px 0;
        background-color: var(--color-light);
        min-height: 70vh;
    }
    .login-card {
        background-color: #ffffff;
        border-radius: 20px;
        padding: 40px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        border: 1px solid rgba(107, 36, 13, 0.05);
    }
    .login-input {
        background-color: #FDF9F5;
        border: 1px solid rgba(107, 36, 13, 0.1);
        border-radius: 12px;
        padding: 14px 18px;
        color: var(--color-primary);
        font-size: 0.95rem;
        transition: all 0.3s ease;
    }
    .login-input:focus {
        outline: none;
        background-color: #FFFFFF;
        border-color: var(--color-secondary);
        box-shadow: 0 0 0 4px rgba(245, 204, 160, 0.3);
    }
    .login-input::placeholder {
        color: rgba(107, 36, 13, 0.4);
    }
    .email-support-box {
        border-radius: 12px;
        padding: 15px;
        margin-top: 20px;
    }
    .provider-badge {
        display: inline-flex;
        align-items: center;
        background: white;
        padding: 5px 12px;
        border-radius: 50px;
        font-size: 0.8rem;
        font-weight: 600;
        color: var(--color-primary);
        box-shadow: 0 2px 5px rgba(0,0,0,0.05);
        margin: 4px;
        border: 1px solid rgba(107, 36, 13, 0.1);
    }
    .provider-badge i {
        margin-right: 6px;
        font-size: 0.9rem;
    }
    .info-text {
        font-size: 0.85rem;
        color: #666;
        margin-bottom: 10px;
        display: block;
    }
    .login-btn {
        background-color: var(--color-primary);
        color: var(--color-light);
        border: none;
        border-radius: 12px;
        padding: 14px 28px;
        font-weight: 600;
        font-size: 1rem;
        transition: all 0.3s ease;
        box-shadow: 0 8px 20px rgba(107, 36, 13, 0.2);
        text-decoration: none;
    }
    .login-btn:hover {
        background-color: #4A1707;
        color: var(--color-secondary);
        transform: translateY(-2px);
        box-shadow: 0 12px 25px rgba(107, 36, 13, 0.3);
        text-decoration: none;
    }
    .fa-google {
        background: conic-gradient(from -45deg, #ea4335 110deg, #4285f4 90deg 180deg, #34a853 180deg 270deg, #fbbc05 270deg) 73% 55%/150% 150% no-repeat;
        -webkit-background-clip: text;
        background-clip: text;
        color: transparent;
        -webkit-text-fill-color: transparent;
        margin-right: 10px;
    }
</style>
@endpush

@section('content')
<!-- Login Section -->
<section class="login-section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-5">
                <div class="login-card">
                    <div class="text-center mb-4">
                        <img src="{{ asset('images/logo Legacy warna 2.png') }}" alt="Logo" width="200" class="mb-3">
                        <h4 class="fw-bold" style="color: #6B240D;">Halo, Selamat Datang!</h4>

                        <div class="email-support-box text-center">
                            <span class="info-text">Mendukung login akun Google dengan penyedia:</span>
                            
                            <div class="d-flex flex-wrap justify-content-center">
                                <div class="provider-badge">
                                    <i class="fa-solid fa-envelope" style="color: #EA4335;"></i> Gmail
                                </div>
                                <div class="provider-badge">
                                    <i class="fa-brands fa-microsoft" style="color: #00A4EF;"></i> Outlook
                                </div>
                                <div class="provider-badge">
                                    <i class="fa-brands fa-yahoo" style="color: #6001d2;"></i> Yahoo
                                </div>
                                <div class="provider-badge">
                                    <i class="fa-brands fa-apple" style="color: #555;"></i> iCloud*
                                </div>
                            </div>
                            
                            <small class="text-muted d-block mt-2" style="font-size: 0.75rem;">
                                *Pastikan email sudah terhubung ke akun Google.
                            </small>
                        </div>
                    </div>
                    
                    <a href="{{ route('google.login') }}" class="btn btn-primary w-100 login-btn d-flex justify-content-center align-items-center" style="text-decoration: none; color: white;">
                        <i class="fa-brands fa-google"></i> Sign in with Google
                    </a>
                    
                    <div class="text-center mt-4">
                        <p class="mb-2">Belum punya akun Google?</p>
                        <a href="https://accounts.google.com/v3/signin/identifier?dsh=S640093762%3A1777370526736286&flowName=GlifWebSignIn&flowEntry=ServiceLogin&ifkv=AWa2PatZt9RdqnAsmlqUg_mnZ8rPN-JS1uxaaAQLrfSbb5An5JLuWwqXomSawVdvDuTE9F_eRV--hw" 
                        class="text-decoration-none fw-bold text-secondary">Daftar Sekarang</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
