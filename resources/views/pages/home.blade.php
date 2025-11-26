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

    {{-- Hero Section (Tetap Sama / Tidak Diubah) --}}
    <section class="relative bg-slate-50 overflow-hidden">
        <div class="absolute inset-0 bg-[url('https://www.toptal.com/designers/subtlepatterns/uploads/dot-grid.png')] opacity-30"></div>
        <div class="absolute right-0 top-0 -mt-20 -mr-20 w-96 h-96 rounded-full bg-blue-100 blur-3xl opacity-50"></div>
        <div class="absolute left-0 bottom-0 -mb-20 -ml-20 w-80 h-80 rounded-full bg-cyan-100 blur-3xl opacity-50"></div>
        
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-20 pb-24 lg:py-32">
            <div class="text-center max-w-3xl mx-auto">
                <span class="inline-block py-1 px-3 rounded-full bg-blue-50 text-blue-600 text-sm font-semibold mb-6 border border-blue-100">
                    Selamat Datang di HIMPESDA
                </span>
                <h1 class="text-4xl md:text-6xl font-extrabold text-slate-900 tracking-tight mb-6 leading-tight">
                    Membangun Negeri Lewat <br>
                    <span class="gradient-text">Pengelolaan Sumber Daya Air</span>
                </h1>
                <p class="mt-4 text-lg text-slate-600 leading-relaxed mb-10">
                    Wadah profesional bagi para ahli dan praktisi untuk bersinergi, berinovasi, dan berkontribusi dalam keberlanjutan sumber daya air di Indonesia.
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="{{ route('pendaftaran.form') }}" class="inline-flex justify-center items-center px-8 py-4 border border-transparent text-base font-bold rounded-full text-white bg-blue-600 hover:bg-blue-700 shadow-lg hover:shadow-xl transition transform hover:-translate-y-1">
                        Gabung Sekarang
                        <i class="fas fa-arrow-right ml-2"></i>
                    </a>
                    <a href="{{ route('profil.sejarah') }}" class="inline-flex justify-center items-center px-8 py-4 border border-slate-200 text-base font-bold rounded-full text-slate-700 bg-white hover:bg-slate-50 shadow-sm hover:shadow-md transition">
                        Pelajari Lebih Lanjut
                    </a>
                </div>
            </div>
        </div>
    </section>

    {{-- Berita Terbaru Section --}}
    <section class="w-full bg-slate-50 py-20">
        <div class="max-w-7xl mx-auto px-6">
            <h2 class="text-3xl font-bold mb-10 text-center">Berita & Kegiatan Terbaru</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                @foreach($beritaTerbaru as $item)
                <article class="flex flex-col bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden hover:shadow-xl transition-all duration-300 group h-full">
                    <div class="relative h-48 overflow-hidden">
                        @if($item->gambar)
                            <img src="{{ asset('storage/' . $item->gambar) }}" alt="{{ $item->judul }}" class="w-full h-full object-cover transform group-hover:scale-105 transition duration-500">
                        @else
                            <div class="w-full h-full bg-slate-200 flex items-center justify-center text-slate-400">
                                <i class="fas fa-image text-4xl"></i>
                            </div>
                        @endif
                        <div class="absolute top-4 left-4 bg-white/90 backdrop-blur px-3 py-1 rounded-full text-xs font-bold text-blue-600">
                            {{ $item->category->name ?? 'Umum' }}
                        </div>
                    </div>
                    <div class="p-6 flex flex-col flex-grow">
                        <div class="flex items-center text-xs text-slate-500 mb-3 gap-4">
                            <span><i class="far fa-calendar-alt mr-1"></i> {{ $item->created_at->format('d M Y') }}</span>
                        </div>
                        <h3 class="text-xl font-bold text-slate-900 mb-3 line-clamp-2 group-hover:text-blue-600 transition">
                            <a href="{{ route('berita.show', $item->slug) }}">
                                {{ $item->judul }}
                            </a>
                        </h3>
                        <p class="text-slate-600 text-sm line-clamp-3 mb-6 flex-grow">
                            {{ Str::limit(strip_tags($item->konten), 100) }}
                        </p>
                        <a href="{{ route('berita.show', $item->slug) }}" class="inline-flex items-center text-sm font-bold text-blue-600 hover:text-blue-700 mt-auto">
                            Baca Selengkapnya <i class="fas fa-long-arrow-alt-right ml-2"></i>
                        </a>
                    </div>
                </article>
                @endforeach
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
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mt-5">
                {{-- Card Chart 1: Gender --}}
                <div class="bg-white p-6 rounded-2xl shadow-lg border border-slate-100 hover:shadow-xl transition-shadow">
                    <h3 class="text-lg font-bold text-center mb-6 text-slate-700">Jenis Kelamin</h3>
                    <div class="relative h-48">
                        <canvas id="chartGender"></canvas>
                    </div>
                </div>

                {{-- Card Chart 2: Unit Kerja --}}
                <div class="bg-white p-6 rounded-2xl shadow-lg border border-slate-100 hover:shadow-xl transition-shadow">
                    <h3 class="text-lg font-bold text-center mb-6 text-slate-700">Unit Kerja</h3>
                    <div class="relative h-48">
                        <canvas id="chartUnit"></canvas>
                    </div>
                </div>

                {{-- Card Chart 3: Jabatan --}}
                <div class="bg-white p-6 rounded-2xl shadow-lg border border-slate-100 hover:shadow-xl transition-shadow">
                    <h3 class="text-lg font-bold text-center mb-6 text-slate-700">Jabatan Fungsional</h3>
                    <div class="relative h-48">
                        <canvas id="chartJabatan"></canvas>
                    </div>
                </div>

                {{-- Map Provinsi: berada di row terpisah; full width di layar kecil/menengah, pada layar ekstra lebar span 2 kolom --}}
                <div class="bg-white p-0 rounded-2xl shadow-md border border-slate-100 hover:shadow-lg transition-all overflow-hidden flex flex-col lg:col-span-3 xl:col-span-3 row-span-2">
                    <div class="p-6 pb-0 flex items-center justify-between mb-2">
                        <h3 class="text-lg font-bold text-slate-700">Peta Sebaran Anggota</h3>
                        <span class="p-2 bg-emerald-50 rounded-lg text-emerald-600"><i class="fas fa-map-marked-alt"></i></span>
                    </div>
                    {{-- Container Peta --}}
                    <div id="map" class="w-full h-80 z-0"></div>
                    <div class="px-6 pb-4 text-xs text-slate-400 text-right italic">
                        *Data ditampilkan berdasarkan provinsi domisili anggota
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
    {{-- Leaflet JS Library --}}
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
    {{-- Alpine.js untuk Animasi Statistik --}}
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>
    
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            
            // 1. Inisialisasi Peta (Pusat: Indonesia)
            var map = L.map('map').setView([-2.5489, 118.0149], 4); // Koordinat tengah Indonesia, Zoom level 4
    
            // 2. Tambahkan Tile Layer OpenStreetMap (Gratis)
            L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
                attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
            }).addTo(map);
    
            // 3. Database Koordinat Provinsi (Hardcoded untuk performa)
            // Key harus cocok dengan nama di database Anda (Uppercase/Titlecase dihandle di logic)
            const provinceCoords = {
                "ACEH": [4.6951, 96.7494],
                "SUMATERA UTARA": [2.1154, 99.5451],
                "SUMATERA BARAT": [-0.7399, 100.8000],
                "RIAU": [0.2933, 101.6760],
                "JAMBI": [-1.6101, 103.6131],
                "SUMATERA SELATAN": [-3.3194, 104.9144],
                "BENGKULU": [-3.5778, 102.3464],
                "LAMPUNG": [-4.5586, 105.4068],
                "KEPULAUAN BANGKA BELITUNG": [-2.7411, 106.4406],
                "KEPULAUAN RIAU": [3.9457, 108.1429],
                "DKI JAKARTA": [-6.2088, 106.8456],
                "JAWA BARAT": [-6.9175, 107.6191],
                "JAWA TENGAH": [-7.1510, 110.1403],
                "DI YOGYAKARTA": [-7.7956, 110.3695],
                "JAWA TIMUR": [-7.5361, 112.2384],
                "BANTEN": [-6.4058, 106.0640],
                "BALI": [-8.3405, 115.0920],
                "NUSA TENGGARA BARAT": [-8.6069, 117.5874],
                "NUSA TENGGARA TIMUR": [-8.6574, 121.0794],
                "KALIMANTAN BARAT": [-0.2787, 111.4753],
                "KALIMANTAN TENGAH": [-1.6815, 113.3824],
                "KALIMANTAN SELATAN": [-3.0926, 115.2838],
                "KALIMANTAN TIMUR": [0.5387, 116.4194],
                "KALIMANTAN UTARA": [3.0731, 116.0414],
                "SULAWESI UTARA": [0.6247, 123.9750],
                "SULAWESI TENGAH": [-1.4300, 121.4456],
                "SULAWESI SELATAN": [-3.6687, 119.9740],
                "SULAWESI TENGGARA": [-4.1449, 122.1746],
                "GORONTALO": [0.6999, 122.4467],
                "SULAWESI BARAT": [-2.8441, 119.2321],
                "MALUKU": [-3.2385, 130.1453],
                "MALUKU UTARA": [1.5709, 127.8087],
                "PAPUA": [-4.2699, 138.0804],
                "PAPUA BARAT": [-1.3361, 133.1747],
                "PAPUA SELATAN": [-7.4000, 139.0000], // Estimasi Merauke
                "PAPUA TENGAH": [-4.0000, 136.0000], // Estimasi Nabire
                "PAPUA PEGUNUNGAN": [-4.5000, 139.5000], // Estimasi Wamena
                "PAPUA BARAT DAYA": [-1.0000, 131.5000], // Estimasi Sorong
            };
    
            // 4. Data dari Controller Laravel
            const labels = {!! json_encode($provinsiData['labels']) !!}; // Nama Provinsi
            const values = {!! json_encode($provinsiData['values']) !!}; // Jumlah Anggota
    
            // 5. Loop Data dan Taruh di Peta
            labels.forEach((provName, index) => {
                let count = values[index];
                
                // Normalisasi nama (Uppercase) untuk pencarian koordinat
                let searchKey = provName.toUpperCase(); 
                
                // Fix nama umum yang mungkin beda sedikit di DB
                if(searchKey === 'DAERAH ISTIMEWA YOGYAKARTA') searchKey = 'DI YOGYAKARTA';
                if(searchKey === 'BANGKA BELITUNG') searchKey = 'KEPULAUAN BANGKA BELITUNG';
    
                let coords = provinceCoords[searchKey];
    
                if (coords) {
                    // Tentukan Warna & Ukuran berdasarkan jumlah
                    let circleColor = '#3B82F6'; // Biru Default
                    let radiusSize = 50000; // Default size (meter)
    
                    if(count > 50) { circleColor = '#EF4444'; radiusSize = 90000; } // Merah (Ramai)
                    else if(count > 20) { circleColor = '#F59E0B'; radiusSize = 70000; } // Kuning (Sedang)
    
                    // Buat Lingkaran di Peta
                    var circle = L.circle(coords, {
                        color: circleColor,
                        fillColor: circleColor,
                        fillOpacity: 0.5,
                        radius: radiusSize
                    }).addTo(map);
    
                    // Tambah Popup (Muncul saat diklik)
                    circle.bindPopup(`
                        <div class="text-center">
                            <b class="text-sm text-slate-700">${provName}</b><br>
                            <span class="text-xs text-slate-500">Jumlah Anggota:</span><br>
                            <strong class="text-lg text-blue-600">${count}</strong>
                        </div>
                    `);
                    
                    // Opsional: Tambah Tooltip (Muncul saat hover)
                    circle.bindTooltip(`${provName}: ${count}`, {permanent: false, direction: "top"});
                }
            });
        });
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

