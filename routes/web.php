<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DataAyamController;
use App\Http\Controllers\InputProduksiController;
use App\Http\Controllers\KesehatanAyamController;
use App\Http\Controllers\KeuanganController;
use App\Http\Controllers\PrediksiHasilController;
use App\Http\Controllers\StokPakanController;
use App\Http\Controllers\RestockReminderController;
use App\Http\Controllers\DokumenController;
use App\Http\Controllers\ProfileController;

// =========================================================
// 1. ROUTE PUBLIK (Bisa dibuka tanpa login)
// =========================================================
Route::get('/', [IndexController::class, 'index'])->name('index');
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.perform');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// =========================================================
// 2. ROUTE PROTEKSI (Wajib Login) - Disatukan dalam 1 Group
// =========================================================
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Rute Petugas
    Route::get('/data-ayam', [DataAyamController::class, 'index'])->name('petugas.data-ayam');
    Route::get('/input-produksi', [InputProduksiController::class, 'index'])->name('petugas.input-produksi');
    Route::get('/kesehatan-ayam', [KesehatanAyamController::class, 'index'])->name('petugas.kesehatan-ayam');
    Route::get('/keuangan', [KeuanganController::class, 'index'])->name('petugas.keuangan');
    Route::get('/prediksi-hasil', [PrediksiHasilController::class, 'index'])->name('petugas.prediksi-hasil');
    Route::get('/stok-pakan', [StokPakanController::class, 'index'])->name('petugas.stok-pakan');
    Route::get('/restock-reminder', [RestockReminderController::class, 'index'])->name('petugas.restock-reminder');
    Route::get('/dokumen', [DokumenController::class, 'index'])->name('petugas.dokumen');
    Route::get('/edit-profile', [ProfileController::class, 'index'])->name('petugas.edit-profile');
});
