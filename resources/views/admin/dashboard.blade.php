@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')

{{-- ====================================================== --}}
{{-- KONTEN UNTUK ADMIN DAN OPERATOR --}}
{{-- ====================================================== --}}
@if (in_array(Auth::user()->level, ['admin', 'operator', 'operator_daerah', 'bendahara', 'bendahara_daerah']))
    <div class="w-full px-6 py-6 mx-auto">

        {{-- Filter Dropdown (Hanya untuk Admin) --}}
        @if(auth()->user()->level == 'admin')
        <div class="flex flex-wrap -mx-3">
            <div class="w-full max-w-full px-3 mb-6">
                <div class="relative flex flex-col min-w-0 break-words bg-white shadow-xl rounded-2xl bg-clip-border">
                    <div class="flex-auto p-4">
                        <form action="{{ route('admin.dashboard') }}" method="GET">
                            <div class="flex flex-wrap items-center">
                                <label for="provinsi" class="mr-3 text-sm font-semibold whitespace-nowrap">Filter Statistik per Provinsi:</label>
                                <select name="provinsi" id="provinsi" class="focus:shadow-primary-outline text-sm leading-5.6 ease block w-full md:w-auto appearance-none rounded-lg border border-solid border-gray-300 bg-white p-2" onchange="this.form.submit()">
                                    <option value="">Semua Provinsi</option>
                                    @foreach($provinsiList as $provinsi)
                                        <option value="{{ $provinsi }}" {{ $selectedProvinsi == $provinsi ? 'selected' : '' }}>
                                            {{ $provinsi }}
                                        </option>
                                    @endforeach
                                </select>
                                @if($selectedProvinsi)
                                    <a href="{{ route('admin.dashboard') }}" class="ml-3 text-sm text-blue-500 hover:underline whitespace-nowrap">Reset Filter</a>
                                @endif
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @endif
        
        {{-- Baris Statistik Chart --}}
        <div class="flex flex-wrap -mx-3">
            <div class="w-full max-w-full px-3 mb-6 lg:w-1/3 lg:flex-none">
                <div class="relative flex flex-col min-w-0 break-words bg-white shadow-xl rounded-2xl bg-clip-border">
                    <div class="p-4 pb-0"><h6 class="mb-0">Statistik Gender</h6></div>
                    <div class="flex-auto p-4"><div class="h-48"><canvas id="gender-chart"></canvas></div></div>
                </div>
            </div>
            <div class="w-full max-w-full px-3 mb-6 lg:w-1/3 lg:flex-none">
                <div class="relative flex flex-col min-w-0 break-words bg-white shadow-xl rounded-2xl bg-clip-border">
                    <div class="p-4 pb-0"><h6 class="mb-0">Status Keanggotaan</h6></div>
                    <div class="flex-auto p-4"><div class="h-48"><canvas id="status-chart"></canvas></div></div>
                </div>
            </div>
            <div class="w-full max-w-full px-3 mb-6 lg:w-1/3 lg:flex-none">
                <div class="relative flex flex-col min-w-0 break-words bg-white shadow-xl rounded-2xl bg-clip-border">
                    <div class="p-4 pb-0"><h6 class="mb-0">Sebaran Jabatan</h6></div>
                    <div class="flex-auto p-4"><div class="h-48"><canvas id="jabatan-chart"></canvas></div></div>
                </div>
            </div>
        </div>

        {{-- Baris Chart Baru: Sebaran Provinsi & Info Himpunan --}}
        <div class="flex flex-wrap mt-6 -mx-3">
            
            {{-- Chart Sebaran Provinsi Interaktif --}}
            <div class="w-full max-w-full px-3 mb-6 lg:w-1/2 lg:flex-none">
                {{-- 
                    PERBAIKAN:
                    1. x-data hanya memanggil fungsinya.
                    2. x-init memanggil initChart() dan meneruskan data dari variabel JS global.
                --}}
                <div 
                    x-data="provinsiChart()"
                    x-init="initChart(provinsiChartData)"
                    class="relative flex flex-col min-w-0 break-words bg-white shadow-xl rounded-2xl bg-clip-border h-full"
                >
                    <div class="p-6 pb-0">
                        <h6 class="mb-0 text-xl font-bold">Sebaran Anggota per Provinsi</h6>
                        <p class="text-sm leading-normal">Klik pada chart untuk melihat detail.</p>
                    </div>
                    
                    <div classs="flex-auto p-6 pt-0">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 h-80">
                            {{-- Tampilan Data Interaktif (kode x-text dll tidak berubah) --}}
                            <div 
                                @click.away="resetChart()"
                                class="md:col-span-1 flex flex-col justify-center items-center text-center border-r border-gray-200 pr-4"
                            >
                                <h3 x-text="selectedProvinsi" class="text-2xl font-bold text-blue-600 transition-all duration-300"></h3>
                                <p x-text="selectedTotal.toLocaleString('id-ID')" class="text-6xl font-extrabold text-slate-800 transition-all duration-300"></p>
                                <p class="text-sm text-slate-500">Anggota</p>
                                <button @click="resetChart()" x-show="selectedProvinsi !== 'Total Keseluruhan'" x-transition class="mt-4 px-3 py-1 bg-slate-100 text-slate-600 text-xs font-semibold rounded-full hover:bg-slate-200 transition">
                                    Reset ke Total
                                </button>
                            </div>
                            
                            {{-- Pie Chart --}}
                            <div class="md:col-span-2 p-6 relative h-full">
                                <canvas id="provinsi-chart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Info Himpunan --}}
            <div class="w-full max-w-full px-3 mb-6 lg:w-1/2 lg:flex-none">
                <div class="relative flex flex-col min-w-0 break-words bg-white border-0 shadow-xl rounded-2xl bg-clip-border h-full">
                    <div class="p-6 pb-4 border-b border-gray-200">
                        <h6 class="mb-1 text-xl font-bold text-gray-800">Informasi HIMPESDA</h6>
                        <p class="text-sm text-gray-500">Data utama organisasi yang ditampilkan untuk publik.</p>
                    </div>
                    
                    <div class="flex-auto p-6">
                        <div class="flex flex-col lg:flex-row gap-6">
                            {{-- Left: Informasi --}}
                            <div class="flex-1 space-y-4">
                                <div>
                                    <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wide mb-2">Profil Singkat</label>
                                    <div class="prose prose-sm text-gray-700 text-sm leading-relaxed max-h-40 overflow-y-auto">
                                        {!! $organisasi->profil_singkat ?? '<span class="text-gray-400 italic">Data belum diisi.</span>' !!}
                                    </div>
                                </div>
                            </div>

                            {{-- Right: Ketua Saat Ini --}}
                            <div class="flex-shrink-0 lg:border-l lg:border-gray-200 lg:pl-6">
                                <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wide mb-4">Ketua Saat Ini</label>
                                <div class="flex flex-col items-center text-center">
                                    @if($organisasi->foto_ketua)
                                        <div class="w-24 h-24 rounded-full bg-gradient-to-br from-blue-100 to-blue-50 flex-shrink-0 mb-4 overflow-hidden shadow-md border-4 border-white">
                                            <img src="{{ asset('storage/' . $organisasi->foto_ketua) }}" class="w-full h-full object-cover">
                                        </div>
                                    @else
                                        <div class="w-24 h-24 rounded-full bg-gradient-to-br from-gray-200 to-gray-100 flex-shrink-0 mb-4 flex items-center justify-center shadow-md border-4 border-white">
                                            <svg class="w-12 h-12 text-gray-400" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 3c1.66 0 3 1.34 3 3s-1.34 3-3 3-3-1.34-3-3 1.34-3 3-3zm0 14.2c-2.5 0-4.71-1.28-6-3.22.03-1.99 4-3.08 6-3.08 1.99 0 5.97 1.09 6 3.08-1.29 1.94-3.5 3.22-6 3.22z"/></svg>
                                        </div>
                                    @endif
                                    <p class="font-semibold text-gray-800 text-sm">{{ $organisasi->nama_ketua ?? 'Data belum diisi.' }}</p>
                                    <p class="text-xs text-gray-500 mt-1">Ketua Organisasi</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Action Buttons --}}
                    @if(auth()->user()->level == 'admin')
                        <div class="px-6 py-4 border-t border-gray-200 bg-gray-50 rounded-b-2xl flex gap-3 justify-end">
                            <a href="{{ route('admin.documents.index') }}" class="inline-flex items-center px-4 py-2 bg-slate-600 hover:bg-slate-700 hover:text-white font-semibold text-xs rounded-lg transition-all duration-200 shadow-sm hover:shadow-md active:scale-95">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                Kelola Dokumen
                            </a>
                            <a href="{{ route('admin.organisasi.edit') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold text-xs rounded-lg transition-all duration-200 shadow-sm hover:shadow-md active:scale-95">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                Ubah Informasi
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@elseif (Auth::user()->level == 'anggota')

    {{-- 
    ==================================================================
    TAMPILAN UNTUK ANGGOTA (TRACER PENDAFTARAN)
    (Menggunakan layout admin, tapi kontennya adalah tracer)
    ==================================================================
    --}}
    <div class="w-full px-6 py-6 mx-auto">
        <div class="flex flex-wrap -mx-3">
            <div class="w-full max-w-full px-3 shrink-0">
                <div class="relative flex flex-col min-w-0 break-words bg-white border-0 shadow-xl rounded-2xl bg-clip-border">
                    <div class="p-6">
                        <h3 class="text-2xl font-bold mb-4">Selamat Datang, {{ Auth::user()->nama_lengkap }}!</h3>

                        @if(session('success'))
                            <div class="mb-4 p-4 text-sm text-green-700 bg-green-100 rounded-lg" role="alert">
                                {{ session('success') }}
                            </div>
                        @endif
                        
                        @if ($errors->any())
                            <div class="mb-4 p-4 text-sm text-red-700 bg-red-100 rounded-lg" role="alert">
                                <strong>Oops!</strong> Terjadi kesalahan pada input Anda.
                                <ul class="mt-2 list-disc list-inside">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        {{-- ====================================================== --}}
                        {{-- LOGIKA TRACER PENDAFTARAN --}}
                        {{-- ====================================================== --}}

                        {{-- 1. Status: Baru Mendaftar (Menunggu Verifikasi Data Diri) --}}
                        @if(Auth::user()->status_pengajuan == 'pending')
                            <div class="p-6 border-l-4 border-yellow-500 bg-yellow-50">
                                <h4 class="font-bold text-lg">Status: Menunggu Verifikasi Admin</h4>
                                <p class="mt-2">Data pendaftaran Anda telah kami terima dan sedang ditinjau oleh tim admin (Operator Daerah). Harap tunggu 1x24 jam untuk proses verifikasi data.</p>
                            </div>

                        {{-- 2. Status: Disetujui (Menunggu Pembayaran) --}}
                        @elseif(Auth::user()->status_pengajuan == 'awaiting_payment')
                            <div class="p-6 border-l-4 border-blue-500 bg-blue-50">
                                <h4 class="font-bold text-lg">Status: Menunggu Pembayaran</h4>
                                <p class="mt-2">Pendaftaran Anda telah disetujui. Silakan lakukan pembayaran iuran keanggotaan dan unggah bukti pembayaran di bawah ini untuk mengaktifkan akun Anda.</p>
                                
                                <div class="mt-4 p-4 bg-gray-100 rounded-md">
                                    <p class="font-semibold">Silakan transfer ke rekening:</p>
                                    <p>Bank ABC - 1234567890 a.n. Bendahara HIMPESDA</p>
                                    <p>Jumlah: Rp 100.000,-</p>
                                </div>

                                <form action="{{ route('anggota.pembayaran.store') }}" method="POST" enctype="multipart/form-data" class="mt-6">
                                    @csrf
                                    <div>
                                        <label for="file_bukti" class="block text-sm font-medium text-gray-700">Unggah Bukti Pembayaran (PDF, JPG, PNG - Maks 2MB)</label>
                                        <input type="file" name="file_bukti" id="file_bukti" class="mt-1 block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none" required>
                                    </div>
                                    <div class="mt-4">
                                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700">
                                            Kirim Bukti
                                        </button>
                                    </div>
                                </form>
                            </div>

                        {{-- 3. Status: Sudah Bayar (Menunggu Konfirmasi Bendahara) --}}
                        @elseif(Auth::user()->status_pengajuan == 'payment_review')
                            <div class="p-6 border-l-4 border-cyan-500 bg-cyan-50">
                                <h4 class="font-bold text-lg">Status: Peninjauan Bukti Pembayaran</h4>
                                <p class="mt-2">Bukti pembayaran Anda telah kami terima dan sedang ditinjau oleh Bendahara. Akun Anda akan segera diaktifkan setelah pembayaran terkonfirmasi.</p>
                            </div>

                        {{-- 4. Status: Selesai (Aktif) --}}
                        @elseif(Auth::user()->status_pengajuan == 'active')
                            <div class="p-6 border-l-4 border-green-500 bg-green-50">
                                <h4 class="font-bold text-lg text-green-700">Status: Aktif</h4>
                                <p class="mt-2">Selamat! Akun Anda telah aktif. Anda sekarang adalah anggota resmi HIMPESDA.</p>
                                <p class="mt-4 font-semibold">Nomor KTA Anda:</p>
                                <p class="text-3xl font-bold text-gray-800 tracking-wider">{{ Auth::user()->nomor_anggota }}</p>
                                <p class="mt-1 text-sm text-gray-500">Diaktifkan pada: {{ Auth::user()->activated_at }}</p>
                            </div>
                        
                        {{-- 5. Status: Ditolak (Data Diri Tidak Valid) --}}
                        @elseif(Auth::user()->status_pengajuan == 'rejected')
                            <div class="p-6 border-l-4 border-red-500 bg-red-50">
                                <h4 class="font-bold text-lg text-red-700">Status: Ditolak</h4>
                                <p class="mt-2">Mohon maaf, pengajuan Anda ditolak oleh admin.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif

