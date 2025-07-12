<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <title><?php echo $__env->yieldContent('title', 'HIMPESDA'); ?> - Himpunan Profesional Pengelola Sumber Daya Air</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />    <link href="<?php echo e(asset('assets/css/nucleo-icons.css')); ?>" rel="stylesheet" />
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/style.css')); ?>"/>
    <?php echo $__env->yieldPushContent('styles'); ?>
</head>
<body class="bg-[var(--yellow-light)] text-[var(--blue-dark)] font-sans">

    
    <header class="sticky top-0 z-50 w-full p-4">
        <nav class="max-w-7xl mx-auto bg-[var(--blue-dark)] text-yellow-300 shadow-xl rounded-full flex justify-between items-center px-6 py-3">
            <a href="<?php echo e(route('home')); ?>" class="text-2xl font-bold tracking-wide">HIMPESDA</a>
            
            <ul class="hidden md:flex space-x-8 text-sm font-medium items-center">
                <li class="relative group">
                    <a href="<?php echo e(route('profil.sejarah')); ?>" class="hover:text-yellow-400 transition flex items-center">
                        Profil <i class="fas fa-chevron-down ml-2 text-xs"></i>
                    </a>
                    <div class="absolute hidden group-hover:block bg-gray-800 text-white shadow-lg rounded-md w-48 py-2">
                        <a href="<?php echo e(route('profil.sejarah')); ?>" class="block px-4 py-2 text-sm hover:bg-gray-700">Sejarah Singkat</a>
                        <a href="<?php echo e(route('profil.visi-misi')); ?>" class="block px-4 py-2 text-sm hover:bg-gray-700">Visi dan Misi</a>
                        <a href="<?php echo e(route('profil.struktur')); ?>" class="block px-4 py-2 text-sm hover:bg-gray-700">Struktur Organisasi</a>
                    </div>
                </li>
                <li><a href="<?php echo e(route('berita.index')); ?>" class="hover:text-yellow-400 transition">Berita</a></li>
                <li><a href="<?php echo e(route('pendaftaran.form')); ?>" class="hover:text-yellow-400 transition">Keanggotaan</a></li>
            </ul>

            <div class="hidden md:flex items-center space-x-4">
                <?php if(auth()->guard()->guest()): ?>
                <a href="<?php echo e(route('login')); ?>" class="bg-yellow-300 text-[var(--blue-dark)] font-semibold px-5 py-2 rounded-full hover:bg-yellow-400 transition text-sm">
                    Login
                </a>
                <?php endif; ?>
                <?php if(auth()->guard()->check()): ?>
                <a href="<?php echo e(route('admin.dashboard')); ?>" class="text-sm font-medium hover:text-yellow-400">Dashboard</a>
                <form method="POST" action="<?php echo e(route('logout')); ?>">
                    <?php echo csrf_field(); ?>
                    <a href="<?php echo e(route('logout')); ?>" onclick="event.preventDefault(); this.closest('form').submit();" class="bg-red-500 text-white font-semibold px-5 py-2 rounded-full hover:bg-red-600 transition text-sm">
                        Logout
                    </a>
                </form>
                <?php endif; ?>
            </div>

            <button id="mobile-menu-btn" class="md:hidden text-yellow-300 focus:outline-none"><i class="fas fa-bars fa-lg"></i></button>
        </nav>
        <div id="mobile-menu" class="hidden md:hidden absolute left-0 w-full px-4 mt-2">
            <div class="bg-[var(--blue-dark)] text-yellow-300 p-6 rounded-3xl shadow-xl">
                <ul class="flex flex-col space-y-4 text-sm font-medium">
                    <li>
                        <span class="font-semibold flex items-center"><i class="fa-solid fa-user mr-2"></i>Profil</span>
                        <ul class="pl-6 mt-2 space-y-2">
                            <li><a href="<?php echo e(route('profil.sejarah')); ?>" class="block hover:text-yellow-400">- Sejarah Singkat</a></li>
                            <li><a href="<?php echo e(route('profil.visi-misi')); ?>" class="block hover:text-yellow-400">- Visi dan Misi</a></li>
                            <li><a href="<?php echo e(route('profil.struktur')); ?>" class="block hover:text-yellow-400">- Struktur Organisasi</a></li>
                        </ul>
                    </li>
                    <li><a href="<?php echo e(route('berita.index')); ?>" class="block hover:text-yellow-400"><i class="fa-solid fa-newspaper mr-2"></i>Berita</a></li>
                    <li><a href="<?php echo e(route('pendaftaran.form')); ?>" class="block hover:text-yellow-400"><i class="fa-solid fa-users mr-2"></i>Keanggotaan</a></li>
                    <li><a href="#footer-kontak" class="block hover:text-yellow-400"><i class="fa-solid fa-envelope mr-2"></i>Kontak</a></li>
                    <li>
                        <a href="<?php echo e(route('login')); ?>" class="block bg-yellow-300 text-[var(--blue-dark)] font-semibold px-4 py-2 rounded-full text-center mt-3">
                            <i class="fa-solid fa-right-to-bracket mr-2"></i>Login Anggota
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </header>

    <main>
        <?php echo $__env->yieldContent('content'); ?>
    </main>

    <footer class="bg-[var(--blue-dark)] text-gray-300 mt-16" id="footer-kontak">
                <div class="max-w-7xl mx-auto px-8 py-12">
            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-8">
                <div class="lg:col-span-2">
                    <h3 class="text-xl font-bold text-white mb-4">HIMPESDA</h3>
                    <p class="text-sm pr-8">
                        HIMPESDA (Himpunan Profesional Pengelola Sumber Daya Air) merupakan organisasi yang mewadahi para profesional di bidang pengelolaan sumber daya air di Indonesia. Kami berkomitmen untuk meningkatkan kompetensi, memperkuat jejaring, serta mendorong kolaborasi antar anggota dalam rangka mewujudkan pengelolaan sumber daya air yang berkelanjutan dan bermanfaat bagi masyarakat. Melalui berbagai program pelatihan, seminar, dan kegiatan sosial, HIMPESDA berperan aktif dalam pengembangan keahlian, advokasi kebijakan, serta pemberdayaan anggota untuk menghadapi tantangan pengelolaan air di masa depan.
                    </p>
                </div>
                <div>
                    <h4 class="font-semibold text-white mb-4">Tautan</h4>
                    <ul class="space-y-2 text-sm">
                        <li><a href="profil.html" class="hover:text-white">Profil</a></li>
                        <li><a href="berita.html" class="hover:text-white">Berita</a></li>
                        <li><a href="keanggotaan.html" class="hover:text-white">Keanggotaan</a></li>
                        <li><a href="login.html" class="hover:text-white">Login</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-semibold text-white mb-4">Kontak</h4>
                    <ul class="space-y-2 text-sm">
                        <li><i class="fas fa-map-marker-alt mr-2"></i>Jl. Merdeka No. 123, Jakarta</li>
                        <li><i class="fas fa-envelope mr-2"></i>info@himpesda.org</li>
                        <li><i class="fas fa-phone mr-2"></i>+62 844 3242 4455</li>
                        <li><i class="fas fa-globe mr-2"></i>www.himpesda.org</li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-semibold text-white mb-4">Ikuti Kami</h4>
                    <div class="flex space-x-4">
                        <a href="#" class="hover:text-yellow-400" aria-label="Instagram"><i class="fab fa-instagram fa-lg"></i></a>
                        <a href="#" class="hover:text-yellow-400" aria-label="Facebook"><i class="fab fa-facebook fa-lg"></i></a>
                        <a href="#" class="hover:text-yellow-400" aria-label="Twitter"><i class="fab fa-twitter fa-lg"></i></a>
                        <a href="#" class="hover:text-yellow-400" aria-label="LinkedIn"><i class="fab fa-linkedin fa-lg"></i></a>
                    </div>
                </div>
            </div>
            <div class="border-t border-gray-700 mt-10 pt-6 text-center text-xs text-gray-400">
                &copy; 2025 HIMPESDA. All rights reserved.
            </div>
        </div>
    </footer>

    <script src="<?php echo e(asset('assets/js/script.js')); ?>"></script>
    <?php echo $__env->yieldPushContent('scripts'); ?>
</body>
</html><?php /**PATH C:\laragon\www\himpesda-web\resources\views/layouts/app.blade.php ENDPATH**/ ?>