<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ekspor Semua Kartu Anggota</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,600,700&display=swap" rel="stylesheet" />
    <style>
        body {
            background-color: #e2e8f0; /* bg-slate-200 */
            font-family: 'Inter', sans-serif;
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }
        .card-container {
            width: 204px; /* 53.98mm */
            height: 323px; /* 85.6mm */
        }
        @media print {
            @page {
                size: A4; /* Mengatur ukuran kertas A4 */
                margin: 1cm; /* Memberi margin pada halaman cetak */
            }
            body {
                background-color: #fff;
                margin: 0;
                padding: 0;
            }
            .no-print {
                display: none;
            }
            .printable-area {
                display: grid;
                grid-template-columns: repeat(2, 1fr); /* 2 kartu per baris */
                gap: 10px;
                width: 100%;
            }
            .card-wrapper {
                page-break-inside: avoid; /* Mencegah kartu terpotong antar halaman */
                display: flex;
                gap: 10px;
                margin-bottom: 10px;
            }
            .card-container {
                box-shadow: none;
                border: 1px solid #eee;
            }
        }
    </style>
</head>
<body class="flex flex-col items-center min-h-screen p-8">

    <div class="mb-8 no-print w-full max-w-7xl">
        <div class="bg-white p-4 rounded-lg shadow-md flex justify-between items-center">
            <div>
                <h1 class="text-xl font-bold">Ekspor Kartu Anggota</h1>
                <p class="text-sm text-gray-600">Total Anggota: {{ count($users) }}. Halaman ini siap untuk dicetak.</p>
            </div>
            <div>
                <button onclick="window.print()" class="px-6 py-2 font-semibold text-white bg-blue-600 rounded-lg shadow-md hover:bg-blue-700">
                    Cetak Semua Kartu
                </button>
                <a href="{{ url()->previous() }}" class="px-6 py-2 font-semibold text-gray-700 bg-gray-200 rounded-lg hover:bg-gray-300 ml-2">
                    Kembali
                </a>
            </div>
        </div>
    </div>

    <div class="w-full max-w-7xl printable-area">
        @foreach($users as $user)
            @php
                $tahunDibuat = \Carbon\Carbon::parse($user->created_at)->year;
                $tahunBerakhir = $tahunDibuat + 3;
                $periode = $tahunDibuat . ' - ' . $tahunBerakhir;
                $expiryDate = "31 Desember " . $tahunBerakhir;
            @endphp
            
            <div class="card-wrapper">
                <!-- Card Front (Vertical) -->
                <div class="card-container bg-gray-900 rounded-xl shadow-lg overflow-hidden relative flex flex-col">
                    <!-- Background Shapes -->
                    <div class="absolute top-0 left-0 w-full h-full">
                        <svg width="204" height="323" viewBox="0 0 204 280" fill="none" xmlns="http://www.w3.org/2000/svg" class="absolute w-full h-full" preserveAspectRatio="none">
                            <path d="M0 0 H204 V70 C170 95, 80 65, 0 85 Z" fill="#00529B"/>
                            <path d="M0 323 H204 V260 C120 240, 80 270, 0 250 Z" fill="#FFD700"/>
                        </svg>
                    </div>
                    
                    <!-- Card Content -->
                    <div class="relative z-10 p-4 flex flex-col h-full">
                        <!-- Header -->
                        <div class="flex items-center space-x-2">
                            <div class="w-10 h-10 bg-white rounded-full p-1 flex-shrink-0"><img src="{{ asset('assets/img/himpesda_logo.png') }}" alt="Logo"></div>
                            <div>
                                <p class="text-white font-bold text-base leading-tight">HIMPESDA</p>
                                <p class="text-blue-200 text-[8px] leading-tight">Himpunan Profesional Pengelola Sumber Daya Air</p>
                            </div>
                        </div>

                        <!-- Main Content -->
                        <div class="flex-grow flex flex-col items-center justify-center text-center">
                            <div class="bg-red-600 p-1 rounded-md shadow-lg">
                            <div class="w-[84px] h-[100px] overflow-hidden rounded-sm">
                                <img src="{{ asset('storage/' . $user->pas_foto) }}" alt="Pas Foto" class="w-full h-full object-cover">
                            </div>
                            </div>
                            <div class="text-white mt-3">
                                <p class="font-bold text-sm tracking-wide">{{ $user->nama_lengkap }}</p>
                                <div class="mt-2 text-[10px] space-y-1">
                                    <p>
                                        <span class="opacity-80">No. Anggota</span>
                                        <span class="font-semibold">: {{ $user->nomor_anggota ?? 'N/A' }}</span>
                                    </p>
                                    <p>
                                        <span class="opacity-80">Cabang</span>
                                        <span class="font-semibold">: {{ strtoupper($user->cabang_display) }}</span> 
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Card Back (Vertical) -->
                <div class="card-container bg-white rounded-xl shadow-lg overflow-hidden relative flex flex-col">
                    <!-- Background Shapes -->
                    <div class="absolute top-0 left-0 w-full h-full">
                        <svg width="204" height="323" viewBox="0 0 204 323" fill="none" xmlns="http://www.w3.org/2000/svg" class="absolute w-full h-full" preserveAspectRatio="none">
                            <path d="M0 0 H204 V20 C150 40, 50 10, 0 25 Z" fill="#FFD700"/>
                            <path d="M0 323 H204 V280 C150 260, 50 300, 0 290 Z" fill="#00529B"/>
                        </svg>
                    </div>
                    <div class="relative z-10 flex flex-col h-full">
                        <div class="bg-gray-800 text-white font-bold text-center py-1.5 text-xs tracking-widest">
                            KARTU TANDA ANGGOTA
                        </div>
                        <div class="p-4 flex flex-col h-full">
                            <div class="text-center my-1">
                                <div class="w-8 h-8 bg-white rounded-full p-0.5 mx-auto shadow-sm inline-block"><img src="{{ asset('assets/img/himpesda_logo.png') }}" alt="Logo"></div>
                                <p class="text-gray-800 font-bold text-xs leading-tight mt-1">HIMPESDA</p>
                                <p class="text-gray-500 text-[8px] leading-tight">Himpunan Profesional Pengelola Sumber Daya Air</p>
                            </div>
                            <div class="text-[9px] text-gray-700 space-y-2 mt-4 flex-grow">
                                <p>1. Kartu ini berlaku selama pemegang kartu ini menjadi Anggota dan Pengurus HIMPESDA {{ $periode }}.</p>
                                <p>2. Jika kartu ini hilang/rusak harap dapat segera menghubungi Sekretariat HIMPESDA.</p>
                                <p>3. Terima kasih bagi yang menemukan kartu ini harap dapat menghubungi Sekretariat HIMPESDA.</p>
                            </div>
                            <div class="text-center mt-2">
                                <p class="text-[9px] text-white">Kartu ini berlaku sampai dengan</p>
                                <p class="font-bold text-xs text-white">{{ $expiryDate }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

</body>
</html>
