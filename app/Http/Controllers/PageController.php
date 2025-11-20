<?php
namespace App\Http\Controllers;

use App\Models\Berita;
use App\Models\Himpunan;
use App\Models\Pendaftar;
use App\Models\User;
use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class PageController extends Controller
{
    public function home()
    {
       $himpunan = Himpunan::first();

        // Ambil 5 berita terbaru yang sudah dipublikasikan
        $beritaTerbaru = Berita::with('user', 'category')
            ->where('status', 'published')
            ->latest()
            ->take(3)
            ->get();

        $youtubePost = Berita::where('kategori', 5)->latest('published_at')->first();
        $instagramPost = Berita::where('kategori', 6)->latest('published_at')->first();
        $xPost = Berita::where('kategori', 7)->latest('published_at')->first();
        // --- Bagian Statistik Anggota ---
        
        $jumlahAnggota = User::where('level', 'anggota')->count(); 
        $jumlahAnggotaPusat = User::where('tipe_anggota', 'pusat')->where('level', 'anggota')->count();
        $jumlahAnggotaDaerah = User::where('tipe_anggota', 'daerah')->where('level', 'anggota')->count();

        // --- DATA STATISTIK UNTUK CHART ---
        // 1. Jenis Kelamin
        $genderData = User::select('jenis_kelamin', DB::raw('count(*) as total'))
            ->whereNotNull('jenis_kelamin')
            ->groupBy('jenis_kelamin')
            ->pluck('total', 'jenis_kelamin');

        // 2. Unit Kerja (Top 5 + Lainnya)
        $unitRaw = User::select('unit_kerja', DB::raw('count(*) as total'))
            ->whereNotNull('unit_kerja')
            ->groupBy('unit_kerja')
            ->orderByDesc('total')
            ->get();
        $unitData = $this->processChartData($unitRaw, 'unit_kerja');

        // 3. Provinsi (Top 5 + Lainnya)
        $provinsiRaw = User::select('provinsi', DB::raw('count(*) as total'))
            ->whereNotNull('provinsi')
            ->groupBy('provinsi')
            ->orderByDesc('total')
            ->get();
        $provinsiData = $this->processChartData($provinsiRaw, 'provinsi');

        // 4. Jabatan Fungsional
        $jabatanRaw = User::select('jabatan_fungsional', DB::raw('count(*) as total'))
            ->whereNotNull('jabatan_fungsional')
            ->groupBy('jabatan_fungsional')
            ->orderByDesc('total')
            ->get();
        $jabatanData = $this->processChartData($jabatanRaw, 'jabatan_fungsional');
        return view('pages.home', compact(
            'himpunan',
            'beritaTerbaru',
            'jumlahAnggota',
            'jumlahAnggotaPusat',
            'jumlahAnggotaDaerah',
            'youtubePost',
            'instagramPost',
            'xPost',
            'genderData',
            'unitData',
            'provinsiData',
            'jabatanData'
        ));
    }

    // Helper untuk membatasi data chart agar tidak terlalu ramai
    private function processChartData($collection, $keyName) {
        $top = $collection->take(5);
        $othersCount = $collection->slice(5)->sum('total');
        
        $labels = $top->pluck($keyName)->toArray();
        $values = $top->pluck('total')->toArray();

        if ($othersCount > 0) {
            $labels[] = 'Lainnya';
            $values[] = $othersCount;
        }

        return ['labels' => $labels, 'values' => $values];
    }

    // --- METHOD BARU UNTUK 3 HALAMAN DOKUMEN ---

    /**
     * Menampilkan halaman untuk Kode Etik.
     */
    public function kodeEtik()
    {
        $document = Document::where('slug', 'kode-etik')->firstOrFail();
        return view('pages.profil.dokumen-detail', compact('document'));
    }

    /**
     * Menampilkan halaman untuk Anggaran Dasar.
     */
    public function anggaranDasar()
    {
        $document = Document::where('slug', 'anggaran-dasar')->firstOrFail();
        return view('pages.profil.dokumen-detail', compact('document'));
    }

    /**
     * Menampilkan halaman untuk Anggaran Rumah Tangga.
     */
    public function anggaranRumahTangga()
    {
        $document = Document::where('slug', 'anggaran-rumah-tangga')->firstOrFail();
        return view('pages.profil.dokumen-detail', compact('document'));
    }

    // Update method berita untuk menangani SEARCH
    public function berita(Request $request)
    {
        $query = Berita::latest();

        if ($request->has('search')) {
            $search = $request->search;
            $query->where('judul', 'like', "%{$search}%")
                  ->orWhere('konten', 'like', "%{$search}%");
        }

        $semuaBerita = $query->paginate(9); 
        return view('pages.berita', compact('semuaBerita'));
    }
        /**
     * Menampilkan halaman detail untuk satu berita berdasarkan slug-nya.
     */
    public function detailBerita($slug)
    {
        // Cari berita berdasarkan kolom 'slug'. Jika tidak ketemu, tampilkan halaman 404 Not Found.
        $berita = Berita::where('slug', $slug)->firstOrFail();

        // Ambil juga beberapa berita terbaru lainnya, kecuali yang sedang ditampilkan
        $beritaLainnya = Berita::where('id', '!=', $berita->id)->latest()->take(3)->get();

        // Kirim data ke view baru
        return view('pages.detail-berita', compact('berita', 'beritaLainnya'));
    }

    public function sejarah() { $organisasi = Himpunan::first(); return view('pages.profil.sejarah', compact('organisasi')); }
    public function visiMisi() { $organisasi = Himpunan::first(); return view('pages.profil.visi-misi', compact('organisasi')); }
    public function struktur() { $organisasi = Himpunan::first(); return view('pages.profil.struktur', compact('organisasi')); }

    public function pendaftaran()
    {
        return view('pages.pendaftaran');
    }

    public function prosesPendaftaran(Request $request)
    {
        // Validasi semua input dari form
        $validatedData = $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'email' => 'required|email|unique:pendaftars,email|unique:users,email',
            'no_telp' => 'required|string|max:20',
            'gol_ruang' => 'nullable|string|max:10',
            'provinsi' => 'required|string|max:255',
            'provinsi_id' => 'required|string|max:2',
            'kabupaten_kota' => 'required|string|max:255',
            'password' => 'required|string|min:8|confirmed',
            'nip' => 'nullable|string|max:20',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'tanggal_lahir' => 'required|date',
            'agama' => 'nullable|string|max:20',
            'npwp' => 'nullable|string|max:25',
            'asal_instansi' => 'nullable|string|max:255',
            'unit_kerja' => 'nullable|string|max:255',
            'jabatan_fungsional' => 'nullable|string|max:255',
            'pas_foto' => 'required|image|mimes:jpeg,png,jpg|max:2048', // maks 2MB
            'bukti_pembayaran' => 'required|image|mimes:jpeg,png,jpg,pdf|max:2048',
        ]);
        
        // Handle upload file pas foto
        if ($request->hasFile('pas_foto')) {
            $validatedData['pas_foto'] = $request->file('pas_foto')->store('pas-foto-pendaftar', 'public');
        }

        // Handle upload file bukti pembayaran
        if ($request->hasFile('bukti_pembayaran')) {
            $validatedData['bukti_pembayaran'] = $request->file('bukti_pembayaran')->store('bukti-pembayaran', 'public');
        }

        // Simpan data ke tabel pendaftar
        Pendaftar::create($validatedData);

        return back()->with('success', 'Permohonan pendaftaran Anda telah berhasil dikirim! Silakan tunggu konfirmasi dari admin.');
    }
}