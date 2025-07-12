@extends('layouts.app')
@section('title', 'Berita & Kegiatan')
@section('content')
    <section class="w-full bg-[var(--blue-dark)] py-20">
        <div class="max-w-7xl mx-auto px-6 text-center"><h1 class="text-4xl font-bold text-white">Arsip Berita & Kegiatan</h1></div>
    </section>
    <section class="max-w-7xl mx-auto px-6 py-16">
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse ($semuaBerita as $berita)
                <article class="bg-white rounded-lg shadow-md overflow-hidden transition-transform duration-300 hover:-translate-y-2">
                    <a href="{{ route('berita.show', $berita->slug) }}" class="hover:text-blue-700">
                        <img src="{{ $berita->gambar ? asset('storage/' . $berita->gambar) : 'https://via.placeholder.com/400x200.png?text=HIMPESDA' }}" alt="{{ $berita->judul }}" class="w-full h-48 object-cover"/>
                    </a>
                    <div class="p-5">
                        <span class="text-xs text-gray-500">{{ $berita->kategori }} &bull; {{ $berita->created_at->translatedFormat('d F Y') }}</span>
                        <h3 class="font-semibold text-lg my-2 leading-tight">
                            <a href="{{ route('berita.show', $berita->slug) }}" class="hover:text-blue-700">{{ Str::limit($berita->judul, 55) }}</a>
                        </h3>
                        <p class="text-sm text-gray-600 mb-4">{{ Str::limit(strip_tags($berita->konten), 100) }}</p>
                    </div>
                </article>
            @empty
                <p class="lg:col-span-3 text-center text-gray-500">Belum ada berita untuk ditampilkan.</p>
            @endforelse
        </div>
        <div class="mt-12">
            {{ $semuaBerita->links() }}
        </div>
    </section>
@endsection