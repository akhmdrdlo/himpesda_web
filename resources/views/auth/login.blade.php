<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="icon" type="image/png" href="{{ asset('assets/img/himpesda_logo.png') }}" />
  <title>Login Anggota - HIMPESDA</title>
  
  {{-- Fonts --}}
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  
  {{-- Icons --}}
  <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
  
  {{-- Tailwind CSS --}}
  <script src="https://cdn.tailwindcss.com"></script>
  
  <style>
    body { font-family: 'Inter', sans-serif; }
    
    /* Animasi Floating (Mengambang) */
    @keyframes float {
        0% { transform: translateY(0px) translateX(0px); }
        50% { transform: translateY(-20px) translateX(10px); }
        100% { transform: translateY(0px) translateX(0px); }
    }
    @keyframes float-reverse {
        0% { transform: translateY(0px) translateX(0px); }
        50% { transform: translateY(20px) translateX(-10px); }
        100% { transform: translateY(0px) translateX(0px); }
    }
    
    .animate-float { animation: float 6s ease-in-out infinite; }
    .animate-float-delayed { animation: float-reverse 7s ease-in-out infinite 1s; }
    .animate-float-slow { animation: float 8s ease-in-out infinite 2s; }

    /* Pattern Background */
    .bg-grid-pattern {
        background-image: radial-gradient(rgba(255, 255, 255, 0.1) 1px, transparent 1px);
        background-size: 20px 20px;
    }
  </style>
</head>

<body class="m-0 font-sans antialiased text-slate-500 bg-slate-50 selection:bg-blue-500 selection:text-white overflow-hidden">

  <div class="min-h-screen flex w-full">
    
    <div class="hidden lg:flex w-1/2 bg-slate-900 relative overflow-hidden items-center justify-center text-white">
        
        <div class="absolute inset-0 bg-gradient-to-br from-blue-900 via-slate-900 to-slate-900 z-0"></div>
        <div class="absolute inset-0 bg-grid-pattern opacity-20 z-0"></div>
        
        <div class="absolute top-1/4 left-1/4 w-72 h-72 bg-blue-500 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-float"></div>
        <div class="absolute bottom-1/4 right-1/4 w-72 h-72 bg-cyan-500 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-float-delayed"></div>
        <div class="absolute bottom-0 left-0 w-96 h-96 bg-indigo-600 rounded-full mix-blend-multiply filter blur-3xl opacity-10 animate-float-slow"></div>

        <div class="relative z-10 p-12 max-w-lg text-center">
            <div class="mb-8 flex justify-center">
                <div class="w-24 h-24 bg-white/10 backdrop-blur-md rounded-2xl p-4 shadow-2xl border border-white/10 flex items-center justify-center">
                    <img src="{{ asset('assets/img/himpesda_logo.png') }}" class="w-full h-full object-contain drop-shadow-lg" alt="HIMPESDA Logo">
                </div>
            </div>
            <h2 class="text-4xl font-bold mb-4 tracking-tight">HIMPESDA</h2>
            <p class="text-lg text-blue-100 leading-relaxed font-light">
                Himpunan Profesional Pengelola Sumber Daya Air. <br>
                Wadah sinergi untuk membangun masa depan air yang berkelanjutan.
            </p>
            
            <div class="mt-12 flex justify-center gap-2">
                <span class="w-2 h-2 bg-white rounded-full opacity-100"></span>
                <span class="w-2 h-2 bg-white rounded-full opacity-50"></span>
                <span class="w-2 h-2 bg-white rounded-full opacity-50"></span>
            </div>
        </div>
    </div>

    <div class="w-full lg:w-1/2 flex items-center justify-center relative bg-white">
        
        <div class="absolute top-0 right-0 w-64 h-64 bg-blue-50 rounded-full filter blur-3xl opacity-50 translate-x-1/2 -translate-y-1/2"></div>
        <div class="absolute bottom-0 left-0 w-64 h-64 bg-cyan-50 rounded-full filter blur-3xl opacity-50 -translate-x-1/2 translate-y-1/2"></div>

        <div class="w-full max-w-md p-8 relative z-10">
            
            <div class="lg:hidden text-center mb-8">
                <img src="{{ asset('assets/img/himpesda_logo.png') }}" class="h-16 mx-auto mb-4" alt="Logo">
                <h3 class="text-2xl font-bold text-slate-800">HIMPESDA</h3>
            </div>

            <a href="{{ route('home') }}" class="inline-flex items-center text-[var(--blue-dark)] hover:text-blue-700 mb-4">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                </svg>
                Kembali ke Dashboard
            </a>

            <div class="mb-8">
                <h3 class="text-3xl font-bold text-slate-800 mb-2">Selamat Datang! 👋</h3>
                <p class="text-slate-500">Silakan masuk ke akun Anda untuk melanjutkan.</p>
            </div>

            @if (session('status'))
                <div class="mb-4 p-4 rounded-lg bg-green-50 text-green-600 text-sm font-medium border border-green-100 flex items-center">
                    <i class="fas fa-check-circle mr-2"></i> {{ session('status') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="mb-6 p-4 rounded-lg bg-red-50 text-red-600 text-sm border border-red-100">
                    <div class="font-bold mb-1">Oops! Terjadi kesalahan:</div>
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form role="form" method="POST" action="{{ route('login') }}">
                @csrf
                
                <div class="mb-5">
                    <label class="block text-sm font-semibold text-slate-700 mb-2 ml-1">Email</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-envelope text-slate-400"></i>
                        </div>
                        <input type="email" name="email" value="{{ old('email') }}" class="w-full pl-10 pr-4 py-3 rounded-xl border border-slate-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 outline-none transition-all text-sm placeholder-slate-400" placeholder="nama@email.com" required autofocus />
                    </div>
                </div>

                <div class="mb-6">
                    <div class="flex justify-between items-center mb-2 ml-1">
                        <label class="block text-sm font-semibold text-slate-700">Password</label>
                    </div>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-lock text-slate-400"></i>
                        </div>
                        <input type="password" name="password" class="w-full pl-10 pr-4 py-3 rounded-xl border border-slate-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 outline-none transition-all text-sm placeholder-slate-400" placeholder="********" required />
                    </div>
                </div>

                {{-- Notice Lupa Password --}}
                <div class="mb-6 text-xs text-right">
                    <p class="text-slate-500">Lupa Password?</p>
                    <p class="text-blue-600 font-medium mt-1">
                        Hubungi <strong>Operator Daerah</strong> Anda untuk reset password.
                    </p>
                </div>

                <div class="text-center">
                    <button type="submit" class="w-full py-3.5 px-6 rounded-xl bg-gradient-to-r from-blue-600 to-blue-500 text-white font-bold text-sm shadow-lg shadow-blue-500/30 hover:shadow-blue-500/50 hover:-translate-y-0.5 transition-all duration-200">
                        Masuk ke Dashboard
                    </button>
                </div>
            </form>
            
            <div class="mt-12 text-center text-xs text-slate-400">
                &copy; {{ date('Y') }} HIMPESDA. All rights reserved.
            </div>
        </div>
    </div>
  </div>

</body>
</html>