<?php

namespace App\Providers;

use Carbon\Carbon;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        config(['app.locale' => 'id']);
        Carbon::setLocale('id');

        // Gate untuk role Admin
        Gate::define('admin', function ($user) {
            return $user->role === 'Admin';
        });

        // Gate untuk role Dokter
        Gate::define('dokter', function ($user) {
            return $user->role === 'Dokter';
        });

        // Gate untuk role Apotek
        Gate::define('apotek', function ($user) {
            return $user->role === 'Apotek';
        });

        // Gate untuk role Pasien
        Gate::define('pasien', function ($user) {
            return $user->role === 'Pasien';
        });
    }
}