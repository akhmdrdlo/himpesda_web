@extends('layouts.app')

@section('title', $document->title)

@section('content')
<div class="bg-gray-50 dark:bg-gray-900">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 md:py-24">
        
        {{-- Header Halaman --}}
        <div class="text-center mb-12">
            <h1 class="text-4xl font-extrabold text-gray-900 dark:text-white">{{ $document->title }}</h1>
            <p class="mt-4 text-lg text-gray-600 dark:text-gray-300 max-w-3xl mx-auto">{{ $document->description }}</p>
        </div>

        {{-- Tombol Aksi (Unduh & Buka Tautan) --}}
        @php
            $rawUrl = null;
            if ($document->source_type === 'upload' && $document->file_path) {
                $rawUrl = asset('storage/' . $document->file_path);
            } elseif ($document->source_type === 'link' && $document->external_link) {
                $rawUrl = $document->external_link;
            }
        @endphp

        @if($rawUrl)
            <div class="flex justify-center items-center space-x-4 mb-8">
                {{-- Tombol Unduh hanya muncul untuk file yang diunggah --}}
                @if($document->source_type === 'upload')
                    <a href="{{ $rawUrl }}" 
                       download 
                       class="inline-flex items-center px-6 py-3 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        <i class="fas fa-download mr-2"></i>
                        Unduh PDF
                    </a>
                @endif
                
                <a href="{{ $rawUrl }}" 
                   target="_blank" 
                   class="inline-flex items-center px-6 py-3 border border-gray-300 text-sm font-medium rounded-md shadow-sm text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    <i class="fas fa-external-link-alt mr-2"></i>
                    Buka di Tab Baru
                </a>
            </div>
        @endif

        {{-- PDF Viewer Container --}}
        <div class="max-w-4xl mx-auto bg-white dark:bg-gray-800 p-2 rounded-lg shadow-lg h-[85vh]">
            @if($document->public_url)
                @php
                    $url = $document->public_url;
        
                    if (str_contains($url, 'drive.google.com')) {
                        // Ekstrak file ID dari URL Google Drive
                        if (preg_match('/\/d\/(.*?)\//', $url, $matches)) {
                            $fileId = $matches[1];
                            $url = "https://drive.google.com/file/d/{$fileId}/preview";
                        }
                    }
                @endphp
        
                <iframe src="{{ $url }}" class="w-full h-full border-0 rounded-md" allowfullscreen></iframe>
            @else
                <div class="flex items-center justify-center h-full text-gray-500">
                    <p>Dokumen belum tersedia. Silakan unggah melalui panel admin.</p>
                </div>
            @endif
        </div>
        
    </div>
</div>
@endsection

