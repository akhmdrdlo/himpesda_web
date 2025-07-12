

<?php $__env->startSection('title', 'Konfirmasi Pembayaran'); ?>

<?php $__env->startSection('content'); ?>
<?php if(session('success')): ?>
<div class="w-full px-6 pt-6 mx-auto">
    <div class="relative p-4 pr-12 mb-4 text-white border border-solid rounded-lg bg-gradient-to-tl from-emerald-500 to-teal-400 border-emerald-300" role="alert">
        <span class="font-bold">Sukses!</span>
        <span class="block sm:inline"><?php echo e(session('success')); ?></span>
        <button type="button" class="absolute top-0 bottom-0 right-0 px-4 py-3" data-alert-close="true">
            <span class="text-2xl" aria-hidden="true">×</span>
        </button>
    </div>
</div>
<?php endif; ?>
<div class="w-full px-6 py-6 mx-auto">
    <div class="flex flex-wrap -mx-3">
        <div class="w-full max-w-full px-3 mb-6 sm:w-1/2 sm:flex-none">
            <div class="relative flex flex-col min-w-0 break-words bg-white shadow-xl rounded-2xl bg-clip-border">
                <div class="flex-auto p-4">
                    <div class="flex flex-row -mx-3">
                        <div class="flex-none w-2/3 max-w-full px-3">
                            <div>
                                <p class="mb-0 font-sans text-sm font-semibold leading-normal uppercase">Menunggu Konfirmasi</p>
                                
                                <h5 class="mb-2 font-bold"><?php echo e($menungguKonfirmasi); ?></h5>
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
                                <p class="mb-0 font-sans text-sm font-semibold leading-normal uppercase">Anggota Terdaftar</p>
                                
                                <h5 class="mb-2 font-bold"><?php echo e($anggotaTerdaftar); ?></h5>
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

    <div class="flex flex-wrap -mx-3">
        <div class="flex-none w-full max-w-full px-3">
            <div class="relative flex flex-col min-w-0 mb-6 break-words bg-white border-0 border-transparent border-solid shadow-xl rounded-2xl bg-clip-border">
                <div class="p-6 pb-0 mb-0 border-b-0 border-b-solid rounded-t-2xl border-b-transparent flex justify-between items-center">
                    <h6>Pendaftar Menunggu Konfirmasi</h6>
                    <a href="#" class="inline-block px-4 py-2 text-xs font-bold text-center text-white uppercase align-middle transition-all bg-blue-500 border-0 rounded-lg shadow-md cursor-pointer">Tambah Pendaftar Baru</a>
                </div>
                <div class="flex-auto px-0 pt-0 pb-2">
                    <div class="p-4 overflow-x-auto">
                        <table class="items-center w-full mb-0 align-top border-collapse text-slate-500">
                            <thead class="align-bottom">
                                <tr>
                                    <th class="px-6 py-3 font-bold text-left uppercase align-middle bg-transparent border-b border-collapse shadow-none text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">Nama Pendaftar</th>
                                    <th class="px-6 py-3 font-bold text-center uppercase align-middle bg-transparent border-b border-collapse shadow-none text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">Status Pembayaran</th>
                                    <th class="px-6 py-3 font-bold text-center uppercase align-middle bg-transparent border-b border-collapse shadow-none text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">Status Anggota</th>
                                    <th class="px-6 py-3 font-bold text-center uppercase align-middle bg-transparent border-b border-collapse shadow-none text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__empty_1 = true; $__currentLoopData = $pendaftar; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <tr>
                                    
                                    <form action="<?php echo e(route('admin.konfirmasi.update', $item->id)); ?>" method="POST">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('PUT'); ?>

                                        <td class="p-2 align-middle bg-transparent border-b">
                                            <p class="mb-0 ml-4 text-xs font-semibold"><?php echo e($item->nama_lengkap); ?></p>
                                            <p class="mb-0 ml-4 text-xs text-slate-400"><?php echo e($item->email); ?></p>
                                        </td>
                                        <td class="p-2 text-center align-middle bg-transparent border-b">
                                            
                                            <select name="status_pembayaran" class="text-xs font-semibold leading-tight border rounded-md p-2">
                                                <option value="Belum Lunas" <?php echo e($item->status_pembayaran == 'Belum Lunas' ? 'selected' : ''); ?>>Belum Lunas</option>
                                                <option value="Sudah Lunas" <?php echo e($item->status_pembayaran == 'Sudah Lunas' ? 'selected' : ''); ?>>Sudah Lunas</option>
                                            </select>
                                        </td>
                                        <td class="p-2 text-center align-middle bg-transparent border-b">
                                            
                                            <select name="status_anggota" class="text-xs font-semibold leading-tight border rounded-md p-2">
                                                <option value="Menunggu Konfirmasi" <?php echo e($item->status_anggota == 'Menunggu Konfirmasi' ? 'selected' : ''); ?>>Menunggu Konfirmasi</option>
                                                <option value="Sedang Diproses" <?php echo e($item->status_anggota == 'Sedang Diproses' ? 'selected' : ''); ?>>Sedang Diproses</option>
                                                <option value="Aktif" <?php echo e($item->status_anggota == 'Aktif' ? 'selected' : ''); ?>>Aktif</option>
                                                <option value="Ditolak" <?php echo e($item->status_anggota == 'Ditolak' ? 'selected' : ''); ?>>Ditolak</option>
                                            </select>
                                        </td>
                                        <td class="p-2 text-center align-middle bg-transparent border-b">
                                            
                                            <a href="<?php echo e(route('admin.konfirmasi.show', $item->id)); ?>" class="inline-block px-4 py-2 mr-2 text-xs font-bold text-center text-white uppercase align-middle bg-blue-500 border-0 rounded-lg shadow-md cursor-pointer">Detail</a>
                                            <button type="submit" class="px-4 py-2 text-xs font-bold text-white uppercase bg-slate-700 rounded-lg">Simpan</button>
                                        </td>
                                    </form>
                                </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <tr><td colspan="4" class="p-4 text-center text-sm">Tidak ada pendaftar baru yang menunggu konfirmasi.</td></tr>
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
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\himpesda-web\resources\views/admin/konfirmasi-pembayaran.blade.php ENDPATH**/ ?>