<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class IsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Periksa apakah user sudah login DAN levelnya adalah salah satu dari peran admin/staf
        if (Auth::check() && in_array(Auth::user()->level, ['admin', 'operator', 'operator_daerah', 'bendahara'])) {
            // Jika ya, izinkan akses ke rute admin
            return $next($request);
        }

        // Jika tidak, kembalikan ke dashboard anggota (halaman tracer)
        return redirect()->route('dashboard')->with('error', 'Anda tidak memiliki hak akses ke halaman admin.');
    }
}