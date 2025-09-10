<?php $__env->startSection('title', 'Pendaftaran Anggota'); ?>
<?php $__env->startSection('content'); ?>
<section class="w-full bg-[var(--blue-dark)] py-20">
    <div class="max-w-7xl mx-auto px-6 text-center"><h1 class="text-4xl font-bold text-white">Formulir Pendaftaran Anggota</h1></div>
</section>
<section class="max-w-3xl mx-auto p-6 md:py-16">
    <div class="text-center mb-10">
        <p class="text-gray-600">Isi semua data di bawah ini dengan benar untuk mengajukan permohonan keanggotaan. Data Anda akan diverifikasi oleh tim kami.</p>
    </div>

    <?php if(session('success')): ?>
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6" role="alert">
            <p class="font-bold">Berhasil!</p>
            <p><?php echo e(session('success')); ?></p>
        </div>
    <?php endif; ?>
    
    <?php if($errors->any()): ?>
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6" role="alert">
            <p class="font-bold">Terjadi Kesalahan, periksa kembali isian Anda:</p>
            <ul class="mt-2 list-disc list-inside">
                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li><?php echo e($error); ?></li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </div>
    <?php endif; ?>
    <form action="<?php echo e(route('pendaftaran.store')); ?>" method="POST" enctype="multipart/form-data" class="bg-white p-8 rounded-xl shadow-lg space-y-6">
        <?php echo csrf_field(); ?>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
            <label for="nama_lengkap" class="block mb-2 text-sm font-semibold">Nama Lengkap</label>
            <input type="text" id="nama_lengkap" name="nama_lengkap"
                class="w-full border-2 border-gray-300 focus:border-blue-600 focus:ring-2 focus:ring-blue-100 rounded-lg text-sm transition-all duration-200"
                required value="<?php echo e(old('nama_lengkap')); ?>">
            </div>
            <div>
            <label for="email" class="block mb-2 text-sm font-semibold">Email</label>
            <input type="email" id="email" name="email"
                class="w-full border-2 border-gray-300 focus:border-blue-600 focus:ring-2 focus:ring-blue-100 rounded-lg text-sm transition-all duration-200"
                required value="<?php echo e(old('email')); ?>">
            </div>
            <div>
            <label for="nip" class="block mb-2 text-sm font-semibold">NIP (Opsional)</label>
            <input type="text" id="nip" name="nip"
                class="w-full border-2 border-gray-300 focus:border-blue-600 focus:ring-2 focus:ring-blue-100 rounded-lg text-sm transition-all duration-200"
                value="<?php echo e(old('nip')); ?>">
            </div>
            <div>
            <label for="npwp" class="block mb-2 text-sm font-semibold">NPWP (Opsional)</label>
            <input type="text" id="npwp" name="npwp"
                class="w-full border-2 border-gray-300 focus:border-blue-600 focus:ring-2 focus:ring-blue-100 rounded-lg text-sm transition-all duration-200"
                value="<?php echo e(old('npwp')); ?>">
            </div>
            <div>
            <label for="jenis_kelamin" class="block mb-2 text-sm font-semibold">Jenis Kelamin</label>
            <select name="jenis_kelamin" id="jenis_kelamin"
                class="w-full border-2 border-gray-300 focus:border-blue-600 focus:ring-2 focus:ring-blue-100 rounded-lg text-sm transition-all duration-200"
                required>
                <option value="">Pilih...</option>
                <option value="Laki-laki" <?php echo e(old('jenis_kelamin') == 'Laki-laki' ? 'selected' : ''); ?>>Laki-laki</option>
                <option value="Perempuan" <?php echo e(old('jenis_kelamin') == 'Perempuan' ? 'selected' : ''); ?>>Perempuan</option>
            </select>
            </div>
            <div>
            <label for="tanggal_lahir" class="block mb-2 text-sm font-semibold">Tanggal Lahir</label>
            <input type="date" id="tanggal_lahir" name="tanggal_lahir"
                class="w-full border-2 border-gray-300 focus:border-blue-600 focus:ring-2 focus:ring-blue-100 rounded-lg text-sm transition-all duration-200"
                required value="<?php echo e(old('tanggal_lahir')); ?>">
            </div>
            <div>
            <label for="agama" class="block mb-2 text-sm font-semibold">Agama</label>
            <input type="text" id="agama" name="agama"
                class="w-full border-2 border-gray-300 focus:border-blue-600 focus:ring-2 focus:ring-blue-100 rounded-lg text-sm transition-all duration-200"
                value="<?php echo e(old('agama')); ?>">
            </div>
            <div>
            <label for="jabatan_fungsional" class="block mb-2 text-sm font-semibold">Jabatan Fungsional</label>
            <input type="text" id="jabatan_fungsional" name="jabatan_fungsional"
                class="w-full border-2 border-gray-300 focus:border-blue-600 focus:ring-2 focus:ring-blue-100 rounded-lg text-sm transition-all duration-200"
                value="<?php echo e(old('jabatan_fungsional')); ?>">
            </div>
            <div>
            <label for="no_telp" class="block mb-2 text-sm font-semibold">No. Telepon</label>
            <input type="text" id="no_telp" name="no_telp"
                class="w-full border-2 border-gray-300 focus:border-blue-600 focus:ring-2 focus:ring-blue-100 rounded-lg text-sm transition-all duration-200"
                required value="<?php echo e(old('no_telp')); ?>">
            </div>
            <div>
                <label for="gol_ruang" class="block mb-2 text-sm font-semibold">Gol/Ruang</label>
                <input type="text" id="gol_ruang" name="gol_ruang"
                    class="w-full border-2 border-gray-300 focus:border-blue-600 focus:ring-2 focus:ring-blue-100 rounded-lg text-sm transition-all duration-200"
                    value="<?php echo e(old('gol_ruang')); ?>">
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 w-full">
                <div>
                    <label for="select-provinsi" class="block mb-2 text-sm font-semibold">Provinsi</label>
                    <select name="provinsi" id="select-provinsi" class="w-full border-2 border-gray-300 focus:border-blue-600 focus:ring-2 focus:ring-blue-100 rounded-lg text-sm transition-all duration-200" required>
                        <?php $__currentLoopData = $provinsiList ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $provinsi): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($provinsi->id); ?>" <?php echo e(old('provinsi') == $provinsi->id ? 'selected' : ''); ?>><?php echo e($provinsi->nama); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                <input type="hidden" name="provinsi_id" id="provinsi-id">
                </div>
                <div>
                    <label for="select-kabupaten" class="block mb-2 text-sm font-semibold">Kabupaten/Kota</label>
                    <select name="kabupaten_kota" id="select-kabupaten" class="w-full border-2 border-gray-300 focus:border-blue-600 focus:ring-2 focus:ring-blue-100 rounded-lg text-sm transition-all duration-200" required>
                        <?php if(old('provinsi') && isset($kabupatenList)): ?>
                            <?php $__currentLoopData = $kabupatenList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $kabupaten): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($kabupaten->id); ?>" <?php echo e(old('kabupaten_kota') == $kabupaten->id ? 'selected' : ''); ?>><?php echo e($kabupaten->nama); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php endif; ?>
                    </select>
                </div>
            </div>  
            <div>
            <label for="password" class="block mb-2 text-sm font-semibold">Password</label>
            <input type="password" id="password" name="password"
                class="w-full border-2 border-gray-300 focus:border-blue-600 focus:ring-2 focus:ring-blue-100 rounded-lg text-sm transition-all duration-200"
                required>
            </div>
            <div>
            <label for="password_confirmation" class="block mb-2 text-sm font-semibold">Konfirmasi Password</label>
            <input type="password" id="password_confirmation" name="password_confirmation"
                class="w-full border-2 border-gray-300 focus:border-blue-600 focus:ring-2 focus:ring-blue-100 rounded-lg text-sm transition-all duration-200"
                required>
            </div>
        </div>
        <div class="col-span-1 md:col-span-2">
            <label for="asal_instansi" class="block mb-2 text-sm font-semibold">Asal Instansi</label>
            <input type="text" id="asal_instansi" name="asal_instansi"
            class="w-full border-2 border-gray-300 focus:border-blue-600 focus:ring-2 focus:ring-blue-100 rounded-lg text-sm transition-all duration-200"
            value="<?php echo e(old('asal_instansi')); ?>">
        </div>
        <div class="col-span-1 md:col-span-2">
            <label for="unit_kerja" class="block mb-2 text-sm font-semibold">Unit Kerja</label>
            <input type="text" id="unit_kerja" name="unit_kerja"
            class="w-full border-2 border-gray-300 focus:border-blue-600 focus:ring-2 focus:ring-blue-100 rounded-lg text-sm transition-all duration-200"
            value="<?php echo e(old('unit_kerja')); ?>">
        </div>
        <div class="col-span-1 md:col-span-2">
            <label for="pas_foto" class="block mb-2 text-sm font-semibold">Pas Foto (JPG, PNG, maks 2MB)</label>
            <input type="file" id="pas_foto" name="pas_foto"
            class="w-full border-2 border-gray-300 focus:border-blue-600 focus:ring-2 focus:ring-blue-100 rounded-lg text-sm p-2 transition-all duration-200"
            required>
        </div>
        <div class="col-span-1 md:col-span-2">
            <label for="bukti_pembayaran" class="block mb-2 text-sm font-semibold">Bukti Pembayaran (JPG, PNG, PDF, maks 2MB)</label>
            <input type="file" id="bukti_pembayaran" name="bukti_pembayaran"
            class="w-full border-2 border-gray-300 focus:border-blue-600 focus:ring-2 focus:ring-blue-100 rounded-lg text-sm p-2 transition-all duration-200"
            required>
        </div>

        <button type="submit" class="w-full bg-[var(--blue-dark)] text-white font-semibold py-3 rounded-lg hover:bg-opacity-90 transition">Kirim Permohonan Pendaftaran</button>
    </form>
