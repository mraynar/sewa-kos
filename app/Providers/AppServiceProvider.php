<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        Gate::define('access-admin', fn($user) => $user->role === 'admin');
        Gate::define('access-pegawai', fn($user) => in_array($user->role, ['admin', 'pegawai']));
        Gate::define('access-penyewa', fn($user) => $user->role === 'penyewa');
        Paginator::useTailwind();
    }
}
