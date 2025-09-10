<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Berita;
use App\Models\Himpunan;
use App\Models\Pendaftar;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function home()
    {
        // 1. Ambil data baris pertama dari tabel 'organisasis'
        $himpunan = Himpunan::first();

        // 2. Ambil 3 berita terbaru dari tabel 'berita'
        $beritaTerbaru = Berita::latest()->take(3)->get();

        // 3. Tampilkan view 'pages.home' dan kirim kedua data tersebut ke dalamnya
        return view('pages.home', compact('himpunan', 'beritaTerbaru'));
    }

    public function dashboard() { return view('admin.dashboard'); }
    public function daftarAnggota() { return view('admin.daftar-anggota'); }
    public function detailAnggota() { return view('admin.detail-anggota'); }
    public function profileAdmin() { return view('admin.profile-admin'); }
    public function konfirmasiPembayaran() { return view('admin.konfirmasi-pembayaran'); }


}
