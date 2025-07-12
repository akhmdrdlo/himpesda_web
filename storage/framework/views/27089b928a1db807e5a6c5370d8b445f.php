

<?php $__env->startSection('title', 'Manajemen Berita'); ?>

<?php $__env->startPush('styles'); ?>
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.8/css/dataTables.tailwindcss.css">
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div class="w-full px-6 py-6 mx-auto">
    <?php if(session('success')): ?>
    <div class="relative p-4 pr-12 mb-4 text-white border border-solid rounded-lg bg-gradient-to-tl from-emerald-500 to-teal-400">
        <?php echo e(session('success')); ?>

    </div>
    <?php endif; ?>
    
    <div class="flex flex-wrap -mx-3">
        <div class="flex-none w-full max-w-full px-3">
            <div class="relative flex flex-col min-w-0 mb-6 break-words bg-white border-0 border-transparent border-solid shadow-xl rounded-2xl bg-clip-border">
                <div class="p-6 pb-0 mb-0 border-b-0 border-b-solid rounded-t-2xl border-b-transparent flex justify-between items-center">
                    <h6>Tabel Berita</h6>
                    <a href="<?php echo e(route('admin.berita.create')); ?>" class="inline-block px-4 py-2 text-xs font-bold text-center text-white uppercase align-middle transition-all bg-blue-500 border-0 rounded-lg shadow-md">Tambah Berita Baru</a>
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
                                <?php $__empty_1 = true; $__currentLoopData = $berita; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <tr class="bg-white border-b hover:bg-gray-50">
                                    <td class="px-6 py-4 font-semibold text-gray-900"><?php echo e(Str::limit($item->judul, 40)); ?></td>
                                    <td class="px-6 py-4"><?php echo e($item->kategori); ?></td>
                                    <td class="px-6 py-4"><?php echo e($item->user->nama_lengkap ?? 'N/A'); ?></td>
                                    <td class="px-6 py-4"><?php echo e($item->created_at->translatedFormat('d F Y')); ?></td>
                                    <td class="px-6 py-4 text-center whitespace-nowrap">
                                        <a href="<?php echo e(route('admin.berita.show', $item->id)); ?>" class="px-4 py-2 mr-2 text-xs font-bold text-white bg-slate-700 rounded-lg">Edit</a>
                                        <form action="<?php echo e(route('admin.berita.destroy', $item->id)); ?>" method="POST" class="inline-block" onsubmit="return confirm('Yakin ingin menghapus berita ini?');">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('DELETE'); ?>
                                            <button type="submit" class="px-4 py-2 text-xs font-bold text-white bg-gradient-to-tl from-red-600 to-orange-600 rounded-lg">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <tr>
                                    <td colspan="5" class="p-4 text-center text-slate-500">Anda belum memiliki berita.</td>
                                </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
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
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\himpesda-web\resources\views/admin/berita/index.blade.php ENDPATH**/ ?>