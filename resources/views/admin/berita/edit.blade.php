@extends('layouts.admin')
@section('title', 'Edit Berita')
@section('content')
<div class="w-full p-6 mx-auto">
    <div class="relative flex flex-col min-w-0 break-words bg-white border-0 shadow-xl rounded-2xl bg-clip-border">
        <div class="p-6 pb-0"><h6 class="text-lg">Formulir Edit Berita</h6></div>
        <div class="flex-auto p-6">
            <form action="{{ route('admin.berita.update', $berita->id) }}" method="POST" enctype="multipart/form-data" novalidate id="berita-form">
                @csrf
                @method('PUT')
                <div class="space-y-4">
                    {{-- Input Judul --}}
                    <div>
                        <label for="judul" class="block font-bold text-xs text-slate-700">Judul Berita</label>
                        <input type="text" name="judul" class="w-full rounded-lg border-gray-300" value="{{ old('judul', $berita->judul) }}" required>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        {{-- Dropdown Kategori --}}
                        <div>
                            <label for="kategori" class="block font-bold text-xs text-slate-700">Kategori</label>
                            <select name="kategori" class="w-full rounded-lg border-gray-300" required>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('kategori', $berita->kategori) == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label for="published_at" class="block font-bold text-xs text-slate-700">Tanggal Publikasi</label>
                            <input type="datetime-local" name="published_at" class="w-full rounded-lg border-gray-300" value="{{ old('published_at', $berita->published_at ? \Carbon\Carbon::parse($berita->published_at)->format('Y-m-d\TH:i') : '') }}" required>
                        </div>
                    </div>

                    {{-- Input Gambar --}}
                    <div>
                        <label for="gambar" class="block font-bold text-xs text-slate-700">Gambar Headline (Kosongkan jika tidak ingin diubah)</label>
                        @if($berita->gambar)
                            <img src="{{ asset('storage/' . $berita->gambar) }}" class="my-2 h-auto w-48 rounded-md object-contain">
                        @endif
                        <input type="file" name="gambar" class="w-full p-2 border rounded-lg border-gray-300">
                    </div>
                    
                    {{-- CKEditor Konten --}}
                    <div>
                        <label for="konten" class="block font-bold text-xs text-slate-700">Isi Berita</label>
                        <textarea name="konten" id="editor" rows="10" class="w-full rounded-lg border-gray-300" required>{{ old('konten', $berita->konten) }}</textarea>
                    </div>

                    {{-- Tombol Aksi --}}
                    <div class="flex justify-end">
                        <a href="{{ route('admin.berita.index') }}" class="px-8 py-2 mr-2 font-bold text-gray-700 bg-gray-200 rounded-lg">Batal</a>
                        <button type="submit" class="px-8 py-2 font-bold text-white bg-blue-500 rounded-lg">Simpan Perubahan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
{{-- Skrip untuk CKEditor --}}
<script src="https://cdn.ckeditor.com/ckeditor5/41.4.2/classic/ckeditor.js"></script>
<script>
    let editorInstance;
    ClassicEditor.create(document.querySelector('#editor'))
        .then(editor => { editorInstance = editor; })
        .catch(error => { console.error(error); });
    document.querySelector('#berita-form').addEventListener('submit', function(event) {
        if (editorInstance) {
            document.querySelector('#editor').value = editorInstance.getData();
        }
    });
</script>
@endpush

