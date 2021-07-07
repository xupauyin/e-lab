<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class LaboranMiddleware
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
        if(session()->has('inventaris_qr')){
            $id = session('inventaris_qr');

            $request->session()->forget('inventaris_qr');

            return redirect()->route('laboran.maintenance.inputqr', $id);
        }

        if ($request->segment(1) == 'qrlink') {
            session()->put('inventaris_qr', $request->segment(2));
        }

        if(Auth::check()) {
            if(Auth::user()->role == 'laboran') {
                return $next($request);
            } else {
                return redirect()->back();
            }
        }

        return redirect()->route('login');
    }
}
