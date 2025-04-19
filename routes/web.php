<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PenilaianController;
use App\Http\Controllers\KriteriaController;
use App\Http\Controllers\KaryawanController;
use App\Http\Controllers\AHPController;

// Halaman awal
Route::get('/', function () {
    return view('welcome');
});

// Dashboard
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Grup untuk user yang sudah login
Route::middleware(['auth'])->group(function () {

    // Profile user
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // ----------------------------
    // Akses PENUH untuk SEMUA YANG LOGIN
    // ----------------------------
    Route::resource('karyawan', KaryawanController::class);
    Route::resource('kriteria', KriteriaController::class);

    Route::post('/pairwise', [AHPController::class, 'store'])->name('pairwise.store');
    Route::delete('/pairwise/reset', [AHPController::class, 'reset'])->name('pairwise.reset');
    Route::delete('/pairwise/reset', [\App\Http\Controllers\AHPController::class, 'reset'])->name('pairwise.reset');
    Route::get('/bobot', [AHPController::class, 'hitungBobot'])->name('pairwise.bobot');
    Route::get('/ranking/pdf', [AHPController::class, 'exportPDF'])->name('ahp.export');

    // ----------------------------
    // AKSES TAMPILAN (READ-ONLY) juga tetap bisa
    // ----------------------------
    Route::get('/pairwise', [AHPController::class, 'index'])->name('pairwise.index');

    Route::get('/karyawan/{karyawan}', [KaryawanController::class, 'show'])->name('karyawan.show');
    Route::get('/kriteria/{kriteria}', [KriteriaController::class, 'show'])->name('kriteria.show');

    // Penilaian (boleh untuk semua yang login)
    Route::get('/penilaian', [PenilaianController::class, 'index'])->name('penilaian.index');
    Route::post('/penilaian', [PenilaianController::class, 'store'])->name('penilaian.store');

    // Ranking bisa dilihat semua
    Route::get('/ranking', [AHPController::class, 'ranking'])->name('ranking');
});

require __DIR__.'/auth.php';
