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
                                    <th scope="col" class="px-6 py-3">Provinsi</th>
                                    <th scope="col" class="px-6 py-3">Asal Instansi</th>
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
                                    <td class="px-6 py-4">{{ $user->provinsi }}</td>
                                    <td class="px-6 py-4">{{ $user->asal_instansi }}</td>
                                    <td class="px-6 py-4">{{ $user->created_at->translatedFormat('d F Y') }}</td>
                                    <td class="px-6 py-4">
                                        <a href="{{ asset('storage/' . $user->pas_foto) }}" target="_blank" class="text-blue-600 hover:underline font-medium">
                                            Lihat Foto
                                        </a>
                                    </td>
                                    <td class="px-6 py-4 text-center whitespace-nowrap">
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

{{-- Modal untuk Alasan Penolakan Data --}}
<div x-data="{ show: false, actionUrl: '', userName: '' }" x-show="show" x-on:open-data-reject-modal.window="show = true; actionUrl = $event.detail.action; userName = $event.detail.name" x-on:keydown.escape.window="show = false" class="fixed inset-0 z-50 flex items-center justify-center p-4" style="display: none; background-color: rgba(0, 0, 0, 0.5);">
    <div @click.away="show = false" class="relative w-full max-w-md p-6 bg-white rounded-lg shadow-xl">
        <h3 class="text-lg font-medium text-gray-900">Tolak Pendaftar: <span x-text="userName"></span></h3>
        <p class="mt-1 text-sm text-gray-600">Anda harus memberikan alasan penolakan. Status anggota akan diubah menjadi "Ditolak".</p>
        <form :action="actionUrl" method="POST" class="mt-4">
            @csrf
            @method('PATCH')
            <div>
                <label for="catatan_penolakan_data" class="block text-sm font-medium text-gray-700">Alasan Penolakan Data</label>
                <textarea name="catatan_penolakan" id="catatan_penolakan_data" rows="3" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm sm:text-sm" placeholder="Contoh: Data NIP tidak valid, Pas Foto tidak sesuai." required></textarea>
            </div>
            <div class="mt-6 flex justify-end space-x-3">
                <button type="button" @click="show = false" class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-200 rounded-md hover:bg-gray-300">Batal</button>
                <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-red-600 rounded-md hover:bg-red-700">Tolak Pendaftar</button>
            </div>
        </form>
    </div>
</div>

{{-- Modal untuk Alasan Penolakan Pembayaran --}}
<div x-data="{ show: false, actionUrl: '', userName: '' }" x-show="show" x-on:open-payment-reject-modal.window="show = true; actionUrl = $event.detail.action; userName = $event.detail.name" x-on:keydown.escape.window="show = false" class="fixed inset-0 z-50 flex items-center justify-center p-4" style="display: none; background-color: rgba(0, 0, 0, 0.5);">
    <div @click.away="show = false" class="relative w-full max-w-md p-6 bg-white rounded-lg shadow-xl">
        <h3 class="text-lg font-medium text-gray-900">Tolak Pembayaran: <span x-text="userName"></span></h3>
        <p class="mt-1 text-sm text-gray-600">Anda harus memberikan alasan penolakan. Status anggota akan dikembalikan ke "Menunggu Pembayaran".</p>
        <form :action="actionUrl" method="POST" class="mt-4">
            @csrf
            @method('PATCH')
            <div>
                <label for="catatan_penolakan_bayar" class="block text-sm font-medium text-gray-700">Alasan Penolakan Pembayaran</label>
                <textarea name="catatan_penolakan" id="catatan_penolakan_bayar" rows="3" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm sm:text-sm" placeholder="Contoh: Bukti transfer tidak jelas/terpotong. Harap unggah ulang." required></textarea>
            </div>
            <div class="mt-6 flex justify-end space-x-3">
                <button type="button" @click="show = false" class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-200 rounded-md hover:bg-gray-300">Batal</button>
                <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-red-600 rounded-md hover:bg-red-700">Tolak Pembayaran</button>
            </div>
        </form>
    </div>
</div>
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
        const url = `{{ url('admin/verifikasi-anggota/reject-data') }}/${userId}`;
        window.dispatchEvent(new CustomEvent('open-data-reject-modal', { 
            detail: { action: url, name: userName } 
        }));
    }

    // Fungsi untuk modal penolakan pembayaran
    function openPaymentRejectModal(pembayaranId, userName) {
        const url = `{{ url('admin/verifikasi-anggota/reject-payment') }}/${pembayaranId}`;
        window.dispatchEvent(new CustomEvent('open-payment-reject-modal', { 
            detail: { action: url, name: userName } 
        }));
    }
</script>
@endpush