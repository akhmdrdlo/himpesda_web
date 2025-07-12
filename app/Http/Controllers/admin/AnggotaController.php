<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\AnggotaImport;


class AnggotaController extends Controller
{
    /**
     * Menampilkan halaman daftar semua anggota.
     */
    public function index()
    {
        $anggota = User::where('level', 'anggota')->latest()->get();
        return view('admin.anggota.daftar-anggota', compact('anggota'));
    }

         /**
     * MENAMPILKAN HALAMAN Detail anggota
     */
    public function show($id)
    {
        $anggota = User::findOrFail($id);
        return view('admin.anggota.detail-anggota', compact('anggota'));
    }
    /**
     * Menampilkan form untuk mengimpor anggota dari file Excel.
     */
    public function showImportForm()
    {
        return view('admin.anggota.import-anggota');
    }
    /**
     * MEMPROSES FILE EXCEL YANG DIUNGGAH
     * (Method ini sudah kita buat sebelumnya, tidak perlu diubah)
     */
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls',
        ]);

        Excel::import(new AnggotaImport, $request->file('file'));

        return redirect()->route('admin.anggota.anggota.index')->with('success', 'Data anggota berhasil diimpor!');
    }

    /**
     * Menampilkan form untuk mengedit anggota.
     */
    public function edit($id)
    {
        $anggota = User::findOrFail($id);
        return view('admin.anggota.edit-anggota', compact('anggota'));
    }

    /**
     * Memproses dan menyimpan perubahan data anggota.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'email' => ['required', 'email', Rule::unique('users')->ignore($id)],
            'nip' => ['nullable', 'string', 'max:20', Rule::unique('users')->ignore($id)],
            'tanggal_lahir' => 'nullable|date',
            'jenis_kelamin' => 'nullable|string',
            'jabatan_fungsional' => 'nullable|string|max:255',
            'pas_foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $anggota = User::findOrFail($id);
        $dataToUpdate = $request->except('pas_foto');

        if ($request->hasFile('pas_foto')) {
            if ($anggota->pas_foto) {
                Storage::disk('public')->delete($anggota->pas_foto);
            }
            $path = $request->file('pas_foto')->store('profil-fotos', 'public');
            $dataToUpdate['pas_foto'] = $path;
        }

        $anggota->update($dataToUpdate);

        return redirect()->route('admin.anggota.show', $anggota->id)->with('success', 'Profil anggota berhasil diperbarui!');
    }

    /**
     * Menghapus data anggota.
     */
    public function destroy($id)
    {
        // Logika untuk menghapus akan kita implementasikan nanti.
        // Untuk saat ini, kita hanya redirect kembali.
        return redirect()->route('admin.anggota.index')->with('info', 'Fungsi hapus belum diimplementasikan.');
    }
}