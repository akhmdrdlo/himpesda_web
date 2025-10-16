@extends('layouts.admin')

@section('title', 'Manajemen Dokumen')

@section('content')
<div class="w-full px-6 py-6 mx-auto">
    @if(session('success'))
    <div class="relative p-4 pr-12 mb-4 text-white border border-solid rounded-lg bg-gradient-to-tl from-emerald-500 to-teal-400" role="alert">
        {{ session('success') }}
    </div>
    @endif
    
    <div class="flex flex-wrap -mx-3">
        <div class="flex-none w-full max-w-full px-3">
            <div class="relative flex flex-col min-w-0 mb-6 break-words bg-white border-0 border-transparent border-solid shadow-xl rounded-2xl bg-clip-border">
                <div class="p-6 pb-0 mb-0 border-b-0 border-b-solid rounded-t-2xl border-b-transparent">
                    <h6>Manajemen Dokumen Organisasi</h6>
                    <p class="text-sm text-gray-500">Unggah atau tautkan dokumen penting seperti Kode Etik, AD, dan ART di sini.</p>
                </div>
                <div class="flex-auto p-4">
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm text-left text-gray-500">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3">Judul Dokumen</th>
                                    <th scope="col" class="px-6 py-3">Sumber Saat Ini</th>
                                    <th scope="col" class="px-6 py-3 text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($documents as $document)
                                <tr class="bg-white border-b hover:bg-gray-50">
                                    <td class="px-6 py-4 font-semibold text-gray-900">{{ $document->title }}</td>
                                    <td class="px-6 py-4">
                                        @if($document->source_type == 'link' && $document->external_link)
                                            <a href="{{ $document->external_link }}" target="_blank" class="text-blue-600 hover:underline">Lihat Tautan</a>
                                        @elseif($document->source_type == 'upload' && $document->file_path)
                                            <a href="{{ asset('storage/' . $document->file_path) }}" target="_blank" class="text-green-600 hover:underline">Lihat File</a>
                                        @else
                                            <span class="text-gray-400">Belum diatur</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <a href="{{ route('admin.documents.edit', $document->id) }}" class="px-4 py-2 text-xs font-bold text-white bg-slate-700 rounded-lg">Ubah</a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="3" class="p-4 text-center text-slate-500">Data dokumen tidak ditemukan.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
