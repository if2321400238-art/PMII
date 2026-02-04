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

        // Force HTTPS di production kecuali di localhost
        if (config('app.env') === 'production' && !str_contains(request()->getHost(), 'localhost')) {
            URL::forceScheme('https');
        }
    }
}
