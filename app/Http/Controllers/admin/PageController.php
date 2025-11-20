<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Berita;
use App\Models\Himpunan;
use App\Models\User;
use App\Models\Document;
use Illuminate\Http\Request;

class PageController extends Controller
{
    /**
     * Menampilkan Halaman Beranda Publik
     */
    public function home()
    {
        $himpunan = Himpunan::first();
        $beritaTerbaru = Berita::with('user', 'category')->where('status', 'published')->latest('published_at')->take(5)->get();
        
        $jumlahAnggota = User::where('level', 'anggota')->count(); 
        $jumlahAnggotaPusat = User::where('tipe_anggota', 'pusat')->where('level', 'anggota')->count();
        $jumlahAnggotaDaerah = User::where('tipe_anggota', 'daerah')->where('level', 'anggota')->count();

        $youtubePost = Berita::where('kategori', 5)->latest('published_at')->first();
        $instagramPost = Berita::where('kategori', 6)->latest('published_at')->first();
        $xPost = Berita::where('kategori', 7)->latest('published_at')->first();
        
        return view('beranda', compact(
            'himpunan', 'beritaTerbaru', 'jumlahAnggota',
            'jumlahAnggotaPusat', 'jumlahAnggotaDaerah',
            'youtubePost', 'instagramPost', 'xPost'
        ));
    }

    // --- METHOD UNTUK HALAMAN DOKUMEN ---
    public function kodeEtik()
    {
        $document = Document::where('slug', 'kode-etik')->firstOrFail();
        return view('pages.dokumen-detail', compact('document'));
    }

    public function anggaranDasar()
    {
        $document = Document::where('slug', 'anggaran-dasar')->firstOrFail();
        return view('pages.dokumen-detail', compact('document'));
    }

    public function anggaranRumahTangga()
    {
        $document = Document::where('slug', 'anggaran-rumah-tangga')->firstOrFail();
        return view('pages.dokumen-detail', compact('document'));
    }

    /* Semua method admin (dashboard, daftarAnggota, dll.)
    telah dihapus dari sini karena sekarang ditangani
    oleh controller-nya masing-masing.
    */
}