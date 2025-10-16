@extends('layouts.admin')

@section('title', 'Manajemen Berita')

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
    
    <div class="flex flex-wrap -mx-3">
        <div class="flex-none w-full max-w-full px-3">
            <div class="relative flex flex-col min-w-0 mb-6 break-words bg-white border-0 border-transparent border-solid shadow-xl rounded-2xl bg-clip-border">
                <div class="p-6 pb-0 mb-0 border-b-0 border-b-solid rounded-t-2xl border-b-transparent flex justify-between items-center">
                    <h6>Tabel Berita</h6>
                    {{-- [MODIFIED] Tombol-tombol aksi ditambahkan di sini --}}
                    <div class="flex space-x-2">
                        <a href="{{ route('admin.categories.index') }}" class="inline-block px-4 py-2 text-xs font-bold text-center text-white uppercase align-middle transition-all bg-slate-500 border-0 rounded-lg shadow-md hover:shadow-lg hover:bg-slate-600">Kelola Kategori</a>
                        <a href="{{ route('admin.berita.create') }}" class="inline-block px-4 py-2 text-xs font-bold text-center text-white uppercase align-middle transition-all bg-blue-500 border-0 rounded-lg shadow-md hover:shadow-lg hover:bg-blue-600">Tambah Berita Baru</a>
                    </div>
                </div>
                <div class="flex-auto pt-0 pb-2">
                    <div class="p-4 overflow-x-auto">
                        <table id="berita-table" class="w-full text-sm text-left text-gray-500">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3">Judul Berita</th>
                                    <th scope="col" class="px-6 py-3">Kategori</th>
                                    <th scope="col" class="px-6 py-3">Penulis</th>
                                    <th scope="col" class="px-6 py-3">Tanggal</th>
                                    <th scope="col" class="px-6 py-3 text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($berita as $item)
                                <tr class="bg-white border-b hover:bg-gray-50">
                                    <td class="px-6 py-4 font-semibold text-gray-900">{{ Str::limit($item->judul, 40) }}</td>
                                    <td class="px-6 py-4">{{ $item->category->name ?? 'N/A' }}</td> 
                                    <td class="px-6 py-4">{{ $item->user->nama_lengkap ?? 'N/A' }}</td>
                                    <td class="px-6 py-4">{{ $item->published_at->translatedFormat('d F Y') }}</td>
                                    <td class="px-6 py-4 text-center whitespace-nowrap">
                                        <a href="{{ route('admin.berita.show', $item->id) }}" class="px-4 py-2 mr-2 text-xs font-bold text-white bg-slate-700 rounded-lg">Edit</a>
                                        <form action="{{ route('admin.berita.destroy', $item->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Yakin ingin menghapus berita ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="px-4 py-2 text-xs font-bold text-white bg-gradient-to-tl from-red-600 to-orange-600 rounded-lg">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="p-4 text-center text-slate-500">Anda belum memiliki berita.</td>
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
        $('#berita-table').DataTable({
            language: {
                search: "Cari:",
                lengthMenu: "Tampilkan _MENU_ entri",
                info: "Dari _START_ sampai _END_ dari _TOTAL_ entri",
                infoEmpty: "menampilkan 0 sampai 0 dari 0 entri",
                infoFiltered: "(disaring dari _MAX_ total entri)",
                paginate: {
                    first: "Awal",
                    last: "Akhir",
                    next: "Selanjutnya",
                    previous: "Sebelumnya"
                }
            }
        });
    });
</script>
@endpush