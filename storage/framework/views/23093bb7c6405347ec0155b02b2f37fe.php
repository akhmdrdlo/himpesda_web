<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="icon" type="image/png" href="<?php echo e(asset('assets/img/favicon.png')); ?>" />
    <title><?php echo $__env->yieldContent('title'); ?> - HIMPESDA Dashboard</title>
    
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />    <link href="<?php echo e(asset('assets/css/nucleo-icons.css')); ?>" rel="stylesheet" />
    <link href="<?php echo e(asset('assets/css/nucleo-svg.css')); ?>" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link href="<?php echo e(asset('assets/css/argon-dashboard-tailwind.css?v=1.0.1')); ?>" rel="stylesheet" />
    <?php echo $__env->yieldPushContent('styles'); ?>
  </head>

  <body class="m-0 font-sans text-base antialiased font-normal dark:bg-slate-900 leading-default bg-gray-50 text-slate-500">
    <div class="absolute w-full bg-slate-700 dark:hidden min-h-75"></div>
    <aside id="sidenav-main" class="fixed inset-y-0 flex-wrap items-center justify-between block w-full p-0 my-4 overflow-y-auto antialiased transition-transform duration-200 -translate-x-full bg-white border-0 shadow-xl dark:shadow-none dark:bg-slate-850 max-w-64 ease-nav-brand z-990 xl:ml-6 rounded-2xl xl:left-0 xl:translate-x-0" aria-expanded="false">
      <div class="h-19">
        <i id="sidenav-close-btn" class="absolute top-0 right-0 p-4 opacity-50 cursor-pointer fas fa-times dark:text-white text-slate-400 xl:hidden"></i>
        <a class="block px-8 py-6 m-0 text-sm whitespace-nowrap dark:text-white text-slate-700" href="<?php echo e(route('admin.dashboard')); ?>">
          <img src="<?php echo e(asset('assets/img/logo-ct-dark.png')); ?>" class="inline h-full max-w-full transition-all duration-200 dark:hidden ease-nav-brand max-h-8" alt="main_logo" />
          <span class="ml-1 font-semibold transition-all duration-200 ease-nav-brand">HIMPESDA Dashboard</span>
        </a>
      </div>
      <hr class="h-px mt-0 bg-transparent bg-gradient-to-r from-transparent via-black/40 to-transparent dark:bg-gradient-to-r dark:from-transparent dark:via-white dark:to-transparent" />
      
      <div class="items-center block w-auto max-h-screen overflow-auto h-sidenav grow basis-full">
        <ul class="flex flex-col pl-0 mb-0">
          <li class="mt-0.5 w-full">
            <a class="py-2.7 text-sm my-0 mx-2 flex items-center whitespace-nowrap px-4 transition-colors <?php echo e(request()->routeIs('admin.dashboard') ? 'bg-blue-500/13 font-semibold text-slate-700' : ''); ?>" href="<?php echo e(route('admin.dashboard')); ?>">
              <div class="mr-2 flex h-8 w-8 items-center justify-center rounded-lg bg-center"><i class="relative top-0 text-sm leading-normal <?php echo e(request()->routeIs('admin.dashboard') ? 'text-blue-500' : 'text-gray-400'); ?> ni ni-tv-2"></i></div>
              <span class="ml-1">Dashboard</span>
            </a>
          </li>
          <li class="mt-0.5 w-full">
            <a class="py-2.7 text-sm my-0 mx-2 flex items-center whitespace-nowrap px-4 transition-colors <?php echo e(request()->routeIs('admin.anggota.*') ? 'bg-blue-500/13 font-semibold text-slate-700' : ''); ?>" href="<?php echo e(route('admin.anggota.index')); ?>">
              <div class="mr-2 flex h-8 w-8 items-center justify-center rounded-lg bg-center"><i class="relative top-0 text-sm leading-normal <?php echo e(request()->routeIs('admin.anggota.*') ? 'text-orange-500' : 'text-gray-400'); ?> ni ni-calendar-grid-58"></i></div>
              <span class="ml-1">Daftar Anggota</span>
            </a>
          </li>
          <li class="mt-0.5 w-full">
            <a class="py-2.7 text-sm my-0 mx-2 flex items-center whitespace-nowrap px-4 transition-colors <?php echo e(request()->routeIs('admin.berita.*') ? 'bg-blue-500/13 font-semibold' : ''); ?>" href="<?php echo e(route('admin.berita.index')); ?>">
              <div class="mr-2 flex h-8 w-8 items-center justify-center rounded-lg bg-center"><i class="ni ni-single-copy-04 <?php echo e(request()->routeIs('admin.berita.*') ? 'text-blue-500' : 'text-gray-400'); ?>"></i></div>
              <span>Manajemen Berita</span>
            </a>
          </li>
          <?php if(in_array(auth()->user()->level, ['admin', 'bendahara'])): ?>
          <li class="mt-0.5 w-full">
            <a class="py-2.7 text-sm my-0 mx-2 flex items-center whitespace-nowrap px-4 transition-colors <?php echo e(request()->routeIs('admin.konfirmasi.*') ? 'bg-blue-500/13 font-semibold text-slate-700' : ''); ?>" href="<?php echo e(route('admin.konfirmasi.index')); ?>">
              <div class="mr-2 flex h-8 w-8 items-center justify-center rounded-lg bg-center"><i class="relative top-0 text-sm leading-normal <?php echo e(request()->routeIs('admin.konfirmasi.*') ? 'text-emerald-500' : 'text-gray-400'); ?> ni ni-money-coins"></i></div>
              <span class="ml-1">Konfirmasi Pembayaran</span>
            </a>
          </li>
          <?php endif; ?>
        </ul>
      </div>
    </aside>

    
    <main class="relative h-full max-h-screen transition-all duration-200 ease-in-out xl:ml-68 rounded-xl">
      <nav class="relative flex flex-wrap items-center justify-between px-0 py-2 mx-6 transition-all ease-in shadow-none duration-250 rounded-2xl lg:flex-nowrap lg:justify-start">
        <div class="flex items-center justify-between w-full px-4 py-1 mx-auto flex-wrap-inherit">
          <h6 class="mb-0 font-bold text-white capitalize"><?php echo $__env->yieldContent('title'); ?></h6>
          <div class="flex items-center mt-2 grow sm:mt-0 sm:mr-6 md:mr-0 lg:flex lg:basis-auto">
            <div class="flex items-center md:ml-auto md:pr-4"></div>
            <ul class="flex flex-row justify-end pl-0 mb-0 list-none md-max:w-full">
              <li class="relative flex items-center">
                <button id="user-menu-button" class="block px-0 py-2 mt-3 text-sm font-semibold text-white transition-all">
                    <i class="fa fa-user sm:mr-1"></i>
                    <span class="hidden sm:inline"><?php echo e(auth()->user()->nama_lengkap); ?></span>
                    <i class="fa fa-chevron-down text-xs ml-2"></i>
                </button>
                
                <div id="user-menu" class="absolute right-0 top-full mt-2 w-48 bg-white rounded-md shadow-lg py-1 hidden z-50">
                    <a href="<?php echo e(route('admin.profile.show')); ?>" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Lihat Profil</a>
                    <div class="border-t border-gray-100"></div>
                    <form method="POST" action="<?php echo e(route('logout')); ?>">
                        <?php echo csrf_field(); ?>
                        <a href="<?php echo e(route('logout')); ?>" onclick="event.preventDefault(); this.closest('form').submit();" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                            Log Out
                        </a>
                    </form>
                </div>
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
      
      <?php echo $__env->yieldContent('content'); ?>

    </main>
  
    
    <?php echo $__env->yieldPushContent('scripts'); ?>

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

            var userMenuButton = document.getElementById('user-menu-button');
            var userMenu = document.getElementById('user-menu');

            if (userMenuButton) {
                userMenuButton.addEventListener('click', function() {
                    userMenu.classList.toggle('hidden');
                });
            }

            window.addEventListener('click', function(e) {
                if (userMenuButton && !userMenuButton.contains(e.target) && userMenu && !userMenu.contains(e.target)) {
                    userMenu.classList.add('hidden');
                }
            });
        });
    </script>
  </body>
</html><?php /**PATH C:\laragon\www\himpesda-web\resources\views/layouts/admin.blade.php ENDPATH**/ ?>