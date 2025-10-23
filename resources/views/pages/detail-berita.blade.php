@extends('layouts.app')

@section('title', $berita->judul)

@section('content')
<div class="max-w-6xl mx-auto px-4 py-10 sm:px-6 lg:px-8">
    <div class="bg-white dark:bg-gray-800 shadow-lg rounded-lg overflow-hidden">
        @if($berita->gambar)
            <img class="w-full h-96 object-cover" src="{{ asset('storage/' . $berita->gambar) }}" alt="{{ $berita->judul }}">
        @endif

        <div class="p-6 md:p-10">
            <div class="mb-6">
                <p class="text-sm text-gray-500">
                    <a href="#" class="font-semibold text-blue-600">{{ $berita->category->name ?? 'N/A' }}</a>
                    &bull;
                    <span>
                        <td class="px-6 py-4">
                        {{-- Jika published_at ada, format tanggalnya. Jika tidak, tampilkan '-' --}}
                            {{ $berita->published_at ? $berita->published_at->translatedFormat('d F Y') : '-' }}
                        </td>
                    </span>
                    &bull;
                    <span>Oleh: {{ $berita->user->nama_lengkap ?? 'Tim HIMPESDA' }}</span>
                </p>
            </div>

            <h1 class="text-3xl md:text-4xl font-bold text-gray-900 dark:text-white mb-4 leading-tight">
                {{ $berita->judul }}
            </h1>

            <div class="prose max-w-none text-gray-800 dark:text-gray-200 text-justify">
                {!! $berita->konten !!}
            </div>

             <hr class="my-8">

            <div>
                <h3 class="text-2xl font-bold mb-4">Berita Lainnya</h3>
                <div class="space-y-4">
                    @forelse($beritaLainnya as $item)
                    <a href="{{ route('berita.show', $item->slug) }}" class="block hover:bg-gray-50 p-4 rounded-md">
                        <p class="font-semibold text-gray-800">{{ $item->judul }}</p>
                        <p class="text-xs text-gray-500">{{ $item->created_at->translatedFormat('d F Y') }}</p>
                    </a>
                    @empty
                    <p class="text-sm text-gray-500">Tidak ada berita lainnya.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection