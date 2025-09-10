<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pendaftar;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class KonfirmasiController extends Controller
{
    // Fungsi terpusat untuk otorisasi halaman ini
    private function authorizeAccess()
    {
        if (!in_array(auth()->user()->level, ['admin', 'bendahara'])) {
            abort(403, 'ANDA TIDAK MEMILIKI AKSES KE HALAMAN INI.');
        }
    }

    public function index()
    {
        $this->authorizeAccess(); 
        $pendaftar = Pendaftar::whereNotIn('status_anggota', ['Aktif', 'Ditolak'])->latest()->get();
        $menungguKonfirmasi = $pendaftar->count();
        $anggotaTerdaftar = User::where('level', 'anggota')->count();
        return view('admin.pendaftar.konfirmasi-pembayaran', compact('pendaftar', 'menungguKonfirmasi', 'anggotaTerdaftar'));
    }

    public function show(Pendaftar $pendaftar)
    {
        $this->authorizeAccess(); // Panggil pengecekan di sini
        // Dengan Route Model Binding, Laravel otomatis mencari pendaftar berdasarkan ID dari URL
        return view('admin.pendaftar.detail-pendaftar', compact('pendaftar'));
    }

    /**
     * Update status pendaftar dan promosikan menjadi anggota jika syarat terpenuhi.
     */
    public function updateStatus(Request $request, Pendaftar $pendaftar)
    {
        $this->authorizeAccess(); // Panggil pengecekan di sini
        $request->validate([
            'status_pembayaran' => 'required|in:Belum Lunas,Sudah Lunas',
            'status_anggota' => 'required|in:Menunggu Konfirmasi,Sedang Diproses,Aktif,Ditolak',
        ]);

        // Jika status tidak diubah menjadi "Aktif", cukup update statusnya saja
        if ($request->status_pembayaran !== 'Sudah Lunas' || $request->status_anggota !== 'Aktif') {
            $pendaftar->status_pembayaran = $request->status_pembayaran;
            $pendaftar->status_anggota = $request->status_anggota;
            $pendaftar->save();

            return redirect()->route('admin.konfirmasi.index')->with('success', 'Status untuk ' . $pendaftar->nama_lengkap . ' berhasil diperbarui.');
        }

        // --- PROSES PROMOSI MENJADI ANGGOTA AKTIF ---
        try {
            // Gunakan provinsi_id dari pendaftar sebagai awalan KTA
            $kodeProvinsi = $pendaftar->provinsi_id; 
            $nomorUrut = str_pad($pendaftar->id, 4, '0', STR_PAD_LEFT); 
            $nomorKTA = $kodeProvinsi . $nomorUrut; 

            // Pindahkan data pendaftar ke tabel users
            User::create([
                'nomor_anggota' => $nomorKTA,
                'provinsi_id' => $pendaftar->provinsi_id, 
                'nama_lengkap' => $pendaftar->nama_lengkap,
                'email' => $pendaftar->email,
                'password' => $pendaftar->password, 
                'no_telp' => $pendaftar->no_telp,
                'nip' => $pendaftar->nip,
                'jenis_kelamin' => $pendaftar->jenis_kelamin,
                'tanggal_lahir' => $pendaftar->tanggal_lahir,
                'agama' => $pendaftar->agama,
                'npwp' => $pendaftar->npwp,
                'asal_instansi' => $pendaftar->asal_instansi,
                'unit_kerja' => $pendaftar->unit_kerja,
                'jabatan_fungsional' => $pendaftar->jabatan_fungsional,
                'gol_ruang' => $pendaftar->gol_ruang,
                'pas_foto' => $pendaftar->pas_foto,
                'level' => 'anggota',
                'provinsi' => $pendaftar->provinsi,
                'kabupaten_kota' => $pendaftar->kabupaten_kota,
            ]);

            // Hapus data dari tabel pendaftar setelah berhasil dipromosikan
            $pendaftar->delete();

            return redirect()->route('admin.konfirmasi.index')->with('success', $pendaftar->nama_lengkap . ' telah berhasil diaktifkan menjadi anggota dengan KTA: ' . $nomorKTA);

        } catch (\Exception $e) {
            // Jika terjadi error, kembalikan dengan pesan error
            return redirect()->route('admin.konfirmasi.index')->with('error', 'Gagal mengaktifkan anggota: ' . $e->getMessage());
        }
    }


}