<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Penyewa\dashboardPeController as dashboardPenyewa;

// 1. Area Publik
Route::get('/', [LandingPageController::class, 'index'])->name('home');
Route::get('/kamar/{id}', [dashboardPenyewa::class, 'show'])->name('kamar.show');


// 2. Guest Area
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'index'])->name('login');
    Route::post('/login', [AuthController::class, 'authenticate']);
    Route::get('/register', [AuthController::class, 'registerIndex'])->name('register');
    Route::post('/register', [AuthController::class, 'store']);
});


// 3. Area Wajib Login
Route::middleware('auth')->group(function () {

    // Logout Tunggal
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // A. Bagian Admin/Owner Master - Tugas ...
    Route::middleware(['auth', 'can:access-admin'])->prefix('admin')->group(function () {
        Route::get('/dashboard', function () {
            return '
            <h1>Dashboard Admin Tugase sopo iki...</h1>
            <p>Halo ' . auth()->user()->nickname . ', Anda login sebagai Admin.</p>
            <form action="' . route('logout') . '" method="POST">
                ' . csrf_field() . '
                <button type="submit" style="color:red; font-weight:bold; cursor:pointer;">LOGOUT SEKARANG</button>
            </form>
        ';
        })->name('admin.dashboard');
    });

    // B. Bagian Pegawai - Tugas ...
    Route::middleware(['auth', 'can:access-pegawai'])->prefix('pegawai')->group(function () {
        Route::get('/dashboard', function () {
            return '
            <h1>Dashboard pegawai Tugase Sopo iki...</h1>
            <p>Halo ' . auth()->user()->nickname . ', Anda login sebagai pegawai.</p>
            <form action="' . route('logout') . '" method="POST">
                ' . csrf_field() . '
                <button type="submit" style="color:red; font-weight:bold; cursor:pointer;">LOGOUT SEKARANG</button>
            </form>
        ';
        })->name('pegawai.dashboard');
    });

    // C. Bagian Penyewa - Tugas Hammam
    Route::middleware('can:access-penyewa')->group(function () {
        Route::get('/dashboard', [dashboardPenyewa::class, 'index'])->name('penyewa.dashboard');
        Route::get('/profile', [dashboardPenyewa::class, 'profile'])->name('profile');
    });
});
