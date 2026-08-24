<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DataAyamController;

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
    Route::get('/data-ayam', [DataAyamController::class, 'index'])->name('data-ayam');
    
    // Halaman internal lainnya (stok-pakan, keuangan, dll) tinggal dimasukkan di sini
});