</section>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
        // Inisialisasi Select2
        $('#select-provinsi').select2({
            width: '100%'
        });
        $('#select-kabupaten').select2({
            width: '100%'
        });

       // Mengambil data Provinsi
        $.getJSON('https://ibnux.github.io/data-indonesia/provinsi.json', function(data) {
            $('#select-provinsi').empty().append('<option value=""></option>'); 
            $.each(data, function(index, provinsi) {
                // Di sini kita tetap menggunakan nama provinsi sebagai value untuk ditampilkan
                $('#select-provinsi').append(new Option(provinsi.nama, provinsi.nama));
            });
        });

        // Event listener saat provinsi berubah
        $('#select-provinsi').on('change', function() {
            var namaProvinsi = $(this).val();
            $('#select-kabupaten').empty().append('<option value="">Memuat...</option>').trigger('change');

            $.getJSON('https://ibnux.github.io/data-indonesia/provinsi.json', function(data) {
                // Cari provinsi yang dipilih untuk mendapatkan ID-nya
                var provinsiDipilih = data.find(p => p.nama === namaProvinsi);

                if (provinsiDipilih) {
                    // FIX: Simpan ID provinsi ke input tersembunyi
                    $('#provinsi-id').val(provinsiDipilih.id);

                    $.getJSON('https://ibnux.github.io/data-indonesia/kabupaten/' + provinsiDipilih.id + '.json', function(kabupatenData) {
                        $('#select-kabupaten').empty().append('<option value=""></option>'); 
                        $.each(kabupatenData, function(index, kabupaten) {
                            $('#select-kabupaten').append(new Option(kabupaten.nama, kabupaten.nama));
                        });
                    });
                }
            });
        }); 
    });
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\himpesda-web\resources\views/pages/pendaftaran.blade.php ENDPATH**/ ?>