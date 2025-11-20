@extends('layouts.admin')

@section('title', 'Konfirmasi Pembayaran Anggota')

@section('content')
<div class="w-full px-6 py-6 mx-auto">
    
    @if(session('success'))
    <div class="relative p-4 pr-12 mb-4 text-white border border-solid rounded-lg bg-gradient-to-tl from-emerald-500 to-teal-400">
        {{ session('success') }}
    </div>
    @endif
    @if ($errors->any())
        <div class="relative p-4 pr-12 mb-4 text-white border border-solid rounded-lg bg-gradient-to-tl from-red-500 to-pink-400">
            <strong>Oops!</strong> Terjadi kesalahan:
            <ul class="mt-2 list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Statistik Box --}}
    <div class="flex flex-wrap -mx-3">
        <div class="w-full max-w-full px-3 mb-6 sm:w-1/2 sm:flex-none">
            <div class="relative flex flex-col min-w-0 break-words bg-white shadow-xl rounded-2xl bg-clip-border">
                <div class="flex-auto p-4">
                    <div class="flex flex-row -mx-3">
                        <div class="flex-none w-2/3 max-w-full px-3">
                            <div>
                                <p class="mb-0 font-sans text-sm font-semibold leading-normal uppercase">Menunggu Konfirmasi</p>
                                <h5 class="mb-2 font-bold">{{ $menungguKonfirmasi }}</h5>
                            </div>
                        </div>
                        <div class="px-3 text-right basis-1/3">
                            <div class="inline-block w-12 h-12 text-center rounded-circle bg-gradient-to-tl from-orange-500 to-yellow-500">
                                <i class="ni leading-none ni-time-alarm text-lg relative top-3.5 text-white"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="w-full max-w-full px-3 mb-6 sm:w-1/2 sm:flex-none">
            <div class="relative flex flex-col min-w-0 break-words bg-white shadow-xl rounded-2xl bg-clip-border">
                <div class="flex-auto p-4">
                    <div class="flex flex-row -mx-3">
                        <div class="flex-none w-2/3 max-w-full px-3">
                            <div>
                                <p class="mb-0 font-sans text-sm font-semibold leading-normal uppercase">Anggota Aktif</p>
                                <h5 class="mb-2 font-bold">{{ $anggotaTerdaftar }}</h5>
                            </div>
                        </div>
                        <div class="px-3 text-right basis-1/3">
                            <div class="inline-block w-12 h-12 text-center rounded-circle bg-gradient-to-tl from-emerald-500 to-teal-400">
                                <i class="ni leading-none ni-check-bold text-lg relative top-3.5 text-white"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Tabel Konfirmasi --}}
    <div class="flex flex-wrap -mx-3">
        <div class="flex-none w-full max-w-full px-3">
            <div class="relative flex flex-col min-w-0 mb-6 break-words bg-white border-0 border-transparent border-solid shadow-xl rounded-2xl bg-clip-border">
                <div class="p-6 pb-0 mb-0 border-b-0 border-b-solid rounded-t-2xl border-b-transparent">
                    <h6>Daftar Konfirmasi Pembayaran (Pending)</h6>
                    <p class="text-sm text-gray-500">Tinjau dan konfirmasi bukti pembayaran yang dikirim oleh calon anggota.</p>
                </div>
                <div class="flex-auto p-4">
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm text-left text-gray-500">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3">Nama Calon Anggota</th>
                                    <th scope="col" class="px-6 py-3">Email</th>
                                    <th scope="col" class="px-6 py-3">Tanggal Unggah</th>
                                    <th scope="col" class="px-6 py-3">Bukti Bayar</th>
                                    <th scope="col" class="px-6 py-3 text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($pembayaranPending as $item)
                                <tr class="bg-white border-b hover:bg-gray-50">
                                    <td class="px-6 py-4 font-semibold text-gray-900">{{ $item->user->nama_lengkap }}</td>
                                    <td class="px-6 py-4">{{ $item->user->email }}</td>
                                    <td class="px-6 py-4">{{ $item->created_at->translatedFormat('d F Y, H:i') }}</td>
                                    <td class="px-6 py-4">
                                        <a href="{{ asset('storage/' . $item->file_bukti) }}" target="_blank" class="text-blue-600 hover:underline font-medium">
                                            Lihat Bukti
                                        </a>
                                    </td>
                                    <td class="px-6 py-4 text-center whitespace-nowrap">
                                        {{-- Tombol Setujui --}}
                                        <form action="{{ route('admin.konfirmasi.approve', $item->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Yakin ingin menyetujui pembayaran ini?');">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="px-4 py-2 text-xs font-bold text-white bg-green-500 rounded-lg shadow-md hover:bg-green-600">
                                                Setujui
                                            </button>
                                        </form>

                                        {{-- Tombol Tolak (dengan modal) --}}
                                        <button 
                                            type="button" 
                                            onclick="openRejectModal({{ $item->id }}, '{{ $item->user->nama_lengkap }}')"
                                            class="px-4 py-2 ml-2 text-xs font-bold text-white bg-red-500 rounded-lg shadow-md hover:bg-red-600">
                                            Tolak
                                        </button>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="p-4 text-center text-slate-500">Tidak ada bukti pembayaran yang menunggu konfirmasi.</td>
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

{{-- Modal untuk Alasan Penolakan --}}
<div 
    x-data="{ 
        show: false, 
        actionUrl: '', 
        userName: '' 
    }"
    x-show="show" 
    x-on:open-reject-modal.window="show = true; actionUrl = $event.detail.action; userName = $event.detail.name"
    x-on:keydown.escape.window="show = false"
    class="fixed inset-0 z-50 flex items-center justify-center p-4" 
    style="display: none; background-color: rgba(0, 0, 0, 0.5);"
>
    <div 
        @click.away="show = false" 
        class="relative w-full max-w-md p-6 bg-white rounded-lg shadow-xl"
    >
        <h3 class="text-lg font-medium text-gray-900">Tolak Pembayaran: <span x-text="userName"></span></h3>
        <p class="mt-1 text-sm text-gray-600">Anda harus memberikan alasan penolakan. Status anggota akan dikembalikan ke "Menunggu Pembayaran".</p>
        
        <form :action="actionUrl" method="POST" class="mt-4">
            @csrf
            @method('PATCH')
            
            <div>
                <label for="catatan_penolakan" class="block text-sm font-medium text-gray-700">Alasan Penolakan</label>
                <textarea 
                    name="catatan_penolakan" 
                    id="catatan_penolakan" 
                    rows="3" 
                    class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm" 
                    placeholder="Contoh: Bukti transfer tidak jelas/terpotong. Harap unggah ulang." 
                    required></textarea>
            </div>

            <div class="mt-6 flex justify-end space-x-3">
                <button 
                    type="button" 
                    @click="show = false" 
                    class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-200 rounded-md hover:bg-gray-300">
                    Batal
                </button>
                <button 
                    type="submit" 
                    class="px-4 py-2 text-sm font-medium text-white bg-red-600 rounded-md hover:bg-red-700">
                    Tolak Pembayaran
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
    {{-- Pastikan Alpine.js dimuat jika belum ada di layout admin --}}
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>
    <script>
        // Fungsi untuk membuka modal penolakan
        function openRejectModal(pembayaranId, userName) {
            const url = `{{ url('admin/konfirmasi/reject') }}/${pembayaranId}`;
            window.dispatchEvent(new CustomEvent('open-reject-modal', { 
                detail: { 
                    action: url,
                    name: userName 
                } 
            }));
        }
    </script>
@endpush