@extends('layouts.admin')

@section('title', 'Profil Saya')

@section('content')
    {{-- Helper Logic untuk Tampilan --}}
    @php
        // Format Level: hapus underscore dan kapitalisasi (ex: operator_daerah -> Operator Daerah)
        $levelDisplay = ucwords(str_replace('_', ' ', $anggota->level));
        
        // Logika Wilayah: Jika Admin/Pusat tampilkan 'Pusat', jika Daerah tampilkan 'Provinsi'
        $isPusat = in_array($anggota->level, ['admin', 'operator', 'bendahara']) || $anggota->tipe_anggota == 'pusat';
        $wilayahDisplay = $isPusat ? 'Pusat (Nasional)' : ($anggota->provinsi ?? '-');

        // Warna Badge berdasarkan level
        $badgeColor = match($anggota->level) {
            'admin' => 'bg-purple-100 text-purple-800',
            'anggota' => 'bg-blue-100 text-blue-800',
            default => 'bg-orange-100 text-orange-800', // Operator/Bendahara
        };
    @endphp

    {{-- Notifikasi Sukses --}}
    @if(session('success'))
    <div class="w-full px-6 mt-6 mx-auto">
        <div class="relative p-4 pr-12 text-white border border-solid rounded-lg bg-gradient-to-tl from-emerald-500 to-teal-400 border-emerald-300" role="alert">
            <span class="font-bold"><i class="fas fa-check-circle mr-1"></i> Sukses!</span>
            <span class="block sm:inline">{{ session('success') }}</span>
            <button type="button" class="absolute top-0 bottom-0 right-0 px-4 py-3" data-alert-close="true">
                <span class="text-xl" aria-hidden="true">×</span>
            </button>
        </div>
    </div>
    @endif

    {{-- Header Profil --}}
    <div class="relative w-full mx-auto mt-6 px-6">
        <div class="relative flex flex-col flex-auto min-w-0 p-4 overflow-hidden break-words bg-white border-0 shadow-xl rounded-2xl bg-clip-border">
            <div class="flex flex-wrap -mx-3 items-center">
                {{-- Foto Profil --}}
                <div class="flex-none w-auto max-w-full px-3">
                    <div class="relative inline-flex items-center justify-center text-white h-24 w-24 rounded-xl shadow-lg overflow-hidden">
                        @if($anggota->pas_foto)
                            <img src="{{ asset('storage/' . $anggota->pas_foto) }}" alt="profile_image" class="w-full h-12 shadow-2xl rounded-xl" />
                        @else
                            <img src="{{ asset('assets/img/team-1.jpg') }}" alt="profile_image" class="w-full h-12 shadow-2xl rounded-xl" />
                        @endif
                    </div>
                </div>

                {{-- Info Utama --}}
                <div class="flex-none w-auto max-w-full px-3 my-auto">
                    <div class="h-full flex flex-col justify-center">
                        <h5 class="mb-1 text-xl font-bold text-slate-800">{{ $anggota->nama_lengkap }}</h5>
                        
                        {{-- Jabatan Fungsional --}}
                        <p class="mb-1 font-semibold text-slate-600 text-sm">
                            <i class="fas fa-briefcase mr-1 text-slate-400"></i> 
                            {{ $anggota->jabatan_fungsional ?? 'Jabatan belum diisi' }}
                        </p>

                        {{-- Level & Wilayah --}}
                        <div class="flex items-center gap-2 mt-1">
                            <span class="px-3 py-1 rounded-full text-xs font-bold uppercase {{ $badgeColor }}">
                                {{ $levelDisplay }}
                            </span>
                            <span class="text-xs text-slate-500 font-semibold">
                                <i class="fas fa-map-marker-alt mr-1"></i> {{ $wilayahDisplay }}
                            </span>
                        </div>
                    </div>
                </div>

                {{-- Tombol Aksi --}}
                <div class="w-full max-w-full px-3 mt-4 lg:mt-0 lg:w-auto lg:flex-none ml-auto self-center">
                    <div class="flex items-center justify-center lg:justify-end space-x-3">
                        <a href="{{ route('admin.profile.cetak_kartu') }}" target="_blank" class="inline-flex items-center px-4 py-2 font-bold text-white transition-all bg-blue-500 rounded-lg shadow-md text-xs hover:shadow-lg hover:-translate-y-px active:opacity-85">
                            <i class="fas fa-print mr-2"></i> Cetak Kartu
                        </a>
                        <a href="{{ route('admin.profile.edit') }}" class="inline-flex items-center px-4 py-2 font-bold text-white transition-all bg-slate-700 rounded-lg shadow-md text-xs hover:shadow-lg hover:-translate-y-px active:opacity-85">
                            <i class="fas fa-edit mr-2"></i> Update Profil
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Detail Informasi --}}
    <div class="w-full p-6 mx-auto">
        <div class="flex flex-wrap -mx-3">
            <div class="w-full max-w-full px-3 shrink-0">
                <div class="relative flex flex-col min-w-0 break-words bg-white border-0 shadow-xl rounded-2xl bg-clip-border">
                    <div class="border-b border-gray-100 p-6 pb-4">
                        <h6 class="text-lg font-bold text-slate-700 mb-0">
                            <i class="fas fa-info-circle mr-2 text-blue-500"></i> Detail Informasi Akun
                        </h6>
                    </div>
                    <div class="flex-auto p-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                            {{-- Kolom Kiri --}}
                            <div>
                                <h6 class="text-xs font-bold leading-tight uppercase text-slate-500 opacity-70 mb-4">Informasi Pribadi</h6>
                                <ul class="flex flex-col pl-0 mb-0 space-y-4 rounded-lg">
                                    <li class="relative block px-0 py-2 bg-white border-0 text-slate-600">
                                        <strong class="block text-xs text-slate-700 mb-1">Email Akun:</strong>
                                        {{ $anggota->email }}
                                    </li>
                                    <li class="relative block px-0 py-2 bg-white border-0 text-slate-600">
                                        <strong class="block text-xs text-slate-700 mb-1">Tanggal Lahir:</strong>
                                        {{ $anggota->tanggal_lahir ? \Carbon\Carbon::parse($anggota->tanggal_lahir)->translatedFormat('d F Y') : '-' }}
                                    </li>
                                    <li class="relative block px-0 py-2 bg-white border-0 text-slate-600">
                                        <strong class="block text-xs text-slate-700 mb-1">Jenis Kelamin:</strong>
                                        {{ $anggota->jenis_kelamin ?? '-' }}
                                    </li>
                                    <li class="relative block px-0 py-2 bg-white border-0 text-slate-600">
                                        <strong class="block text-xs text-slate-700 mb-1">Agama:</strong>
                                        {{ $anggota->agama ?? '-' }}
                                    </li>
                                </ul>
                            </div>

                            {{-- Kolom Kanan --}}
                            <div>
                                <h6 class="text-xs font-bold leading-tight uppercase text-slate-500 opacity-70 mb-4">Kepegawaian & Instansi</h6>
                                <ul class="flex flex-col pl-0 mb-0 space-y-4 rounded-lg">
                                    <li class="relative block px-0 py-2 bg-white border-0 text-slate-600">
                                        <strong class="block text-xs text-slate-700 mb-1">NIP / No. Identitas:</strong>
                                        {{ $anggota->nip ?? 'Tidak ada' }}
                                    </li>
                                    <li class="relative block px-0 py-2 bg-white border-0 text-slate-600">
                                        <strong class="block text-xs text-slate-700 mb-1">NPWP:</strong>
                                        {{ $anggota->npwp ?? 'Tidak ada' }}
                                    </li>
                                    <li class="relative block px-0 py-2 bg-white border-0 text-slate-600">
                                        <strong class="block text-xs text-slate-700 mb-1">Asal Instansi & Unit Kerja:</strong>
                                        {{ $anggota->asal_instansi ?? '-' }} <br>
                                        <span class="text-xs text-slate-400">{{ $anggota->unit_kerja ?? '' }}</span>
                                    </li>
                                    <li class="relative block px-0 py-2 bg-white border-0 text-slate-600">
                                        <strong class="block text-xs text-slate-700 mb-1">Bergabung Sejak:</strong>
                                        {{ $anggota->created_at->translatedFormat('d F Y') }}
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection