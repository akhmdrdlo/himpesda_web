@extends('layouts.admin')

@section('title', 'Detail Anggota')

@section('content')
    {{-- Helper Logic --}}
    @php
        $levelDisplay = ucwords(str_replace('_', ' ', $anggota->level));
        
        // Logika Wilayah
        $isPusat = in_array($anggota->level, ['admin', 'operator', 'bendahara']) || $anggota->tipe_anggota == 'pusat';
        $wilayahDisplay = $isPusat ? 'Pusat (Nasional)' : ($anggota->provinsi ?? '-');

        // Warna Badge
        $badgeColor = match($anggota->level) {
            'admin' => 'bg-purple-100 text-purple-800 border-purple-200',
            'anggota' => 'bg-emerald-100 text-emerald-800 border-emerald-200',
            'rejected' => 'bg-red-100 text-red-800 border-red-200',
            default => 'bg-blue-100 text-blue-800 border-blue-200',
        };
    @endphp

    @if(session('success'))
    <div class="w-full px-6 pt-6 mx-auto">
        <div class="relative p-4 pr-12 mb-4 text-white border border-solid rounded-lg bg-gradient-to-tl from-emerald-500 to-teal-400 border-emerald-300" role="alert">
            <span class="font-bold"><i class="fas fa-check mr-1"></i> Sukses!</span>
            <span class="block sm:inline">{{ session('success') }}</span>
            <button type="button" class="absolute top-0 bottom-0 right-0 px-4 py-3" data-alert-close="true">
                <span class="text-xl" aria-hidden="true">×</span>
            </button>
        </div>
    </div>
    @endif

    {{-- MODAL PASSWORD BARU (Compact & Fixed Z-Index) --}}
    @if(session('new_password'))
        @push('modals')
        <div x-data="{ show: true, password: '{{ session('new_password') }}' }" 
             x-show="show" 
             style="display: none;"
             class="fixed inset-0 z-[99999] flex items-center justify-center bg-black/60 backdrop-blur-sm p-4">
            
            <div class="bg-white rounded-xl shadow-2xl w-50 max-w-sm overflow-hidden transform transition-all"
                 @click.away="show = false"
                 x-transition:enter="ease-out duration-300"
                 x-transition:enter-start="opacity-0 scale-95"
                 x-transition:enter-end="opacity-100 scale-100">
                
                {{-- Header Compact --}}
                <div class="bg-gradient-to-r from-orange-500 to-yellow-500 px-6 py-4 flex items-center justify-between">
                    <h3 class="text-white font-bold text-lg"><i class="fas fa-key mr-2"></i> Password Baru</h3>
                    <button @click="show = false" class="text-orange-100 hover:text-white transition-colors">
                        <i class="fas fa-times"></i>
                    </button>
                </div>

                <div class="p-6">
                    <p class="text-sm text-gray-500 mb-4 text-center">
                        Password ini hanya tampil <strong>SATU KALI</strong>.
                    </p>
                    
                    {{-- Password Display --}}
                    <div class="bg-gray-50 border-2 border-dashed border-gray-300 rounded-lg p-3 mb-4 text-center group hover:border-orange-300 transition-colors relative">
                        <span x-text="password" class="font-mono text-xl font-bold text-slate-800 tracking-wider"></span>
                    </div>

                    {{-- Action Button --}}
                    <button @click="navigator.clipboard.writeText(password); $el.innerHTML = '<i class=\'fas fa-check mr-2\'></i> Tersalin!'" 
                            class="w-full py-2.5 px-4 bg-slate-800 hover:bg-slate-900 text-white text-sm font-bold rounded-lg shadow transform active:scale-95 transition-all flex items-center justify-center mb-2">
                        <i class="fas fa-copy mr-2"></i> Salin Password
                    </button>
                    
                    <p class="text-[10px] text-gray-400 text-center mt-2">
                        Infokan anggota untuk segera ganti password di profil.
                    </p>
                </div>
            </div>
        </div>
        @endpush
    @endif

    {{-- Header Detail Anggota --}}
    <div class="relative w-full mx-auto mt-6 px-6">
        <div class="relative flex flex-col flex-auto min-w-0 p-4 overflow-hidden break-words bg-white border-0 shadow-xl rounded-2xl bg-clip-border">
            <div class="flex flex-wrap -mx-3 items-center">
                {{-- Foto --}}
                <div class="flex-none w-auto max-w-full px-3">
                    <div class="relative inline-flex items-center justify-center text-white h-24 w-24 rounded-xl shadow-lg overflow-hidden">
                        @if($anggota->pas_foto)
                            <img src="{{ asset('storage/' . $anggota->pas_foto) }}" alt="Pas Foto {{ $anggota->nama_lengkap }}" class="w-full h-12 object-cover" />
                        @else
                            <img src="{{ asset('assets/img/team-2.jpg') }}" alt="Placeholder Foto" class="w-full h-12 object-cover"/>
                        @endif
                    </div>
                </div>

                {{-- Info Header --}}
                <div class="flex-none w-auto max-w-full px-3 my-auto">
                    <div class="h-full flex flex-col justify-center">
                        <h5 class="mb-1 text-xl font-bold text-slate-800">{{ $anggota->nama_lengkap }}</h5>
                        
                        {{-- Jabatan --}}
                        <p class="mb-2 font-semibold text-slate-600 text-sm">
                            <i class="fas fa-briefcase mr-1 text-slate-400"></i> 
                            {{ $anggota->jabatan_fungsional ?? 'Jabatan Fungsional Belum Diisi' }}
                        </p>

                        {{-- Badges Level & Wilayah --}}
                        <div class="flex flex-wrap items-center gap-2">
                            <span class="px-3 py-1 rounded-md text-xs font-bold border {{ $badgeColor }} uppercase tracking-wide">
                                {{ $levelDisplay }}
                            </span>
                            <span class="px-3 py-1 rounded-md text-xs font-bold bg-slate-100 text-slate-600 border border-slate-200">
                                <i class="fas fa-map-marker-alt mr-1 text-slate-400"></i> {{ $wilayahDisplay }}
                            </span>
                        </div>
                    </div>
                </div>

                {{-- Tombol Aksi --}}
                <div class="w-full max-w-full px-3 mt-4 lg:mt-0 lg:w-auto lg:flex-none ml-auto self-center">
                    @if(in_array(auth()->user()->status_pengajuan, ['active']))
                    <div class="flex items-center justify-center lg:justify-end space-x-2 flex-wrap gap-y-2">
                        <a href="{{ route('admin.anggota.cetak-kartu', $anggota->id) }}" target="_blank" class="inline-flex items-center px-4 py-2 font-bold text-white bg-gradient-to-tl from-blue-500 to-violet-500 rounded-lg shadow-md text-xs hover:shadow-lg hover:-translate-y-px active:opacity-85">
                            <i class="fas fa-print mr-2"></i> Cetak Kartu
                        </a>
                        
                        @if(in_array(auth()->user()->level, ['admin', 'operator']))
                            <a href="{{ route('admin.anggota.edit', $anggota->id) }}" class="inline-flex items-center px-4 py-2 font-bold text-white bg-slate-700 rounded-lg shadow-md text-xs hover:shadow-lg hover:-translate-y-px active:opacity-85">
                                <i class="fas fa-pen mr-2"></i> Edit
                            </a>
                            <form action="{{ route('admin.anggota.destroy', $anggota->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus anggota ini? Tindakan ini tidak dapat dibatalkan.');" class="inline-block">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="inline-flex items-center px-4 py-2 font-bold text-white bg-red-600 rounded-lg shadow-md text-xs hover:bg-red-700 hover:shadow-lg hover:-translate-y-px active:opacity-85">
                                    <i class="fas fa-trash mr-2"></i> Hapus
                                </button>
                            </form>
                            
                            {{-- Tombol Generate Password (Reset) --}}
                            <form action="{{ route('admin.anggota.generate-password', $anggota->id) }}" method="POST" onsubmit="return confirm('Yakin ingin mereset password user ini? Password baru akan digenerate dan ditampilkan satu kali.');" class="inline-block">
                                @csrf
                                <button type="submit" class="inline-flex items-center px-4 py-2 font-bold text-white bg-slate-800 hover:bg-slate-900 rounded-lg shadow-md text-xs hover:shadow-lg hover:-translate-y-px active:opacity-85">
                                    <i class="fas fa-key mr-2"></i> Reset Pass
                                </button>
                            </form>
                        @endif
                    </div>
                    @else
                    {{-- Jika akun belum aktif --}}
                    <div class="flex items-center justify-center lg:justify-end">
                        <span class="px-4 py-2 text-xs font-bold text-yellow-800 bg-yellow-100 border border-yellow-200 rounded-lg">
                            <i class="fas fa-exclamation-triangle mr-1"></i> Akun Belum Aktif
                        </span>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- Detail Informasi Lengkap --}}
    <div class="w-full p-6 mx-auto">
        <div class="flex flex-wrap -mx-3">
            <div class="w-full max-w-full px-3 shrink-0">
                <div class="relative flex flex-col min-w-0 break-words bg-white border-0 shadow-xl rounded-2xl bg-clip-border">
                    <div class="border-b border-gray-100 p-6 pb-4">
                         <h6 class="text-lg font-bold text-slate-700 mb-0">
                            <i class="fas fa-file-alt mr-2 text-blue-500"></i> Data Lengkap Anggota
                        </h6>
                    </div>
                    <div class="flex-auto p-6">
                        {{-- Grid Layout --}}
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                            
                            {{-- Kolom 1: Pribadi --}}
                            <div>
                                <p class="text-xs font-bold leading-tight uppercase text-slate-500 mb-4">Informasi Pribadi</p>
                                <div class="space-y-4">
                                    <div class="flex justify-between border-b border-slate-100 pb-2">
                                        <span class="text-xs text-slate-500">Nama Lengkap</span>
                                        <span class="text-sm font-semibold text-slate-700 text-right">{{ $anggota->nama_lengkap }}</span>
                                    </div>
                                    <div class="flex justify-between border-b border-slate-100 pb-2">
                                        <span class="text-xs text-slate-500">Email</span>
                                        <span class="text-sm font-semibold text-slate-700 text-right">{{ $anggota->email }}</span>
                                    </div>
                                    <div class="flex justify-between border-b border-slate-100 pb-2">
                                        <span class="text-xs text-slate-500">No. Telepon</span>
                                        <span class="text-sm font-semibold text-slate-700 text-right">{{ $anggota->no_telp ?? '-' }}</span>
                                    </div>
                                    <div class="flex justify-between border-b border-slate-100 pb-2">
                                        <span class="text-xs text-slate-500">Jenis Kelamin</span>
                                        <span class="text-sm font-semibold text-slate-700 text-right">{{ $anggota->jenis_kelamin ?? '-' }}</span>
                                    </div>
                                    <div class="flex justify-between border-b border-slate-100 pb-2">
                                        <span class="text-xs text-slate-500">Tanggal Lahir</span>
                                        <span class="text-sm font-semibold text-slate-700 text-right">
                                            {{ $anggota->tanggal_lahir ? \Carbon\Carbon::parse($anggota->tanggal_lahir)->translatedFormat('d F Y') : '-' }}
                                        </span>
                                    </div>
                                     <div class="flex justify-between border-b border-slate-100 pb-2">
                                        <span class="text-xs text-slate-500">Agama</span>
                                        <span class="text-sm font-semibold text-slate-700 text-right">{{ $anggota->agama ?? '-' }}</span>
                                    </div>
                                </div>
                            </div>

                            {{-- Kolom 2: Kepegawaian & Domisili --}}
                            <div>
                                <p class="text-xs font-bold leading-tight uppercase text-slate-500 mb-4">Informasi Kepegawaian</p>
                                <div class="space-y-4">
                                    <div class="flex justify-between border-b border-slate-100 pb-2">
                                        <span class="text-xs text-slate-500">Nomor Anggota (KTA)</span>
                                        <span class="text-sm font-bold text-blue-600 text-right">{{ $anggota->nomor_anggota ?? 'Belum Ada' }}</span>
                                    </div>
                                    <div class="flex justify-between border-b border-slate-100 pb-2">
                                        <span class="text-xs text-slate-500">NIP / Identitas</span>
                                        <span class="text-sm font-semibold text-slate-700 text-right">{{ $anggota->nip ?? '-' }}</span>
                                    </div>
                                    <div class="flex justify-between border-b border-slate-100 pb-2">
                                        <span class="text-xs text-slate-500">Jabatan Fungsional</span>
                                        <span class="text-sm font-semibold text-slate-700 text-right">{{ $anggota->jabatan_fungsional ?? '-' }}</span>
                                    </div>
                                    <div class="flex justify-between border-b border-slate-100 pb-2">
                                        <span class="text-xs text-slate-500">Instansi / Unit Kerja</span>
                                        <div class="text-right">
                                            <span class="block text-sm font-semibold text-slate-700">{{ $anggota->asal_instansi ?? '-' }}</span>
                                            <span class="block text-xs text-slate-400">{{ $anggota->unit_kerja ?? '' }}</span>
                                        </div>
                                    </div>
                                </div>

                                <p class="text-xs font-bold leading-tight uppercase text-slate-500 mt-8 mb-4">Domisili & Wilayah</p>
                                <div class="space-y-4">
                                    <div class="flex justify-between border-b border-slate-100 pb-2">
                                        <span class="text-xs text-slate-500">Provinsi</span>
                                        <span class="text-sm font-semibold text-slate-700 text-right">{{ $anggota->provinsi ?? '-' }}</span>
                                    </div>
                                    <div class="flex justify-between border-b border-slate-100 pb-2">
                                        <span class="text-xs text-slate-500">Kabupaten/Kota</span>
                                        <span class="text-sm font-semibold text-slate-700 text-right">{{ $anggota->kabupaten_kota ?? '-' }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- End Grid --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection