<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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
        $user = Auth::user();
        // berikan query yang dimana levelnya anggota DAN status_pengajuan active
        $query = User::where('level', 'anggota')->where('status_pengajuan', 'active');

        // Filter Wilayah untuk Staff Daerah
        if (in_array($user->level, ['operator_daerah', 'bendahara_daerah'])) {
            $query->where('provinsi', $user->provinsi);
        }
        
        $anggota = $query->latest()->get();
        
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

    public function cetakKartu(User $user)
    {
        // Menggunakan 'user' karena view kartu anggota mengharapkan variabel $user
        return view('admin.anggota.kartu-anggota', ['user' => $user]);
    }

    public function eksporKartu()
    {
        // Mengambil semua user yang levelnya 'anggota'
        $users = User::where('level', 'anggota')->get();
        
        // Pastikan path ke view sudah benar
        return view('admin.anggota.ekspor-kartu', compact('users'));
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

        return redirect()->route('admin.anggota.index')->with('success', 'Data anggota berhasil diimpor!');
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
            'provinsi' => 'nullable|string|max:255',
            'kabupaten_kota' => 'nullable|string|max:255',
            'tipe_anggota' => 'required|in:pusat,daerah',
            // TAMBAHAN VALIDASI LEVEL
            'level' => 'required|string|in:admin,operator,operator_daerah,bendahara,bendahara_daerah,anggota',
        ]);

        // Memisahkan file dari data teks
        $dataToUpdate = $request->except(['pas_foto', '_token', '_method']);

        // --- LOGIKA KEAMANAN LEVEL (ROLE) ---
        // Cek apakah user yang login adalah Admin atau Operator
        if (in_array(Auth::user()->level, ['admin', 'operator'])) {
            // Jika ya, gunakan level dari input form
            $dataToUpdate['level'] = $request->level;
        } else {
            // Jika bukan (misal: operator daerah iseng inspect element), 
            // kembalikan level ke level aslinya di database.
            $dataToUpdate['level'] = $anggota->level;
        }

        // --- Logika Khusus untuk Tipe Anggota ---
        // Hanya admin yang bisa mengubah tipe anggota (Sesuai request sebelumnya)
        if (Auth::user()->level != 'admin') {
            $dataToUpdate['tipe_anggota'] = $anggota->tipe_anggota;
        }

        // Handle upload foto jika ada file baru
        if ($request->hasFile('pas_foto')) {
            if ($anggota->pas_foto) {
                Storage::disk('public')->delete($anggota->pas_foto);
            }
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
        // FIX 2: Implementasi logika hapus yang sebenarnya
        $anggota = User::findOrFail($id);
        
        // Hapus foto jika ada
        if ($anggota->pas_foto) {
            Storage::disk('public')->delete($anggota->pas_foto);
        }
        
        $anggota->delete();
        
        return redirect()->route('admin.anggota.index')->with('success', 'Anggota berhasil dihapus.');
    }
}