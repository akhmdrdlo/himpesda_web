@extends('layouts.admin')

@section('title', 'Manajemen Pendaftar')

@push('styles')
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.8/css/dataTables.tailwindcss.css">
@endpush

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

    {{-- =============================================== --}}
    {{-- BAGIAN 1: VERIFIKASI DATA (Admin / Operator Daerah) --}}
    {{-- =============================================== --}}
    @if(in_array(auth()->user()->level, ['admin','operator' , 'operator_daerah']))
    <div class="flex flex-wrap -mx-3">
        <div class="flex-none w-full max-w-full px-3">
            <div class="relative flex flex-col min-w-0 mb-6 break-words bg-white border-0 border-transparent border-solid shadow-xl rounded-2xl bg-clip-border">
                <div class="p-6 pb-0 mb-0 border-b-0 border-b-solid rounded-t-2xl border-b-transparent">
                    <h6>Daftar Pendaftar Baru (Menunggu Verifikasi Data) - {{ $menungguVerifikasiData }} orang</h6>
                    <p class="text-sm text-gray-500">Tinjau data pendaftar. Jika disetujui, pendaftar akan diminta untuk melakukan pembayaran.</p>
                </div>
                <div class="flex-auto p-4">
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm text-left text-gray-500 datatable-no-order">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3">Nama Pendaftar</th>
                                    <th scope="col" class="px-6 py-3">Asal Instansi/Provinsi</th>
                                    <th scope="col" class="px-6 py-3">Tanggal Daftar</th>
                                    <th scope="col" class="px-6 py-3">Pas Foto</th>
                                    <th scope="col" class="px-6 py-3 text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($pendaftarPending as $user)
                                <tr class="bg-white border-b hover:bg-gray-50">
                                    <td class="px-6 py-4 font-semibold text-gray-900">
                                        {{ $user->nama_lengkap }}
                                        <span class="block text-xs font-normal text-gray-500">{{ $user->email }}</span>
                                    </td>
                                    <td class="px-6 py-4 font-semibold text-gray-900">
                                        <span class="block text-xs font-normal text-gray-500">{{ $user->asal_instansi }}</span>
                                        {{ $user->provinsi }}
                                    </td>
                                    <td class="px-6 py-4">{{ $user->created_at->translatedFormat('d F Y') }}</td>
                                    <td class="px-6 py-4">
                                        <a href="{{ asset('storage/' . $user->pas_foto) }}" target="_blank" class="text-blue-600 hover:underline font-medium">
                                            Lihat Foto
                                        </a>
                                    </td>
                                    <td class="px-6 py-4 text-center whitespace-nowrap">
                                        <a href="{{ route('admin.anggota.show', $user->id) }}" class="inline-block px-4 py-2 text-xs font-bold text-center text-white uppercase align-middle transition-all bg-blue-500 border-0 rounded-lg shadow-md cursor-pointer hover:shadow-xs active:opacity-85">Detail</a>
                                        {{-- Tombol Setujui Data --}}
                                        <form action="{{ route('admin.verifikasi.approveData', $user->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Yakin ingin menyetujui data pendaftar ini?');">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="px-4 py-2 text-xs font-bold text-white bg-blue-500 rounded-lg shadow-md hover:bg-blue-600">
                                                Setujui Data
                                            </button>
                                        </form>
                                        {{-- Tombol Tolak Data (dengan modal) --}}
                                        <button 
                                            type="button" 
                                            onclick="openDataRejectModal({{ $user->id }}, '{{ $user->nama_lengkap }}')"
                                            class="px-4 py-2 ml-2 text-xs font-bold text-white bg-red-500 rounded-lg shadow-md hover:bg-red-600">
                                            Tolak Data
                                        </button>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="p-4 text-center text-slate-500">Tidak ada pendaftar baru yang menunggu verifikasi data.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
    
    {{-- =============================================== --}}
    {{-- BAGIAN 2: KONFIRMASI PEMBAYARAN (Admin / Bendahara) --}}
    {{-- =============================================== --}}
    @if(in_array(auth()->user()->level, ['admin', 'bendahara', 'bendahara_daerah']))
    <div class="flex flex-wrap -mx-3 mt-8">
        <div class="flex-none w-full max-w-full px-3">
            <div class="relative flex flex-col min-w-0 mb-6 break-words bg-white border-0 border-transparent border-solid shadow-xl rounded-2xl bg-clip-border">
                <div class="p-6 pb-0 mb-0 border-b-0 border-b-solid rounded-t-2xl border-b-transparent">
                    <h6>Daftar Konfirmasi Pembayaran (Menunggu Peninjauan) - {{ $menungguKonfirmasiBayar }} orang</h6>
                    <p class="text-sm text-gray-500">Tinjau bukti pembayaran. Jika disetujui, pendaftar akan menjadi anggota aktif.</p>
                </div>
                <div class="flex-auto p-4">
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm text-left text-gray-500 datatable-no-order">
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
                                        <a href="{{ route('admin.anggota.show', $item->user->id) }}" class="inline-block px-4 py-2 text-xs font-bold text-center text-white uppercase align-middle transition-all bg-blue-500 border-0 rounded-lg shadow-md cursor-pointer hover:shadow-xs active:opacity-85">Detail</a>
                                        <a href="{{ asset('storage/' . $item->file_bukti) }}" target="_blank" class="text-blue-600 hover:underline font-medium">
                                            Lihat Bukti
                                        </a>
                                    </td>
                                    <td class="px-6 py-4 text-center whitespace-nowrap">
                                        {{-- Tombol Setujui Bayar --}}
                                        <form action="{{ route('admin.verifikasi.approvePayment', $item->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Yakin ingin menyetujui pembayaran ini?');">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="px-4 py-2 text-xs font-bold text-white bg-green-500 rounded-lg shadow-md hover:bg-green-600">
                                                Setujui Bayar
                                            </button>
                                        </form>
                                        {{-- Tombol Tolak Bayar (dengan modal) --}}
                                        <button 
                                            type="button" 
                                            onclick="openPaymentRejectModal({{ $item->id }}, '{{ $item->user->nama_lengkap }}')"
                                            class="px-4 py-2 ml-2 text-xs font-bold text-white bg-red-500 rounded-lg shadow-md hover:bg-red-600">
                                            Tolak Bayar
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
    @endif

