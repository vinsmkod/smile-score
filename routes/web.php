<?php

use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\SmileScoreAdminController;
use App\Http\Controllers\SmileScoreController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Smile Score Landing Page and research questionnaire routes.
|
*/

// Halaman Beranda Publik
Route::get('/', function () {
    return view('home');
})->name('home');

// Alur 01: Biodata Siswa
Route::get('/smile-score', [SmileScoreController::class, 'biodataForm'])->name('smile-score.start');
Route::get('/smile-score/biodata', [SmileScoreController::class, 'biodataForm'])->name('smile-score.biodata');
Route::post('/smile-score/biodata', [SmileScoreController::class, 'saveBiodata'])->name('smile-score.biodata.save');

// Alur 02: Kuesioner (Dilindungi agar siswa wajib isi biodata terlebih dahulu)
Route::get('/smile-score/kuesioner', [SmileScoreController::class, 'kuesioner'])->name('smile-score.kuesioner');
Route::post('/smile-score/submit', [SmileScoreController::class, 'submit'])->name('smile-score.submit');

// Alur 03: Hasil & Edukasi
Route::get('/smile-score/hasil', [SmileScoreController::class, 'result'])->name('smile-score.result');
Route::get('/smile-score/edukasi', [SmileScoreController::class, 'education'])->name('smile-score.education');
Route::post('/smile-score/edukasi/regenerate', [SmileScoreController::class, 'regenerateEducation'])->name('smile-score.education.regenerate');

/*
|--------------------------------------------------------------------------
| Admin & Research Management Routes
|--------------------------------------------------------------------------
*/

// Login & Logout Administrator
Route::get('/login', fn () => redirect()->route('admin.login'))->name('login');
Route::get('/admin/login', [AdminAuthController::class, 'loginForm'])->name('admin.login');
Route::post('/admin/login', [AdminAuthController::class, 'login'])->name('admin.login.submit');
Route::post('/admin/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');

// Panel Administrasi & Ekspor Data Penelitian (Terproteksi Autentikasi)
Route::middleware('auth')->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [SmileScoreAdminController::class, 'index'])->name('dashboard');
    Route::get('/responden/{id}', [SmileScoreAdminController::class, 'detail'])->name('detail');
    Route::get('/export', [SmileScoreAdminController::class, 'export'])->name('export');
});
