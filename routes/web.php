<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BerandaController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ZakatController;
use App\Http\Controllers\MidtransCallbackController;
use App\Http\Controllers\KegiatanController;

/*
|--------------------------------------------------------------------------
| PUBLIC
|--------------------------------------------------------------------------
*/
Route::get('/', [ZakatController::class, 'welcome'])->name('welcome');
Route::get('/home', [ZakatController::class, 'welcome'])->name('home');

/*
|--------------------------------------------------------------------------
| ZAKAT & MIDTRANS
|--------------------------------------------------------------------------
*/
Route::prefix('zakat')->name('zakat.')->group(function () {

    // halaman form zakat
    Route::get('/', [ZakatController::class, 'create'])->name('create');

    // ajax midtrans
    Route::post('/midtrans', [ZakatController::class, 'midtrans'])->name('midtrans');

    // hasil pembayaran
    Route::get('/success/{kode}', [ZakatController::class, 'success'])->name('success');
    Route::get('/pending/{kode}', [ZakatController::class, 'pending'])->name('pending');
});

/*
|--------------------------------------------------------------------------
| MIDTRANS CALLBACK
|--------------------------------------------------------------------------
*/
Route::post('/midtrans/callback', [MidtransCallbackController::class, 'receive'])
    ->name('midtrans.callback');

/*
|--------------------------------------------------------------------------
| AUTH
|--------------------------------------------------------------------------
*/
Route::get('/login', [AuthController::class, 'login'])->name('auth.login');
Route::post('/login', [AuthController::class, 'verify'])->name('auth.login.verify');

Route::get('/register', [AuthController::class, 'register'])->name('auth.register');
Route::post('/register', [AuthController::class, 'store'])->name('auth.register.post');

Route::post('/logout', [AuthController::class, 'logout'])->name('auth.logout');

/*
|--------------------------------------------------------------------------
| ADMIN
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [BerandaController::class, 'index'])->name('beranda');
    Route::get('/users', [BerandaController::class, 'users'])->name('users');
    Route::get('/zakat', [BerandaController::class, 'zakat'])->name('zakat');
    Route::get('/donasi', [BerandaController::class, 'donasi'])->name('donasi');
    Route::get('/laporan', [BerandaController::class, 'laporan'])->name('laporan');
    Route::get('/pengaturan', [BerandaController::class, 'pengaturan'])->name('pengaturan');
});

/*
|--------------------------------------------------------------------------
| KEGIATAN
|--------------------------------------------------------------------------
*/
Route::get('/kegiatan/{slug}', [KegiatanController::class, 'show'])->name('kegiatan.show');

/*
|--------------------------------------------------------------------------
| TEST
|--------------------------------------------------------------------------
*/
Route::get('/midtrans-test', fn () => config('services.midtrans.server_key'));
