

<?php $__env->startSection('title', 'Profil Saya'); ?>

<?php $__env->startSection('content'); ?>
    
    <?php if(session('success')): ?>
    <div class="relative w-full mx-auto mt-4">
        <div class="relative p-4 pr-12 mx-6 text-white border border-solid rounded-lg bg-gradient-to-tl from-emerald-500 to-teal-400 border-emerald-300" role="alert">
            <span class="font-bold">Sukses!</span>
            <span class="block sm:inline"><?php echo e(session('success')); ?></span>
            <button type="button" class="absolute top-0 bottom-0 right-0 px-4 py-3" data-alert-close="true">
                <span class="text-2xl" aria-hidden="true">×</span>
            </button>
        </div>
    </div>
    <?php endif; ?>
     <div class="relative w-full mx-auto mt-30">
        <div class="relative flex flex-col flex-auto min-w-0 p-4 mx-6 overflow-hidden break-words bg-white border-0 shadow-3xl rounded-2xl bg-clip-border">
            <div class="flex flex-wrap -mx-3">
                <div class="flex-none w-auto max-w-full px-3">
                    <div class="relative inline-flex items-center justify-center text-white h-19 w-19 rounded-xl">
                        
                        <?php if($anggota->pas_foto): ?>
                            <img src="<?php echo e(asset('storage/' . $anggota->pas_foto)); ?>" alt="profile_image" class="w-full shadow-2xl rounded-xl" />
                        <?php else: ?>
                            <img src="<?php echo e(asset('assets/img/team-1.jpg')); ?>" alt="profile_image" class="w-full shadow-2xl rounded-xl" />
                        <?php endif; ?>
                    </div>
                </div>
                <div class="flex-none w-auto max-w-full px-3 my-auto">
                    <div class="h-full">
                        
                        <h5 class="mb-1"><?php echo e($anggota->nama_lengkap); ?></h5>
                        <p class="mb-0 font-semibold leading-normal text-sm capitalize"><?php echo e($anggota->level); ?></p>
                    </div>
                </div>
                <div class="w-full max-w-full px-3 mt-4 lg:mt-0 lg:w-auto lg:flex-none ml-auto self-center">
                    <div class="flex items-center justify-center lg:justify-end space-x-4">
                        <a href="<?php echo e(route('admin.profile.cetak_kartu')); ?>" class="inline-block px-4 py-2 font-bold text-center  text-white uppercase bg-blue-500 align-middle transition-all ease-in border-0 rounded-lg shadow-md cursor-pointer text-xs hover:shadow-xs hover:-translate-y-px active:opacity-100">Cetak Kartu Anggota</a>
                        <a  href="<?php echo e(route('admin.profile.edit')); ?>" class="inline-block px-4 py-2 font-bold text-center text-white align-middle transition-all ease-in bg-slate-700 border-0 rounded-lg shadow-md cursor-pointer text-xs hover:shadow-xs hover:-translate-y-px active:opacity-85">Update Profil</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="w-full p-6 mx-auto">
        <div class="flex flex-wrap -mx-3">
            <div class="w-full max-w-full px-3 shrink-0">
                <div class="relative flex flex-col min-w-0 break-words bg-white border-0 shadow-xl rounded-2xl bg-clip-border">
                    <div class="border-black/12.5 rounded-t-2xl border-b-0 border-solid p-6 pb-0">
                        <h6 class="text-lg">Detail Informasi Akun</h6>
                    </div>
                    <div class="flex-auto p-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            <div>
                                <p class="leading-normal uppercase text-sm text-slate-500 mb-4">Informasi Pribadi</p>
                                <div class="space-y-4">
                                    <div>
                                        <strong class="block text-xs text-slate-500">Nama Lengkap:</strong>
                                        <p><?php echo e($anggota->nama_lengkap); ?></p>
                                    </div>
                                    <div>
                                        <strong class="block text-xs text-slate-500">Email:</strong>
                                        <p><?php echo e($anggota->email); ?></p>
                                    </div>
                                    <div>
                                        <strong class="block text-xs text-slate-500">Tanggal Lahir:</strong>
                                        <p><?php echo e($anggota->tanggal_lahir ? \Carbon\Carbon::parse($anggota->tanggal_lahir)->translatedFormat('d F Y') : '-'); ?></p>
                                    </div>
                                    <div>
                                        <strong class="block text-xs text-slate-500">Jenis Kelamin:</strong>
                                        <p><?php echo e($anggota->jenis_kelamin ?? '-'); ?></p>
                                    </div>
                                    <div>
                                        <strong class="block text-xs text-slate-500">Agama:</strong>
                                        <p><?php echo e($anggota->agama ?? '-'); ?></p>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <p class="leading-normal uppercase text-sm text-slate-500 mb-4">Informasi Kepegawaian & Instansi</p>
                                <div class="space-y-4">
                                    <div>
                                        <strong class="block text-xs text-slate-500">NIP:</strong>
                                        <p><?php echo e($anggota->nip ?? 'Tidak ada'); ?></p>
                                    </div>
                                    <div>
                                        <strong class="block text-xs text-slate-500">NPWP:</strong>
                                        <p><?php echo e($anggota->npwp ?? 'Tidak ada'); ?></p>
                                    </div>
                                    <div>
                                        <strong class="block text-xs text-slate-500">Asal Instansi:</strong>
                                        <p><?php echo e($anggota->asal_instansi ?? 'Tidak ada'); ?></p>
                                    </div>
                                    <div>
                                        <strong class="block text-xs text-slate-500">Unit Kerja:</strong>
                                        <p><?php echo e($anggota->unit_kerja ?? 'Tidak ada'); ?></p>
                                    </div>
                                    <div>
                                        <strong class="block text-xs text-slate-500">Jabatan Fungsional:</strong>
                                        <p><?php echo e($anggota->jabatan_fungsional ?? 'Tidak ada'); ?></p>
                                    </div>
                                    <div>
                                        <strong class="block text-xs text-slate-500">Tanggal Bergabung:</strong>
                                        <p><?php echo e($anggota->created_at->translatedFormat('d F Y')); ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\himpesda-web\resources\views/admin/profile-admin.blade.php ENDPATH**/ ?>