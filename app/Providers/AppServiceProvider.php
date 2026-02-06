<?php

namespace App\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
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

        // Force HTTPS jika diakses via HTTPS atau di production domain
        if (request()->secure() ||
            str_contains(request()->getHost(), 'shahib-kholil.me') ||
            (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https')) {
            URL::forceScheme('https');
        }

        // Custom password validation rule that supports all guards
        Validator::extend('current_password_any', function ($attribute, $value, $parameters, $validator) {
            $user = Auth::user() ?? Auth::guard('korwil')->user() ?? Auth::guard('rayon')->user();

            if (!$user) {
                return false;
            }

            return Hash::check($value, $user->password);
        });

        Validator::replacer('current_password_any', function ($message, $attribute, $rule, $parameters) {
            return 'Password saat ini tidak sesuai.';
        });
    }
}