</div>

@push('modals')
{{-- Modal untuk Alasan Penolakan Data (Side Drawer) --}}
<div x-data="{ show: false, actionUrl: '', userName: '' }" 
     x-show="show" 
     x-on:open-data-reject-modal.window="show = true; actionUrl = $event.detail.action; userName = $event.detail.name" 
     x-on:keydown.escape.window="show = false"
     class="fixed inset-0 flex justify-end"
     style="z-index: 99999 !important; display: none;">
    
    {{-- Backdrop --}}
    <div x-show="show" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         @click="show = false" 
         class="fixed inset-0 bg-black/50 transition-opacity"></div>

    {{-- Drawer Panel --}}
    <div x-show="show"
         x-transition:enter="transform transition ease-in-out duration-300 sm:duration-500"
         x-transition:enter-start="translate-x-full"
         x-transition:enter-end="translate-x-0"
         x-transition:leave="transform transition ease-in-out duration-300 sm:duration-500"
         x-transition:leave-start="translate-x-0"
         x-transition:leave-end="translate-x-full"
         class="relative w-full max-w-sm bg-white shadow-2xl flex flex-col h-full pointer-events-auto">
        
        <div class="px-6 py-6 border-b border-gray-100 flex items-center justify-between bg-red-50">
            <h3 class="text-lg font-bold text-red-700">Tolak Permohonan</h3>
            <button @click="show = false" class="text-gray-400 hover:text-gray-500 focus:outline-none">
                <i class="fas fa-times"></i>
            </button>
        </div>

        <div class="p-6 flex-1 overflow-y-auto">
            <div class="mb-4 p-4 bg-red-50 rounded-lg border border-red-100">
                <p class="font-semibold text-sm text-red-800">Menolak Pendaftar:</p>
                <p class="text-lg font-bold text-gray-900" x-text="userName"></p>
            </div>
            
            <p class="text-sm text-gray-600 mb-6">
                Tindakan ini akan mengubah status pendaftar menjadi <span class="font-bold text-red-600">Ditolak</span>. 
                Mohon berikan alasan yang jelas agar pendaftar dapat memperbaiki datanya.
            </p>

            <form :action="actionUrl" method="POST" id="rejectDataForm">
                @csrf
                @method('PATCH')
                <div class="space-y-2">
                    <label for="catatan_penolakan_data" class="block text-sm font-bold text-gray-700">Alasan Penolakan <span class="text-red-500">*</span></label>
                    <textarea name="catatan_penolakan" id="catatan_penolakan_data" rows="6" 
                              class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500 sm:text-sm p-3" 
                              placeholder="Contoh: Foto tidak terlihat jelas, NIP tidak sesuai format, dll..." required></textarea>
                </div>
            </form>
        </div>

        <div class="px-6 py-4 bg-gray-50 border-t border-gray-100 flex justify-end gap-3">
             <button type="button" @click="show = false" class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 shadow-sm">
                Batal
            </button>
            <button type="submit" form="rejectDataForm" class="px-4 py-2 text-sm font-bold text-white bg-red-600 rounded-lg hover:bg-red-700 shadow-md">
                Tolak Data
            </button>
        </div>
    </div>
</div>

