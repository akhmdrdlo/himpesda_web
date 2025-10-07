@extends('layouts.app')
@section('title', 'Visi dan Misi')
@section('content')
    <section class="w-full bg-[var(--blue-dark)] py-20">
        <div class="max-w-7xl mx-auto px-6 text-center">
            <h1 class="text-4xl font-bold text-white">Visi & Misi HIMPESDA</h1>
            <p class="text-white/80 mt-2">Arah dan tujuan organisasi dalam mencapai cita-citanya.</p>
        </div>
    </section>
    <section class="max-w-5xl mx-auto p-6 md:py-20">
        <div class="grid md:grid-cols-2 gap-10 items-start">
            
            <!-- Kolom Visi -->
            <div class="bg-white p-8 rounded-lg shadow-lg border border-gray-200 h-full">
                <div class="flex items-center mb-4">
                    <div class="bg-blue-100 text-blue-600 rounded-full p-3 mr-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-800">Visi</h3>
                </div>
                <div class="prose max-w-none text-gray-600">
                    {!! $organisasi->visi ?? '<p>Visi organisasi belum tersedia saat ini.</p>' !!}
                </div>
            </div>

            <!-- Kolom Misi -->
            <div class="bg-white p-8 rounded-lg shadow-lg border border-gray-200 h-full">
                <div class="flex items-center mb-4">
                    <div class="bg-emerald-100 text-emerald-600 rounded-full p-3 mr-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-800">Misi</h3>
                </div>
                <div class="prose max-w-none text-gray-600">
                     {!! $organisasi->misi ?? '<ul><li>Misi organisasi belum tersedia saat ini.</li></ul>' !!}
                </div>
            </div>

        </div>
    </section>
@endsection
