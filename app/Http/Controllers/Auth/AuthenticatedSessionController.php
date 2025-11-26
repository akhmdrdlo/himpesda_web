<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Menampilkan halaman login.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Menangani proses login (Autentikasi).
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        // 1. Coba Autentikasi
        // Jika password/email salah, Laravel otomatis melempar kembali 
        // ke halaman login dengan membawa variabel $errors.
        $request->authenticate();


        // 2. Regenerasi Session (Keamanan)
        $request->session()->regenerate();

        // 3. Redirect jika Sukses
        // Menambahkan notifikasi selamat datang (Opsional)
        return redirect()->intended(route('admin.dashboard', absolute: false))
                         ->with('status', 'Selamat datang kembali! Anda berhasil masuk.');
    }

    /**
     * Menangani proses logout (Keluar).
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        // PERBAIKAN DISINI:
        // Redirect ke halaman login dengan membawa pesan sukses ('status')
        // Pesan ini akan ditangkap oleh alert hijau di login.blade.php
        return redirect('/')->with('status', 'Anda telah berhasil keluar sistem (Logout).');
    }
}