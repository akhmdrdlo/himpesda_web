@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
<div class="w-full px-6 py-6 mx-auto">
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
    <div class="flex flex-wrap mt-6 -mx-3">
        <div class="w-full max-w-full px-3">
            <div class="relative flex flex-col min-w-0 break-words bg-white border-0 shadow-xl rounded-2xl bg-clip-border">
                <div class="p-6 pb-0">
                    <div class="flex items-start">
                        <div class="w-auto">
                            <h6 class="mb-0 text-xl font-bold">Informasi HIMPESDA</h6>
                            <p class="text-sm leading-normal">Data utama organisasi yang ditampilkan untuk publik.</p>
                        </div>
                        {{-- Tombol ini HANYA akan muncul jika user yang login levelnya 'admin' --}}
                        @auth
                            @if(auth()->user()->level == 'admin')
                                <a href="{{ route('admin.organisasi.edit') }}" class="inline-block px-6 py-3 mb-0 ml-auto font-bold text-center text-white align-middle transition-all ease-in bg-blue-500 border-0 rounded-lg shadow-md cursor-pointer text-xs hover:shadow-xs hover:-translate-y-px active:opacity-85">
                                    Ubah Informasi
                                </a>
                            @endif
                        @endauth
                    </div>
                </div>
                <div class="flex-auto p-6 pt-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div>
                            <strong class="block text-sm">Profil Singkat</strong>
                            <p class="text-sm text-slate-500">{{ $organisasi->profil_singkat ?? 'Data belum diisi.' }}</p>
                        </div>
                        <div>
                            <strong class="block text-sm">Ketua Saat Ini</strong>
                            <div class="flex items-center mt-2">
                                <div class="w-12 h-12 rounded-full bg-gray-200 flex-shrink-0 mr-3">
                                    <img src="{{ asset('storage/' . $organisasi->foto_ketua) }}" class="w-full h-full object-cover rounded-full">
                                </div>
                                <p class="text-sm font-semibold">{{ $organisasi->nama_ketua ?? 'Data belum diisi.' }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
  document.addEventListener("DOMContentLoaded", function() {
    const chartOptions = { responsive: true, maintainAspectRatio: false, plugins: { legend: { position: 'bottom', labels: { padding: 20, usePointStyle: true } } }, cutout: '60%' };
    const colors = { blue: '#5E72E4', green: '#2DCE89', orange: '#FB6340', red: '#F5365C', purple: '#8965E0', yellow: '#FFD600' };

    // 1. Grafik Gender (Dinamis)
    new Chart(document.getElementById("gender-chart"), {
        type: "doughnut",
        data: { labels: ["Laki-laki", "Perempuan"], datasets: [{ data: [{{ $jumlahLaki }}, {{ $jumlahPerempuan }}], backgroundColor: [colors.blue, colors.orange], borderColor: '#fff' }] },
        options: chartOptions,
    });

    // 2. Grafik Status Keanggotaan (Dinamis)
    new Chart(document.getElementById("status-chart"), {
        type: "doughnut",
        data: { labels: ["Aktif", "Tidak Aktif"], datasets: [{ data: [{{ $anggotaAktif }}, {{ $anggotaTidakAktif }}], backgroundColor: [colors.green, colors.red], borderColor: '#fff' }] },
        options: chartOptions,
    });
    
    // 3. Grafik Sebaran Jabatan (Dinamis)
    new Chart(document.getElementById("jabatan-chart"), {
        type: "doughnut",
        data: {
            labels: {!! json_encode($jabatanLabels) !!},
            datasets: [{ data: {!! json_encode($jabatanCounts) !!}, backgroundColor: [colors.blue, colors.green, colors.orange, colors.red, colors.purple, colors.yellow], borderColor: '#fff' }]
        },
        options: chartOptions,
    });
  });
</script>
@endpush