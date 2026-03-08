<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        Gate::define('access-admin', fn(User $user) => $user->isAdmin());
        Gate::define('access-pegawai', fn(User $user) => $user->isPegawai());
        Gate::define('access-penyewa', fn(User $user) => $user->isPenyewa());
    }
}
