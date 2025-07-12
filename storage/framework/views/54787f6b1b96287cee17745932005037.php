

<?php $__env->startSection('title', 'Detail Pendaftar'); ?>

<?php $__env->startSection('content'); ?>
<div class="w-full p-6 mx-auto">
    <div class="flex flex-wrap -mx-3">
        <div class="w-full max-w-full px-3 shrink-0">
            <div class="relative flex flex-col min-w-0 break-words bg-white border-0 shadow-xl rounded-2xl bg-clip-border">
                
                <div class="border-black/12.5 rounded-t-2xl border-b-0 border-solid p-6 pb-0">
                    <div class="flex items-center">
                        <h6 class="mb-0 text-lg">Detail Pendaftar: <?php echo e($pendaftar->nama_lengkap); ?></h6>
                        <a href="<?php echo e(route('admin.konfirmasi.index')); ?>" class="inline-block px-4 py-2 mb-0 ml-auto font-bold text-center text-white align-middle transition-all ease-in bg-slate-500 border-0 rounded-lg shadow-md cursor-pointer text-xs hover:shadow-xs hover:-translate-y-px active:opacity-85">
                            &laquo; Kembali
                        </a>
                    </div>
                </div>

                <div class="flex-auto p-6">
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-4 mb-6">
                        <div>
                            <strong class="block text-xs text-slate-500">Nama Lengkap:</strong>
                            <p><?php echo e($pendaftar->nama_lengkap); ?></p>
                            
                            <strong class="block mt-4 text-xs text-slate-500">Email:</strong>
                            <p><?php echo e($pendaftar->email); ?></p>

                            <strong class="block mt-4 text-xs text-slate-500">NIP:</strong>
                            <p><?php echo e($pendaftar->nip ?? '-'); ?></p>
                        </div>
                        <div>
                            <strong class="block text-xs text-slate-500">Tanggal Daftar:</strong>
                            <p><?php echo e($pendaftar->created_at->translatedFormat('d F Y, H:i')); ?></p>
                            
                            <strong class="block mt-4 text-xs text-slate-500">Status Pembayaran:</strong>
                            <p><?php echo e($pendaftar->status_pembayaran); ?></p>
                            
                            <strong class="block mt-4 text-xs text-slate-500">Status Anggota:</strong>
                            <p><?php echo e($pendaftar->status_anggota); ?></p>
                        </div>
                    </div>
                    
                    <hr class="h-px mx-0 my-4 bg-transparent border-0 opacity-25 bg-gradient-to-r from-transparent via-black/40 to-transparent" />

                    
                    <div>
                        <p class="leading-normal uppercase text-sm text-slate-500">Bukti Pembayaran</p>
                        <div class="mt-2 border border-gray-200 rounded-lg p-4">
                            <?php if($pendaftar->bukti_pembayaran): ?>
                                <img src="<?php echo e(asset('storage/' . $pendaftar->bukti_pembayaran)); ?>" alt="Bukti Pembayaran" class="w-full md:w-1/2 rounded-lg">
                            <?php else: ?>
                                <p class="text-sm text-slate-500">Pendaftar belum mengunggah bukti pembayaran.</p>
                                
                                <img src="https://via.placeholder.com/600x400.png?text=Contoh+Bukti+Pembayaran" alt="Bukti Pembayaran Dummy" class="w-full md:w-1/2 rounded-lg mt-2">
                                <a href="#" class="text-blue-500 text-sm mt-2 inline-block">Download File Dummy</a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\himpesda-web\resources\views/admin/detail-pendaftar.blade.php ENDPATH**/ ?>