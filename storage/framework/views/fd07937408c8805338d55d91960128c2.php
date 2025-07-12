

<?php $__env->startSection('title', 'Update Profil Anggota'); ?>

<?php $__env->startSection('content'); ?>
<div class="w-full p-6 mx-auto">
    <div class="flex flex-wrap -mx-3">
      <div class="w-full max-w-full px-3 shrink-0">
        <div class="relative flex flex-col min-w-0 break-words bg-white border-0 shadow-xl rounded-2xl bg-clip-border">
          <div class="border-black/12.5 rounded-t-2xl border-b-0 border-solid p-6 pb-0">
            <h6 class="text-lg">Update Profil: <?php echo e($anggota->nama_lengkap); ?></h6>
          </div>
          <div class="flex-auto p-6">
            
            <form action="<?php echo e(route('admin.anggota.update', $anggota->id)); ?>" method="POST" enctype="multipart/form-data">
              <?php echo csrf_field(); ?>
              <?php echo method_field('PUT'); ?>

              <p class="leading-normal uppercase text-sm text-slate-500">Informasi Pribadi</p>
              <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <div>
                  <label for="nama_lengkap" class="inline-block mb-2 ml-1 font-bold text-xs text-slate-700">Nama Lengkap</label>
                  <input type="text" name="nama_lengkap" value="<?php echo e(old('nama_lengkap', $anggota->nama_lengkap)); ?>" class="focus:shadow-primary-outline text-sm leading-5.6 ease block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 outline-none transition-all focus:border-blue-500 focus:outline-none" />
                </div>
                <div>
                  <label for="email" class="inline-block mb-2 ml-1 font-bold text-xs text-slate-700">Email</label>
                  <input type="email" name="email" value="<?php echo e(old('email', $anggota->email)); ?>" class="focus:shadow-primary-outline text-sm leading-5.6 ease block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 outline-none transition-all focus:border-blue-500 focus:outline-none" />
                </div>
                <div>
                  <label for="tanggal_lahir" class="inline-block mb-2 ml-1 font-bold text-xs text-slate-700">Tanggal Lahir</label>
                  <input type="date" name="tanggal_lahir" value="<?php echo e(old('tanggal_lahir', $anggota->tanggal_lahir)); ?>" class="focus:shadow-primary-outline text-sm leading-5.6 ease block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 outline-none transition-all focus:border-blue-500 focus:outline-none" />
                </div>
                <div>
                  <label for="jenis_kelamin" class="inline-block mb-2 ml-1 font-bold text-xs text-slate-700">Jenis Kelamin</label>
                  <select name="jenis_kelamin" class="focus:shadow-primary-outline text-sm leading-5.6 ease block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 outline-none transition-all focus:border-blue-500 focus:outline-none">
                    <option value="Laki-laki" <?php echo e($anggota->jenis_kelamin == 'Laki-laki' ? 'selected' : ''); ?>>Laki-laki</option>
                    <option value="Perempuan" <?php echo e($anggota->jenis_kelamin == 'Perempuan' ? 'selected' : ''); ?>>Perempuan</option>
                  </select>
                </div>
              </div>

              <hr class="h-px mx-0 my-4 bg-transparent border-0 opacity-25 bg-gradient-to-r from-transparent via-black/40 to-transparent" />
              
              <p class="leading-normal uppercase text-sm text-slate-500">Informasi Kepegawaian</p>
              <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                  <label for="nip" class="inline-block mb-2 ml-1 font-bold text-xs text-slate-700">NIP</label>
                  <input type="text" name="nip" value="<?php echo e(old('nip', $anggota->nip)); ?>" class="focus:shadow-primary-outline text-sm leading-5.6 ease block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 outline-none transition-all focus:border-blue-500 focus:outline-none" />
                </div>
                <div>
                  <label for="jabatan_fungsional" class="inline-block mb-2 ml-1 font-bold text-xs text-slate-700">Jabatan Fungsional</label>
                  <input type="text" name="jabatan_fungsional" value="<?php echo e(old('jabatan_fungsional', $anggota->jabatan_fungsional)); ?>" class="focus:shadow-primary-outline text-sm leading-5.6 ease block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 outline-none transition-all focus:border-blue-500 focus:outline-none" />
                </div>
                <div>
                  <label for="pas_foto" class="inline-block mb-2 ml-1 font-bold text-xs text-slate-700">Ganti Pas Foto (Opsional)</label>
                  <input type="file" name="pas_foto" class="focus:shadow-primary-outline text-sm leading-5.6 ease block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 outline-none transition-all" />
                </div>
              </div>

              <div class="flex justify-end mt-6">
                <button type="submit" class="inline-block px-8 py-2 font-bold leading-normal text-center text-white align-middle transition-all ease-in bg-gradient-to-tl from-emerald-500 to-teal-400 border-0 rounded-lg shadow-md cursor-pointer text-xs hover:shadow-xs hover:-translate-y-px active:opacity-85">Simpan Perubahan</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\himpesda-web\resources\views/admin/edit-anggota.blade.php ENDPATH**/ ?>