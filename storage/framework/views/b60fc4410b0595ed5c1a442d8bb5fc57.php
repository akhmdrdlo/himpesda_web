
<?php $__env->startSection('title', 'Tambah Berita Baru'); ?>
<?php $__env->startSection('content'); ?>
<div class="w-full p-6 mx-auto">
    <div class="relative flex flex-col min-w-0 break-words bg-white border-0 shadow-xl rounded-2xl bg-clip-border">
        <div class="p-6 pb-0"><h6 class="text-lg">Formulir Tambah Berita</h6></div>
            
            <?php if($errors->any()): ?>
                <div class="p-4 mb-4 text-sm text-red-800 bg-red-100 rounded-lg" role="alert">
                    <span class="font-medium">Terjadi kesalahan!</span>
                    <ul>
                        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li class="list-disc list-inside"><?php echo e($error); ?></li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                </div>
            <?php endif; ?>
        <div class="flex-auto p-6">
            <form action="<?php echo e(route('admin.berita.store')); ?>" method="POST" enctype="multipart/form-data">
                <?php echo csrf_field(); ?>
                <div class="space-y-4">
                    <div>
                        <label for="judul" class="block font-bold text-xs text-slate-700">Judul Berita</label>
                        <input type="text" name="judul" class="focus:shadow-primary-outline text-sm leading-5.6 ease block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 outline-none transition-all focus:border-blue-500 focus:outline-none" required>
                    </div>
                    <div>
                        <label for="kategori" class="block font-bold text-xs text-slate-700">Kategori</label>
                        <input type="text" name="kategori" class="focus:shadow-primary-outline text-sm leading-5.6 ease block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 outline-none transition-all focus:border-blue-500 focus:outline-none" required>
                    </div>
                    <div>
                        <label for="gambar" class="block font-bold text-xs text-slate-700">Gambar Headline</label>
                        <input type="file" name="gambar" class="focus:shadow-primary-outline text-sm leading-5.6 ease block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 outline-none transition-all focus:border-blue-500 focus:outline-none">
                    </div>
                    <div>
                        <label for="konten" class="block font-bold text-xs text-slate-700">Isi Berita</label>
                        <textarea name="konten" rows="10" class="focus:shadow-primary-outline text-sm leading-5.6 ease block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 outline-none transition-all focus:border-blue-500 focus:outline-none" required></textarea>
                    </div>
                    <div class="flex justify-end">
                        <button type="submit" class="px-8 py-2 font-bold text-white bg-blue-500 rounded-lg">Publikasikan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\himpesda-web\resources\views/admin/berita/create.blade.php ENDPATH**/ ?>