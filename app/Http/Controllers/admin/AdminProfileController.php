<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use App\Models\Pembayaran;

class AdminProfileController extends Controller
{
    public function index()
    {
        $user = Auth::user();
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

        // 1. Validasi Input (Gabungan Pendaftaran & Pembayaran)
        $request->validate([
            'nama_lengkap' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'password' => ['nullable', 'confirmed', Password::defaults()],
            
            // Data Tambahan (Standard Anggota)
            'no_telp' => 'nullable|string|max:20',
            'jenis_kelamin' => 'nullable|string|in:Laki-laki,Perempuan',
            'tanggal_lahir' => 'nullable|date',
            'agama' => 'nullable|string|max:50',
            'provinsi' => 'nullable|string|max:100',
            'kabupaten_kota' => 'nullable|string|max:100',
            'nip' => 'nullable|string|max:50',
            'npwp' => 'nullable|string|max:50',
            'gol_ruang' => 'nullable|string|max:50',
            'jabatan_fungsional' => 'nullable|string|max:100',
            'asal_instansi' => 'nullable|string|max:100',
            'unit_kerja' => 'nullable|string|max:100',
            
            // File Uploads
            'pas_foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'file_bukti' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048', // Opsional, hanya jika diisi
        ]);

        // 2. Update Data Diri Dasar
        $user->fill($request->except(['password', 'pas_foto', 'file_bukti', 'tipe_anggota', 'level', 'status_pengajuan'])); // level/status dll diproteksi

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        // 3. Handle Update Pas Foto
        if ($request->hasFile('pas_foto')) {
            // Hapus foto lama jika ada
            if ($user->pas_foto) {
                Storage::disk('public')->delete($user->pas_foto);
            }
            $user->pas_foto = $request->file('pas_foto')->store('pas_foto', 'public');
        }
        
        // 4. LOGIKA STATUS & RE-SUBMISSION (PENTING)
        // Jika user sebelumnya DITOLAK (REJECTED), dan dia update profil -> Reset ke PENDING
        if ($user->status_pengajuan == 'rejected') {
            $user->status_pengajuan = 'pending';
            $user->catatan_admin = null; // Hapus catatan penolakan lama
        }

        // 5. Handle Upload Bukti Pembayaran (Jika ada input file_bukti)
        // Ini muncul jika user statusnya 'awaiting_payment' atau diminta upload ulang
        if ($request->hasFile('file_bukti')) {
            
            // Hapus bukti lama yg pending/rejected
            $existingPayment = Pembayaran::where('user_id', $user->id)
                                         ->whereIn('status', ['pending', 'rejected'])
                                         ->first();
            
            if ($existingPayment) {
                 if($existingPayment->file_bukti) {
                    Storage::disk('public')->delete($existingPayment->file_bukti);
                 }
                 $existingPayment->delete();
            }

            $pathPayment = $request->file('file_bukti')->store('bukti_pembayaran', 'public');

            Pembayaran::create([
                'user_id' => $user->id,
                'file_bukti' => $pathPayment,
                'status' => 'pending',
            ]);

            // Ubah status user ke payment_review
            $user->status_pengajuan = 'payment_review';
            $user->catatan_admin = null;
        }

        $user->save();

        return redirect()->route('admin.dashboard')->with('success', 'Profil berhasil diperbarui. Status pengajuan Anda telah disesuaikan.');
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
