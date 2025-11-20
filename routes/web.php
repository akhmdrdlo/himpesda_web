<?php

use Illuminate\Support\Facades\Route;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

// --- KORELASI NAMA CONTROLLER ---
// Controller untuk Halaman Publik
use App\Http\Controllers\PageController; 
use App\Http\Controllers\Admin\DashboardController; // <-- Controller utama dashboard
// Controller untuk Pendaftaran (Fase 3.1)
use App\Http\Controllers\Admin\PendaftaranController; 
// Controller untuk Upload Bukti Bayar (Fase 3.3)
use App\Http\Controllers\Admin\PembayaranController; 
use App\Http\Controllers\Admin\VerifikasiController;
// Controller untuk Panel Admin
use App\Http\Controllers\Admin\AnggotaController;
use App\Http\Controllers\Admin\AdminProfileController; 
use App\Http\Controllers\Admin\KonfirmasiController;
use App\Http\Controllers\Admin\BeritaController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\HimpunanController;
use App\Http\Controllers\Admin\DocumentController;


/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/
Route::get('/', [PageController::class, 'home'])->name('home');
Route::get('/berita', [PageController::class, 'berita'])->name('berita.index');
Route::get('/berita/{slug}', [PageController::class, 'detailBerita'])->name('berita.show');


Route::get('pendaftaran', [PendaftaranController::class, 'create'])
            ->name('pendaftaran.form'); 
Route::post('pendaftaran', [PendaftaranController::class, 'store'])
            ->name('pendaftaran.store'); 


// --- ROUTE DASHBOARD ANGGOTA (Fase 3.3) ---
// Ini adalah route untuk 'dashboard.blade.php' (Halaman Tracer)
Route::get('/dashboard', function () {
    return view('admin/dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Route untuk anggota mengunggah bukti bayar (sesuai Fase 3.3)
Route::post('/anggota/upload-pembayaran', [PembayaranController::class, 'store'])
    ->name('anggota.pembayaran.store')
    ->middleware('auth');


Route::prefix('profil')->name('profil.')->group(function () {
    Route::get('/sejarah', [PageController::class, 'sejarah'])->name('sejarah');
    Route::get('/visi-misi', [PageController::class, 'visiMisi'])->name('visi-misi');
    Route::get('/struktur', [PageController::class, 'struktur'])->name('struktur');
    
    // Route untuk halaman dokumen
    Route::get('/kode-etik', [PageController::class, 'kodeEtik'])->name('kode-etik');
    Route::get('/anggaran-dasar', [PageController::class, 'anggaranDasar'])->name('anggaran-dasar');
    Route::get('/anggaran-rumah-tangga', [PageController::class, 'anggaranRumahTangga'])->name('anggaran-rumah-tangga');
});


/*
|--------------------------------------------------------------------------
| Admin Routes (Protected)
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->name('admin.')->middleware('auth')->group(function () {
    
    // Rute ini sudah benar, mengarah ke DashboardController Admin
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Route Anggota (sudah benar)
    Route::get('/anggota/import', [AnggotaController::class, 'showImportForm'])->name('anggota.import.form');
    Route::get('/anggota/ekspor-kartu', [AnggotaController::class, 'eksporKartu'])->name('anggota.ekspor-kartu');
    Route::get('/anggota/{user}/cetak-kartu', [AnggotaController::class, 'cetakKartu'])->name('anggota.cetak-kartu');
    Route::post('/anggota/import', [AnggotaController::class, 'import'])->name('anggota.import.store');
    Route::resource('anggota', AnggotaController::class);

    // Resource route lainnya (sudah benar)
    Route::resource('berita', BeritaController::class);
    Route::resource('categories', CategoryController::class);
    Route::get('/organisasi/edit', [HimpunanController::class, 'edit'])->name('organisasi.edit');
    Route::put('/organisasi', [HimpunanController::class, 'update'])->name('organisasi.update');
    Route::resource('documents', DocumentController::class)->only(['index', 'edit', 'update']);

    
    // Rute Profil Admin (sudah benar)
    Route::get('/profile', [AdminProfileController::class, 'index'])->name('profile.show');
    Route::get('/profile/edit', [AdminProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [AdminProfileController::class, 'update'])->name('profile.update');
    Route::get('/profile/cetak-kartu', [AdminProfileController::class, 'cetakKartu'])->name('profile.cetak_kartu');
    

    Route::prefix('verifikasi')->name('verifikasi.')->group(function () {
        // Halaman utama yang cerdas
        Route::get('/', [VerifikasiController::class, 'index'])->name('index');
        
        // Aksi Verifikasi Data (Admin/Operator)
        Route::patch('/approve-data/{user}', [VerifikasiController::class, 'approveData'])->name('approveData');
        Route::patch('/reject-data/{user}', [VerifikasiController::class, 'rejectData'])->name('rejectData');
        
        // Aksi Konfirmasi Pembayaran (Admin/Bendahara)
        Route::patch('/approve-payment/{pembayaran}', [VerifikasiController::class, 'approvePayment'])->name('approvePayment');
        Route::patch('/reject-payment/{pembayaran}', [VerifikasiController::class, 'rejectPayment'])->name('rejectPayment');
    });
    Route::get('/tracing-pembayaran', [VerifikasiController::class, 'tracing'])->name('tracing.index');
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
| Auth Routes
|--------------------------------------------------------------------------
*/
require __DIR__.'/auth.php';