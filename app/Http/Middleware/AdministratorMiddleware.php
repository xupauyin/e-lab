<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class AdministratorMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($request->segment(1) == 'qrlink') {
            session()->put('inventaris_qr', $request->segment(2));
        }

        if (Auth::check()) {
            if (Auth::user()->role == 'administrator') {
                return $next($request);
            }

            return redirect()->back();
        }
        
        return redirect()->route('login');
    }
}
