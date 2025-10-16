@extends('layouts.admin')

@section('title', 'Ubah Informasi Organisasi')

@section('content')
<div class="w-full p-6 mx-auto">
    <div class="relative flex flex-col min-w-0 break-words bg-white border-0 shadow-xl rounded-2xl bg-clip-border">
        <div class="border-black/12.5 rounded-t-2xl border-b-0 border-solid p-6 pb-0">
            <h6 class="text-lg font-bold">Formulir Informasi Organisasi</h6>
        </div>

        @if(session('success'))
            <div class="relative p-4 mx-6 mt-4 text-white border border-solid rounded-lg bg-gradient-to-tl from-emerald-500 to-teal-400" role="alert">
                {{ session('success') }}
            </div>
        @endif

        <div class="flex-auto p-6">
            <form action="{{ route('admin.organisasi.update') }}" method="POST" enctype="multipart/form-data" novalidate id="organisasi-form">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    {{-- Kolom Kiri --}}
                    <div class="space-y-4">
                        <div>
                            <label for="profil_singkat" class="block font-bold text-xs text-slate-700">Profil Singkat</label>
                            <textarea name="profil_singkat" rows="10" class="ckeditor-instance w-full rounded-lg border-gray-300" required>{{ old('profil_singkat', $organisasi->profil_singkat) }}</textarea>
                        </div>
                        <div>
                            <label for="sejarah_singkat" class="block font-bold text-xs text-slate-700">Sejarah Singkat</label>
                            <textarea name="sejarah_singkat" rows="10" class="ckeditor-instance w-full rounded-lg border-gray-300" required>{{ old('sejarah_singkat', $organisasi->sejarah_singkat) }}</textarea>
                        </div>
                         <div>
                            <label for="nama_ketua" class="block font-bold text-xs text-slate-700">Nama Ketua Saat Ini</label>
                            <input type="text" name="nama_ketua" value="{{ old('nama_ketua', $organisasi->nama_ketua) }}" class="focus:shadow-primary-outline text-sm leading-5.6 ease block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 outline-none transition-all focus:border-blue-500 focus:outline-none">
                        </div>
                        <div>
                            <label for="foto_ketua" class="block font-bold text-xs text-slate-700">Ganti Foto Ketua (Opsional)</label>
                            @if($organisasi->foto_ketua)
                                <div class="my-2 w-32 h-32">
                                    <img src="{{ asset('storage/' . $organisasi->foto_ketua) }}" alt="Foto Ketua" class="w-full h-full rounded-full object-cover border">
                                </div>
                            @endif
                            <input type="file" name="foto_ketua" class="focus:shadow-primary-outline text-sm leading-5.6 ease block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 outline-none transition-all focus:border-blue-500 focus:outline-none">
                        </div>
                    </div>
                    {{-- Kolom Kanan --}}
                    <div class="space-y-4">
                        <div>
                            <label for="visi" class="block font-bold text-xs text-slate-700">Visi</label>
                            <textarea name="visi" rows="10" class="ckeditor-instance w-full rounded-lg border-gray-300" required>{{ old('visi', $organisasi->visi) }}</textarea>
                        </div>
                        <div>
                            <label for="misi" class="block font-bold text-xs text-slate-700">Misi</label>
                            <textarea name="misi" rows="10" class="ckeditor-instance w-full rounded-lg border-gray-300" required>{{ old('misi', $organisasi->misi) }}</textarea>
                        </div>
                        <div>
                            <label for="gambar_struktur_organisasi" class="block font-bold text-xs text-slate-700">Ganti Gambar Struktur (Opsional)</label>
                             @if($organisasi->gambar_struktur_organisasi)
                                <div class="my-2 border rounded-md p-2">
                                    <img src="{{ asset('storage/' . $organisasi->gambar_struktur_organisasi) }}" alt="Struktur Organisasi" class="w-full h-auto rounded-md">
                                </div>
                            @endif
                            <input type="file" name="gambar_struktur_organisasi" class="focus:shadow-primary-outline text-sm leading-5.6 ease block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 outline-none transition-all focus:border-blue-500 focus:outline-none">
                        </div>
                    </div>
                </div>

                <div class="flex justify-end mt-6">
                    <a href="{{ route('admin.dashboard') }}" class="px-8 py-2 mr-2 font-bold text-gray-700 bg-gray-200 rounded-lg text-xs">Batal</a>
                    <button type="submit" class="px-8 py-2 font-bold text-white bg-blue-500 rounded-lg text-xs">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.ckeditor.com/ckeditor5/41.4.2/classic/ckeditor.js"></script>
<script>
    const editorInstances = {};

    document.querySelectorAll('.ckeditor-instance').forEach(editorEl => {
        ClassicEditor
            .create(editorEl)
            .then(editor => {
                editorInstances[editorEl.name] = editor;
            })
            .catch(error => {
                console.error('Error creating editor for element:', editorEl, error);
            });
    });

    document.getElementById('organisasi-form').addEventListener('submit', function(event) {
        for (const name in editorInstances) {
            const textarea = document.querySelector(`textarea[name="${name}"]`);
            if (textarea) {
                textarea.value = editorInstances[name].getData();
            }
        }
    });
</script>
@endpush
