<?php

namespace App\Providers;

use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Force HTTPS with ngrok
        if (env('WITH_NGROK') === true) {
            if (env(key: 'APP_ENV') === 'local' && request()->server(key: 'HTTP_X_FORWARDED_PROTO') === 'https') {
                URL::forceScheme(scheme: 'https');
            }
        }
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
    }
}
