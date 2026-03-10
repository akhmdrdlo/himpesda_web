<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>500 - Kesalahan Sistem</title>
    <link rel="icon" type="image/png" href="{{ asset('assets/img/himpesda_logo.png') }}" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body { font-family: 'Open Sans', sans-serif; }
    </style>
</head>
<body class="bg-gray-50 flex items-center justify-center min-h-screen">
    <div class="text-center px-6 py-12 bg-white rounded-2xl shadow-xl max-w-lg mx-4 border-t-4 border-red-600">
        <img src="{{ asset('assets/img/himpesda_logo.png') }}" alt="HIMPESDA Logo" class="h-24 mx-auto mb-6 grayscale opacity-60">
        <h1 class="text-6xl font-bold text-red-600 mb-2">500</h1>
        <h2 class="text-2xl font-semibold text-gray-700 mb-4">Kesalahan Server Internal</h2>
        <p class="text-gray-500 mb-8 leading-relaxed">
            Ups! Terjadi kesalahan pada sistem pemrosesan kami. Administrator telah diberitahu dan sedang berusaha memperbaiki masalah ini secepat mungkin.
        </p>
        <a href="{{ url('/') }}" class="inline-block px-6 py-3 text-sm font-bold text-gray-700 bg-gray-200 hover:bg-gray-300 rounded-lg shadow-md transition-all duration-200">
            Kembali ke Beranda
        </a>
    </div>
</body>
</html>
