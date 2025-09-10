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
            background-color: #e2e8f0; /* bg-slate-200 */
            font-family: 'Inter', sans-serif;
        }
        .card-container {
            /* Ukuran ID Card vertikal standar (CR80): 54mm x 85.6mm */
            width: 212px;   /* 54mm x 3.94px/mm ≈ 213px @ 96dpi */
            height: 336px;  /* 85.6mm x 3.94px/mm ≈ 337px @ 96dpi */
        }
        @media print {
            body {
            background-color: #fff;
            }
            .no-print {
            display: none;
            }
            @page {
            size: auto;
            margin: 0mm;
            }
            .printable-area {
            margin: 0;
            padding: 0;
            }
            .card-container {
            box-shadow: none;
            border: 1px solid #eee;
            break-inside: avoid;
            }
        }
        </style>
</head>
<body class="flex flex-col items-center justify-center min-h-screen p-8 printable-area">

    <div class="mb-8 no-print">
        <button onclick="window.print()" class="px-6 py-2 font-semibold text-white bg-blue-600 rounded-lg shadow-md hover:bg-blue-700">
            <i class="fas fa-print mr-2"></i>Cetak Kartu
        </button>
        <a href="{{ url()->previous() }}" class="px-6 py-2 font-semibold text-gray-700 bg-gray-200 rounded-lg hover:bg-gray-300">
            Kembali
        </a>
    </div>

    <div class="flex flex-wrap justify-center gap-8">

        <div class="card-container bg-gray-800 rounded-2xl shadow-lg overflow-hidden relative flex flex-col">
            <div class="absolute top-0 left-0 w-full h-full">
                <svg viewBox="0 0 323 204" class="absolute w-full h-full" preserveAspectRatio="none">
                    <path d="M0,0 C150,150 150,50 323,80 L323,0 Z" fill="#00529B"/>
                    <path d="M0,204 C50,150 200,220 323,150 L323,204 Z" fill="#FFD700"/>
                </svg>
            </div>
            
            <div class="relative z-10 p-4 flex flex-col flex-grow">
                <div class="flex items-center space-x-2">
                    <div class="w-10 h-10 bg-white rounded-full p-1"><img src="{{ asset('assets/img/logo-ct-dark.png') }}" alt="Logo"></div>
                    <div>
                        <p class="text-white font-bold text-lg leading-tight">HIMPESDA</p>
                        <p class="text-blue-200 text-[10px] leading-tight">Himpunan Profesional Pengelola Sumber Daya Air</p>
                    </div>
                </div>
                <div class="flex-grow flex items-center justify-center">
                    <div class="flex flex-col items-center w-full">
                        <div class="w-20 h-20 border-2 border-white rounded-md overflow-hidden shadow-md mb-2">
                            <img src="{{ asset('storage/' . $user->pas_foto) }}" alt="Pas Foto" class="w-full h-full object-cover">
                        </div>
                        <p class="text-white font-bold text-base text-center">{{ $user->nama_lengkap }}</p>
                        <p class="text-blue-200 text-xs text-center">{{ $user->jabatan_fungsional ?? '' }}</p>
                    </div>
                </div>
                <div class="text-white text-xs flex justify-between">
                    <div>
                        <p class="opacity-100">Unit Kerja</p>
                        <p class="font-semibold">{{$user->unit_kerja??'Karyawan'}}</p>
                    </div>
                    <div class="text-right">
                        <p class="opacity-100">No. Anggota</p>
                        <p class="font-semibold">{{ $user->nomor_anggota ?? 'N/A' }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="card-container bg-white rounded-2xl shadow-lg overflow-hidden relative flex flex-col">
            <div class="absolute top-0 left-0 w-full h-full">
                <svg viewBox="0 0 323 204" class="absolute w-full h-full" preserveAspectRatio="none">
                    <path d="M0,0 C50,80 200,20 323,40 L323,0 Z" fill="#FFD700"/>
                    <path d="M0,204 C80,170 240,190 323,204 L0,204 Z" fill="#00529B" opacity="0.7"/>
                </svg>
            </div>
            <div class="relative z-10 p-4 flex flex-col h-full">
                <div class="bg-gray-800 text-white font-bold text-center py-1 text-xs tracking-widest">
                    KARTU TANDA ANGGOTA
                </div>
                <div class="text-center my-2">
                    <div class="w-10 h-10 bg-white rounded-full p-1 mx-auto shadow-sm"><img src="{{ asset('assets/img/logo-ct-dark.png') }}" alt="Logo"></div>
                    <p class="text-gray-800 font-bold text-sm leading-tight mt-1">HIMPESDA</p>
                    <p class="text-gray-500 text-[10px] leading-tight">Himpunan Profesional Pengelola Sumber Daya Air</p>
                </div>
                <div class="text-[9px] text-gray-700 space-y-1 mt-1 flex-grow">
                    <p>1. Kartu ini berlaku selama pemegang kartu ini menjadi Anggota dan Pengurus HIMPESDA</p>
                    <p>2. Jika kartu ini hilang/rusak harap dapat segera menghubungi Sekretariat HIMPESDA.</p>
                    <p>3. Terima kasih bagi yang menemukan kartu ini harap dapat menghubungi Sekretariat HIMPESDA.</p>
                </div>
                <div class="text-center">
                    <p class="text-[9px] text-gray-600">Kartu ini berlaku sampai dengan</p>
                    <p class="font-bold text-xs text-gray-800">
                        {{ \Carbon\Carbon::parse($user->created_at)->addYears(5)->locale('id')->isoFormat('D MMMM YYYY') }}
                    </p>
                </div>
            </div>
        </div>

    </div>

</body>
</html>