{{-- Modal untuk Alasan Penolakan Pembayaran (Side Drawer) --}}
<div x-data="{ show: false, actionUrl: '', userName: '' }" 
     x-show="show" 
     x-on:open-payment-reject-modal.window="show = true; actionUrl = $event.detail.action; userName = $event.detail.name" 
     x-on:keydown.escape.window="show = false"
     class="fixed inset-0 flex justify-end"
     style="z-index: 99999 !important; display: none;">

    {{-- Backdrop --}}
    <div x-show="show" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         @click="show = false" 
         class="fixed inset-0 bg-black/50 transition-opacity"></div>

    {{-- Drawer Panel --}}
    <div x-show="show"
         x-transition:enter="transform transition ease-in-out duration-300 sm:duration-500"
         x-transition:enter-start="translate-x-full"
         x-transition:enter-end="translate-x-0"
         x-transition:leave="transform transition ease-in-out duration-300 sm:duration-500"
         x-transition:leave-start="translate-x-0"
         x-transition:leave-end="translate-x-full"
         class="relative w-full max-w-sm bg-white shadow-2xl flex flex-col h-full pointer-events-auto">
        
        <div class="px-6 py-6 border-b border-gray-100 flex items-center justify-between bg-red-50">
            <h3 class="text-lg font-bold text-red-700">Tolak Pembayaran</h3>
             <button @click="show = false" class="text-gray-400 hover:text-gray-500 focus:outline-none">
                <i class="fas fa-times"></i>
            </button>
        </div>

        <div class="p-6 flex-1 overflow-y-auto">
            <div class="mb-4 p-4 bg-red-50 rounded-lg border border-red-100">
                <p class="font-semibold text-sm text-red-800">Menolak Pembayaran:</p>
                <p class="text-lg font-bold text-gray-900" x-text="userName"></p>
            </div>

            <p class="text-sm text-gray-600 mb-6">
                Status anggota akan dikembalikan ke <span class="font-bold text-orange-600">Menunggu Pembayaran</span> dan pendaftar akan diminta mengunggah ulang bukti bayar.
            </p>

            <form :action="actionUrl" method="POST" id="rejectPaymentForm">
                @csrf
                @method('PATCH')
                <div class="space-y-2">
                    <label for="catatan_penolakan_bayar" class="block text-sm font-bold text-gray-700">Alasan Penolakan <span class="text-red-500">*</span></label>
                    <textarea name="catatan_penolakan" id="catatan_penolakan_bayar" rows="6" 
                              class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500 sm:text-sm p-3" 
                              placeholder="Contoh: Bukti transfer buram, Nominal tidak sesuai, dll..." required></textarea>
                </div>
            </form>
        </div>

        <div class="px-6 py-4 bg-gray-50 border-t border-gray-100 flex justify-end gap-3">
            <button type="button" @click="show = false" class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 shadow-sm">
                Batal
            </button>
            <button type="submit" form="rejectPaymentForm" class="px-4 py-2 text-sm font-bold text-white bg-red-600 rounded-lg hover:bg-red-700 shadow-md">
                Tolak Pembayaran
            </button>
        </div>
    </div>
</div>
@endpush
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.datatables.net/2.0.8/js/dataTables.js"></script>
<script src="https://cdn.datatables.net/2.0.8/js/dataTables.tailwindcss.js"></script>
<script>
    $.fn.dataTable.ext.errMode = 'none';
    $(document).ready(function() {
        // Inisialisasi semua tabel dengan kelas .datatable-no-order
        $('.datatable-no-order').DataTable({
            language: {
                search: "_INPUT_",
                searchPlaceholder: "Cari anggota...",
                lengthMenu: "Tampilkan _MENU_ entri",
                info: "Dari _START_ sampai _END_ dari _TOTAL_ entri",
                infoEmpty: "Menampilkan 0 entri",
                infoFiltered: "(disaring dari _MAX_ total entri)",
                paginate: {
                    first: "Awal",
                    last: "Akhir",
                    next: "→",
                    previous: "←"
                }
            },
            "ordering": false // Mematikan sorting
        });
    });

    // Fungsi untuk modal penolakan data
    function openDataRejectModal(userId, userName) {
        const url = `{{ url('admin/verifikasi/reject-data') }}/${userId}`;
        window.dispatchEvent(new CustomEvent('open-data-reject-modal', { 
            detail: { action: url, name: userName } 
        }));
    }

    // Fungsi untuk modal penolakan pembayaran
    function openPaymentRejectModal(pembayaranId, userName) {
        const url = `{{ url('admin/verifikasi/reject-payment') }}/${pembayaranId}`;
        window.dispatchEvent(new CustomEvent('open-payment-reject-modal', { 
            detail: { action: url, name: userName } 
        }));
    }
</script>
@endpush