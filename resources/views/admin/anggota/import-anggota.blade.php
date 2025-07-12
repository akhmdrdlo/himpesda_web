@extends('layouts.admin')

@section('title', 'Import Anggota')

@section('content')
<div class="w-full px-6 py-6 mx-auto">
    <div class="flex flex-wrap -mx-3">
        <div class="flex-none w-full max-w-full px-3">
            <div class="relative flex flex-col min-w-0 mb-6 break-words bg-white border-0 border-transparent border-solid shadow-xl rounded-2xl bg-clip-border">
                <div class="p-6 pb-0 mb-0 border-b-0 border-b-solid rounded-t-2xl border-b-transparent flex justify-between items-center">
                    <h6>Formulir Import Anggota dari Excel</h6>
                    <a href="{{ route('admin.anggota.index') }}" class="inline-block px-4 py-2 text-xs font-bold text-center text-white uppercase bg-slate-700 border-0 rounded-lg">
                        &laquo; Kembali ke Daftar Anggota
                    </a>
                </div>
                <div class="flex-auto px-6 pt-4 pb-6">
                    {{-- Form untuk upload file --}}
                    <form action="{{ route('admin.anggota.import.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-4">
                            <label for="file" class="block mb-2 text-sm font-medium text-gray-900">Pilih file Excel</label>
                            <input type="file" name="file" id="file" class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none" required>
                            @error('file')
                                <p class="mt-2 text-xs text-red-500">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="p-4 mb-4 text-sm bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700">
                            <p class="font-bold">Perhatian!</p>
                            <p>Pastikan file Excel Anda memiliki header kolom yang sesuai: `nama_lengkap`, `email`, `nip`, `jenis_kelamin`, `tanggal_lahir`, `agama`, `npwp`, `asal_instansi`, `unit_kerja`, `jabatan_fungsional`.</p>
                        </div>
                        <div class="flex justify-end">
                            <button type="submit" class="px-8 py-2 text-sm font-bold text-white bg-blue-500 rounded-lg">Mulai Proses Import</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection