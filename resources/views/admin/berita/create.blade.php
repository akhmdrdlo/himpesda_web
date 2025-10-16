@extends('layouts.admin')
@section('title', 'Tambah Berita Baru')
@section('content')
<div class="w-full p-6 mx-auto">
    <div class="relative flex flex-col min-w-0 break-words bg-white border-0 shadow-xl rounded-2xl bg-clip-border">
        <div class="p-6 pb-0"><h6 class="text-lg">Formulir Tambah Berita</h6></div>
            {{-- Menampilkan semua error validasi di bagian atas --}}
            @if ($errors->any())
                <div class="p-4 mb-4 text-sm text-red-800 bg-red-100 rounded-lg" role="alert">
                    <span class="font-medium">Terjadi kesalahan!</span>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li class="list-disc list-inside">{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        <div class="flex-auto p-6">
            <form action="{{ route('admin.berita.store') }}" method="POST" enctype="multipart/form-data" novalidate>
                @csrf
                <div class="space-y-4">
                    <div>
                        <label for="judul" class="block font-bold text-xs text-slate-700">Judul Berita</label>
                        <input type="text" name="judul" class="focus:shadow-primary-outline text-sm leading-5.6 ease block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 outline-none transition-all focus:border-blue-500 focus:outline-none" required>
                    </div>
                    <div>
                        <label for="kategori" class="block font-bold text-xs text-slate-700">Kategori</label>
                        <select name="kategori" id="kategori" class="w-full rounded-lg border-gray-300" required>
                            <option value="" disabled selected>-- Pilih Kategori --</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('kategori') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select> 
                    </div>
                    <div>
                        <label for="gambar" class="block font-bold text-xs text-slate-700">Gambar Headline</label>
                        <input type="file" name="gambar" class="focus:shadow-primary-outline text-sm leading-5.6 ease block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 outline-none transition-all focus:border-blue-500 focus:outline-none">
                    </div>
                    <div>
                        <label for="konten" class="block font-bold text-xs text-slate-700">Isi Berita</label>
                        {{-- Atribut 'required' di sini sekarang akan diabaikan oleh browser --}}
                        <textarea name="konten" id="editor" rows="10" class="w-full rounded-lg border-gray-300" required>{{ old('konten') }}</textarea>
                    </div>
                    <div class="flex justify-end">
                        <a href="{{ route('admin.berita.index') }}" class="px-8 py-2 mr-2 font-bold text-gray-700 bg-gray-200 rounded-lg">Batal</a>
                        <button type="submit" class="px-8 py-2 font-bold text-white bg-blue-500 rounded-lg">Publikasikan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.ckeditor.com/ckeditor5/41.4.2/classic/ckeditor.js"></script>
<script>
    let editorInstance;

    ClassicEditor
        .create( document.querySelector( '#editor' ) )
        .then( editor => {
            editorInstance = editor; 
        } )
        .catch( error => {
            console.error( error );
        } );

    document.querySelector('#berita-form').addEventListener('submit', function(event) {
        if (editorInstance) {
            document.querySelector('#editor').value = editorInstance.getData();
        }
    });
</script>
@endpush