@extends('layouts.admin')

@section('title', 'Update Profil Saya')

@section('content')
<div class="w-full p-6 mx-auto">
    <div class="relative flex flex-col min-w-0 break-words bg-white border-0 shadow-xl rounded-2xl bg-clip-border">
      <div class="border-black/12.5 rounded-t-2xl border-b-0 border-solid p-6 pb-0">
        <h6 class="text-lg">Update Profil Saya</h6>
      </div>
      <div class="flex-auto p-6">
        <form action="{{ route('admin.profile.update') }}" method="POST">
          @csrf
          @method('PUT')
          <p class="leading-normal uppercase text-sm text-slate-500">Informasi Akun</p>
          <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
            <div>
              <label for="nama_lengkap" class="inline-block mb-2 ml-1 font-bold text-xs text-slate-700">Nama Lengkap</label>
              <input type="text" name="nama_lengkap" value="{{ old('nama_lengkap', auth()->user()->nama_lengkap) }}" class="focus:shadow-primary-outline text-sm leading-5.6 ease block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700" />
            </div>
            <div>
              <label for="email" class="inline-block mb-2 ml-1 font-bold text-xs text-slate-700">Email</label>
              <input type="email" name="email" value="{{ old('email', auth()->user()->email) }}" class="focus:shadow-primary-outline text-sm leading-5.6 ease block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700" />
            </div>
          </div>
          <hr class="h-px mx-0 my-4 bg-transparent border-0 opacity-25 bg-gradient-to-r from-transparent via-black/40 to-transparent" />
          <p class="leading-normal uppercase text-sm text-slate-500">Ganti Password (Opsional)</p>
           <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
             <div>
              <label for="password" class="inline-block mb-2 ml-1 font-bold text-xs text-slate-700">Password Baru</label>
              <input type="password" name="password" class="focus:shadow-primary-outline text-sm leading-5.6 ease block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700" />
            </div>
            <div>
              <label for="password_confirmation" class="inline-block mb-2 ml-1 font-bold text-xs text-slate-700">Konfirmasi Password Baru</label>
              <input type="password" name="password_confirmation" class="focus:shadow-primary-outline text-sm leading-5.6 ease block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700" />
            </div>
          </div>
           <div class="flex justify-end mt-6">
            <button type="submit" class="inline-block px-8 py-2 font-bold leading-normal text-center text-white align-middle transition-all ease-in bg-blue-500 border-0 rounded-lg shadow-md cursor-pointer text-xs hover:shadow-xs hover:-translate-y-px active:opacity-85">Simpan Perubahan</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection