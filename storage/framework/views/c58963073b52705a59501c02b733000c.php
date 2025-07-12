
<?php $__env->startSection('title', 'Berita & Kegiatan'); ?>
<?php $__env->startSection('content'); ?>
    <section class="w-full bg-[var(--blue-dark)] py-20">
        <div class="max-w-7xl mx-auto px-6 text-center"><h1 class="text-4xl font-bold text-white">Arsip Berita & Kegiatan</h1></div>
    </section>
    <section class="max-w-7xl mx-auto px-6 py-16">
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
            <?php $__empty_1 = true; $__currentLoopData = $semuaBerita; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $berita): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <article class="bg-white rounded-lg shadow-md overflow-hidden transition-transform duration-300 hover:-translate-y-2">
                    <a href="<?php echo e(route('berita.show', $berita->slug)); ?>" class="hover:text-blue-700">
                        <img src="<?php echo e($berita->gambar ? asset('storage/' . $berita->gambar) : 'https://via.placeholder.com/400x200.png?text=HIMPESDA'); ?>" alt="<?php echo e($berita->judul); ?>" class="w-full h-48 object-cover"/>
                    </a>
                    <div class="p-5">
                        <span class="text-xs text-gray-500"><?php echo e($berita->kategori); ?> &bull; <?php echo e($berita->created_at->translatedFormat('d F Y')); ?></span>
                        <h3 class="font-semibold text-lg my-2 leading-tight">
                            <a href="<?php echo e(route('berita.show', $berita->slug)); ?>" class="hover:text-blue-700"><?php echo e(Str::limit($berita->judul, 55)); ?></a>
                        </h3>
                        <p class="text-sm text-gray-600 mb-4"><?php echo e(Str::limit(strip_tags($berita->konten), 100)); ?></p>
                    </div>
                </article>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <p class="lg:col-span-3 text-center text-gray-500">Belum ada berita untuk ditampilkan.</p>
            <?php endif; ?>
        </div>
        <div class="mt-12">
            <?php echo e($semuaBerita->links()); ?>

        </div>
    </section>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\himpesda-web\resources\views/pages/berita.blade.php ENDPATH**/ ?>