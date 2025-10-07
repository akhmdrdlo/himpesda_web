<?php

use Illuminate\Support\Facades\Route;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\PageController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\AnggotaController;
use App\Http\Controllers\Admin\AdminProfileController; 
use App\Http\Controllers\Admin\KonfirmasiController;
use App\Http\Controllers\Admin\BeritaController;
use App\Http\Controllers\Admin\HimpunanController;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/
Route::get('/', [PageController::class, 'home'])->name('home');
Route::get('/berita', [PageController::class, 'berita'])->name('berita.index');
Route::get('/berita/{slug}', [PageController::class, 'detailBerita'])->name('berita.show');
Route::get('/pendaftaran', [PageController::class, 'pendaftaran'])->name('pendaftaran.form');
Route::post('/pendaftaran', [PageController::class, 'prosesPendaftaran'])->name('pendaftaran.store');

Route::prefix('profil')->name('profil.')->group(function () {
    Route::get('/sejarah', [PageController::class, 'sejarah'])->name('sejarah');
    Route::get('/visi-misi', [PageController::class, 'visiMisi'])->name('visi-misi');
    Route::get('/struktur', [PageController::class, 'struktur'])->name('struktur');
});

/*
|--------------------------------------------------------------------------
| Dashboard Redirect
|--------------------------------------------------------------------------
*/
Route::get('/dashboard', function () {
    if (auth()->user()->level == 'admin' || auth()->user()->level == 'operator' || auth()->user()->level == 'bendahara' || auth()->user()->level == 'anggota') {
        return redirect()->route('admin.dashboard');
    }
    return redirect()->route('home');
})->middleware(['auth', 'verified'])->name('dashboard');

/*
|--------------------------------------------------------------------------
| Admin Routes (Protected)
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->name('admin.')->middleware('auth')->group(function () {
    
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Route spesifik untuk import diletakkan SEBELUM Route::resource
    Route::get('/anggota/import', [AnggotaController::class, 'showImportForm'])->name('anggota.import.form');
    Route::get('/anggota/ekspor-kartu', [AnggotaController::class, 'eksporKartu'])->name('anggota.ekspor-kartu');
    Route::get('/anggota/{user}/cetak-kartu', [AnggotaController::class, 'cetakKartu'])->name('anggota.cetak-kartu');
    Route::post('/anggota/import', [AnggotaController::class, 'import'])->name('anggota.import.store');
    Route::resource('anggota', AnggotaController::class);

    // Resource route untuk Berita dan Organisasi
    Route::resource('berita', BeritaController::class);
    Route::get('/organisasi/edit', [HimpunanController::class, 'edit'])->name('organisasi.edit');
    Route::put('/organisasi', [HimpunanController::class, 'update'])->name('organisasi.update');

    // Konfirmasi & Profil
    Route::get('/konfirmasi', [KonfirmasiController::class, 'index'])->name('konfirmasi.index');
    Route::put('/konfirmasi/{pendaftar}', [KonfirmasiController::class, 'updateStatus'])->name('konfirmasi.update');
    Route::get('/konfirmasi/{pendaftar}', [KonfirmasiController::class, 'show'])->name('konfirmasi.show');
    
    Route::get('/profile', [AdminProfileController::class, 'index'])->name('profile.show');
    Route::get('/profile/edit', [AdminProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [AdminProfileController::class, 'update'])->name('profile.update');
    Route::get('/profile/cetak-kartu', [AdminProfileController::class, 'cetakKartu'])->name('profile.cetak_kartu');
});

/*
|--------------------------------------------------------------------------
| Development Helper Route (Login as Admin)
|--------------------------------------------------------------------------
*/
Route::get('/login-sebagai-admin', function () {
    $user = User::find(1); 
    if ($user) {
        Auth::login($user);
    }
    return redirect()->route('admin.dashboard');
});

/*
|--------------------------------------------------------------------------
| Auth Routes (Duplicate, can be dihapus jika tidak diperlukan)
|--------------------------------------------------------------------------
*/
require __DIR__.'/auth.php';