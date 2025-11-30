<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BerandaController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ZakatController;
use App\Http\Controllers\MidtransCallbackController;

/*
|--------------------------------------------------------------------------
| PUBLIC ROUTES
|--------------------------------------------------------------------------
*/

// Halaman landing dan home
Route::get('/', [ZakatController::class, 'welcome'])->name('welcome');
Route::get('/home', [ZakatController::class, 'welcome'])->name('home');

/*
|--------------------------------------------------------------------------
| ZAKAT & PAYMENT FLOW
|--------------------------------------------------------------------------
*/
Route::prefix('zakat')->group(function () {

    // Form input zakat
    Route::get('/', [ZakatController::class, 'create'])->name('zakat.create');
    Route::post('/store', [ZakatController::class, 'store'])->name('zakat.store');

    // Halaman pembayaran (Snap Midtrans)
    Route::get('/{kode_transaksi}', [ZakatController::class, 'show'])->name('zakat.show');

    // Halaman status setelah pembayaran
    Route::get('/success/{kode_transaksi}', [ZakatController::class, 'success'])->name('zakat.success');
    Route::get('/pending/{kode_transaksi}', [ZakatController::class, 'pending'])->name('zakat.pending');
    Route::get('/status/{kode_transaksi}', [ZakatController::class, 'status'])->name('zakat.status');
});

// Callback Midtrans (WAJIB)
Route::post('/midtrans/callback', [MidtransCallbackController::class, 'receive'])
    ->name('midtrans.callback');

/*
|--------------------------------------------------------------------------
| FINISH / ERROR HANDLING PAGE FOR MIDTRANS REDIRECT (OPTIONAL)
|--------------------------------------------------------------------------
*/
Route::view('/midtrans/finish', 'midtrans.finish')->name('midtrans.finish');
Route::view('/midtrans/unfinish', 'midtrans.unfinish')->name('midtrans.unfinish');
Route::view('/midtrans/error', 'midtrans.error')->name('midtrans.error');

/*
|--------------------------------------------------------------------------
| AUTH ROUTES
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'index'])->name('auth.index');
    Route::post('/login', [AuthController::class, 'verify'])->name('auth.verify');
});

/*
|--------------------------------------------------------------------------
| ADMIN AREA
|--------------------------------------------------------------------------
*/
Route::middleware('auth:user')->prefix('admin')->group(function () {
    
    Route::get('/', [BerandaController::class, 'index'])->name('beranda.index');
    Route::get('/profil', [BerandaController::class, 'profil'])->name('beranda.profil');

    Route::post('/logout', [AuthController::class, 'logout'])->name('auth.logout');
});
Route::get('/midtrans-test', function() {
    return config('services.midtrans.server_key');
});
