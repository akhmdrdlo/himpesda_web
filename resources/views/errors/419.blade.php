<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>419 - Sesi Berakhir</title>
    <link rel="icon" type="image/png" href="{{ asset('assets/img/himpesda_logo.png') }}" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body { font-family: 'Open Sans', sans-serif; }
    </style>
</head>
<body class="bg-gray-50 flex items-center justify-center min-h-screen">
    <div class="text-center px-6 py-12 bg-white rounded-2xl shadow-xl max-w-lg mx-4 border-t-4 border-blue-400">
        <img src="{{ asset('assets/img/himpesda_logo.png') }}" alt="HIMPESDA Logo" class="h-24 mx-auto mb-6">
        <h1 class="text-6xl font-bold text-blue-400 mb-2"><i class="fas fa-clock"></i> 419</h1>
        <h2 class="text-2xl font-semibold text-gray-700 mb-4">Halaman Kedaluwarsa (Page Expired)</h2>
        <p class="text-gray-500 mb-8 leading-relaxed">
            Sesi keamanan Anda telah berakhir karena terlalu lama tidak ada aktivitas di halaman ini. Silakan muat ulang (refresh) halaman untuk melanjutkan.
        </p>
        <button onclick="window.location.reload();" class="inline-block px-6 py-3 mr-2 text-sm font-bold text-white bg-blue-600 hover:bg-blue-700 rounded-lg shadow-md transition-all duration-200">
            Muat Ulang Halaman
        </button>
        <a href="{{ url('/') }}" class="inline-block px-6 py-3 text-sm font-bold text-gray-700 bg-gray-200 hover:bg-gray-300 rounded-lg shadow-md transition-all duration-200">
            Ke Beranda
        </a>
    </div>
</body>
</html>
