<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class AdminProfileController extends Controller
{
    public function index()
    {
        // INI DIA INTEGRASINYA!
        // Auth::user() secara otomatis mengambil seluruh data dari user
        // yang sesi loginnya sedang aktif saat ini.
        $user = Auth::user();

        // Lalu kita kirim data user tersebut ke view
        return view('admin.anggota.profile-admin', ['anggota' => $user]);
    }

    /**
     * Menampilkan form untuk edit profil.
     */
    public function edit()
    {
        return view('admin.anggota.profile-edit', ['user' => Auth::user()]);
    }

    /**
     * Memproses update profil.
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'nama_lengkap' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'password' => ['nullable', 'confirmed', Password::defaults()],
        ]);

        $user->nama_lengkap = $request->nama_lengkap;
        $user->email = $request->email;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->route('admin.profile.show')->with('success', 'Profil berhasil diperbarui!');
    }
    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

    public function cetakKartu()
    {
        $user = Auth::user();
        return view('admin.anggota.kartu-anggota', compact('user'));
    }
}
