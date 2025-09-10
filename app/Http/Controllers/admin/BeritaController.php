<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Berita;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Yajra\DataTables\Facades\DataTables;

class BeritaController extends Controller
{
    /**
     * Fungsi terpusat untuk memeriksa hak akses.
     * Hanya 'admin' dan 'operator' yang diizinkan.
     */
    private function checkAuthorization()
    {
        if (!in_array(auth()->user()->level, ['admin', 'operator','anggota','bendahara'])) {
            abort(403, 'AKSI INI TIDAK DIIZINKAN');
        }
    }

    public function index()
    {
        $user = auth()->user();
        
        // Mulai query dasar
        $beritaQuery = Berita::with('user');

        // Jika level user adalah 'anggota' atau 'bendahara'
        if (in_array($user->level, ['anggota', 'bendahara'])) {
            $beritaQuery->where('user_id', $user->id);
        }
        
        $berita = $beritaQuery->latest()->get();
        
        return view('admin.berita.index', compact('berita'));
    }

    /**
     * Menampilkan form untuk membuat berita baru.
     */
    public function create()
    {   
        $this->checkAuthorization();
        return view('admin.berita.create');
    }

    /**
     * Menyimpan berita baru ke database.
     */
    public function store(Request $request)
    {
        $this->checkAuthorization();
        
        $validated = $request->validate([
            'judul' => 'required|string|max:255|unique:beritas,judul',
            'kategori' => 'required|string|max:50',
            'konten' => 'required|string',
            'gambar' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('gambar')) {
            $validated['gambar'] = $request->file('gambar')->store('berita-headlines', 'public');
        }

        $validated['slug'] = Str::slug($validated['judul']);
        $validated['user_id'] = Auth::id();
        $validated['status'] = 'published';

        Berita::create($validated);

        return redirect()->route('admin.berita.index')->with('success', 'Berita baru berhasil dipublikasikan!');
    }

    /**
     * Menampilkan halaman detail untuk satu berita.
     * (Route untuk ini bisa dibuat jika diperlukan di masa depan).
     */
    public function show($id)
    {
        $berita = Berita::findOrFail($id);
        // Mungkin arahkan ke halaman detail di sisi publik, atau ke halaman edit
        return view('admin.berita.edit', compact('berita'));
    }

    /**
     * Menampilkan form untuk mengedit berita yang ada.
     */
    public function edit($id)
    {
        $this->checkAuthorization();
        $berita = Berita::findOrFail($id);
        return view('admin.berita.edit', compact('berita'));
    }

    /**
     * Memproses dan menyimpan perubahan pada berita.
     */
    public function update(Request $request, $id)
    {
        $this->checkAuthorization();
        $berita = Berita::findOrFail($id);
        
        $validated = $request->validate([
            'judul' => ['required','string','max:255', Rule::unique('beritas')->ignore($berita->id)],
            'kategori' => 'required|string|max:50',
            'konten' => 'required|string',
            'gambar' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('gambar')) {
            if ($berita->gambar) Storage::disk('public')->delete($berita->gambar);
            $validated['gambar'] = $request->file('gambar')->store('berita-headlines', 'public');
        }
        $validated['slug'] = Str::slug($validated['judul']);
        
        $berita->update($validated);
        
        return redirect()->route('admin.berita.index')->with('success', 'Berita berhasil diperbarui!');
    }

    /**
     * Menghapus berita dari database.
     */
    public function destroy($id)
    {
        $this->checkAuthorization();
        $berita = Berita::findOrFail($id);
        
        if ($berita->gambar) {
            Storage::disk('public')->delete($berita->gambar);
        }
        
        $berita->delete();
        
        return redirect()->route('admin.berita.index')->with('success', 'Berita berhasil dihapus!');
    }
}