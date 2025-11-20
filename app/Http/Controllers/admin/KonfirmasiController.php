<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pembayaran;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon; // Import Carbon untuk mengisi activated_at

class KonfirmasiController extends Controller
{
    /**
     * Fungsi terpusat untuk otorisasi halaman ini
     */
    private function authorizeAccess()
    {
        // Tambahkan bendahara_daerah ke array izin
        if (!in_array(auth()->user()->level, ['admin', 'bendahara', 'bendahara_daerah'])) {
            abort(403, 'ANDA TIDAK MEMILIKI AKSES KE HALAMAN INI.');
        }
    }

    /**
     * Menampilkan halaman daftar konfirmasi pembayaran.
     * Logika ini menggantikan index() lama.
     */
    public function index()
    {
        $this->authorizeAccess();

        // Ambil data pembayaran yang masih 'pending'
        // 'with('user')' untuk eager loading data user (efisien)
        $pembayaranPending = Pembayaran::with('user')
                            ->where('status', 'pending')
                            ->whereHas('user', function ($query) {
                                // Pastikan user-nya juga dalam status 'payment_review'
                                $query->where('status_pengajuan', 'payment_review');
                            })
                            ->latest()
                            ->get();
        
        // Ambil statistik
        $menungguKonfirmasi = $pembayaranPending->count();
        // Hitung anggota terdaftar (juga difilter per wilayah)
        $anggotaQuery = User::where('status_pengajuan', 'active');
        if ($user->level == 'bendahara_daerah') {
            $anggotaQuery->where('provinsi', $user->provinsi);
        }
        $anggotaTerdaftar = $anggotaQuery->count();

        return view('admin..pendaftar.konfirmasi-pembayaran', compact('pembayaranPending', 'menungguKonfirmasi', 'anggotaTerdaftar'));
    }

    /**
     * Menyetujui pembayaran (Aksi Bendahara).
     * Di sinilah 'activated_at' diisi.
     */
    public function approve(Pembayaran $pembayaran)
    {
        $this->authorizeAccess();

        // 1. Update status pembayaran
        $pembayaran->update([
            'status' => 'approved',
            'catatan_admin' => 'Dikonfirmasi oleh ' . auth()->user()->nama_lengkap,
        ]);

        // 2. Dapatkan user terkait
        $user = $pembayaran->user;

        // 3. Generate Nomor KTA (Kartu Tanda Anggota)
        $kodeProvinsi = $user->provinsi_id ?? '00'; // '00' jika provinsi_id null
        $nomorUrut = str_pad($user->id, 4, '0', STR_PAD_LEFT); 
        $nomorKTA = $kodeProvinsi . $nomorUrut;

        // 4. Update status user menjadi 'active'
        $user->update([
            'status_pengajuan' => 'active',
            'nomor_anggota' => $nomorKTA,
            'activated_at' => Carbon::now(), // <-- KODE DI SINI: Mengisi tanggal aktivasi
        ]);

        return redirect()->route('admin.konfirmasi.index')->with('success', 'Pembayaran untuk ' . $user->nama_lengkap . ' berhasil dikonfirmasi. Anggota kini aktif.');
    }

    /**
     * Menolak pembayaran (Aksi Bendahara).
     */
    public function reject(Request $request, Pembayaran $pembayaran)
    {
        $this->authorizeAccess();

        $request->validate([
            'catatan_penolakan' => 'required|string|max:255',
        ]);

        // 1. Update status pembayaran
        $pembayaran->update([
            'status' => 'rejected',
            'catatan_admin' => $request->catatan_penolakan,
        ]);

        // 2. Kembalikan status user ke 'awaiting_payment' agar bisa upload ulang
        $pembayaran->user->update([
            'status_pengajuan' => 'awaiting_payment',
            'catatan_penolakan' => $request->catatan_penolakan,
        ]);

        return redirect()->route('admin.konfirmasi.index')->with('success', 'Pembayaran untuk ' . $pembayaran->user->nama_lengkap . ' telah ditolak.');
    }
}