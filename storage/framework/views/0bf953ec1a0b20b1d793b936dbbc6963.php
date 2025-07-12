

<?php $__env->startSection('title', 'Selamat Datang'); ?>

<?php $__env->startSection('content'); ?>
    <section class="relative w-full h-screen -mt-[88px] top-0 overflow-hidden" id="hero-carousel">
        <div class="absolute inset-0 flex transition-transform duration-700 ease-in-out" id="carousel">
            <article class="relative w-full flex-shrink-0">
                <img alt="Kegiatan HIMPESDA" class="w-full h-full object-cover" src="<?php echo e(asset('assets/img/berita-1.jpg')); ?>"/>
                <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent flex flex-col justify-end p-12 md:p-24">
                    <h1 class="text-4xl md:text-6xl font-extrabold text-white drop-shadow-lg max-w-3xl mb-4">Membangun SDM Unggul dan Berdaya Saing</h1>
                </div>
            </article>
            <article class="relative w-full flex-shrink-0">
                <img alt="Seminar HIMPESDA" class="w-full h-full object-cover" src="<?php echo e(asset('assets/img/berita-2.jpg')); ?>"/>
                <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent flex flex-col justify-end p-12 md:p-24">
                    <h1 class="text-4xl md:text-6xl font-extrabold text-white drop-shadow-lg max-w-3xl mb-4">Inovasi Untuk Negeri</h1>
                </div>
            </article>
        </div>
        <button id="prevBtn" class="absolute top-1/2 left-6 transform -translate-y-1/2 bg-white/70 p-3 rounded-full z-20"><i class="fas fa-chevron-left"></i></button>
        <button id="nextBtn" class="absolute top-1/2 right-6 transform -translate-y-1/2 bg-white/70 p-3 rounded-full z-20"><i class="fas fa-chevron-right"></i></button>
    </section>

    <section class="max-w-7xl mx-auto px-6 py-20 text-center">
        <?php if($organisasi): ?>
            <h2 class="text-3xl md:text-4xl font-bold mb-4">Selamat Datang di HIMPESDA</h2>
            <p class="text-lg text-slate-600 max-w-3xl mx-auto leading-relaxed mb-8">
                <?php echo e($organisasi->profil_singkat); ?>

            </p>
            <a href="<?php echo e(route('profil.sejarah')); ?>" class="inline-block bg-blue-900 text-white font-semibold px-8 py-3 rounded-lg hover:bg-blue-800 transition-colors">
                Selengkapnya tentang Kami
            </a>
        <?php else: ?>
             <p class="text-lg text-slate-500">Informasi organisasi belum tersedia.</p>
        <?php endif; ?>
    </section>

    <section class="w-full bg-slate-50 py-20">
        <div class="max-w-7xl mx-auto px-6">
            <h2 class="text-3xl font-bold mb-10 text-center">Berita & Kegiatan Terbaru</h2>
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                <?php $__empty_1 = true; $__currentLoopData = $beritaTerbaru; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $berita): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
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
            <div class="text-center mt-12">
                <a href="<?php echo e(route('berita.index')); ?>" class="text-blue-900 font-semibold hover:underline">
                    Lihat Semua Berita &rarr;
                </a>
            </div>
        </div>
    </section>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\himpesda-web\resources\views/pages/home.blade.php ENDPATH**/ ?>