<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pembayaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PembayaranController extends Controller
{
    /**
     * Menyimpan bukti pembayaran yang diunggah oleh anggota.
     * Ini adalah Fase 3.3 dari Rencana Revisi.
     */
    public function store(Request $request)
    {
        $request->validate([
            'file_bukti' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        $user = Auth::user();

        // 0. Hapus bukti pembayaran lama jika ada (agar tidak menumpuk)
        $existingPayment = Pembayaran::where('user_id', $user->id)->whereIn('status', ['pending', 'rejected'])->first();
        if ($existingPayment) {
             if($existingPayment->file_bukti) {
                Storage::disk('public')->delete($existingPayment->file_bukti);
             }
             $existingPayment->delete();
        }

        // 1. Simpan file bukti pembayaran baru
        $path = $request->file('file_bukti')->store('bukti_pembayaran', 'public');

        // 2. Buat record baru di tabel 'pembayaran'
        Pembayaran::create([
            'user_id' => $user->id,
            'file_bukti' => $path,
            'status' => 'pending', // Status pembayaran, bukan user
        ]);

        // 3. Update status user agar Bendahara bisa meninjau
        $user->update([
            'status_pengajuan' => 'payment_review'
        ]);

        return redirect()->route('dashboard')->with('success', 'Bukti pembayaran Anda telah terkirim dan sedang ditinjau oleh Bendahara.');
    }
}