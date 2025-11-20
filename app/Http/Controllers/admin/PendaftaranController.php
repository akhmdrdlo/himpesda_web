<?php

namespace App\Http\Controllers\Admin; // <-- PASTIKAN INI ADALAH '...Admin'

use App\Http\Controllers\Controller; // <-- Pastikan ini menunjuk ke Controller utama
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PendaftaranController extends Controller
{
    /**
     * Menampilkan formulir pendaftaran (Fase 3.1).
     */
    public function create()
    {
        return view('pages.pendaftaran'); 
    }

    /**
     * Menyimpan pendaftar baru LANGSUNG ke tabel USERS.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'tanggal_lahir' => 'required|date',
            'agama' => 'nullable|string|max:100',
            'no_telp' => 'required|string|max:20',
            'nip' => 'nullable|string|max:20|unique:users,nip',
            'npwp' => 'nullable|string|max:25',
            'jabatan_fungsional' => 'nullable|string|max:255',
            'gol_ruang' => 'nullable|string|max:100',
            'asal_instansi' => 'nullable|string|max:255',
            'unit_kerja' => 'nullable|string|max:255',
            'provinsi' => 'required|string|max:255',
            'provinsi_id' => 'required|string|max:4',
            'kabupaten_kota' => 'required|string|max:255',
            'password' => 'required|string|min:8|confirmed',
            'pas_foto' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $pathPasFoto = $request->file('pas_foto')->store('pas_foto', 'public');

        $user = User::create([
            'nama_lengkap' => $validated['nama_lengkap'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'jenis_kelamin' => $validated['jenis_kelamin'],
            'tanggal_lahir' => $validated['tanggal_lahir'],
            'agama' => $validated['agama'],
            'no_telp' => $validated['no_telp'],
            'nip' => $validated['nip'],
            'npwp' => $validated['npwp'],
            'jabatan_fungsional' => $validated['jabatan_fungsional'],
            'gol_ruang' => $validated['gol_ruang'],
            'asal_instansi' => $validated['asal_instansi'],
            'unit_kerja' => $validated['unit_kerja'],
            'provinsi' => $validated['provinsi'],
            'provinsi_id' => $validated['provinsi_id'],
            'kabupaten_kota' => $validated['kabupaten_kota'],
            'pas_foto' => $pathPasFoto,
            'level' => 'anggota',
            'tipe_anggota' => 'daerah',
            'status_pengajuan' => 'pending',
        ]);

        Auth::login($user);

        return redirect()->route('admin.dashboard');
    }
}