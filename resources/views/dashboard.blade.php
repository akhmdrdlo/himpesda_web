{{-- 
Ini adalah halaman yang dilihat Anggota setelah login.
Ini adalah Fase 3.3 (Tracer Pendaftaran)
--}}
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Tracer Pendaftaran Anggota') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-2xl font-bold mb-4">Selamat Datang, {{ Auth::user()->nama_lengkap }}!</h3>

                    @if(session('success'))
                        <div class="mb-4 p-4 text-sm text-green-700 bg-green-100 rounded-lg" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif
                    
                    @if ($errors->any())
                        <div class="mb-4 p-4 text-sm text-red-700 bg-red-100 rounded-lg" role="alert">
                            <strong>Oops!</strong> Terjadi kesalahan pada input Anda.
                            <ul class="mt-2 list-disc list-inside">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    {{-- ====================================================== --}}
                    {{-- LOGIKA TRACER PENDAFTARAN --}}
                    {{-- ====================================================== --}}

                    {{-- 1. Status: Baru Mendaftar (Menunggu Verifikasi Data Diri) --}}
                    @if(Auth::user()->status_pengajuan == 'pending')
                        <div class="p-6 border-l-4 border-yellow-500 bg-yellow-50">
                            <h4 class="font-bold text-lg">Status: Menunggu Verifikasi Admin</h4>
                            <p class="mt-2">Data pendaftaran Anda telah kami terima dan sedang ditinjau oleh tim admin (Operator Daerah). Harap tunggu 1x24 jam untuk proses verifikasi data.</p>
                        </div>

                    {{-- 2. Status: Disetujui (Menunggu Pembayaran) --}}
                    @elseif(Auth::user()->status_pengajuan == 'awaiting_payment')
                        <div class="p-6 border-l-4 border-blue-500 bg-blue-50">
                            <h4 class="font-bold text-lg">Status: Menunggu Pembayaran</h4>
                            <p class="mt-2">Pendaftaran Anda telah disetujui. Silakan lakukan pembayaran iuran keanggotaan dan unggah bukti pembayaran di bawah ini untuk mengaktifkan akun Anda.</p>
                            
                            <div class="mt-4 p-4 bg-gray-100 rounded-md">
                                <p class="font-semibold">Silakan transfer ke rekening:</p>
                                <p>Bank ABC - 1234567890 a.n. Bendahara HIMPESDA</p>
                                <p>Jumlah: Rp 100.000,-</p>
                            </div>

                            <form action="{{ route('anggota.pembayaran.store') }}" method="POST" enctype="multipart/form-data" class="mt-6">
                                @csrf
                                <div>
                                    <label for="file_bukti" class="block text-sm font-medium text-gray-700">Unggah Bukti Pembayaran (PDF, JPG, PNG - Maks 2MB)</label>
                                    <input type="file" name="file_bukti" id="file_bukti" class="mt-1 block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none" required>
                                </div>
                                <div class="mt-4">
                                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700">
                                        Kirim Bukti
                                    </button>
                                </div>
                            </form>
                        </div>

                    {{-- 3. Status: Sudah Bayar (Menunggu Konfirmasi Bendahara) --}}
                    @elseif(Auth::user()->status_pengajuan == 'payment_review')
                        <div class="p-6 border-l-4 border-cyan-500 bg-cyan-50">
                            <h4 class="font-bold text-lg">Status: Peninjauan Bukti Pembayaran</h4>
                            <p class="mt-2">Bukti pembayaran Anda telah kami terima dan sedang ditinjau oleh Bendahara. Akun Anda akan segera diaktifkan setelah pembayaran terkonfirmasi.</p>
                        </div>

                    {{-- 4. Status: Selesai (Aktif) --}}
                    @elseif(Auth::user()->status_pengajuan == 'active')
                        <div class="p-6 border-l-4 border-green-500 bg-green-50">
                            <h4 class="font-bold text-lg text-green-700">Status: Aktif</h4>
                            <p class="mt-2">Selamat! Akun Anda telah aktif. Anda sekarang adalah anggota resmi HIMPESDA.</p>
                            <p class="mt-4 font-semibold">Nomor KTA Anda:</p>
                            <p class="text-3xl font-bold text-gray-800 tracking-wider">{{ Auth::user()->nomor_anggota }}</p>
                            <p class="mt-1 text-sm text-gray-500">Diaktifkan pada: {{ Auth::user()->activated_at->translatedFormat('d F Y') }}</p>
                        </div>
                    
                    {{-- 5. Status: Ditolak (Data Diri Tidak Valid) --}}
                    @elseif(Auth::user()->status_pengajuan == 'rejected')
                        <div class="p-6 border-l-4 border-red-500 bg-red-50">
                            <h4 class="font-bold text-lg text-red-700">Status: Ditolak</h4>
                            <p class="mt-2">Mohon maaf, pengajuan Anda ditolak oleh admin.</p>
                        </div>
                    @endif
                    
                </div>
            </div>
        </div>
    </div>
</x-app-layout>