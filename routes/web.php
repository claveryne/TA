<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\GoogleController;
use App\Http\Controllers\PemesananController;
use App\Http\Controllers\RuanganController;
use App\Http\Controllers\FasilitasController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PemeliharaanController;

// STARTING PAGE
Route::get('/', [PemesananController::class, 'home']);

// NAVBAR
Route::get('/home', [PemesananController::class, 'home'])->name('home');

Route::get('/login', function () {
    return view('login');
})->name('login');

Route::get('auth/google', [GoogleController::class, 'redirectToGoogle'])->name('google.login');
Route::get('auth/google/callback', [GoogleController::class, 'handleGoogleCallback']);

Route::post('/logout', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/');
})->name('logout');

Route::get('/gallery', fn () => view('gallery'))->name('gallery');
Route::get('/facility', fn () => view('facility'))->name('facility');

Route::get('/booking', [PemesananController::class, 'booking'])->name('booking');
Route::post('/booking/store', [PemesananController::class, 'store'])->name('booking.store');

Route::middleware(['auth', 'is_admin', 'prevent-back-history'])->group(function () {
    Route::get('/dashboard', [PemesananController::class, 'calendar'])->name('dashboard');

    Route::get('/ruangan', [RuanganController::class, 'index'])->name('ruangan');
    Route::post('/ruangan', [RuanganController::class, 'store'])->name('ruangan.store');
    Route::post('/ruangan/edit/{id}', [RuanganController::class, 'update'])->name('ruangan.update');

    Route::get('/fasilitas', [FasilitasController::class, 'index'])->name('fasilitas');
    Route::post('/fasilitas', [FasilitasController::class, 'store'])->name('fasilitas.store');
    Route::post('/fasilitas/edit/{id}', [FasilitasController::class, 'update'])->name('fasilitas.update');
    
    Route::get('/pemesanan', [PemesananController::class, 'index'])->name('pemesanan');
    Route::post('/pemesanan/laporan', [PemesananController::class, 'cetakLaporan'])->name('pemesanan.laporan');
    Route::post('/pemesanan/{id}/status', [PemesananController::class, 'updateStatus'])->name('pemesanan.status');
    Route::post('/pemesanan/{id}/edit', [PemesananController::class, 'edit'])->name('pemesanan.edit');

    Route::get('/pemeliharaan', [PemeliharaanController::class, 'index'])->name('pemeliharaan');
    Route::post('/pemeliharaan', [PemeliharaanController::class, 'store'])->name('pemeliharaan.store');
    Route::post('/pemeliharaan/laporan', [PemeliharaanController::class, 'cetakLaporan'])->name('pemeliharaan.laporan');
    Route::post('/pemeliharaan/edit/{id}', [PemeliharaanController::class, 'update'])->name('pemeliharaan.update');
    
    Route::get('/pelanggan', [UserController::class, 'indexPelanggan'])->name('pelanggan');
    Route::post('/pelanggan', [UserController::class, 'storePelanggan'])->name('pelanggan.store');
    Route::post('/pelanggan/edit/{id}', [UserController::class, 'updatePelanggan'])->name('pelanggan.update');

    Route::get('/karyawan', [UserController::class, 'indexKaryawan'])->name('karyawan');
    Route::post('/karyawan', [UserController::class, 'storeKaryawan'])->name('karyawan.store');
    Route::post('/karyawan/edit/{id}', [UserController::class, 'updateKaryawan'])->name('karyawan.update');
    
    Route::post('/karyawan/jadwal', [UserController::class, 'storeJadwal'])->name('karyawan.jadwal.store');
    Route::post('/karyawan/jadwal/edit/{id}', [UserController::class, 'updateJadwal'])->name('karyawan.jadwal.update');
});

Route::middleware(['auth', 'prevent-back-history'])->group(function () {
    Route::get('/profile', fn () => view('profile'))->name('profile');
    Route::post('/profile/update', [UserController::class, 'updateProfile'])->name('profile.update');
    Route::get('/history', [PemesananController::class, 'history'])->name('history');
    Route::post('/pemesanan/{id}/batal', [PemesananController::class, 'batal'])->name('pemesanan.batal');
    Route::post('/pemesanan/{id}/nota', [PemesananController::class, 'cetakNota'])->name('pemesanan.nota');
});
