
<?php $__env->startSection('title', 'Edit Berita'); ?>
<?php $__env->startSection('content'); ?>
<div class="w-full p-6 mx-auto">
    <div class="relative flex flex-col min-w-0 break-words bg-white border-0 shadow-xl rounded-2xl bg-clip-border">
        <div class="p-6 pb-0"><h6 class="text-lg">Formulir Edit Berita</h6></div>
        <div class="flex-auto p-6">
            <form action="<?php echo e(route('admin.berita.update', $berita->id)); ?>" method="POST" enctype="multipart/form-data">
                <?php echo csrf_field(); ?>
                <?php echo method_field('PUT'); ?>
                <div class="space-y-4">
                    <div>
                        <label for="judul" class="block font-bold text-xs text-slate-700">Judul Berita</label>
                        <input type="text" name="judul" class="w-full rounded-lg border-gray-300" value="<?php echo e(old('judul', $berita->judul)); ?>" required>
                    </div>
                    <div>
                        <label for="kategori" class="block font-bold text-xs text-slate-700">Kategori</label>
                        <input type="text" name="kategori" class="w-full rounded-lg border-gray-300" value="<?php echo e(old('kategori', $berita->kategori)); ?>" required>
                    </div>
                    <div>
                        <label for="gambar" class="block font-bold text-xs text-slate-700">Gambar Headline (Kosongkan jika tidak ingin diubah)</label>
                        <?php if($berita->gambar): ?>
                            <div class="max-w-xs">
                                <img src="<?php echo e(asset('storage/' . $berita->gambar)); ?>" class="w-full h-auto my-2 rounded-md object-contain">
                            </div>
                        <?php endif; ?>
                        <input type="file" name="gambar" class="w-full rounded-lg border p-2">
                    </div>
                    <div>
                        <label for="konten" class="block font-bold text-xs text-slate-700">Isi Berita</label>
                        <textarea name="konten" rows="10" class="w-full rounded-lg border-gray-300" required><?php echo e(old('konten', $berita->konten)); ?></textarea>
                    </div>
                    <div class="flex justify-end">
                        <a href="<?php echo e(route('admin.berita.index')); ?>" class="px-8 py-2 mr-2 font-bold text-gray-700 bg-gray-200 rounded-lg">Batal</a>
                        <button type="submit" class="px-8 py-2 font-bold text-white bg-blue-500 rounded-lg">Simpan Perubahan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\himpesda-web\resources\views/admin/berita/edit.blade.php ENDPATH**/ ?>