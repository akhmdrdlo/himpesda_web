@extends('layouts.admin')

@section('title', 'Daftar Anggota')

@push('styles')
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.8/css/dataTables.tailwindcss.css">
@endpush


@section('content')
@if(session('success'))
<div class="w-full px-6 pt-6 mx-auto">
    <div class="relative p-4 pr-12 mb-4 text-white border border-solid rounded-lg bg-gradient-to-tl from-emerald-500 to-teal-400 border-emerald-300" role="alert">
        <span class="font-bold">Sukses!</span>
        <span class="block sm:inline">{{ session('success') }}</span>
        <button type="button" class="absolute top-0 bottom-0 right-0 px-4 py-3" data-alert-close="true">
            <span class="text-2xl" aria-hidden="true">×</span>
        </button>
    </div>
</div>
@endif
<div class="w-full px-6 py-6 mx-auto">
    <div class="flex flex-wrap -mx-3">
        <div class="flex-none w-full max-w-full px-3">
            <div class="relative flex flex-col min-w-0 mb-6 break-words bg-white border-0 border-transparent border-solid shadow-xl rounded-2xl bg-clip-border">
                <div class="p-6 pb-0 mb-0 border-b-0 border-b-solid rounded-t-2xl border-b-transparent flex flex-wrap justify-between items-center gap-4">
                    <h6>Tabel Daftar Anggota</h6>
                    @if(in_array(auth()->user()->level, ['admin', 'operator']))
                    <div class="space-x-2">
                        <a href="{{ route('admin.anggota.import.form') }}" class="inline-block px-4 py-2 text-xs font-bold text-center text-white uppercase align-middle transition-all bg-blue-500 border-0 rounded-lg shadow-md cursor-pointer hover:shadow-xs active:opacity-85">Import Excel</a>
                        <a href="{{ route('admin.anggota.ekspor-kartu') }}" target="_blank" class="inline-block px-4 py-2 text-xs font-bold text-center text-black uppercase align-middle transition-all  border-0 rounded-lg shadow-md cursor-pointer hover:shadow-xs active:opacity-85">Ekspor Kartu</a>
                    </div>
                    @endif
                </div>
                <div class="flex-auto px-4 pt-0 pb-2">
                    <div class="p-4 overflow-x-auto">
                        <table id="anggota-table" class="w-full text-sm text-left text-gray-500">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3">Anggota</th>
                                    <th scope="col" class="px-6 py-3">Jabatan Fungsional</th>
                                    <th scope="col" class="px-6 py-3">Tanggal Bergabung</th>
                                    <th scope="col" class="px-6 py-3 text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($anggota as $item)
                                <tr class="bg-white border-b hover:bg-gray-50">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center">
                                            @if ($item->pas_foto)
                                                <div>
                                                    <img src="{{ asset('storage/' . $item->pas_foto) }}" class="h-9 w-9 rounded-xl" alt="anggota"/>
                                                </div>
                                            @else
                                                <div>
                                                    <img src="{{ asset('assets/img/team-2.jpg') }}" class="h-9 w-9 rounded-xl" alt="anggota"/>
                                                </div>
                                            @endif
                                            <div class="pl-3">
                                                <div class="text-base font-semibold text-slate-700">{{ $item->nama_lengkap }}</div>
                                                <div class="font-normal text-slate-500">{{ $item->email }}</div>
                                            </div>  
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">{{ $item->jabatan_fungsional ?? '-' }}</td>
                                    <td class="px-6 py-4 text-center">{{ $item->created_at->format('d/m/Y') }}</td>
                                    <td class="px-6 py-4 text-center">
                                        <a href="{{ route('admin.anggota.show', $item->id) }}" class="inline-block px-4 py-2 text-xs font-bold text-center text-white uppercase align-middle transition-all bg-blue-500 border-0 rounded-lg shadow-md cursor-pointer hover:shadow-xs active:opacity-85">Detail</a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="p-4 text-center">Belum ada data anggota yang terdaftar.</td>
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
<script src="https://code.jquery.com/jquery-3.7.1.js"></script>
<script src="https://cdn.datatables.net/2.0.8/js/dataTables.js"></script>
<script src="https://cdn.datatables.net/2.0.8/js/dataTables.tailwindcss.js"></script>
<script>
    $(document).ready(function() {
        
        // Inisialisasi DataTables dengan layout yang diperbaiki
        $('#anggota-table').DataTable({
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
            }
        });

        const tableContainer = $('#table-container');
        const formContainer = $('#import-form-container');
        const toggleBtn = $('#toggle-import-btn');
        const cancelBtn = $('#cancel-import-btn');
        const cardTitle = $('#card-title');

        toggleBtn.on('click', function() {
            // Sembunyikan tabel, tampilkan form
            tableContainer.addClass('hidden');
            formContainer.removeClass('hidden');
            // Ubah teks tombol dan judul
            toggleBtn.text('Lihat Tabel');
            cardTitle.text('Formulir Import Data Anggota');
        });

        cancelBtn.on('click', function() {
            // Sembunyikan form, tampilkan tabel
            formContainer.addClass('hidden');
            tableContainer.removeClass('hidden');
            // Kembalikan teks tombol dan judul
            toggleBtn.text('Import Excel');
            cardTitle.text('Tabel Daftar Anggota');
        });

        // Jika tombol 'Lihat Tabel' diklik saat form tampil
        toggleBtn.on('click', function() {
            if (!tableContainer.hasClass('hidden')) {
                // Jika tabel sedang tampil, klik tombol akan menyembunyikan tabel dan menampilkan form
                tableContainer.addClass('hidden');
                formContainer.removeClass('hidden');
                toggleBtn.text('Lihat Tabel');
                cardTitle.text('Formulir Import Data Anggota');
            } else {
                // Jika form sedang tampil, klik tombol akan menyembunyikan form dan menampilkan tabel
                formContainer.addClass('hidden');
                tableContainer.removeClass('hidden');
                toggleBtn.text('Import Excel');
                cardTitle.text('Tabel Daftar Anggota');
            }
        });

    });
</script>
@endpush