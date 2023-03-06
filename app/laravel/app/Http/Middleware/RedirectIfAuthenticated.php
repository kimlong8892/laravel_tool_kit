<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param  Closure  $next
     * @param string|null $guard
     * @return mixed
     */
    public function handle(Request $request, Closure $next, string $guard = null): mixed {
        if (Auth::guard($guard)->check()) {
            if ($guard == 'web') {
                return redirect()->route('web.home');
            } else if ($guard == 'admin') {
                return redirect()->route('admin.home');
            }
        }

        return $next($request);
    }
}
