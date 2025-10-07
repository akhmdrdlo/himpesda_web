@extends('layouts.app')
@section('title', 'Sejarah Singkat')
@section('content')
    <section class="w-full bg-[var(--blue-dark)] py-20">
        <div class="max-w-7xl mx-auto px-6 text-center"><h1 class="text-4xl font-bold text-white">Sejarah Singkat HIMPESDA</h1></div>
    </section>
    <section class="max-w-5xl mx-auto p-6 md:py-20">
        <div class="bg-white p-8 rounded-lg shadow-md">
            <div class="flex flex-col md:flex-row items-center md:items-start -mx-4">
                
                <!-- Kolom Kiri: Foto & Nama Ketua -->
                <div class="w-full md:w-1/3 px-4 text-center mb-8 md:mb-0">
                    <div class="relative inline-block">
                        <img src="{{ asset('storage/' . $organisasi->foto_ketua) }}" alt="Foto Ketua" class="w-40 h-40 object-cover rounded-full shadow-lg mx-auto border-4 border-gray-200">
                    </div>
                    <h3 class="text-xl font-bold mt-4 text-gray-800">{{ $organisasi->nama_ketua ?? 'Data belum diisi.' }}</h3>
                    <p class="text-sm text-gray-500">Ketua HIMPESDA</p>
                </div>

                <!-- Kolom Kanan: Sejarah Singkat -->
                <div class="w-full md:w-2/3 px-4">
                    <div class="prose lg:prose-lg max-w-none text-justify">
                        {!! $organisasi->sejarah_singkat ?? '<p>Konten sejarah belum tersedia.</p>' !!}
                    </div>
                </div>

            </div>
        </div>
    </section>
@endsection
