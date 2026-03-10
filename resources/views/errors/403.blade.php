<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>403 - Akses Ditolak</title>
    <link rel="icon" type="image/png" href="{{ asset('assets/img/himpesda_logo.png') }}" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body { font-family: 'Open Sans', sans-serif; }
    </style>
</head>
<body class="bg-gray-50 flex items-center justify-center min-h-screen">
    <div class="text-center px-6 py-12 bg-white rounded-2xl shadow-xl max-w-lg mx-4 border-t-4 border-orange-500">
        <img src="{{ asset('assets/img/himpesda_logo.png') }}" alt="HIMPESDA Logo" class="h-24 mx-auto mb-6 grayscale opacity-80">
        <h1 class="text-6xl font-bold text-orange-500 mb-2">403</h1>
        <h2 class="text-2xl font-semibold text-gray-600 mb-4">Akses Ditolak</h2>
        <p class="text-gray-500 mb-8 leading-relaxed">
            Maaf, Anda tidak memiliki izin (hak akses) untuk melihat halaman ini. Silakan hubungi Administrator jika Anda merasa ini adalah sebuah kesalahan.
        </p>
        <a href="{{ url('/') }}" class="inline-block px-6 py-3 text-sm font-bold text-white bg-blue-600 hover:bg-blue-700 rounded-lg shadow-md transition-all duration-200">
            Kembali ke Beranda
        </a>
    </div>
</body>
</html>
