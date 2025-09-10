@extends('layouts.app')
@section('title', 'Sejarah Singkat')
@section('content')
    <section class="w-full bg-[var(--blue-dark)] py-20">
        <div class="max-w-7xl mx-auto px-6 text-center"><h1 class="text-4xl font-bold text-white">Sejarah Singkat</h1></div>
    </section>
    <section class="max-w-4xl mx-auto p-6 md:p-10">
        <div class="prose lg:prose-xl max-w-none text-justify">
            <p>{{ $organisasi->sejarah_singkat ?? 'Konten sejarah belum tersedia.' }}</p>
        </div>
    </section>
@endsection