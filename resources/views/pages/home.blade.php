@extends('layouts.app')

@section('title', 'Selamat Datang')

@section('content')
    <section class="relative w-full h-screen -mt-[88px] top-0 overflow-hidden" id="hero-carousel">
        <div class="absolute inset-0 flex transition-transform duration-700 ease-in-out" id="carousel">
            <article class="relative w-full flex-shrink-0">
                <img alt="Kegiatan HIMPESDA" class="w-full h-full object-cover" src="{{ asset('assets/img/berita-1.jpg') }}"/>
                <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent flex flex-col justify-end p-12 md:p-24">
                    <h1 class="text-4xl md:text-6xl font-extrabold text-white drop-shadow-lg max-w-3xl mb-4">Membangun SDM Unggul dan Berdaya Saing</h1>
                </div>
            </article>
            <article class="relative w-full flex-shrink-0">
                <img alt="Seminar HIMPESDA" class="w-full h-full object-cover" src="{{ asset('assets/img/berita-2.jpg') }}"/>
                <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent flex flex-col justify-end p-12 md:p-24">
                    <h1 class="text-4xl md:text-6xl font-extrabold text-white drop-shadow-lg max-w-3xl mb-4">Inovasi Untuk Negeri</h1>
                </div>
            </article>
        </div>
        <button id="prevBtn" class="absolute top-1/2 left-6 transform -translate-y-1/2 bg-white/70 p-3 rounded-full z-20"><i class="fas fa-chevron-left"></i></button>
        <button id="nextBtn" class="absolute top-1/2 right-6 transform -translate-y-1/2 bg-white/70 p-3 rounded-full z-20"><i class="fas fa-chevron-right"></i></button>
    </section>

    <section class="max-w-7xl mx-auto px-6 py-20 text-center">
        @if($organisasi)
            <h2 class="text-3xl md:text-4xl font-bold mb-4">Selamat Datang di HIMPESDA</h2>
            <p class="text-lg text-slate-600 max-w-3xl mx-auto leading-relaxed mb-8">
                {{ $organisasi->profil_singkat }}
            </p>
            <a href="{{ route('profil.sejarah') }}" class="inline-block bg-blue-900 text-white font-semibold px-8 py-3 rounded-lg hover:bg-blue-800 transition-colors">
                Selengkapnya tentang Kami
            </a>
        @else
             <p class="text-lg text-slate-500">Informasi organisasi belum tersedia.</p>
        @endif
    </section>

    <section class="w-full bg-slate-50 py-20">
        <div class="max-w-7xl mx-auto px-6">
            <h2 class="text-3xl font-bold mb-10 text-center">Berita & Kegiatan Terbaru</h2>
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                @forelse ($beritaTerbaru as $berita)
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
            <div class="text-center mt-12">
                <a href="{{ route('berita.index') }}" class="text-blue-900 font-semibold hover:underline">
                    Lihat Semua Berita &rarr;
                </a>
            </div>
        </div>
    </section>
@endsection