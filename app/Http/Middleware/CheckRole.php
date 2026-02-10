<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        if (!\Illuminate\Support\Facades\Auth::guard('web')->check()
            && !\Illuminate\Support\Facades\Auth::guard('rayon')->check()) {
            return redirect()->route('login');
        }

        $userRole = null;

        if (\Illuminate\Support\Facades\Auth::guard('web')->check()) {
            $userRole = \Illuminate\Support\Facades\Auth::guard('web')->user()->role_slug;
        } elseif (\Illuminate\Support\Facades\Auth::guard('rayon')->check()) {
            $userRole = 'rayon_admin';
        }

        // Admin always has access
        if ($userRole === 'admin') {
            return $next($request);
        }

        // Check if user has one of the allowed roles
        if (!in_array($userRole, $roles)) {
            abort(403, 'Unauthorized access');
        }

        return $next($request);
    }
}
