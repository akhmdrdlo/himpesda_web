@extends('layouts.app')
@section('title', 'Visi dan Misi')
@section('content')
    <section class="w-full bg-[var(--blue-dark)] py-20">
        <div class="max-w-7xl mx-auto px-6 text-center"><h1 class="text-4xl font-bold text-white">Visi & Misi</h1></div>
    </section>
    <section class="max-w-5xl mx-auto p-6 md:p-10 grid md:grid-cols-2 gap-10">
        <div class="prose lg:prose-xl max-w-none">
            <h3>Visi</h3>
            <p>{{ $organisasi->visi ?? 'Visi belum tersedia.' }}</p>
        </div>
        <div class="prose lg:prose-xl max-w-none">
            <h3>Misi</h3>
            <p>{{ $organisasi->misi ?? 'Misi belum tersedia.' }}</p>
        </div>
    </section>
@endsection