@extends('layouts.admin')

@section('title', 'Tambah Kategori Baru')

@section('content')
<div class="w-full p-6 mx-auto">
    <div class="relative flex flex-col min-w-0 break-words bg-white border-0 shadow-xl rounded-2xl bg-clip-border">
        <div class="p-6 pb-0"><h6 class="text-lg">Formulir Tambah Kategori</h6></div>
            {{-- Menampilkan semua error validasi di bagian atas --}}
            @if ($errors->any())
                <div class="p-4 mx-6 mt-4 text-sm text-red-800 bg-red-100 rounded-lg" role="alert">
                    <span class="font-medium">Terjadi kesalahan!</span>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li class="list-disc list-inside">{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        <div class="flex-auto p-6">
            <form action="{{ route('admin.categories.store') }}" method="POST">
                @csrf
                <div class="space-y-4">
                    <div>
                        <label for="name" class="block font-bold text-xs text-slate-700">Nama Kategori</label>
                        <input type="text" name="name" id="name" class="focus:shadow-primary-outline text-sm leading-5.6 ease block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 outline-none transition-all focus:border-blue-500 focus:outline-none" required value="{{ old('name') }}">
                    </div>

                    <div class="flex justify-end space-x-2">
                        <a href="{{ route('admin.categories.index') }}" class="px-8 py-2 font-bold text-gray-700 bg-gray-200 rounded-lg">Batal</a>
                        <button type="submit" class="px-8 py-2 font-bold text-white bg-blue-500 rounded-lg">Simpan Kategori</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
