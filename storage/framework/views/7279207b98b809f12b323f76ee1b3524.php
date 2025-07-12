


<?php $__env->startSection('title', $berita->judul); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-4xl mx-auto px-4 py-10 sm:px-6 lg:px-8">
    <div class="bg-white dark:bg-gray-800 shadow-lg rounded-lg overflow-hidden">
        <?php if($berita->gambar): ?>
            <img class="w-full h-96 object-cover" src="<?php echo e(asset('storage/' . $berita->gambar)); ?>" alt="<?php echo e($berita->judul); ?>">
        <?php endif; ?>

        <div class="p-6 md:p-10">
            <div class="mb-6">
                <p class="text-sm text-gray-500">
                    <a href="#" class="font-semibold text-blue-600"><?php echo e($berita->kategori); ?></a>
                    &bull;
                    <span><?php echo e($berita->created_at->translatedFormat('d F Y')); ?></span>
                    &bull;
                    <span>Oleh: <?php echo e($berita->user->nama_lengkap ?? 'Tim HIMPESDA'); ?></span>
                </p>
            </div>

            <h1 class="text-3xl md:text-4xl font-bold text-gray-900 dark:text-white mb-4 leading-tight">
                <?php echo e($berita->judul); ?>

            </h1>

            <div class="prose lg:prose-lg max-w-none text-gray-800 dark:text-gray-200 text-justify">
                
                <?php echo $berita->konten; ?>

            </div>

             <hr class="my-8">

            <div>
                <h3 class="text-2xl font-bold mb-4">Berita Lainnya</h3>
                <div class="space-y-4">
                    <?php $__empty_1 = true; $__currentLoopData = $beritaLainnya; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <a href="<?php echo e(route('berita.show', $item->slug)); ?>" class="block hover:bg-gray-50 p-4 rounded-md">
                        <p class="font-semibold text-gray-800"><?php echo e($item->judul); ?></p>
                        <p class="text-xs text-gray-500"><?php echo e($item->created_at->translatedFormat('d F Y')); ?></p>
                    </a>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <p class="text-sm text-gray-500">Tidak ada berita lainnya.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\himpesda-web\resources\views/pages/detail-berita.blade.php ENDPATH**/ ?>