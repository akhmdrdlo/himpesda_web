@extends('layouts.app')
@section('title', 'Sejarah Singkat')
@section('content')
    <section class="w-full bg-[var(--blue-dark)] py-20">
        <div class="max-w-7xl mx-auto px-6 text-center"><h1 class="text-4xl font-bold text-white">Sejarah Singkat HIMPESDA</h1></div>
    </section>
    <section class="max-w-4xl mx-auto p-6 md:py-20">
        <div class="prose lg:prose-xl max-w-none text-justify bg-white p-8 rounded-lg shadow-md">
            {!! $organisasi->sejarah_singkat ?? '<p>Konten sejarah belum tersedia.</p>' !!}
        </div>
    </section>
@endsection