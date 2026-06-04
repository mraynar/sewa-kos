<?php

use App\Http\Controllers\admin\AdditionalServiceController;
use App\Http\Controllers\admin\AdminController;
use App\Http\Controllers\admin\PegawaiController;
use App\Http\Controllers\admin\PesananController;
use App\Http\Controllers\admin\ProfileController;
use App\Http\Controllers\admin\PropertiController;
use App\Http\Controllers\admin\ReportController;
use App\Http\Controllers\admin\UserController;
use App\Http\Controllers\auth\AuthController;
use App\Http\Controllers\auth\ForgotPasswordController;
use App\Http\Controllers\auth\SocialAuthController;
use App\Http\Controllers\pegawai\PegawaiDashboardController;
use App\Http\Controllers\pegawai\PegawaiMaintenanceController;
use App\Http\Controllers\pegawai\PegawaiProfileController;
use App\Http\Controllers\pegawai\PegawaiTaskController;
use App\Http\Controllers\penyewa\PenyewaController;
use App\Http\Controllers\penyewa\TransactionController;
use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PenyewaController::class, 'index'])->name('home');
Route::get('/kamar/{id}', [PenyewaController::class, 'show'])->name('kamar.show');

Route::post('/webhook/midtrans', [TransactionController::class, 'webhook'])
    ->name('webhook.midtrans')
    ->withoutMiddleware([\Illuminate\Foundation\Http\Middleware\VerifyCsrfToken::class]);

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'index'])->name('login');
    Route::post('/login', [AuthController::class, 'authenticate']);
    Route::get('/register', [AuthController::class, 'registerIndex'])->name('register');
    Route::post('/register', [AuthController::class, 'store']);

    Route::get('/auth/google', [SocialAuthController::class, 'redirectToGoogle'])->name('auth.google');
    Route::get('/auth/google/callback', [SocialAuthController::class, 'handleGoogleCallback']);

    Route::get('/forgot-password', [ForgotPasswordController::class, 'showForgotForm'])->name('password.request');
    Route::post('/forgot-password', [ForgotPasswordController::class, 'sendOtp'])->name('password.send-otp');
    Route::get('/verify-otp', [ForgotPasswordController::class, 'showOtpForm'])->name('password.otp');
    Route::post('/verify-otp', [ForgotPasswordController::class, 'verifyOtp'])->name('password.verify-otp');
    Route::get('/reset-password', [ForgotPasswordController::class, 'showResetForm'])->name('password.reset.form');
    Route::post('/reset-password', [ForgotPasswordController::class, 'resetPassword'])->name('password.reset');
});

