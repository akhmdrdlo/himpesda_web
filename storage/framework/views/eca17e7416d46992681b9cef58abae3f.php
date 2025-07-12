
<?php $__env->startSection('title', 'Sejarah Singkat'); ?>
<?php $__env->startSection('content'); ?>
    <section class="w-full bg-[var(--blue-dark)] py-20">
        <div class="max-w-7xl mx-auto px-6 text-center"><h1 class="text-4xl font-bold text-white">Sejarah Singkat</h1></div>
    </section>
    <section class="max-w-4xl mx-auto p-6 md:p-10">
        <div class="prose lg:prose-xl max-w-none text-justify">
            <p><?php echo e($organisasi->sejarah_singkat ?? 'Konten sejarah belum tersedia.'); ?></p>
        </div>
    </section>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\himpesda-web\resources\views/pages/profil/sejarah.blade.php ENDPATH**/ ?>