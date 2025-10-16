<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::all();
        return view('admin.berita.create-category', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name',
        ]);

        Category::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
        ]);

        // Redirect kembali dengan pesan sukses
        // return redirect()->route('admin.categories.index')->with('success', 'Kategori berhasil ditambahkan.');
        return response()->json(['message' => 'Kategori berhasil ditambahkan.'], 201);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,' . $category->id,
        ]);

        $category->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
        ]);

        // Redirect kembali dengan pesan sukses
        // return redirect()->route('admin.categories.index')->with('success', 'Kategori berhasil diperbarui.');
        return response()->json(['message' => 'Kategori berhasil diperbarui.']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        $category->delete();
        // Redirect kembali dengan pesan sukses
        // return redirect()->route('admin.categories.index')->with('success', 'Kategori berhasil dihapus.');
        return response()->json(null, 204);
    }
}
