<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\auth\AuthController;
use App\Http\Controllers\auth\SocialAuthController;
use App\Http\Controllers\penyewa\PenyewaController;
use App\Http\Controllers\penyewa\TransactionController;
use App\Http\Controllers\auth\ForgotPasswordController;

Route::get('/', [PenyewaController::class, 'index'])->name('home');
Route::get('/kamar/{id}', [PenyewaController::class, 'show'])->name('kamar.show');

Route::post('/webhook/midtrans', [TransactionController::class, 'webhook'])
    ->name('webhook.midtrans')
    ->withoutMiddleware([\Illuminate\Foundation\Http\Middleware\VerifyCsrfToken::class]);

Route::middleware('guest')->group(function () {
    Route::get('/login',    [AuthController::class, 'index'])->name('login');
    Route::post('/login',   [AuthController::class, 'authenticate']);
    Route::get('/register', [AuthController::class, 'registerIndex'])->name('register');
    Route::post('/register', [AuthController::class, 'store']);

    Route::get('/auth/google',          [SocialAuthController::class, 'redirectToGoogle'])->name('auth.google');
    Route::get('/auth/google/callback', [SocialAuthController::class, 'handleGoogleCallback']);

    Route::get('/forgot-password',       [ForgotPasswordController::class, 'showForgotForm'])->name('password.request');
    Route::post('/forgot-password',      [ForgotPasswordController::class, 'sendOtp'])->name('password.send-otp');
    Route::get('/verify-otp',            [ForgotPasswordController::class, 'showOtpForm'])->name('password.otp');
    Route::post('/verify-otp',           [ForgotPasswordController::class, 'verifyOtp'])->name('password.verify-otp');
    Route::get('/reset-password',        [ForgotPasswordController::class, 'showResetForm'])->name('password.reset.form');
    Route::post('/reset-password',       [ForgotPasswordController::class, 'resetPassword'])->name('password.reset');
});

Route::middleware('auth')->group(function () {

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::middleware('can:access-admin')->prefix('admin')->group(function () {
        Route::get('/dashboard', function () {
            $user = Auth::user();
            return '
                <h1>Dashboard Admin</h1>
                <p>Halo ' . $user->nickname . ', Anda login sebagai Admin.</p>
                <form action="' . route('logout') . '" method="POST">
                    ' . csrf_field() . '
                    <button type="submit" style="color:red;font-weight:bold;cursor:pointer;">LOGOUT</button>
                </form>';
        })->name('admin.dashboard');
    });

    Route::middleware('can:access-pegawai')->prefix('pegawai')->group(function () {
        Route::get('/dashboard', function () {
            $user = Auth::user();
            return '
                <h1>Dashboard Pegawai</h1>
                <p>Halo ' . $user->nickname . ', Anda login sebagai Pegawai.</p>
                <form action="' . route('logout') . '" method="POST">
                    ' . csrf_field() . '
                    <button type="submit" style="color:red;font-weight:bold;cursor:pointer;">LOGOUT</button>
                </form>';
        })->name('pegawai.dashboard');
    });

    Route::middleware('can:access-penyewa')->group(function () {
        Route::get('/dashboard', [PenyewaController::class, 'index'])->name('penyewa.dashboard');

        Route::get('/profile',              [PenyewaController::class, 'profile'])->name('profile');
        Route::put('/profile/update',       [PenyewaController::class, 'updateProfile'])->name('profile.update');
        Route::put('/profile/password',     [PenyewaController::class, 'updatePassword'])->name('profile.password');
        Route::post('/profile/verify',      [PenyewaController::class, 'verify'])->name('profile.verify');
        Route::post('/profile/report',      [PenyewaController::class, 'report'])->name('profile.report');
        Route::get('/transactions/receipt/{id}', [TransactionController::class, 'receipt'])->name('transactions.receipt');

        Route::post('/transactions/confirm',  [TransactionController::class, 'bookingConfirmation'])->name('transactions.confirm');
        Route::post('/transactions/payment',  [TransactionController::class, 'payment'])->name('transactions.payment');
        Route::post('/transactions/checkout', [TransactionController::class, 'checkout'])->name('transactions.checkout');
    });
});