Route::middleware('auth')->group(function () {

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::middleware('can:access-admin')->prefix('admin')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');

        Route::get('/properti', [PropertiController::class, 'index'])->name('admin.properti.index');
        Route::get('/properti/create', [PropertiController::class, 'create'])->name('admin.properti.create');
        Route::post('/properti', [PropertiController::class, 'store'])->name('admin.properti.store');
        Route::get('/properti/{id}/edit', [PropertiController::class, 'edit'])->name('admin.properti.edit');
        Route::put('/properti/{id}', [PropertiController::class, 'update'])->name('admin.properti.update');
        Route::delete('/properti/{id}', [PropertiController::class, 'destroy'])->name('admin.properti.destroy');

        Route::get('/additional-services', [AdditionalServiceController::class, 'index'])->name('admin.additional_services.index');
        Route::get('/additional-services/create', [AdditionalServiceController::class, 'create'])->name('admin.additional_services.create');
        Route::post('/additional-services', [AdditionalServiceController::class, 'store'])->name('admin.additional_services.store');
        Route::get('/additional-services/{id}/edit', [AdditionalServiceController::class, 'edit'])->name('admin.additional_services.edit');
        Route::put('/additional-services/{id}', [AdditionalServiceController::class, 'update'])->name('admin.additional_services.update');
        Route::delete('/additional-services/{id}', [AdditionalServiceController::class, 'destroy'])->name('admin.additional_services.destroy');

        Route::get('/pengguna', [UserController::class, 'index'])->name('admin.pengguna.index');
        Route::get('/pengguna/create', [UserController::class, 'create'])->name('admin.pengguna.create');
        Route::post('/pengguna', [UserController::class, 'store'])->name('admin.pengguna.store');
        Route::get('/pengguna/{id}/edit', [UserController::class, 'edit'])->name('admin.pengguna.edit');
        Route::put('/pengguna/{id}', [UserController::class, 'update'])->name('admin.pengguna.update');
        Route::delete('/pengguna/{id}', [UserController::class, 'destroy'])->name('admin.pengguna.destroy');

        Route::get('/pegawai', [PegawaiController::class, 'index'])->name('admin.pegawai.index');
        Route::get('/pegawai/create', [PegawaiController::class, 'create'])->name('admin.pegawai.create');
        Route::post('/pegawai', [PegawaiController::class, 'store'])->name('admin.pegawai.store');
        Route::get('/pegawai/{id}/edit', [PegawaiController::class, 'edit'])->name('admin.pegawai.edit');
        Route::put('/pegawai/{id}', [PegawaiController::class, 'update'])->name('admin.pegawai.update');
        Route::delete('/pegawai/{id}', [PegawaiController::class, 'destroy'])->name('admin.pegawai.destroy');

        Route::get('/pesanan', [PesananController::class, 'index'])->name('admin.pesanan.index');

        Route::get('/task', [TaskController::class, 'task'])->name('admin.task.index');
        Route::post('/task/assign', [TaskController::class, 'assignTask'])->name('admin.task.assign');

        Route::get('/admin/laporan', [ReportController::class, 'index'])->name('admin.report.index');
        Route::put('/admin/laporan/assign', [ReportController::class, 'assign'])->name('admin.report.assign');

        Route::get('/admin/profile', [ProfileController::class, 'index'])->name('admin.profile.index');
        Route::put('/admin/profile', [ProfileController::class, 'update'])->name('admin.profile.update');
    });

    Route::middleware(['auth', 'can:access-pegawai'])->prefix('pegawai')->name('pegawai.')->group(function () {
        Route::get('/dashboard', [PegawaiDashboardController::class, 'index'])->name('dashboard');

        Route::get('/tugas', [PegawaiTaskController::class, 'index'])->name('tasks.index');
        Route::put('/tugas/{id}/status', [PegawaiTaskController::class, 'updateStatus'])->name('tasks.update');
        Route::get('/laporan', [PegawaiMaintenanceController::class, 'index'])->name('maintenance.index');
        Route::put('/laporan/{id}/status', [PegawaiMaintenanceController::class, 'updateStatus'])->name('maintenance.update');
        Route::get('/profile', [PegawaiProfileController::class, 'index'])->name('profile.index');
        Route::put('/profile', [PegawaiProfileController::class, 'update'])->name('profile.update');
    });

    Route::middleware('can:access-penyewa')->group(function () {
        Route::get('/dashboard', [PenyewaController::class, 'index'])->name('penyewa.dashboard');

        Route::get('/profile', [PenyewaController::class, 'profile'])->name('profile');
        Route::put('/profile/update', [PenyewaController::class, 'updateProfile'])->name('profile.update');
        Route::put('/profile/password', [PenyewaController::class, 'updatePassword'])->name('profile.password');
        Route::post('/profile/verify', [PenyewaController::class, 'verify'])->name('profile.verify');
        Route::post('/profile/report', [PenyewaController::class, 'report'])->name('profile.report');
        Route::get('/transactions/receipt/{id}', [TransactionController::class, 'receipt'])->name('transactions.receipt');

        Route::post('/transactions/confirm', [TransactionController::class, 'bookingConfirmation'])->name('transactions.confirm');
        Route::post('/transactions/payment', [TransactionController::class, 'payment'])->name('transactions.payment');
        Route::post('/transactions/checkout', [TransactionController::class, 'checkout'])->name('transactions.checkout');
    });
});
