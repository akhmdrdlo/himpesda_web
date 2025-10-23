@extends('layouts.admin')

@section('title', 'Detail Anggota')

@section('content')
<div class="relative w-full mx-auto mt-30">
@if(session('success'))
<div class="w-full px-6 pt-6 mx-auto">
    <div class="relative p-4 pr-12 mb-4 text-white border border-solid rounded-lg bg-gradient-to-tl from-emerald-500 to-teal-400 border-emerald-300" role="alert">
        <span class="font-bold">Sukses!</span>
        <span class="block sm:inline">{{ session('success') }}</span>
        <button type="button" class="absolute top-0 bottom-0 right-0 px-4 py-3" data-alert-close="true">
            <span class="text-2xl" aria-hidden="true">×</span>
        </button>
    </div>
</div>
@endif
    <div class="relative flex flex-col flex-auto min-w-0 p-4 mx-6 overflow-hidden break-words bg-white border-0 shadow-3xl rounded-2xl bg-clip-border">
        <div class=" flex-wrap -mx-3">
            <div class="flex-none w-auto max-w-full px-3">
                <!-- Ukuran foto profil diperbesar -->
                <div class="relative inline-flex items-center justify-center text-white transition-all duration-200 ease-in-out h-10 w-10 rounded-xl">
                    @if($anggota->pas_foto)
                        <img src="{{ asset('storage/' . $anggota->pas_foto) }}" alt="Pas Foto {{ $anggota->nama_lengkap }}" class="w-full h-full shadow-2xl rounded-xl object-cover" />
                    @else
                        <img src="{{ asset('assets/img/team-2.jpg') }}" alt="Placeholder Foto" class="w-full h-full shadow-2xl rounded-xl object-cover"/>
                    @endif
                </div>
            </div>
            <div class="flex-none w-auto max-w-full px-3 my-auto">
                <div class="h-full">
                    <h5 class="mb-1 text-xl">{{ $anggota->nama_lengkap }}</h5>
                    <p class="mb-0 font-semibold leading-normal text-sm">{{ $anggota->jabatan_fungsional ?? 'Jabatan Belum Diisi' }}</p>
                    <p class="mb-0 font-semibold leading-normal text-sm">Anggota {{$anggota->tipe_anggota}}</p>
                </div>
            </div>
            <div class="w-full max-w-full px-3 mt-4 lg:mt-0 lg:w-auto lg:flex-none ml-auto self-center">
                <div class="flex items-center justify-center lg:justify-end space-x-2 flex-wrap gap-y-2">
                    <!-- Tombol Cetak Kartu ditambahkan -->
                    <a href="{{ route('admin.anggota.cetak-kartu', $anggota->id) }}" target="_blank" class="inline-block px-4 py-2 font-bold text-center text-white align-middle transition-all ease-in bg-gradient-to-tl from-blue-500 to-violet-500 border-0 rounded-lg shadow-md cursor-pointer text-xs hover:shadow-xs hover:-translate-y-px active:opacity-85">
                        <i class="fas fa-print mr-1"></i> Cetak Kartu
                    </a>
                    @if(in_array(auth()->user()->level, ['admin', 'operator']))
                    <a href="{{ route('admin.anggota.edit', $anggota->id) }}" class="inline-block px-4 py-2 font-bold text-center text-white align-middle transition-all ease-in bg-slate-700 border-0 rounded-lg shadow-md cursor-pointer text-xs hover:shadow-xs hover:-translate-y-px active:opacity-85">Update Profil</a>
                    <form action="{{ route('admin.anggota.destroy', $anggota->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus anggota ini?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="inline-block px-4 py-2 font-bold text-center text-white align-middle transition-all ease-in bg-gradient-to-tl from-red-600 to-orange-600 border-0 rounded-lg shadow-md cursor-pointer text-xs hover:shadow-xs hover:-translate-y-px active:opacity-85">Hapus Profil</button>
                    </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<div class="w-full p-6 mx-auto">
    <div class="flex flex-wrap -mx-3">
        <div class="w-full max-w-full px-3 shrink-0">
            <div class="relative flex flex-col min-w-0 break-words bg-white border-0 shadow-xl rounded-2xl bg-clip-border">
                <div class="p-6 pb-0">
                    <h6 class="text-lg">Detail Informasi Anggota</h6>
                </div>
                <div class="flex-auto p-6">
                    {{-- Informasi Pribadi --}}
                    <p class="text-sm leading-normal uppercase text-slate-500">Informasi Pribadi</p>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-4 mb-6">
                        <div><strong class="block text-xs text-slate-500">Nama Lengkap:</strong><p>{{ $anggota->nama_lengkap }}</p></div>
                        <div><strong class="block text-xs text-slate-500">Email:</strong><p>{{ $anggota->email }}</p></div>
                        <div><strong class="block text-xs text-slate-500">No. Telepon:</strong><p>{{ $anggota->no_telp ?? '-' }}</p></div>
                        <div><strong class="block text-xs text-slate-500">Jenis Kelamin:</strong><p>{{ $anggota->jenis_kelamin ?? '-' }}</p></div>
                        <div><strong class="block text-xs text-slate-500">Tanggal Lahir:</strong><p>{{ $anggota->tanggal_lahir ? \Carbon\Carbon::parse($anggota->tanggal_lahir)->translatedFormat('d F Y') : '-' }}</p></div>
                        <div><strong class="block text-xs text-slate-500">Agama:</strong><p>{{ $anggota->agama ?? '-' }}</p></div>
                    </div>
                    <hr class="h-px mx-0 my-4 bg-transparent border-0 opacity-25 bg-gradient-to-r from-transparent via-black/40 to-transparent" />
                    {{-- Informasi Kepegawaian --}}
                    <p class="text-sm leading-normal uppercase text-slate-500">Informasi Kepegawaian</p>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-4 mb-6">
                        <div><strong class="block text-xs text-slate-500">Nomor Anggota (KTA):</strong><p>{{ $anggota->nomor_anggota ?? 'Belum Digenerate' }}</p></div>
                        <div><strong class="block text-xs text-slate-500">NIP:</strong><p>{{ $anggota->nip ?? '-' }}</p></div>
                        <div><strong class="block text-xs text-slate-500">NPWP:</strong><p>{{ $anggota->npwp ?? '-' }}</p></div>
                        <div><strong class="block text-xs text-slate-500">Golongan/Ruang:</strong><p>{{ $anggota->gol_ruang ?? '-' }}</p></div>
                        <div><strong class="block text-xs text-slate-500">Jabatan Fungsional:</strong><p>{{ $anggota->jabatan_fungsional ?? '-' }}</p></div>
                        <div><strong class="block text-xs text-slate-500">Asal Instansi:</strong><p>{{ $anggota->asal_instansi ?? '-' }}</p></div>
                        <div><strong class="block text-xs text-slate-500">Unit Kerja:</strong><p>{{ $anggota->unit_kerja ?? '-' }}</p></div>
                    </div>
                    <hr class="h-px mx-0 my-4 bg-transparent border-0 opacity-25 bg-gradient-to-r from-transparent via-black/40 to-transparent" />
                    {{-- Alamat Domisili --}}
                    <p class="text-sm leading-normal uppercase text-slate-500">Alamat Domisili</p>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-4">
                        <div><strong class="block text-xs text-slate-500">Provinsi:</strong><p>{{ $anggota->provinsi ?? '-' }}</p></div>
                        <div><strong class="block text-xs text-slate-500">Kabupaten/Kota:</strong><p>{{ $anggota->kabupaten_kota ?? '-' }}</p></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

