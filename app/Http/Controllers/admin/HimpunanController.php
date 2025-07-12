<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Himpunan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class HimpunanController extends Controller
{
    /**
     * Menampilkan form untuk mengedit informasi organisasi.
     */
    public function edit()
    {
        // Ambil data organisasi pertama (dan satu-satunya) dari tabel
        $organisasi = Himpunan::firstOrFail();
        return view('admin.organisasi-edit', compact('organisasi'));
    }

    /**
     * Mengupdate informasi organisasi di database.
     */
    public function update(Request $request)
    {
        $organisasi = Himpunan::firstOrFail();

        $request->validate([
            'profil_singkat' => 'required|string',
            'sejarah_singkat' => 'required|string',
            'visi' => 'required|string',
            'misi' => 'required|string',
            'nama_ketua' => 'required|string|max:255',
            'foto_ketua' => 'nullable|image|max:2048',
            'gambar_struktur_organisasi' => 'nullable|image|max:2048',
        ]);
        
        $dataToUpdate = $request->except(['foto_ketua', 'gambar_struktur_organisasi']);

        if ($request->hasFile('foto_ketua')) {
            if ($organisasi->foto_ketua) Storage::disk('public')->delete($organisasi->foto_ketua);
            $dataToUpdate['foto_ketua'] = $request->file('foto_ketua')->store('organisasi', 'public');
        }

        if ($request->hasFile('gambar_struktur_organisasi')) {
            if ($organisasi->gambar_struktur_organisasi) Storage::disk('public')->delete($organisasi->gambar_struktur_organisasi);
            $dataToUpdate['gambar_struktur_organisasi'] = $request->file('gambar_struktur_organisasi')->store('organisasi', 'public');
        }

        $organisasi->update($dataToUpdate);

        return redirect()->route('admin.dashboard')->with('success', 'Informasi organisasi berhasil diperbarui!');
    }
}