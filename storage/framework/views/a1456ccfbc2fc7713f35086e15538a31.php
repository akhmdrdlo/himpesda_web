<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Kartu Anggota - <?php echo e($user->nama_lengkap); ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            background-color: #f8fafc;
        }
        @media print {
            body {
                background-color: #fff;
            }
            .no-print {
                display: none;
            }
            .printable-card {
                margin: 0;
                box-shadow: none;
                border: 1px solid #ddd;
            }
        }
    </style>
</head>
<body class="flex flex-col items-center justify-center min-h-screen p-8">

    <div class="mb-8 no-print">
        <button onclick="window.print()" class="px-6 py-2 text-white bg-blue-500 rounded-lg shadow-md hover:bg-blue-600">
            Cetak Kartu
        </button>
        <a href="<?php echo e(route('admin.profile.show')); ?>" class="px-6 py-2 text-gray-700 bg-gray-200 rounded-lg hover:bg-gray-300">
            Kembali ke Profil
        </a>
    </div>

    <div class="printable-card w-full max-w-lg bg-white rounded-2xl shadow-lg overflow-hidden font-sans">
        <div class="bg-blue-900 p-6 flex justify-between items-center">
            <div>
                <h1 class="text-white text-2xl font-bold">KARTU ANGGOTA</h1>
                <p class="text-blue-200 text-sm">Himpunan Profesional Pengelola Sumber Daya Air</p>
            </div>
            <div class="w-16 h-16 bg-white rounded-md p-1">
                 <img src="<?php echo e(asset('assets/img/logo-ct-dark.png')); ?>" alt="Logo">
            </div>
        </div>
        <div class="p-8 flex items-center space-x-6">
            <div class="flex-shrink-0">
                <img class="h-28 w-28 object-cover rounded-lg shadow-md" src="<?php echo e(asset('assets/img/team-1.jpg')); ?>" alt="Pas Foto">
            </div>
            <div>
                <h2 class="text-xl font-bold text-gray-800"><?php echo e($user->nama_lengkap); ?></h2>
                <p class="text-sm text-gray-500"><?php echo e($user->jabatan_fungsional ?? 'Anggota'); ?></p>
                <hr class="my-3">
                <div class="text-xs text-gray-600">
                    <p><strong class="font-semibold">No. Anggota:</strong> <?php echo e($user->nomor_anggota ?? 'N/A'); ?></p>
                    <p><strong class="font-semibold">Bergabung:</strong> <?php echo e($user->created_at->format('d F Y')); ?></p>
                </div>
            </div>
        </div>
        <div class="px-8 py-4 bg-gray-50 text-right">
            <p class="text-xs text-gray-400">Masa Berlaku: Seumur Hidup</p>
        </div>
    </div>

</body>
</html><?php /**PATH C:\laragon\www\himpesda-web\resources\views/admin/kartu-anggota.blade.php ENDPATH**/ ?>