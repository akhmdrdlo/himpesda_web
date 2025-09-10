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
     * FIX: Validasi dan update disesuaikan dengan semua kolom di tabel users.
     */
    public function update(Request $request, $id)
    {
        $anggota = User::findOrFail($id);

        $validated = $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'email' => ['required', 'email', Rule::unique('users')->ignore($anggota->id)],
            'no_telp' => 'nullable|string|max:20',
            'nip' => ['nullable', 'string', 'max:20', Rule::unique('users')->ignore($anggota->id)],
            'jenis_kelamin' => 'nullable|string|max:25',
            'tanggal_lahir' => 'nullable|date',
            'agama' => 'nullable|string|max:20',
            'npwp' => 'nullable|string|max:25',
            'asal_instansi' => 'nullable|string|max:255',
            'unit_kerja' => 'nullable|string|max:255',
            'jabatan_fungsional' => 'nullable|string|max:255',
            'gol_ruang' => 'nullable|string|max:10',
            'pas_foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Memisahkan file dari data teks
        $dataToUpdate = $request->except('pas_foto');

        // Handle upload foto jika ada file baru
        if ($request->hasFile('pas_foto')) {
            // Hapus foto lama jika ada
            if ($anggota->pas_foto) {
                Storage::disk('public')->delete($anggota->pas_foto);
            }
            // Simpan foto baru dan dapatkan path-nyaax:2048
            $path = $request->file('pas_foto')->store('profil-fotos', 'public');
            $dataToUpdate['pas_foto'] = $path;
        }

        // Update data di database
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