<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MejaController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PembayaranController;
use App\Http\Controllers\ReservasiController;
use App\Http\Controllers\PesananController;
use App\Http\Controllers\PesananSayaController;
use App\Http\Controllers\ReservasiSayaController;
use App\Http\Controllers\RiwayatController;

Route::get('/', function () {
    return view('auth.login');
});

Route::post('/postlogin', [AuthController::class, 'postlogin'])->name('postlogin');
Route::get('/login', [AuthController::class, 'index']);
Route::get('/register', [AuthController::class, 'register']);
Route::post('/registeruser', [AuthController::class, 'create']);
Route::get('/logout', [AuthController::class, 'logout']);

Route::resource('dashboard', DashboardController::class);
Route::resource('meja', MejaController::class);
Route::resource('menu', MenuController::class);
Route::resource('order', OrderController::class);
Route::resource('pembayaran', PembayaranController::class);

Route::middleware(['auth'])->prefix('reservasi')->name('reservasi.')->group(function () {
    Route::get('/', [ReservasiController::class, 'index'])->name('index');
    Route::post('/meja-tersedia', [ReservasiController::class, 'mejaTersedia'])->name('mejaTersedia');
    Route::post('/pilih-meja', [ReservasiController::class, 'pilihMeja'])->name('pilihMeja');
    Route::get('/pilih-menu', [ReservasiController::class, 'pilihMenu'])->name('pilihMenu');
    Route::post('/keranjang/tambah', [ReservasiController::class, 'tambahKeranjang'])->name('tambahKeranjang');
    Route::get('/keranjang', [ReservasiController::class, 'keranjang'])->name('keranjang');
    Route::get('/keranjang/hapus/{id}', [ReservasiController::class, 'hapusItemKeranjang'])->name('hapusItem');
    Route::get('/pembayaran', [ReservasiController::class, 'pembayaran'])->name('pembayaran');
    Route::post('/proses-pembayaran', [ReservasiController::class, 'prosesPembayaran'])->name('prosesPembayaran');
    });

Route::middleware(['auth'])->prefix('pesanan')->name('pesanan.')->group(function () {
    Route::get('/', [PesananController::class, 'index'])->name('index');
    Route::get('/{id}/detail', [PesananController::class, 'detail'])->name('detail');
    Route::get('/{id}/pelunasan', [PesananController::class, 'pelunasanForm'])->name('pelunasan');
    Route::post('/{id}/pelunasan', [PesananController::class, 'prosesPelunasan'])->name('prosesPelunasan');
});
Route::get('saya', [ReservasiSayaController::class, 'index'])->name('saya');
Route::resource('riwayat', RiwayatController::class);