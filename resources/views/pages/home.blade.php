@extends('layouts.app')

@section('title', 'Selamat Datang di HIMPESDA')

@section('content')
    {{-- Hero Carousel Section --}}
    <section class="relative w-full h-screen -mt-[88px] top-0 overflow-hidden" id="hero-carousel">
        <div class="absolute inset-0 flex transition-transform duration-700 ease-in-out" id="carousel">
            @forelse ($beritaTerbaru as $berita)
            <article class="relative w-full flex-shrink-0">
                <a href="{{ route('berita.show', $berita->slug) }}">
                    <img src="{{ $berita->gambar ? asset('storage/' . $berita->gambar) : 'https://placehold.co/1920x1080/003366/FFFFFF?text=HIMPESDA' }}" alt="{{ $berita->judul }}" class="w-full h-full object-cover"/>
                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent flex flex-col justify-end p-12 md:p-24">
                        <h1 class="text-4xl md:text-6xl font-extrabold text-white drop-shadow-lg max-w-4xl mb-4 leading-tight">{{$berita->judul}}</h1>
                    </div>
                </a>
            </article>
            @empty
            <article class="relative w-full flex-shrink-0">
                <img alt="Kegiatan HIMPESDA" class="w-full h-full object-cover" src="https://placehold.co/1920x1080/003366/FFFFFF?text=Selamat+Datang"/>
                <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent flex flex-col justify-end p-12 md:p-24">
                    <h1 class="text-4xl md:text-6xl font-extrabold text-white drop-shadow-lg max-w-4xl mb-4 leading-tight">Membangun SDM Unggul dan Berdaya Saing dalam Pengelolaan Sumber Daya Air</h1>
                </div>
            </article>
            @endforelse
        </div>
        <button id="prevBtn" class="absolute top-1/2 left-6 transform -translate-y-1/2 bg-white/70 p-3 rounded-full z-20 shadow-lg hover:bg-white transition"><i class="fas fa-chevron-left"></i></button>
        <button id="nextBtn" class="absolute top-1/2 right-6 transform -translate-y-1/2 bg-white/70 p-3 rounded-full z-20 shadow-lg hover:bg-white transition"><i class="fas fa-chevron-right"></i></button>
    </section>

    {{-- Profil Singkat Section --}}
    <section class="max-w-7xl mx-auto px-6 py-20 text-center">
        @if($himpunan ?? null)
            <h2 class="text-3xl md:text-4xl font-bold mb-4">Selamat Datang di HIMPESDA</h2>
            <p class="text-lg text-slate-600 max-w-3xl mx-auto leading-relaxed mb-8">
                {!! $himpunan->profil_singkat !!}
            </p>
            <a href="#" class="inline-block bg-blue-900 text-white font-semibold px-8 py-3 rounded-lg hover:bg-blue-800 transition-colors">
                Selengkapnya tentang Kami
            </a>
        @endif
    </section>

    {{-- Berita Terbaru Section --}}
    <section class="w-full bg-slate-50 py-20">
        <div class="max-w-7xl mx-auto px-6">
            <h2 class="text-3xl font-bold mb-10 text-center">Berita & Kegiatan Terbaru</h2>
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                @forelse ($beritaTerbaru as $berita)
                    <article class="bg-white rounded-lg shadow-md overflow-hidden transition-transform duration-300 hover:-translate-y-2 group">
                        <a href="{{ route('berita.show', $berita->slug) }}">
                            <div class="overflow-hidden">
                                <img src="{{ $berita->gambar ? asset('storage/' . $berita->gambar) : 'https://placehold.co/400x250/E2E8F0/4A5568?text=Berita' }}" alt="{{ $berita->judul }}" class="w-full h-48 object-cover group-hover:scale-105 transition-transform duration-300"/>
                            </div>
                        </a>
                        <div class="p-5">
                            <span class="text-xs text-gray-500">{{ $berita->category->name ?? 'Umum' }} &bull; {{ $berita->created_at->translatedFormat('d F Y') }}</span>
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

    {{-- Statistik Section --}}
    <div x-data="statisticsSection()" x-ref="statSection" class="bg-slate-50 py-20 transition-opacity duration-1000" :class="isVisible ? 'opacity-100' : 'opacity-0'">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-extrabold text-gray-900 sm:text-4xl">
                    Statistik Keanggotaan
                </h2>
                <p class="mt-4 text-lg text-gray-600">
                    Kekuatan Profesional Pengelola Sumber Daya Air di Indonesia
                </p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 text-center">
                <!-- Statistik Total Anggota -->
                <div class="bg-white rounded-lg shadow-lg p-8">
                    <h3 class="text-xl font-semibold text-gray-700">Total Anggota</h3>
                    <div x-ref="totalAnggota" data-target="{{ $jumlahAnggota }}" class="mt-4 text-6xl font-bold text-blue-600">0</div>
                </div>

                <!-- Statistik Anggota Pusat (Sekarang Aktif) -->
                <div class="bg-white rounded-lg shadow-lg p-8">
                    <h3 class="text-xl font-semibold text-gray-700">Anggota Pusat</h3>
                    <div x-ref="anggotaPusat" data-target="{{ $jumlahAnggotaPusat ?? 0 }}" class="mt-4 text-6xl font-bold text-green-600">0</div>
                </div>

                <!-- Statistik Anggota Daerah (Sekarang Aktif) -->
                <div class="bg-white rounded-lg shadow-lg p-8">
                    <h3 class="text-xl font-semibold text-gray-700">Anggota Daerah</h3>
                    <div x-ref="anggotaDaerah" data-target="{{ $jumlahAnggotaDaerah ?? 0 }}" class="mt-4 text-6xl font-bold text-yellow-600">0</div>
                </div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 mt-5">
                {{-- Card Chart 1: Gender --}}
                <div class="bg-white p-6 rounded-2xl shadow-lg border border-slate-100 hover:shadow-xl transition-shadow">
                    <h3 class="text-lg font-bold text-center mb-6 text-slate-700">Jenis Kelamin</h3>
                    <div class="relative h-48">
                        <canvas id="chartGender"></canvas>
                    </div>
                </div>
                
                {{-- Card Chart 2: Provinsi --}}
                <div class="bg-white p-6 rounded-2xl shadow-lg border border-slate-100 hover:shadow-xl transition-shadow">
                    <h3 class="text-lg font-bold text-center mb-6 text-slate-700">Sebaran Provinsi</h3>
                    <div class="relative h-48">
                        <canvas id="chartProvinsi"></canvas>
                    </div>
                </div>

                {{-- Card Chart 3: Unit Kerja --}}
                <div class="bg-white p-6 rounded-2xl shadow-lg border border-slate-100 hover:shadow-xl transition-shadow">
                    <h3 class="text-lg font-bold text-center mb-6 text-slate-700">Unit Kerja</h3>
                    <div class="relative h-48">
                        <canvas id="chartUnit"></canvas>
                    </div>
                </div>

                {{-- Card Chart 4: Jabatan --}}
                <div class="bg-white p-6 rounded-2xl shadow-lg border border-slate-100 hover:shadow-xl transition-shadow">
                    <h3 class="text-lg font-bold text-center mb-6 text-slate-700">Jabatan Fungsional</h3>
                    <div class="relative h-48">
                        <canvas id="chartJabatan"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Social Media Section --}}
    <section class="w-full bg-white py-20">
        <div class="max-w-7xl mx-auto px-6">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-extrabold text-gray-900 sm:text-4xl">
                    Terhubung Bersama Kami
                </h2>
                <p class="mt-4 text-lg text-gray-600">
                    Ikuti unggahan terbaru kami di media sosial.
                </p>
            </div>
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                
                <!-- YouTube Card -->
                <article class="border border-red-200 rounded-lg shadow-lg overflow-hidden transition-transform duration-300 hover:-translate-y-2 group">
                    <div class="p-6 bg-red-500 text-white flex items-center justify-between">
                        <h3 class="text-2xl font-bold">YouTube</h3>
                        <i class="fab fa-youtube fa-3x"></i>
                    </div>
                    <div class="p-6">
                        @if($youtubePost)
                            <h4 class="font-semibold text-lg my-2 leading-tight">
                                <a href="{{ route('berita.show', $youtubePost->slug) }}" class="hover:text-red-700">{{ Str::limit($youtubePost->judul, 55) }}</a>
                            </h4>
                            <p class="text-sm text-gray-600 mb-4">{{ Str::limit(strip_tags($youtubePost->konten), 100) }}</p>
                            <a href="{{ route('berita.show', $youtubePost->slug) }}" class="font-semibold text-red-600 hover:underline text-sm">Lihat Video &rarr;</a>
                        @else
                            <p class="text-sm text-gray-500">Belum ada unggahan terbaru.</p>
                        @endif
                    </div>
                </article>

                <!-- Instagram Card -->
                <article class="border border-pink-200 rounded-lg shadow-lg overflow-hidden transition-transform duration-300 hover:-translate-y-2 group">
                    <div class="p-6 bg-gradient-to-r from-purple-500 to-pink-500 text-white flex items-center justify-between">
                        <h3 class="text-2xl font-bold">Instagram</h3>
                        <i class="fab fa-instagram fa-3x"></i>
                    </div>
                    <div class="p-6">
                        @if($instagramPost)
                            <h4 class="font-semibold text-lg my-2 leading-tight">
                                <a href="{{ route('berita.show', $instagramPost->slug) }}" class="hover:text-pink-700">{{ Str::limit($instagramPost->judul, 55) }}</a>
                            </h4>
                            <p class="text-sm text-gray-600 mb-4">{{ Str::limit(strip_tags($instagramPost->konten), 100) }}</p>
                            <a href="{{ route('berita.show', $instagramPost->slug) }}" class="font-semibold text-pink-600 hover:underline text-sm">Lihat Postingan &rarr;</a>
                        @else
                             <p class="text-sm text-gray-500">Belum ada unggahan terbaru.</p>
                        @endif
                    </div>
                </article>

                <!-- X (Twitter) Card -->
                <article class="border border-gray-300 rounded-lg shadow-lg overflow-hidden transition-transform duration-300 hover:-translate-y-2 group">
                    <div class="p-6 bg-gray-800 text-white flex items-center justify-between">
                        <h3 class="text-2xl font-bold">X.com</h3>
                        <i class="fab fa-twitter fa-3x"></i>
                    </div>
                    <div class="p-6">
                       @if($xPost)
                            <h4 class="font-semibold text-lg my-2 leading-tight">
                                <a href="{{ route('berita.show', $xPost->slug) }}" class="hover:text-gray-900">{{ Str::limit($xPost->judul, 55) }}</a>
                            </h4>
                            <p class="text-sm text-gray-600 mb-4">{{ Str::limit(strip_tags($xPost->konten), 100) }}</p>
                            <a href="{{ route('berita.show', $xPost->slug) }}" class="font-semibold text-gray-800 hover:underline text-sm">Lihat Cuitan &rarr;</a>
                        @else
                             <p class="text-sm text-gray-500">Belum ada unggahan terbaru.</p>
                        @endif
                    </div>
                </article>

            </div>
        </div>
    </section>
