<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BerandaController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ZakatController;
use App\Http\Controllers\MidtransCallbackController;

// ==================== WELCOME & HOME ROUTES ====================
Route::get('/', [ZakatController::class, 'welcome'])->name('welcome');
Route::get('/home', [ZakatController::class, 'welcome'])->name('home');

// ==================== ZAKAT & PAYMENT ROUTES ====================
Route::prefix('zakat')->group(function () {
    // Form input zakat
    Route::get('/', [ZakatController::class, 'create'])->name('zakat.create');
    Route::post('/store', [ZakatController::class, 'store'])->name('zakat.store');
    
    // Halaman pembayaran Midtrans
    Route::get('/{kode_transaksi}', [ZakatController::class, 'show'])->name('zakat.show');
    
    // Status pembayaran
    Route::get('/success/{kode_transaksi}', [ZakatController::class, 'success'])->name('zakat.success');
    Route::get('/pending/{kode_transaksi}', [ZakatController::class, 'pending'])->name('zakat.pending');
    Route::get('/status/{kode_transaksi}', [ZakatController::class, 'status'])->name('zakat.status');
});

// Callback Midtrans (WAJIB untuk update status otomatis)
Route::post('/midtrans/callback', [MidtransCallbackController::class, 'receive'])
     ->name('midtrans.callback');

// ==================== AUTH ROUTES ====================
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'index'])->name('auth.index');
    Route::post('/login', [AuthController::class, 'verify'])->name('auth.verify');
});

// ==================== ADMIN ROUTES ====================
Route::middleware('auth:user')->group(function () {
    Route::prefix('admin')->group(function () {
        Route::get('/', [BerandaController::class, 'index'])->name('beranda.index');
        Route::get('/profil', [BerandaController::class, 'profil'])->name('beranda.profil');
    });

    Route::post('/logout', [AuthController::class, 'logout'])->name('auth.logout');
});
Route::get('/zakat/demo/{kode_transaksi}', [ZakatController::class, 'demo'])->name('zakat.demo');