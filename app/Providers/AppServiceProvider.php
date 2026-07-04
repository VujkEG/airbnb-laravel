<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Auth\Events\Authenticated;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Schema;

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
        \Illuminate\Pagination\Paginator::useBootstrapFive();
        // Rešava grešku: 1071 Specified key was too long; max key length is 1000 bytes
        Schema::defaultStringLength(191);

        // Presrećemo Laravelovo interno preusmeravanje za ulogovane korisnike
        // i preusmeravamo ih na početnu stranicu umesto na /home
        if (config('auth.defaults.home') === '/home') {
            config(['auth.defaults.home' => '/']);
        }
    }
}