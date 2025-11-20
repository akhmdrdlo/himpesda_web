<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ekspor Kartu Anggota - Bulk</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #e2e8f0; /* bg-slate-200 */
            -webkit-print-color-adjust: exact !important;
            print-color-adjust: exact !important;
        }

        /* Ukuran Kartu Vertikal Standar CR-80 */
        .id-card {
            width: 53.98mm;
            height: 85.6mm;
            position: relative;
            overflow: hidden;
            background-color: white;
            border: 1px solid #cbd5e1; /* Border tipis untuk panduan potong */
        }

        /* Kontainer per Anggota (Depan + Belakang) */
        .member-row {
            display: flex;
            gap: 2mm; /* Jarak lipat antara depan dan belakang */
            justify-content: center;
            margin-bottom: 5mm; /* Jarak antar anggota ke bawah */
            break-inside: avoid; /* Mencegah kartu terpotong beda halaman */
            page-break-inside: avoid;
        }

        /* Pattern Background */
        .bg-pattern {
            background-image: radial-gradient(#ffffff 15%, transparent 16%), radial-gradient(#ffffff 15%, transparent 16%);
            background-size: 10px 10px;
            background-position: 0 0, 5px 5px;
            opacity: 0.1;
        }

        @media print {
            body {
                background-color: white;
                margin: 0;
                padding: 5mm; /* Margin aman printer */
            }
            .no-print {
                display: none !important;
            }
            .id-card {
                box-shadow: none; /* Hilangkan bayangan saat print untuk hemat tinta */
                border: 1px dashed #94a3b8; /* Garis putus-putus halus untuk potong */
            }
            .member-row {
                margin-bottom: 5mm;
            }
        }
    </style>
</head>
<body class="py-10">

    @php
        $totalMembers = $users->count();
        $pusatCount = $users->filter(function($u){
            return in_array($u->level, ['admin','operator','bendahara']) || (($u->tipe_anggota ?? '') === 'pusat');
        })->count();
        $daerahCount = $totalMembers - $pusatCount;
    @endphp

    <div class="no-print fixed top-6 right-6 z-50 bg-white/90 backdrop-blur-sm border border-slate-200 rounded-lg shadow-lg p-3 w-80 flex items-start gap-3">
        <div class="flex-1">
            <div class="flex items-center justify-between">
                <div>
                    <div class="text-xs text-slate-500 uppercase tracking-wide">Ringkasan Cetak</div>
                    <div class="mt-1 text-sm font-semibold text-slate-800 flex items-center gap-2">
                        <i class="fas fa-users text-yellow-500"></i>
                        <span>{{ $totalMembers }} Anggota</span>
                    </div>
                </div>
                <div class="text-xs text-slate-400">PDF / Print</div>
            </div>

            <div class="mt-3 grid grid-cols-2 gap-2 text-[12px]">
                <div class="flex items-center gap-2">
                    <div class="w-8 h-8 flex items-center justify-center rounded bg-slate-100 text-slate-700">
                        <i class="fas fa-city"></i>
                    </div>
                    <div>
                        <div class="text-[11px] text-slate-500">Pusat</div>
                        <div class="font-medium text-slate-800">{{ $pusatCount }}</div>
                    </div>
                </div>

                <div class="flex items-center gap-2">
                    <div class="w-8 h-8 flex items-center justify-center rounded bg-slate-100 text-slate-700">
                        <i class="fas fa-map-marker-alt"></i>
                    </div>
                    <div>
                        <div class="text-[11px] text-slate-500">Daerah</div>
                        <div class="font-medium text-slate-800">{{ $daerahCount }}</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="flex flex-col gap-2">
            <button onclick="window.print()" class="flex items-center px-3 py-2 bg-yellow-500 text-white rounded-md shadow hover:bg-yellow-600 text-sm" aria-label="Cetak daftar anggota">
                <i class="fas fa-print mr-2"></i> Cetak
            </button>
            <button onclick="window.close()" class="flex items-center px-3 py-2 bg-slate-50 text-slate-700 rounded-md border border-slate-200 hover:bg-slate-100 text-sm" aria-label="Tutup jendela">
                <i class="fas fa-times mr-2"></i> Tutup
            </button>
        </div>
    </div>

    <div class="max-w-[210mm] mx-auto bg-white min-h-screen p-4 shadow-xl print:shadow-none print:p-0">
        
        @foreach($users as $user)
            @php
                // Logika Data (Sama seperti single card)
                $createdAt = \Carbon\Carbon::parse($user->activated_at ?? $user->created_at);
                $expiryDate = "31 Des " . ($createdAt->year + 3);

                $isPusat = in_array($user->level, ['admin', 'operator', 'bendahara']) || $user->tipe_anggota == 'pusat';
                $cabangText = $isPusat ? 'PUSAT (NASIONAL)' : strtoupper($user->provinsi ?? 'DAERAH');
            @endphp

            <div class="member-row">  
                <div class="id-card rounded-xl flex flex-col">
                    <div class="absolute inset-0 bg-gradient-to-br from-slate-900 to-slate-800 z-0"></div>
                    <div class="absolute inset-0 bg-pattern z-0"></div>
                    
                    <div class="absolute -bottom-10 -right-10 w-40 h-40 opacity-10 z-0 rotate-12">
                        <img src="{{ asset('assets/img/himpesda_logo.png') }}" class="w-full h-full object-contain grayscale">
                    </div>

                    <div class="absolute top-0 right-0 w-24 h-24 bg-yellow-500 rounded-bl-full opacity-90 z-10" style="clip-path: circle(70% at 100% 0);"></div>
                    <div class="absolute bottom-0 left-0 w-full h-2 bg-gradient-to-r from-yellow-500 to-yellow-300 z-10"></div>

                    <div class="relative z-20 flex flex-col h-full text-white p-4">
                        
                        <div class="flex items-center gap-2 mb-3">
                            <div class="w-10 h-10 bg-white rounded-full p-1 flex items-center justify-center shadow-md shrink-0">
                                <img src="{{ asset('assets/img/himpesda_logo.png') }}" alt="Logo" class="w-full h-full object-contain">
                            </div>
                            <div>
                                <h1 class="font-black text-sm tracking-wider leading-tight">HIMPESDA</h1>
                                <p class="text-[6px] text-slate-300 leading-tight uppercase tracking-wide">Himpunan Profesional Pengelola<br>Sumber Daya Air</p>
                            </div>
                        </div>

                        <div class="flex justify-center mb-3">
                            <div class="w-24 h-24 rounded-full border-4 border-yellow-500 shadow-xl overflow-hidden bg-slate-200">
                                @if($user->pas_foto)
                                    <img src="{{ asset('storage/' . $user->pas_foto) }}" class="w-full h-full object-cover">
                                @else
                                    <img src="{{ asset('assets/img/team-2.jpg') }}" class="w-full h-full object-cover grayscale">
                                @endif
                            </div>
                        </div>

                        <div class="text-center flex-grow">
                            <h2 class="font-bold text-sm uppercase leading-tight mb-1 drop-shadow-md">
                                {{ Str::limit($user->nama_lengkap, 35) }}
                            </h2>
                            <p class="text-[8px] font-semibold text-yellow-400 tracking-widest uppercase mb-3">
                                {{ $user->jabatan_fungsional ?? 'ANGGOTA' }}
                            </p>

                            <div class="inline-block bg-white/10 backdrop-blur-sm px-3 py-1 rounded border border-white/20">
                                <p class="text-[7px] text-slate-300 uppercase tracking-wider mb-0.5">Nomor Anggota</p>
                                <p class="font-mono font-bold text-sm tracking-widest leading-none">{{ $user->nomor_anggota ?? 'PENDING' }}</p>
                            </div>
                        </div>

                        <div class="mt-auto pt-2 text-center">
                            <p class="text-[7px] uppercase text-slate-400 tracking-widest">Wilayah / Cabang</p>
                            <p class="font-bold text-[9px] text-white uppercase">{{ Str::limit($cabangText, 30) }}</p>
                        </div>
                    </div>
                </div>

                <div class="id-card rounded-xl flex flex-col bg-white relative border border-slate-200">
                    
                    <div class="bg-slate-900 h-10 w-full flex items-center justify-center relative overflow-hidden">
                        <div class="absolute inset-0 bg-pattern opacity-20"></div>
                        <p class="text-white text-[10px] font-bold tracking-[0.2em] z-10 uppercase">Kartu Tanda Anggota</p>
                    </div>

                    <div class="p-4 flex flex-col h-full bg-[url('{{ asset('assets/img/himpesda_logo.png') }}')] bg-no-repeat bg-center bg-[length:80%]">
                        <div class="absolute inset-0 bg-white/90"></div>

                        <div class="relative z-10 flex flex-col h-full text-center">
                            
                            <div class="text-[7px] text-slate-600 text-justify leading-relaxed space-y-1.5 mb-3">
                                <p>1. Kartu ini adalah bukti sah keanggotaan HIMPESDA.</p>
                                <p>2. Segala fasilitas dan hak anggota berlaku selama kartu ini masih aktif.</p>
                                <p>3. Apabila kartu ini ditemukan, mohon dikembalikan ke Sekretariat HIMPESDA atau hubungi kontak di bawah.</p>
                            </div>

                            <div class="flex-grow flex flex-col items-center justify-center">
                                <div class="w-full border-t border-slate-100 my-2"></div>
                                <p class="text-[6px] text-slate-400 italic">HIMPESDA Membership Card</p>
                            </div>

                            <div class="mt-auto flex justify-between items-end text-left w-full">
                                <div>
                                    <p class="text-[6px] text-slate-400 uppercase">Berlaku Hingga</p>
                                    <p class="text-[10px] font-bold text-slate-800">{{ $expiryDate }}</p>
                                </div>
                                <div class="text-right">
                                    <p class="text-[5px] text-slate-400 uppercase tracking-wider">Nomor KTA</p>
                                    <p class="text-[10px] font-black text-slate-800 tracking-widest font-mono">{{ $user->nomor_anggota ?? '---' }}</p>
                                </div>
                            </div>

                            <div class="mt-3 pt-1 border-t border-slate-100">
                                <p class="text-[6px] text-slate-500 font-mono">www.himpesda.or.id | info@himpesda.or.id</p>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        @endforeach

    </div>
</body>
</html>