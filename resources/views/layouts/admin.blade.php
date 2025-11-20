<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="icon" type="image/png" href="{{ asset('assets/img/himpesda_logo.png') }}" />
    <title>@yield('title') - HIMPESDA Dashboard</title>
    {{-- Aset CSS --}}
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" xintegrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />   <link href="{{ asset('assets/css/nucleo-icons.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/css/nucleo-svg.css') }}" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link href="{{ asset('assets/css/argon-dashboard-tailwind.css?v=1.0.1') }}" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
  </head>

  <body class="m-0 font-sans text-base antialiased font-normal dark:bg-slate-900 leading-default bg-gray-50 text-slate-500">
    <div class="absolute w-full bg-slate-700 dark:hidden min-h-75"></div>
    <aside id="sidenav-main" class="fixed inset-y-0 flex-wrap items-center justify-between block w-full p-0 my-4 overflow-y-auto antialiased transition-transform duration-200 -translate-x-full bg-white border-0 shadow-xl dark:shadow-none dark:bg-slate-850 max-w-64 ease-nav-brand z-990 xl:ml-6 rounded-2xl xl:left-0 xl:translate-x-0" aria-expanded="false">
      <div class="h-auto pb-4">
          <i id="sidenav-close-btn" class="absolute top-0 right-0 p-4 opacity-50 cursor-pointer fas fa-times dark:text-white text-slate-400 xl:hidden"></i>
          
          <a class="block px-8 py-6 m-0 text-sm whitespace-nowrap dark:text-white text-slate-700" href="{{ route('admin.dashboard') }}">
              <img src="{{ asset('assets/img/himpesda_logo.png') }}" class="inline h-full max-w-full transition-all duration-200 dark:hidden ease-nav-brand max-h-8" alt="main_logo" />
              <span class="ml-1 font-semibold transition-all duration-200 ease-nav-brand">HIMPESDA Dashboard</span>
          </a>

          @php
              $user = auth()->user();
              $isDaerah = in_array($user->level, ['operator_daerah', 'bendahara_daerah']) || ($user->tipe_anggota == 'daerah' && $user->provinsi);
              $wilayahLabel = $isDaerah ? strtoupper($user->provinsi) : 'PUSAT (NASIONAL)';
              $bgClass = $isDaerah ? 'from-blue-600 to-cyan-400' : 'from-slate-700 to-slate-900';
          @endphp

          <div class="mx-4 mt-2 p-3 rounded-xl bg-gradient-to-tl {{ $bgClass }} shadow-md text-center ">
              <p class="text-[10px] opacity-80 uppercase tracking-wider mb-1">Area Kerja Aktif</p>
              <h6 class=" font-bold text-sm mb-0 leading-tight">
                  <i class="fas fa-map-marker-alt mr-1"></i> {{ $wilayahLabel }}
              </h6>
              @if($isDaerah)
                  <div class="mt-2 pt-2 border-t border-white/20 text-[10px]">
                      Anda login sebagai: <br> 
                      <span class="font-bold uppercase">{{ str_replace('_', ' ', $user->level) }}</span>
                  </div>
              @endif
          </div>
      </div>
      <hr class="h-px mt-4 bg-transparent bg-gradient-to-r from-transparent via-black/40 to-transparent dark:bg-gradient-to-r dark:from-transparent dark:via-white dark:to-transparent" />
      
      <div class="items-center block w-auto max-h-screen overflow-auto grow basis-full">
      <ul class="flex flex-col pl-0 mb-0">
          
          {{-- 1. DASHBOARD: Semua Level Bisa Akses --}}
          <li class="mt-0.5 w-full">
            <a class="py-2.7 text-sm my-0 mx-2 flex items-center whitespace-nowrap px-4 transition-colors {{ request()->routeIs('admin.dashboard') ? 'bg-blue-500/13 font-semibold text-slate-700' : '' }}" href="{{ route('admin.dashboard') }}">
              <div class="mr-2 flex h-8 w-8 items-center justify-center rounded-lg bg-center"><i class="relative top-0 text-sm leading-normal {{ request()->routeIs('admin.dashboard') ? 'text-blue-500' : 'text-gray-400' }} ni ni-tv-2"></i></div>
              <span class="ml-1">Dashboard</span>
            </a>
          </li>

          {{-- 
            2. DAFTAR ANGGOTA: 
            Bisa diakses oleh: Admin, Operator (Pusat/Daerah), Bendahara (Pusat/Daerah) 
            TIDAK BISA: Anggota
          --}}
          @if(in_array(auth()->user()->level, ['admin', 'operator', 'operator_daerah', 'bendahara', 'bendahara_daerah']))
          <li class="mt-0.5 w-full">
            <a class="py-2.7 text-sm my-0 mx-2 flex items-center whitespace-nowrap px-4 transition-colors {{ request()->routeIs('admin.anggota.*') ? 'bg-blue-500/13 font-semibold text-slate-700' : '' }}" href="{{ route('admin.anggota.index') }}">
              <div class="mr-2 flex h-8 w-8 items-center justify-center rounded-lg bg-center"><i class="relative top-0 text-sm leading-normal {{ request()->routeIs('admin.anggota.*') ? 'text-orange-500' : 'text-gray-400' }} ni ni-calendar-grid-58"></i></div>
              <span class="ml-1">Daftar Anggota</span>
            </a>
          </li>
          @endif

          {{-- 
            3. MANAJEMEN BERITA: 
            Biasanya: Admin, Operator, Operator Daerah 
          --}}
          @if(in_array(auth()->user()->level, ['admin', 'operator', 'operator_daerah']))
          <li class="mt-0.5 w-full">
            <a class="py-2.7 text-sm my-0 mx-2 flex items-center whitespace-nowrap px-4 transition-colors {{ request()->routeIs('admin.berita.*') ? 'bg-blue-500/13 font-semibold' : '' }}" href="{{ route('admin.berita.index') }}">
              <div class="mr-2 flex h-8 w-8 items-center justify-center rounded-lg bg-center"><i class="ni ni-single-copy-04 {{ request()->routeIs('admin.berita.*') ? 'text-blue-500' : 'text-gray-400' }}"></i></div>
              <span>Manajemen Berita</span>
            </a>
          </li>
          @endif

          {{-- 
            4. VERIFIKASI & KONFIRMASI (Menu Gabungan atau Terpisah)
            
            Menu "Verifikasi Anggota" (Halaman Index Gabungan):
            Halaman ini cerdas (VerifikasiController), dia akan menampilkan tabel sesuai role.
            Jadi semua staf (Admin/Ops/Bendahara) bisa akses menu ini.
          --}}
          @if(in_array(auth()->user()->level, ['admin', 'operator', 'operator_daerah', 'bendahara', 'bendahara_daerah']))
          <li class="mt-0.5 w-full">
            <a class="py-2.7 text-sm my-0 mx-2 flex items-center whitespace-nowrap px-4 transition-colors {{ request()->routeIs('admin.verifikasi.*') ? 'bg-blue-500/13 font-semibold text-slate-700' : '' }}" href="{{ route('admin.verifikasi.index') }}">
              <div class="mr-2 flex h-8 w-8 items-center justify-center rounded-lg bg-center">
                {{-- Ikon berubah warna tergantung role --}}
                <i class="relative top-0 text-sm leading-normal {{ request()->routeIs('admin.verifikasi.*') ? 'text-red-500' : 'text-gray-400' }} ni ni-notification-70"></i>
              </div>
              <span class="ml-1">Verifikasi & Konfirmasi</span>
            </a>
          </li>
          @endif
          {{-- 
            5. TRACING PEMBAYARAN (MONITORING)
            Akses: Admin, Operator, Ops Daerah, Bendahara, Bendahara Daerah
          --}}
          @if(in_array(auth()->user()->level, ['admin', 'operator', 'operator_daerah', 'bendahara', 'bendahara_daerah']))
          <li class="mt-0.5 w-full">
            <a class="py-2.7 text-sm my-0 mx-2 flex items-center whitespace-nowrap px-4 transition-colors {{ request()->routeIs('admin.tracing.*') ? 'bg-blue-500/13 font-semibold text-slate-700' : '' }}" href="{{ route('admin.tracing.index') }}">
              <div class="mr-2 flex h-8 w-8 items-center justify-center rounded-lg bg-center">
                <i class="relative top-0 text-sm leading-normal {{ request()->routeIs('admin.tracing.*') ? 'text-cyan-500' : 'text-gray-400' }} fas fa-history"></i>
              </div>
              <span class="ml-1">Tracing Pembayaran</span>
            </a>
          </li>
          @endif
          
        </ul>
      </div>
    </aside>

    {{-- Konten Utama --}}
    <main class="h-full max-h-screen transition-all duration-200 ease-in-out xl:ml-68 rounded-xl">
      <nav class="relative flex flex-wrap items-center justify-between px-0 py-2 mx-6 transition-all ease-in shadow-none duration-250 rounded-2xl lg:flex-nowrap lg:justify-start">
        <div class="flex items-center justify-between w-full px-4 py-1 mx-auto flex-wrap-inherit">
          <h6 class="mb-0 font-bold text-white capitalize">@yield('title')</h6>
          <div class="flex items-center mt-2 grow sm:mt-0 sm:mr-6 md:mr-0 lg:flex lg:basis-auto">
            <div class="flex items-center md:ml-auto md:pr-4"></div>
            <ul class="flex flex-row items-center justify-end pl-0 mb-0 list-none md-max:w-full">
              <li class="flex items-center">
                <a href="{{ route('home') }}" class="block px-0 py-2 mr-4 text-sm font-semibold text-white transition-all" title="Dashboard User">
                    <i class="fa fa-tachometer-alt sm:mr-1"></i>
                    <span class="hidden sm:inline">Dashboard User</span>
                </a>
              </li>

              <li class="flex items-center"> <!-- Dihapus 'relative' -->
                <button id="user-menu-button" class="block px-0 py-2 text-sm font-semibold text-white transition-all">
                    <i class="fa fa-user sm:mr-1"></i>
                    <span class="hidden sm:inline">{{ auth()->user()->nama_lengkap }}</span>
                    <i class="fa fa-chevron-down text-xs ml-2"></i>
                </button>
              </li>

              <li class="flex items-center pl-4 xl:hidden">
                <a href="javascript:;" id="hamburger-btn" class="block p-0 text-sm text-white transition-all ease-nav-brand">
                  <div class="w-4.5 overflow-hidden">
                    <i class="ease mb-0.75 relative block h-0.5 rounded-sm bg-white transition-all"></i>
                    <i class="ease mb-0.75 relative block h-0.5 rounded-sm bg-white transition-all"></i>
                    <i class="ease relative block h-0.5 rounded-sm bg-white transition-all"></i>
                  </div>
                </a>
              </li>
            </ul>
          </div>
        </div>
      </nav>
      
      @yield('content')

    </main>

    <!-- Menu dropdown dipindah ke luar <main> untuk menghindari masalah pemotongan (clipping) -->
    <div id="user-menu" class="absolute w-48 bg-white rounded-md shadow-lg py-1 hidden z-[100]">
      <a href="{{ route('admin.profile.show') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Lihat Profil</a>
      <a href="{{ route('home') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Dashboard User</a>
      <div class="border-t border-gray-100"></div>

      <!-- Tombol buka modal logout -->
      <button id="logout-btn" type="button" class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
        Log Out
      </button>
    </div>

    <!-- Modal konfirmasi logout -->
    <div id="logout-modal" class="fixed inset-0 flex items-center justify-center bg-black/40 hidden z-[110]" aria-hidden="true">
      <div class="bg-white rounded-lg shadow-lg w-11/12 max-w-md mx-4">
      <div class="px-6 py-4">
        <h3 class="text-lg font-semibold">Konfirmasi Logout</h3>
        <p class="mt-2 text-sm text-gray-600">Apakah Anda yakin ingin logout, {{ auth()->user()->nama_lengkap }}?</p>
      </div>
      <div class="flex justify-end gap-2 px-6 py-4 border-t">
        <button id="logout-cancel" type="button" class="px-4 py-2 bg-gray-100 rounded text-sm">Batal</button>
        <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded text-sm">Ya, Logout</button>
        </form>
      </div>
      </div>
    </div>

    @stack('scripts')
    <script>
      (function(){
      var logoutBtn = document.getElementById('logout-btn');
      var logoutModal = document.getElementById('logout-modal');
      var logoutCancel = document.getElementById('logout-cancel');

      function showModal() {
        logoutModal.classList.remove('hidden');
        logoutModal.setAttribute('aria-hidden','false');
      }
      function hideModal() {
        logoutModal.classList.add('hidden');
        logoutModal.setAttribute('aria-hidden','true');
      }

      if (logoutBtn) {
        logoutBtn.addEventListener('click', function(e){
        e.stopPropagation();
        showModal();
        });
      }
      if (logoutCancel) {
        logoutCancel.addEventListener('click', function(){
        hideModal();
        });
      }
      // Klik di area overlay akan menutup modal
      if (logoutModal) {
        logoutModal.addEventListener('click', function(e){
        if (e.target === logoutModal) hideModal();
        });
        // ESC untuk menutup
        document.addEventListener('keydown', function(e){
        if (e.key === 'Escape' && !logoutModal.classList.contains('hidden')) hideModal();
        });
      }
      })();
    </script>

    <script>
      document.addEventListener('DOMContentLoaded', function() {
          var sidenav = document.getElementById('sidenav-main');
          var hamburgerBtn = document.getElementById('hamburger-btn');
          var closeBtn = document.getElementById('sidenav-close-btn');

          if (hamburgerBtn) {
            hamburgerBtn.addEventListener('click', function(e) {
              e.preventDefault(); 
              sidenav.classList.toggle('-translate-x-full');
            });
          }

          if (closeBtn) {
              closeBtn.addEventListener('click', function() {
                  sidenav.classList.add('-translate-x-full');
              });
          }

          // Logika baru untuk dropdown menu yang sudah diperbaiki
          var userMenuButton = document.getElementById('user-menu-button');
          var userMenu = document.getElementById('user-menu');

          if (userMenuButton && userMenu) {
              userMenuButton.addEventListener('click', function(event) {
                  event.stopPropagation();

                  if (userMenu.classList.contains('hidden')) {
                      // Show logic
                      userMenu.style.visibility = 'hidden'; // Siapkan untuk pengukuran
                      userMenu.classList.remove('hidden');

                      const menuWidth = userMenu.offsetWidth;
                      const rect = userMenuButton.getBoundingClientRect();

                      userMenu.style.top = `${rect.bottom + window.scrollY + 4}px`;
                      userMenu.style.left = `${rect.right + window.scrollX - menuWidth}px`;

                      userMenu.style.visibility = 'visible'; // Tampilkan di posisi yang benar
                  } else {
                      // Hide logic
                      userMenu.classList.add('hidden');
                      userMenu.style.visibility = ''; // Reset inline style
                  }
              });

              // Menutup dropdown jika user mengklik di luar area
              window.addEventListener('click', function(e) {
                  if (!userMenu.classList.contains('hidden') && !userMenu.contains(e.target) && !userMenuButton.contains(e.target)) {
                      userMenu.classList.add('hidden');
                      userMenu.style.visibility = ''; // Reset juga di sini
                  }
              });
          }
      });
  </script>
  </body>
</html>

