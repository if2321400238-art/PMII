<?php

namespace App\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\URL;
use App\Http\Middleware\CheckRole;
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
        // Pastikan alias middleware 'role' terdaftar (jaga-jaga jika cache bermasalah)
        Route::aliasMiddleware('role', CheckRole::class);

        // Force HTTPS hanya di production dengan APP_URL yang valid
        if (config('app.env') === 'production' && !app()->runningInConsole() && str_contains(config('app.url'), 'https://')) {
            URL::forceScheme('https');
        }
    }
}
