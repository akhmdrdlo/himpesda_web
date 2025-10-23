@extends('layouts.admin')

@section('title', 'Update Profil Anggota')

@section('content')
<div class="w-full p-6 mx-auto">
    <div class="relative flex flex-col min-w-0 break-words bg-white border-0 shadow-xl rounded-2xl bg-clip-border">
      <div class="p-6 pb-0">
        <h6 class="text-lg">Update Profil: {{ $anggota->nama_lengkap }}</h6>
      </div>
      <div class="flex-auto p-6">
        @if(session('success'))
            <div class="px-6 py-3 mx-6 mb-4 text-sm text-green-800 bg-green-100 rounded-lg">
                {{ session('success') }}
            </div>
        @endif
        @if ($errors->any())
            <div class="p-4 mb-4 text-sm text-red-800 bg-red-100 rounded-lg">
                <ul>@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
            </div>
        @endif

        <form action="{{ route('admin.anggota.update', $anggota->id) }}" method="POST" enctype="multipart/form-data">
          @csrf
          @method('PUT')

          <p class="text-sm leading-normal uppercase text-slate-500">Informasi Pribadi</p>
          <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
            <div>
              <label class="text-xs font-bold">Nama Lengkap</label>
              <input type="text" name="nama_lengkap" value="{{ old('nama_lengkap', $anggota->nama_lengkap) }}" class="focus:shadow-primary-outline text-sm leading-5.6 ease block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white p-2" required />
            </div>
            <div>
              <label class="text-xs font-bold">Email</label>
              <input type="email" name="email" value="{{ old('email', $anggota->email) }}" class="focus:shadow-primary-outline text-sm leading-5.6 ease block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white p-2" required />
            </div>
            <div>
              <label class="text-xs font-bold">No. Telepon</label>
              <input type="text" name="no_telp" value="{{ old('no_telp', $anggota->no_telp) }}" class="focus:shadow-primary-outline text-sm leading-5.6 ease block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white p-2" />
            </div>
            <div>
              <label class="text-xs font-bold">Jenis Kelamin</label>
              <select name="jenis_kelamin" class="focus:shadow-primary-outline text-sm leading-5.6 ease block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white p-2">
                  <option value="" {{ old('jenis_kelamin', $anggota->jenis_kelamin) == '' ? 'selected' : '' }}>-- Pilih --</option>
                  <option value="Laki-laki" {{ old('jenis_kelamin', $anggota->jenis_kelamin) == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                  <option value="Perempuan" {{ old('jenis_kelamin', $anggota->jenis_kelamin) == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
              </select>
            </div>
            <div>
              <label class="text-xs font-bold">Tanggal Lahir</label>
              <input type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir', $anggota->tanggal_lahir) }}" class="focus:shadow-primary-outline text-sm leading-5.6 ease block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white p-2" />
            </div>
            <div>
              <label class="text-xs font-bold">Agama</label>
              <input type="text" name="agama" value="{{ old('agama', $anggota->agama) }}" class="focus:shadow-primary-outline text-sm leading-5.6 ease block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white p-2" />
            </div>
            <div>
                <label class="text-xs font-bold">Provinsi</label>
                <input type="text" name="provinsi" value="{{ old('provinsi', $anggota->provinsi) }}" class="focus:shadow-primary-outline text-sm leading-5.6 ease block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white p-2" />
            </div>
            <div>
                <label class="text-xs font-bold">Kabupaten/Kota</label>
                <input type="text" name="kabupaten_kota" value="{{ old('kabupaten_kota', $anggota->kabupaten_kota) }}" class="focus:shadow-primary-outline text-sm leading-5.6 ease block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white p-2" />
            </div>
          </div>

          <hr class="h-px mx-0 my-4 bg-transparent border-0 opacity-25 bg-gradient-to-r from-transparent via-black/40 to-transparent" />
          
          <p class="text-sm leading-normal uppercase text-slate-500">Informasi Kepegawaian & Keanggotaan</p>
          <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
              <label class="text-xs font-bold">NIP</label>
              <input type="text" name="nip" value="{{ old('nip', $anggota->nip) }}" class="focus:shadow-primary-outline text-sm leading-5.6 ease block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white p-2" />
            </div>
            <div>
              <label class="text-xs font-bold">NPWP</label>
              <input type="text" name="npwp" value="{{ old('npwp', $anggota->npwp) }}" class="focus:shadow-primary-outline text-sm leading-5.6 ease block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white p-2" />
            </div>
            <div>
              <label class="text-xs font-bold">Golongan/Ruang</label>
              <input type="text" name="gol_ruang" value="{{ old('gol_ruang', $anggota->gol_ruang) }}" class="focus:shadow-primary-outline text-sm leading-5.6 ease block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white p-2" />
            </div>
            <div>
              <label class="text-xs font-bold">Jabatan Fungsional</label>
              <input type="text" name="jabatan_fungsional" value="{{ old('jabatan_fungsional', $anggota->jabatan_fungsional) }}" class="focus:shadow-primary-outline text-sm leading-5.6 ease block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white p-2" />
            </div>
            <div class="md:col-span-2">
              <label class="text-xs font-bold">Asal Instansi</label>
              <input type="text" name="asal_instansi" value="{{ old('asal_instansi', $anggota->asal_instansi) }}" class="focus:shadow-primary-outline text-sm leading-5.6 ease block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white p-2" />
            </div>
            <div class="md:col-span-2">
              <label class="text-xs font-bold">Unit Kerja</label>
              <input type="text" name="unit_kerja" value="{{ old('unit_kerja', $anggota->unit_kerja) }}" class="focus:shadow-primary-outline text-sm leading-5.6 ease block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white p-2" />
            </div>
             {{-- Dropdown Tipe Anggota (Hanya untuk Admin) --}}
            <div class="md:col-span-2">
                <label for="tipe_anggota" class="text-xs font-bold">Tipe Anggota</label>
                @if(auth()->user()->level == 'admin')
                    <select name="tipe_anggota" class="focus:shadow-primary-outline text-sm leading-5.6 ease block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white p-2">
                        <option value="daerah" {{ old('tipe_anggota', $anggota->tipe_anggota) == 'daerah' ? 'selected' : '' }}>Daerah</option>
                        <option value="pusat" {{ old('tipe_anggota', $anggota->tipe_anggota) == 'pusat' ? 'selected' : '' }}>Pusat</option>
                    </select>
                    <p class="text-xs text-gray-500 mt-1">Hanya admin yang dapat mengubah tipe anggota.</p>
                @else
                    {{-- Jika bukan admin, tampilkan teks biasa --}}
                    <input type="text" value="{{ ucfirst($anggota->tipe_anggota) }}" class="focus:shadow-primary-outline text-sm leading-5.6 ease block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-gray-100 p-2" disabled readonly>
                    {{-- Sertakan input hidden agar nilainya tetap terkirim saat update --}}
                    <input type="hidden" name="tipe_anggota" value="{{ $anggota->tipe_anggota }}">
                @endif
            </div>

            <div class="md:col-span-2">
              <label class="text-xs font-bold">Ganti Pas Foto (Opsional)</label>
               @if($anggota->pas_foto)
                    <img src="{{ asset('storage/' . $anggota->pas_foto) }}" alt="Pas Foto" class="my-2 h-32 w-auto rounded">
               @endif
              <input type="file" name="pas_foto" class="focus:shadow-primary-outline text-sm leading-5.6 ease block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white p-2" />
            </div>
          </div>

          <div class="flex justify-end mt-6">
            <a href="{{ route('admin.anggota.show', $anggota->id) }}" class="px-8 py-2 mr-2 font-bold text-gray-700 bg-gray-200 rounded-lg text-xs">Batal</a>
            <button type="submit" class="inline-block px-8 py-2 font-bold text-center text-white bg-blue-500 border-0 rounded-lg text-xs">Simpan Perubahan</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection

