<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class DocumentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $documents = Document::all();
        return view('admin.dokumen-list', compact('documents'));
    }





    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Document $document)
    {
        return view('admin.dokumen-edit', compact('document'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Document $document)
    {
        $request->validate([
            'description' => 'nullable|string|max:1000',
            'source_type' => ['required', Rule::in(['upload', 'link'])],
            'document_file' => 'nullable|required_if:source_type,upload|file|mimes:pdf|max:10240',
            'external_link' => 'nullable|required_if:source_type,link|url', // Wajib jika 'link'
        ]);

        $document->description = $request->description;
        $document->source_type = $request->source_type;

        if ($request->source_type === 'link') {
            // Hapus file fisik lama jika ada, karena beralih ke link
            if ($document->file_path) {
                Storage::disk('public')->delete($document->file_path);
                $document->file_path = null;
            }
            $document->external_link = $request->external_link;
        } 
        elseif ($request->source_type === 'upload' && $request->hasFile('document_file')) {
            // Hapus file fisik lama jika ada
            if ($document->file_path) {
                Storage::disk('public')->delete($document->file_path);
            }
            // Hapus link lama, karena beralih ke upload
            $document->external_link = null;

            // Simpan file baru di 'storage/app/public/documents'
            $path = $request->file('document_file')->store('documents', 'public');
            $document->file_path = $path;
        }

        $document->save();

        return redirect()->route('admin.documents.index')->with('success', 'Dokumen berhasil diperbarui.');
    }
}

