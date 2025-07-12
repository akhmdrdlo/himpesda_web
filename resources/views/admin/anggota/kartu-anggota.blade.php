<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Kartu Anggota - {{ $user->nama_lengkap }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,600,700&display=swap" rel="stylesheet" />
    <style>
        body {
            background-color: #082955; /* bg-slate-200 */
            font-family: 'Inter', sans-serif;
        }
        @page {
            size: A4 portrait;
            margin: 0;
        }
        @media print {
            html, body {
                width: 210mm;
                height: 297mm;
                background: #fff !important;
                margin: 0 !important;
                padding: 0 !important;
                box-shadow: none !important;
            }
            body {
                background-color: #fff !important;
            }
            .no-print {
                display: none !important;
            }
            .printable-page {
                width: 100vw !important;
                height: 100vh !important;
                min-height: 100vh !important;
                page-break-after: always;
                box-shadow: none !important;
                border: none !important;
                margin: 0 !important;
                padding: 0 !important;
                display: flex;
                align-items: center;
                justify-content: center;
            }
            .flex.flex-col.items-center.justify-center.space-y-8 {
                width: 100vw !important;
                min-height: 100vh !important;
                margin: 0 !important;
                padding: 0 !important;
                display: flex;
                flex-direction: column;
                align-items: center;
                justify-content: center;
            }
        }
        .card-vertical {
            width: 20rem; /* 320px */
            height: 32rem; /* 512px */
        }
    </style>
</head>
<body class="bg-slate-200">

    <div class="no-print p-8 text-center">
        <button onclick="window.print()" class="px-6 py-2 font-semibold text-white bg-blue-600 rounded-lg shadow-md hover:bg-blue-700">
            <i class="fas fa-print mr-2"></i>Cetak atau Simpan sebagai PDF
        </button>
        <a href="{{ url()->previous() }}" class="px-6 py-2 font-semibold text-gray-700 bg-gray-200 rounded-lg hover:bg-gray-300">
            Kembali
        </a>
    </div>

    <div class="flex flex-col items-center justify-center space-y-8">
        <div class="printable-page flex items-center justify-center">
            <div class="card-vertical bg-gray-800 rounded-2xl shadow-lg overflow-hidden relative flex flex-col">
                <div class="absolute top-0 left-0 w-full h-full">
                    <svg viewBox="0 0 320 512" class="absolute w-full h-full" preserveAspectRatio="none">
                        <path d="M0,0 C200,200 150,250 320,220 L320,0 Z" fill="#00529B"/>
                        <path d="M0,512 C100,400 250,550 320,400 L320,512 Z" fill="#FFD700"/>
                    </svg>
                </div>
                <div class="relative z-10 p-6 flex flex-col h-full">
                    <div class="flex items-center space-x-3">
                        <div class="w-12 h-12 bg-white rounded-full p-1 shadow-md"><img src="{{ asset('assets/img/logo-ct-dark.png') }}" alt="Logo"></div>
                        <div>
                            <p class="text-white font-bold text-xl leading-tight">HIMPESDA</p>
                            <p class="text-blue-200 text-xs leading-tight">Himpunan Profesional Pengelola Sumber Daya Air</p>
                        </div>
                    </div>
                    
                    <div class="flex-grow flex flex-col items-center justify-center text-center mt-8">
                        <div class="w-32 h-40 border-4 border-white rounded-lg overflow-hidden shadow-lg">
                            <img src="{{ $user->pas_foto ? asset('storage/' . $user->pas_foto) : asset('assets/img/team-1.jpg') }}" alt="Pas Foto" class="w-full h-full object-cover">
                        </div>
                        <h2 class="text-white font-bold text-2xl mt-4">{{ $user->nama_lengkap }}</h2>
                        <p class="text-yellow-300 font-semibold">{{ $user->jabatan_fungsional ?? 'Anggota' }}</p>
                    </div>

                    <div class="text-white text-sm flex justify-between">
                        <div>
                            <p class="opacity-80 text-xs">Cabang</p>
                            <p class="font-semibold">Pusat</p>
                        </div>
                        <div class="text-right">
                            <p class="opacity-80 text-xs">No. Anggota</p>
                            <p class="font-semibold">{{ $user->nomor_anggota ?? 'N/A' }}</p>
                        </div>
                    </div>
                </div>
                
            </div>
        </div>

        <div class="printable-page flex items-center justify-center">
            <div class="card-vertical bg-gray-800 rounded-2xl shadow-lg overflow-hidden relative flex flex-col">
                <div class="absolute top-0 left-0 w-full h-full">
                    <svg viewBox="0 0 320 512" class="absolute w-full h-full" preserveAspectRatio="none">
                        <path d="M0,0 C100,120 250,50 320,80 L320,0 Z" fill="#FFD700"/>
                        <path d="M0,512 C50,450 200,550 320,480 L320,512 Z" fill="#00529B"/>
                    </svg>
                </div>
                <div class="relative z-10 p-6 flex flex-col h-full">
                    <div class="bg-gray-800 text-white font-bold text-center py-2 text-sm tracking-widest rounded-t-lg -mx-6 -mt-6">
                        KARTU TANDA ANGGOTA
                    </div>
                    <div class="flex-grow flex flex-col justify-center text-center px-4">
                        <ol class="text-xs text-white space-y-4 text-left list-decimal list-inside">
                            <li>Kartu ini berlaku selama pemegang kartu ini menjadi Anggota dan Pengurus HIMPESDA 2024-2027.</li>
                            <li>Jika kartu ini hilang/rusak harap dapat segera menghubungi Sekretariat HIMPESDA.</li>
                            <li>Terima kasih bagi yang menemukan kartu ini harap dapat menghubungi Sekretariat HIMPESDA.</li>
                        </ol>
                    </div>
                    <div class="text-center">
                        <p class="text-xs text-white">Kartu ini berlaku sampai dengan</p>
                        <p class="font-bold text-sm text-white">31 Desember 2025</p>
                    </div>
                </div>
            </div>
        </div>

    </div>

</body>
</html>