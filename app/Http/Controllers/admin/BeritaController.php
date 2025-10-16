<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Berita;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class BeritaController extends Controller
{
    /**
     * Fungsi terpusat untuk memeriksa hak akses.
     * Hanya level tertentu yang diizinkan untuk membuat/mengubah/menghapus.
     */
    private function checkAuthorization()
    {
        // Hanya 'admin' dan 'operator' yang bisa melanjutkan
        if (!in_array(auth()->user()->level, ['admin', 'operator'])) {
            abort(403, 'AKSI INI TIDAK DIIZINKAN.');
        }
    }

    /**
     * Menampilkan daftar berita sesuai level pengguna.
     */
    public function index()
    {
        $user = auth()->user();
        $beritaQuery = Berita::with('user', 'category');

        // Jika user adalah 'anggota' atau 'bendahara', hanya tampilkan berita milik mereka
        if (in_array($user->level, ['anggota', 'bendahara'])) {
            $beritaQuery->where('user_id', $user->id);
        }
        
        $berita = $beritaQuery->latest()->get();
        return view('admin.berita.index', compact('berita'));
    }

    /**
     * Menampilkan formulir untuk membuat berita baru.
     */
    public function create()
    {
        $this->checkAuthorization(); // Pengecekan hak akses
        $categories = Category::all();
        return view('admin.berita.create', compact('categories'));
    }

    /**
     * Menyimpan berita baru ke database.
     */
    public function store(Request $request)
    {
        $this->checkAuthorization(); // Pengecekan hak akses

        $validated = $request->validate([
            'judul' => 'required|string|max:255|unique:beritas,judul',
            'kategori' => 'required|exists:categories,id', // Validasi ke tabel categories
            'konten' => 'required|string',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $path = $request->hasFile('gambar') ? $request->file('gambar')->store('berita_images', 'public') : null;

        Berita::create([
            'judul' => $validated['judul'],
            'slug' => Str::slug($validated['judul']),
            'kategori' => $validated['kategori'],
            'konten' => $validated['konten'],
            'gambar' => $path,
            'status' => 'published',
            'user_id' => Auth::id(),
            'published_at' => $request->published_at ?? now(),
        ]);

        return redirect()->route('admin.berita.index')->with('success', 'Berita baru berhasil ditambahkan.');
    }
    
    /**
     * Menampilkan detail berita (bisa digunakan untuk halaman edit).
     */
    public function show(Berita $beritum)
    {
        $berita = $beritum; // Alias agar konsisten
        $categories = Category::all();
        return view('admin.berita.edit', compact('berita', 'categories'));
    }


    /**
     * Menampilkan formulir untuk mengedit berita.
     */
    public function edit(Berita $beritum)
    {
        $this->checkAuthorization(); // Pengecekan hak akses
        $berita = $beritum; // Alias
        $categories = Category::all();
        return view('admin.berita.edit', compact('berita', 'categories'));
    }

    /**
     * Memperbarui berita di database.
     */
    public function update(Request $request, Berita $beritum)
    {
        $this->checkAuthorization(); // Pengecekan hak akses
        $berita = $beritum; // Alias
        
        $validated = $request->validate([
            'judul' => ['required','string','max:255', Rule::unique('beritas')->ignore($berita->id)],
            'kategori' => 'required|exists:categories,id',
            'konten' => 'required|string',
            'gambar' => 'nullable|image|max:2048',
            'published_at' => 'required|date',
        ]);

        $berita->judul = $validated['judul'];
        $berita->slug = Str::slug($validated['judul']);
        $berita->kategori = $validated['kategori'];
        $berita->konten = $validated['konten'];
        $berita->published_at = $validated['published_at'];

        if ($request->hasFile('gambar')) {
            if ($berita->gambar) Storage::delete('public/' . $berita->gambar);
            $berita->gambar = $request->file('gambar')->store('berita_images', 'public');
        }

        $berita->save();
        return redirect()->route('admin.berita.index')->with('success', 'Berita berhasil diperbarui.');
    }

    /**
     * Menghapus berita dari database.
     */
    public function destroy(Berita $beritum)
    {
        $this->checkAuthorization();
        $berita = $beritum;
        
        if ($berita->gambar) {
            Storage::delete('public/' . $berita->gambar);
        }
        
        $berita->delete();
        
        return redirect()->route('admin.berita.index')->with('success', 'Berita berhasil dihapus.');
    }
}

