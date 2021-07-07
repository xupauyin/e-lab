<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class KoordinatorMiddleware
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
        // if (request()->segment(3) == 'qrlink') {
        //     $id = request()->segment(4);

        //     if (Auth::check() && Auth::user()->role == 'koordinator') {
        //         return redirect()->route('koordinator.inventaris.edit', $id);
        // } else {
        //     session()->put('qrdata', $id);

        //     session()->flash('failed', 'Silahkan login terlebih dahulu');

        //     return redirect()->back();
        //      }
        // }

        // if(session()->has('qrdata')){
        //     $id = session('qrdata');

        //     $request->session()->forget('qrdata');

        //     return redirect()->route('koordinator.inventaris.edit', $id);
        // }

        if ($request->segment(1) == 'qrlink') {
            session()->put('inventaris_qr', $request->segment(2));
        }

        if (Auth::check() && Auth::user()->role == 'koordinator') {
            return $next($request);
        }

        return redirect()->route('login');
    }
}