@endsection

@push('scripts')
    {{-- Alpine.js untuk Animasi Statistik --}}
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>

    <script>

    </script>
    <script>
        // Logika Animasi Statistik
        function statisticsSection() {
            return {
                isVisible: false,
                animationDone: false,
                animateCountUp(el) {
                    const target = parseInt(el.dataset.target, 10);
                    if (isNaN(target)) return;
                    let current = 0;
                    const duration = 2000;
                    const increment = target / (duration / 16);
                    const updateCount = () => {
                        current += increment;
                        if (current < target) {
                            el.innerText = Math.ceil(current).toLocaleString('id-ID');
                            requestAnimationFrame(updateCount);
                        } else {
                            el.innerText = target.toLocaleString('id-ID');
                        }
                    };
                    requestAnimationFrame(updateCount);
                },
                init() {
                    const observer = new IntersectionObserver((entries) => {
                        entries.forEach(entry => {
                            if (entry.isIntersecting) {
                                this.isVisible = true;
                                if (!this.animationDone) {
                                    this.animateCountUp(this.$refs.totalAnggota);
                                    this.animateCountUp(this.$refs.anggotaPusat);
                                    this.animateCountUp(this.$refs.anggotaDaerah);
                                    this.animationDone = true;
                                }
                            } else {
                                this.isVisible = false;
                            }
                        });
                    }, { threshold: 0.1 });
                    observer.observe(this.$refs.statSection);
                }
            }
        }

        // Logika Carousel
        document.addEventListener('DOMContentLoaded', function () {
            const carousel = document.getElementById('carousel');
            if (!carousel || carousel.children.length <= 1) return;

            const slides = carousel.children;
            const totalSlides = slides.length;
            let currentIndex = 0;

            function updateCarousel() {
                carousel.style.transform = `translateX(-${currentIndex * 100}%)`;
            }

            document.getElementById('nextBtn').addEventListener('click', function() {
                currentIndex = (currentIndex + 1) % totalSlides;
                updateCarousel();
            });

            document.getElementById('prevBtn').addEventListener('click', function() {
                currentIndex = (currentIndex - 1 + totalSlides) % totalSlides;
                updateCarousel();
            });

            setInterval(() => {
                document.getElementById('nextBtn').click();
            }, 5000);
        });

                // Konfigurasi Umum Chart
        const commonOptions = {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        usePointStyle: true,
                        padding: 20,
                        font: { family: "'Inter', sans-serif", size: 11 }
                    }
                }
            },
            cutout: '65%', // Membuat efek Donut yang lebih modern
            animation: {
                animateScale: true,
                animateRotate: true
            }
        };

        // Palette Warna Modern
        const colors = ['#3B82F6', '#10B981', '#F59E0B', '#EF4444', '#8B5CF6', '#6366F1', '#EC4899'];

        // 1. Chart Gender
        const ctxGender = document.getElementById('chartGender').getContext('2d');
        new Chart(ctxGender, {
            type: 'doughnut',
            data: {
                labels: {!! json_encode($genderData->keys()) !!},
                datasets: [{
                    data: {!! json_encode($genderData->values()) !!},
                    backgroundColor: ['#3B82F6', '#EC4899'], // Biru & Pink
                    borderWidth: 0
                }]
            },
            options: commonOptions
        });

        // 2. Chart Provinsi
        const ctxProv = document.getElementById('chartProvinsi').getContext('2d');
        new Chart(ctxProv, {
            type: 'doughnut',
            data: {
                labels: {!! json_encode($provinsiData['labels']) !!},
                datasets: [{
                    data: {!! json_encode($provinsiData['values']) !!},
                    backgroundColor: colors,
                    borderWidth: 0
                }]
            },
            options: commonOptions
        });

        // 3. Chart Unit Kerja
        const ctxUnit = document.getElementById('chartUnit').getContext('2d');
        new Chart(ctxUnit, {
            type: 'pie', // Variasi pakai Pie
            data: {
                labels: {!! json_encode($unitData['labels']) !!},
                datasets: [{
                    data: {!! json_encode($unitData['values']) !!},
                    backgroundColor: colors,
                    borderWidth: 0
                }]
            },
            options: commonOptions
        });

        // 4. Chart Jabatan
        const ctxJabatan = document.getElementById('chartJabatan').getContext('2d');
        new Chart(ctxJabatan, {
            type: 'doughnut',
            data: {
                labels: {!! json_encode($jabatanData['labels']) !!},
                datasets: [{
                    data: {!! json_encode($jabatanData['values']) !!},
                    backgroundColor: colors,
                    borderWidth: 0
                }]
            },
            options: commonOptions
        });
    </script>
@endpush

