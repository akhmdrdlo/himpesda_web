<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Himpunan;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // --- Data untuk Grafik ---
        $anggota = User::where('level', 'anggota');
        
        // 1. Grafik Gender (sudah ada)
        $jumlahLaki = $anggota->clone()->where('jenis_kelamin', 'Laki-laki')->count();
        $jumlahPerempuan = $anggota->clone()->where('jenis_kelamin', 'Perempuan')->count();

        // 2. Grafik Status Keanggotaan (kita asumsikan semua aktif untuk saat ini)
        $anggotaAktif = $anggota->clone()->count();
        $anggotaTidakAktif = 0; // Data statis untuk contoh

        // 3. Grafik Sebaran Jabatan
        $jabatanData = User::where('level', 'anggota')
            ->select('jabatan_fungsional', DB::raw('count(*) as total'))
            ->groupBy('jabatan_fungsional')
            ->pluck('total', 'jabatan_fungsional');

        $jabatanLabels = $jabatanData->keys();
        $jabatanCounts = $jabatanData->values();

        // --- Data Informasi Organisasi ---
        $organisasi = Himpunan::first(); // Ambil data baris pertama dari tabel organisasi

        // Kirim semua data ke view
        return view('admin.dashboard', compact(
            'jumlahLaki', 'jumlahPerempuan',
            'anggotaAktif', 'anggotaTidakAktif',
            'jabatanLabels', 'jabatanCounts',
            'organisasi'
        ));
    }
}