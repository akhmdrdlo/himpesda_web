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
                        
                        <div class="mb-6 p-4 bg-blue-50 border border-blue-200 rounded-lg">
                            <h5 class="text-sm font-bold text-blue-800 mb-2"><i class="fas fa-info-circle mr-2"></i>Petunjuk Import Data</h5>
                            <ul class="list-disc list-inside text-sm text-blue-700 space-y-1">
                                <li>Gunakan template Excel yang telah disediakan agar format data sesuai.</li>
                                <li>Data yang diimport akan berstatus <strong>Pending (Menunggu Pembayaran/Verifikasi)</strong>.</li>
                                <li>Bendahara perlu memverifikasi data tersebut di menu <strong>Konfirmasi Pembayaran</strong> agar anggota menjadi Aktif.</li>
                                <li>Pastikan kolom <strong>Email</strong> dan <strong>NIP</strong> (jika ada) unik dan belum terdaftar sebelumnya.</li>
                            </ul>
                            <div class="mt-4">
                                <a href="{{ asset('assets/templates/template_import_anggota.xlsx') }}" download class="inline-flex items-center px-4 py-2 bg-white border border-blue-300 rounded-md font-semibold text-xs text-blue-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150">
                                    <i class="fas fa-file-excel mr-2 text-green-600"></i> Download Template Excel
                                </a>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="file" class="block mb-2 text-sm font-medium text-gray-900">Pilih file Excel (.xlsx / .xls)</label>
                            <input type="file" name="file" id="file" accept=".xlsx, .xls" class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none file:mr-4 file:py-2 file:px-4 file:rounded-l-lg file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100" required>
                            @error('file')
                                <p class="mt-2 text-xs text-red-500">{{ $message }}</p>
                            @enderror
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