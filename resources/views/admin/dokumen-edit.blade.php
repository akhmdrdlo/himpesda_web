@extends('layouts.admin')

@section('title', 'Ubah Dokumen')

@section('content')
<div class="w-full p-6 mx-auto" x-data="{ sourceType: '{{ old('source_type', $document->source_type) }}' }">
    <div class="relative flex flex-col min-w-0 break-words bg-white border-0 shadow-xl rounded-2xl bg-clip-border">
        <div class="p-6 pb-0"><h6 class="text-lg">Formulir Ubah Dokumen: {{ $document->title }}</h6></div>
        
        @if ($errors->any())
            <div class="p-4 mx-6 mt-4 text-sm text-red-800 bg-red-100 rounded-lg" role="alert">
                <span class="font-medium">Terjadi kesalahan!</span>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li class="list-disc list-inside">{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="flex-auto p-6">
            <form action="{{ route('admin.documents.update', $document->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="space-y-6">
                    <div>
                        <label for="description" class="block font-bold text-xs text-slate-700">Deskripsi Singkat</label>
                        <textarea name="description" rows="4" class="w-full rounded-lg border-gray-300">{{ old('description', $document->description) }}</textarea>
                    </div>

                    <div>
                        <label class="block font-bold text-xs text-slate-700 mb-2">Sumber Dokumen</label>
                        <div class="flex items-center space-x-4">
                            <label class="flex items-center">
                                <input type="radio" name="source_type" value="upload" x-model="sourceType" class="form-radio">
                                <span class="ml-2 text-sm">Unggah File PDF</span>
                            </label>
                            <label class="flex items-center">
                                <input type="radio" name="source_type" value="link" x-model="sourceType" class="form-radio">
                                <span class="ml-2 text-sm">Tautan Eksternal</span>
                            </label>
                        </div>
                    </div>

                    {{-- Input untuk Unggah File --}}
                    <div x-show="sourceType === 'upload'">
                        <label for="document_file" class="block font-bold text-xs text-slate-700">File PDF (Maks. 5MB)</label>
                        @if($document->file_path)
                        <p class="text-xs text-gray-500 my-1">File saat ini: <a href="{{ asset('storage/'.$document->file_path) }}" target="_blank" class="text-blue-600">Lihat File</a></p>
                        @endif
                        <input type="file" name="document_file" class="w-full p-2 border rounded-lg border-gray-300">
                        <p class="text-xs text-gray-500 mt-1">Kosongkan jika tidak ingin mengubah file yang sudah ada.</p>
                    </div>

                    {{-- Input untuk Tautan Eksternal --}}
                    <div x-show="sourceType === 'link'">
                        <label for="external_link" class="block font-bold text-xs text-slate-700">URL Dokumen</label>
                        <input type="url" name="external_link" value="{{ old('external_link', $document->external_link) }}" class="w-full rounded-lg border-gray-300" placeholder="https://contoh.com/dokumen.pdf">
                    </div>

                    <div class="flex justify-end space-x-2">
                        <a href="{{ route('admin.documents.index') }}" class="px-8 py-2 font-bold text-gray-700 bg-gray-200 rounded-lg">Batal</a>
                        <button type="submit" class="px-8 py-2 font-bold text-white bg-blue-500 rounded-lg">Simpan Perubahan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
{{-- Load Alpine.js untuk interaktivitas form --}}
<script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>
@endpush
