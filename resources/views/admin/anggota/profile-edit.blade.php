@extends('layouts.admin')

@section('title', 'Perbarui Profil Saya')

@section('content')
<div class="w-full p-6 mx-auto">
    <div class="relative flex flex-col min-w-0 break-words bg-white border-0 shadow-xl rounded-2xl bg-clip-border">
      <div class="p-6 pb-0 border-b border-gray-100">
        <h6 class="text-lg font-bold">Update Profil: {{ auth()->user()->nama_lengkap }}</h6>
        @if(auth()->user()->status_pengajuan == 'rejected')
            <div class="mt-2 text-sm text-red-600 bg-red-50 p-2 rounded border border-red-200">
                <strong>Catatan Penolakan:</strong> {{ auth()->user()->catatan_admin }}
            </div>
        @endif
      </div>
      <div class="flex-auto p-6">
        @if(session('success'))
            <div class="px-6 py-3 mb-4 text-sm text-green-800 bg-green-100 rounded-lg">
                {{ session('success') }}
            </div>
        @endif
        @if ($errors->any())
            <div class="p-4 mb-4 text-sm text-red-800 bg-red-100 rounded-lg">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.profile.update') }}" method="POST" enctype="multipart/form-data">
          @csrf
          @method('PUT')

          <p class="text-sm font-bold uppercase text-slate-500 mb-4">Informasi Pribadi</p>
          <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
            <div>
              <label class="text-xs font-bold text-slate-700 uppercase">Nama Lengkap</label>
              <input type="text" name="nama_lengkap" value="{{ old('nama_lengkap', auth()->user()->nama_lengkap) }}" class="focus:shadow-primary-outline text-sm leading-5.6 ease block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white p-2" required />
            </div>
            <div>
              <label class="text-xs font-bold text-slate-700 uppercase">Email</label>
              <input type="email" name="email" value="{{ old('email', auth()->user()->email) }}" class="focus:shadow-primary-outline text-sm leading-5.6 ease block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white p-2" required />
            </div>
            <div>
              <label class="text-xs font-bold text-slate-700 uppercase">No. Telepon</label>
              <input type="text" name="no_telp" value="{{ old('no_telp', auth()->user()->no_telp) }}" class="focus:shadow-primary-outline text-sm leading-5.6 ease block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white p-2" />
            </div>
            <div>
              <label class="text-xs font-bold text-slate-700 uppercase">Jenis Kelamin</label>
              <select name="jenis_kelamin" class="focus:shadow-primary-outline text-sm leading-5.6 ease block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white p-2">
                  <option value="" {{ old('jenis_kelamin', auth()->user()->jenis_kelamin) == '' ? 'selected' : '' }}>-- Pilih --</option>
                  <option value="Laki-laki" {{ old('jenis_kelamin', auth()->user()->jenis_kelamin) == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                  <option value="Perempuan" {{ old('jenis_kelamin', auth()->user()->jenis_kelamin) == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
              </select>
            </div>
            <div>
              <label class="text-xs font-bold text-slate-700 uppercase">Tanggal Lahir</label>
              <input type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir', auth()->user()->tanggal_lahir) }}" class="focus:shadow-primary-outline text-sm leading-5.6 ease block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white p-2" />
            </div>
            <div>
              <label class="text-xs font-bold text-slate-700 uppercase">Agama</label>
              <input type="text" name="agama" value="{{ old('agama', auth()->user()->agama) }}" class="focus:shadow-primary-outline text-sm leading-5.6 ease block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white p-2" />
            </div>
            <div>
                <label class="text-xs font-bold text-slate-700 uppercase">Provinsi</label>
                <input type="text" name="provinsi" value="{{ old('provinsi', auth()->user()->provinsi) }}" class="focus:shadow-primary-outline text-sm leading-5.6 ease block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white p-2" />
            </div>
            <div>
                <label class="text-xs font-bold text-slate-700 uppercase">Kabupaten/Kota</label>
                <input type="text" name="kabupaten_kota" value="{{ old('kabupaten_kota', auth()->user()->kabupaten_kota) }}" class="focus:shadow-primary-outline text-sm leading-5.6 ease block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white p-2" />
            </div>
          </div>

          <hr class="h-px mx-0 my-6 bg-transparent border-0 opacity-25 bg-gradient-to-r from-transparent via-black/40 to-transparent" />
          
          <p class="text-sm font-bold uppercase text-slate-500 mb-4">Informasi Kepegawaian & Keanggotaan</p>
          <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
            <div>
              <label class="text-xs font-bold text-slate-700 uppercase">NIP</label>
              <input type="text" name="nip" value="{{ old('nip', auth()->user()->nip) }}" class="focus:shadow-primary-outline text-sm leading-5.6 ease block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white p-2" />
            </div>
            <div>
              <label class="text-xs font-bold text-slate-700 uppercase">NPWP</label>
              <input type="text" name="npwp" value="{{ old('npwp', auth()->user()->npwp) }}" class="focus:shadow-primary-outline text-sm leading-5.6 ease block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white p-2" />
            </div>
            <div>
              <label class="text-xs font-bold text-slate-700 uppercase">Golongan/Ruang</label>
              <input type="text" name="gol_ruang" value="{{ old('gol_ruang', auth()->user()->gol_ruang) }}" class="focus:shadow-primary-outline text-sm leading-5.6 ease block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white p-2" />
            </div>
            <div>
              <label class="text-xs font-bold text-slate-700 uppercase">Jabatan Fungsional</label>
              <input type="text" name="jabatan_fungsional" value="{{ old('jabatan_fungsional', auth()->user()->jabatan_fungsional) }}" class="focus:shadow-primary-outline text-sm leading-5.6 ease block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white p-2" />
            </div>
            <div class="md:col-span-2">
              <label class="text-xs font-bold text-slate-700 uppercase">Asal Instansi</label>
              <input type="text" name="asal_instansi" value="{{ old('asal_instansi', auth()->user()->asal_instansi) }}" class="focus:shadow-primary-outline text-sm leading-5.6 ease block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white p-2" />
            </div>
            <div class="md:col-span-2">
              <label class="text-xs font-bold text-slate-700 uppercase">Unit Kerja</label>
              <input type="text" name="unit_kerja" value="{{ old('unit_kerja', auth()->user()->unit_kerja) }}" class="focus:shadow-primary-outline text-sm leading-5.6 ease block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white p-2" />
            </div>
          </div>
        
          <hr class="h-px mx-0 my-6 bg-transparent border-0 opacity-25 bg-gradient-to-r from-transparent via-black/40 to-transparent" />

          <p class="text-sm font-bold uppercase text-slate-500 mb-4">Berkas & Keamanan</p>
          <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
             <div class="md:col-span-2">
                <label class="text-xs font-bold text-slate-700 uppercase mb-2 block">Foto Profil (Pas Foto)</label>
                @if(auth()->user()->pas_foto)
                    <div class="mb-2">
                        <img src="{{ asset('storage/' . auth()->user()->pas_foto) }}" alt="Pas Foto" class="h-24 w-24 object-cover rounded shadow-sm border">
                    </div>
                @endif
                <input type="file" name="pas_foto" class="focus:shadow-primary-outline text-sm leading-5.6 ease block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white p-2" />
                <p class="text-[10px] text-gray-500 mt-1">Format: JPG, JPEG, PNG. Maks: 2MB.</p>
            </div>

            {{-- 
                INPUT PEMBAYARAN: HANYA MUNCUL JIKA STATUS 'pending_payment' (awaiting_payment) atau 'rejected' 
                Disinilah tempat user mengoreksi pembayaran jika ditolak, atau upload jika baru disetujui datanya.
            --}}
            @if(in_array(auth()->user()->status_pengajuan, ['awaiting_payment', 'payment_review']))
             <div class="md:col-span-2 bg-blue-50 p-4 rounded-lg border border-blue-200">
                <label class="text-xs font-bold text-blue-800 uppercase mb-2 block">
                    <i class="fas fa-receipt mr-1"></i> Bukti Pembayaran
                </label>
                <p class="text-xs text-blue-600 mb-2">Unggah bukti pembayaran Anda di sini untuk diproses oleh Bendahara.</p>
                
                <input type="file" name="file_bukti" class="focus:shadow-primary-outline text-sm leading-5.6 ease block w-full appearance-none rounded-lg border border-solid border-blue-300 bg-white p-2" />
                <p class="text-[10px] text-gray-500 mt-1">Format: PDF, JPG, PNG.</p>
            </div>
            @endif

            <div class="md:col-span-2">
                <label class="text-xs font-bold text-slate-700 uppercase">Ganti Password (Opsional)</label>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-1">
                    <input type="password" name="password" placeholder="Password Baru" class="focus:shadow-primary-outline text-sm leading-5.6 ease block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white p-2" />
                    <input type="password" name="password_confirmation" placeholder="Konfirmasi Password" class="focus:shadow-primary-outline text-sm leading-5.6 ease block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white p-2" />
                 </div>
            </div>
          </div>

          <div class="flex justify-end mt-8">
            <a href="{{ route('admin.dashboard') }}" class="px-6 py-2.5 mr-3 font-bold text-gray-700 bg-white border border-gray-300 rounded-lg text-xs hover:bg-gray-50 transition-all">Batal</a>
            <button type="submit" class="inline-block px-6 py-2.5 font-bold text-center text-white bg-blue-600 border-0 rounded-lg text-xs hover:bg-blue-700 shadow-md transition-all">
                Simpan & Perbarui Profil
            </button>
          </div>
        </form>
      </div>
    </div>
</div>
@endsection