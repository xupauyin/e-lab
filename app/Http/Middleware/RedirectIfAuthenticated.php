<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (Auth::guard($guard)->check()) {
            if(Auth::user()->role=='koordinator') {
                return redirect()->route('koordinator.home');
            } else if (Auth::user()->role=='laboran') {
                return redirect()->route('laboran.home');
            } else if (Auth::user()->role=='administrator') {
                return redirect()->route('administrator.home');
            }
        }

        return $next($request);
    }
}
