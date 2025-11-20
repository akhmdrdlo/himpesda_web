@extends('layouts.admin')

@section('title', 'Tracing & Monitoring Pembayaran')

@push('styles')
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.8/css/dataTables.tailwindcss.css">
@endpush

@section('content')
<div class="w-full px-6 py-6 mx-auto">
    
    <div class="flex flex-wrap -mx-3">
        <div class="flex-none w-full max-w-full px-3">
            <div class="relative flex flex-col min-w-0 mb-6 break-words bg-white border-0 border-transparent border-solid shadow-xl rounded-2xl bg-clip-border">
                <div class="p-6 pb-0 mb-0 border-b-0 border-b-solid rounded-t-2xl border-b-transparent">
                    <h6 class="font-bold text-slate-700">
                        <i class="fas fa-history mr-2"></i>Tracing Pembayaran Anggota
                    </h6>
                    <p class="text-sm text-gray-500">
                        Monitoring seluruh status pembayaran 
                        @if(str_contains(auth()->user()->level, 'daerah'))
                            (Wilayah: {{ auth()->user()->provinsi }})
                        @else
                            (Nasional)
                        @endif
                    </p>
                </div>
                <div class="flex-auto p-4">
                    <div class="overflow-x-auto">
                        <table id="tracing-table" class="w-full text-sm text-left text-gray-500">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3">Tanggal</th>
                                    <th class="px-6 py-3">Anggota</th>
                                    <th class="px-6 py-3">Wilayah</th>
                                    <th class="px-6 py-3">Bukti</th>
                                    <th class="px-6 py-3">Status</th>
                                    <th class="px-6 py-3">Catatan Admin</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($riwayatPembayaran as $item)
                                <tr class="bg-white border-b hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        {{ $item->created_at->translatedFormat('d M Y, H:i') }}
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="block font-semibold text-slate-700">{{ $item->user->nama_lengkap }}</span>
                                        <span class="text-xs">{{ $item->user->email }}</span>
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ $item->user->provinsi ?? '-' }}
                                    </td>
                                    <td class="px-6 py-4">
                                        <a href="{{ asset('storage/' . $item->file_bukti) }}" target="_blank" class="text-blue-500 hover:text-blue-700 font-bold text-xs border border-blue-500 px-2 py-1 rounded">
                                            Lihat File
                                        </a>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        @if($item->status == 'approved')
                                            <span class="bg-green-100 text-green-800 text-xs font-bold px-2.5 py-0.5 rounded border border-green-400">LUNAS</span>
                                        @elseif($item->status == 'rejected')
                                            <span class="bg-red-100 text-red-800 text-xs font-bold px-2.5 py-0.5 rounded border border-red-400">DITOLAK</span>
                                        @else
                                            <span class="bg-yellow-100 text-yellow-800 text-xs font-bold px-2.5 py-0.5 rounded border border-yellow-400">PENDING</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-xs italic text-gray-500">
                                        {{ $item->catatan_admin ?? '-' }}
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="p-4 text-center text-gray-500">Belum ada data riwayat pembayaran.</td>
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
@endsection

@push('scripts')
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.datatables.net/2.0.8/js/dataTables.js"></script>
<script src="https://cdn.datatables.net/2.0.8/js/dataTables.tailwindcss.js"></script>
<script>
    $.fn.dataTable.ext.errMode = 'none';
    $(document).ready(function() {
        $('#tracing-table').DataTable({
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
</script>
@endpush