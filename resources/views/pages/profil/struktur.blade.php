@extends('layouts.app')
@section('title', 'Struktur Organisasi')
@section('content')
    <section class="w-full bg-[var(--blue-dark)] py-20">
        <div class="max-w-7xl mx-auto px-6 text-center"><h1 class="text-4xl font-bold text-white">Struktur Organisasi</h1></div>
    </section>
    <section class="max-w-5xl mx-auto p-6 md:p-10 text-center">
        <img src="{{ asset('storage/' . $organisasi->gambar_struktur_organisasi) }}" alt="Struktur Organisasi" class="mx-auto rounded-lg shadow-lg">
    </section>
@endsection