<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Pembayaran;
use App\Helpers\KtaHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class VerifikasiController extends Controller
{
    /**
     * Menampilkan satu halaman cerdas untuk seluruh alur verifikasi.
     * Halaman ini akan menampilkan data berbeda berdasarkan level user.
     */
    public function index()
    {
        $user = Auth::user();
        $level = $user->level;
        $provinsiUser = $user->provinsi; // Asumsi kolom provinsi ada di tabel users

        // Default kosong
        $pendaftarPending = collect();
        $pembayaranPending = collect();

        // --- LOGIKA 1: VERIFIKASI DATA (Admin, Operator Pusat, Operator Daerah) ---
        if (in_array($level, ['admin', 'operator', 'operator_daerah'])) {
            
            $query = User::where('status_pengajuan', 'pending');

            // Jika Operator Daerah, filter hanya provinsi dia
            if ($level == 'operator_daerah') {
                $query->where('provinsi', $provinsiUser);
            }

            $pendaftarPending = $query->latest()->get();
        }

        // --- LOGIKA 2: VERIFIKASI PEMBAYARAN (Admin, Bendahara Pusat, Bendahara Daerah) ---
        if (in_array($level, ['admin', 'bendahara', 'bendahara_daerah'])) {
            
            $query = Pembayaran::with('user')
                ->where('status', 'pending')
                ->whereHas('user', function ($q) use ($level, $provinsiUser) {
                    $q->where('status_pengajuan', 'payment_review');
                    
                    // Jika Bendahara Daerah, filter user berdasarkan provinsi bendahara
                    if ($level == 'bendahara_daerah') {
                        $q->where('provinsi', $provinsiUser);
                    }
                });

            $pembayaranPending = $query->latest()->get();
        }
        
        // Statistik untuk Card
        $menungguVerifikasiData = $pendaftarPending->count();
        $menungguKonfirmasiBayar = $pembayaranPending->count();

        return view('admin.pendaftar.index', compact(
            'pendaftarPending', 
            'pembayaranPending',
            'menungguVerifikasiData',
            'menungguKonfirmasiBayar'
        ));
    }

    /**
     * HALAMAN BARU: Tracing/Monitoring Pembayaran (History)
     * Menampilkan semua riwayat pembayaran (Pending, Approved, Rejected).
     */
    public function tracing()
    {
        $user = Auth::user();
        $level = $user->level;
        
        // 1. Definisi Query Dasar (Ambil semua pembayaran)
        $query = Pembayaran::with('user')->latest();

        // 2. Penerapan Filter Wilayah (Regional Scoping)
        // Jika User adalah staf DAERAH (Operator Daerah / Bendahara Daerah)
        if (in_array($level, ['operator_daerah', 'bendahara_daerah'])) {
            // Filter pembayaran hanya dari user yang provinsinya sama dengan staf
            $query->whereHas('user', function ($q) use ($user) {
                $q->where('provinsi', $user->provinsi);
            });
        }

        // 3. Eksekusi Query
        $riwayatPembayaran = $query->get();

        return view('admin.pendaftar.tracing', compact('riwayatPembayaran'));
    }

    // ===============================================
    // AKSI UNTUK VERIFIKASI DATA (ADMIN / OPERATOR)
    // ===============================================

    /**
     * Menyetujui data pendaftar (Approve Data).
     * Mengubah status dari 'pending' -> 'awaiting_payment'
     */
    public function approveData(User $user)
    {
        if (!in_array(auth()->user()->level, ['admin','operator', 'operator_daerah'])) {
            abort(403, 'Aksi tidak diizinkan.');
        }

        $user->update([
            'status_pengajuan' => 'awaiting_payment',
            'catatan_admin' => 'Data disetujui oleh ' . auth()->user()->nama_lengkap,
        ]);

        return redirect()->route('admin.verifikasi.index')->with('success', $user->nama_lengkap . ' telah disetujui dan sekarang menunggu pembayaran.');
    }

    /**
     * Menolak data pendaftar (Reject Data).
     * Mengubah status dari 'pending' -> 'rejected'
     */
    public function rejectData(Request $request, User $user)
    {
        if (!in_array(auth()->user()->level, ['admin','operator', 'operator_daerah'])) {
            abort(403, 'Aksi tidak diizinkan.');
        }

        $request->validate([ 'catatan_penolakan' => 'required|string|max:500' ]);

        $user->update([
            'status_pengajuan' => 'rejected',
            'catatan_admin' => $request->catatan_penolakan,
        ]);

        return redirect()->route('admin.verifikasi.index')->with('success', $user->nama_lengkap . ' telah ditolak.');
    }

    // ===============================================
    // AKSI UNTUK KONFIRMASI BAYAR (ADMIN / BENDAHARA)
    // ===============================================

    // --- APPROVE PAYMENT (DISINI PERUBAHAN UTAMANYA) ---
    public function approvePayment(Pembayaran $pembayaran)
    {
        if (!in_array(auth()->user()->level, ['admin', 'bendahara', 'bendahara_daerah'])) {
            abort(403);
        }

        $pembayaran->update([
            'status' => 'approved',
            'catatan_admin' => 'Dikonfirmasi oleh ' . auth()->user()->nama_lengkap,
        ]);

        $user = $pembayaran->user;

        // 1. PANGGIL HELPER UNTUK DAPAT KODE (Contoh: '12' untuk Jabar)
        $kodeProvinsi = KtaHelper::getCustomCode($user->provinsi);
        
        // 2. GENERATE NOMOR
        $nomorUrut = str_pad($user->id, 4, '0', STR_PAD_LEFT); 
        $nomorKTA = $kodeProvinsi . $nomorUrut;

        $user->update([
            'status_pengajuan' => 'active',
            'nomor_anggota' => $nomorKTA,
            'provinsi_id' => $kodeProvinsi,
            'activated_at' => Carbon::now(),
        ]);

        return redirect()->route('admin.verifikasi.index')->with('success', 'Pembayaran Dikonfirmasi. KTA: ' . $nomorKTA);
    }

    /**
     * Menolak pembayaran (Reject Payment).
     * Mengubah status dari 'payment_review' -> 'awaiting_payment'
     */
    public function rejectPayment(Request $request, Pembayaran $pembayaran)
    {
        if (!in_array(auth()->user()->level, ['admin', 'bendahara', 'bendahara_daerah'])) {
            abort(403, 'Aksi tidak diizinkan.');
        }

        $request->validate([ 'catatan_penolakan' => 'required|string|max:255' ]);

        $pembayaran->update([
            'status' => 'rejected',
            'catatan_admin' => $request->catatan_penolakan,
        ]);

        $pembayaran->user->update([
            'status_pengajuan' => 'awaiting_payment',
        ]);

        return redirect()->route('admin.verifikasi.index')->with('success', 'Pembayaran untuk ' . $pembayaran->user->nama_lengkap . ' telah ditolak (pembayaran).');
    }
}