@endsection

{{-- ==================================================================== --}}
{{-- Seluruh @push('scripts') sekarang dibungkus dalam kondisi @if        --}}
{{-- Ini memastikan skrip HANYA dimuat untuk admin yang memiliki data.   --}}
{{-- ==================================================================== --}}
@if (in_array(Auth::user()->level, ['admin', 'operator', 'operator_daerah', 'bendahara', 'bendahara_daerah']))
    @push('scripts')
    {{-- Chart.js dimuat di sini --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    {{-- Alpine.js (pastikan 'defer' dihapus jika masih ada) --}}
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js"></script>

    <script>
        const provinsiChartData = {
            totalAnggota: {{ $totalAnggota }},
            labels: {!! json_encode($provinsiLabels) !!},
            totals: {!! json_encode($provinsiCounts) !!}
        };
    </script>

    <script>
      // =================================================================
      // Fungsi ini sekarang ditempelkan ke 'window'
      // =================================================================
      window.provinsiChart = function() {
        return {
            // 1. Data & State (diinisialisasi null/kosong)
            selectedProvinsi: null,
            selectedTotal: null,
            initialTotal: null,
            chartInstance: null,
            chartData: null,
            
            // 2. Metode Reset
            resetChart() {
                this.selectedProvinsi = 'Total Keseluruhan';
                this.selectedTotal = this.initialTotal;
                if (this.chartInstance) {
                    // Logika untuk 'de-highlight' chart
                    this.chartInstance.stop();
                }
            },

            // 3. Metode Inisialisasi Chart (sekarang menerima data)
            initChart(data) {
                this.chartData = data;
                this.initialTotal = data.totalAnggota;
                this.resetChart(); // Panggil reset untuk mengisi nilai default

                const ctx = document.getElementById('provinsi-chart').getContext('2d');
                const colorPalette = ['#5E72E4', '#2DCE89', '#FB6340', '#F5365C', '#8965E0', '#FFD600', '#11CDEF', '#E91E63', '#3F51B5', '#4CAF50', '#FF9800', '#9C27B0', '#795548', '#607D8B'];
                
                // Perbaikan: Hancurkan chart lama (jika ada) sebelum membuat yang baru.
                if (window.provinsiChartInstance) {
                    window.provinsiChartInstance.destroy();
                }

                window.provinsiChartInstance = new Chart(ctx, { // Simpan instance baru
                    type: "pie",
                    data: {
                        labels: data.labels,
                        datasets: [{ 
                            data: data.totals, 
                            backgroundColor: colorPalette,
                            borderColor: '#fff' 
                        }]
                    },
                    options: {
                        responsive: true, 
                        maintainAspectRatio: false, 
                        plugins: { 
                        legend: { 
                            position: 'right', 
                            labels: { padding: 10, boxWidth: 12 } 
                        } 
                        },
                        // 4. Logika onClick
                        onClick: (evt, elements, chart) => {
                            if (elements.length === 0) {
                                this.resetChart();
                                return;
                            }
                            const dataIndex = elements[0].index;
                            this.selectedProvinsi = chart.data.labels[dataIndex];
                            this.selectedTotal = chart.data.datasets[0].data[dataIndex];
                        }
                    }
                });
            }
        }
    }

    // --- Chart Statis (Gender, Status, Jabatan) ---
    // Dijalankan setelah DOM selesai dimuat
    document.addEventListener("DOMContentLoaded", function() {
        const chartOptionsDoughnut = { responsive: true, maintainAspectRatio: false, plugins: { legend: { position: 'bottom', labels: { padding: 20, usePointStyle: true } } }, cutout: '60%' };
        const colors = { blue: '#5E72E4', green: '#2DCE89', orange: '#FB6340', red: '#F5365C', purple: '#8965E0', yellow: '#FFD600', pink: '#F3A4B5' };
        const colorPalette = ['#5E72E4', '#2DCE89', '#FB6340', '#F5365C', '#8965E0', '#FFD600', '#11CDEF', '#E91E63', '#3F51B5', '#4CAF50', '#FF9800', '#9C27B0', '#795548', '#607D8B'];

        // 1. Grafik Gender (Dinamis)
        new Chart(document.getElementById("gender-chart"), {
            type: "doughnut",
            data: { 
                labels: ["Laki-laki", "Perempuan"], 
                datasets: [{ data: [{{ $jumlahLaki }}, {{ $jumlahPerempuan }}], backgroundColor: [colors.blue, colors.pink], borderColor: '#fff' }] 
            },
            options: chartOptionsDoughnut,
        });

        // 2. Grafik Status Keanggotaan (Dinamis & Diperbarui)
        new Chart(document.getElementById("status-chart"), {
            type: "doughnut",
            data: { 
                labels: ["Aktif", "Belum Aktif/Pending"], 
                datasets: [{ data: [{{ $anggotaAktif }}, {{ $anggotaTidakAktif }}], backgroundColor: [colors.green, colors.red], borderColor: '#fff' }] 
            },
            options: chartOptionsDoughnut,
        });
        
        // 3. Grafik Sebaran Jabatan (Dinamis)
        new Chart(document.getElementById("jabatan-chart"), {
            type: "doughnut",
            data: {
                labels: {!! json_encode($jabatanLabels) !!},
                datasets: [{ data: {!! json_encode($jabatanCounts) !!}, backgroundColor: colorPalette, borderColor: '#fff' }]
            },
            options: chartOptionsDoughnut,
        });
    });
    </script>
    @endpush
@endif