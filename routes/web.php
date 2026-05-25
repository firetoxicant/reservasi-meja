<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MejaController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PembayaranController;
use App\Http\Controllers\ReservasiController;
use App\Http\Controllers\PesananController;
use App\Http\Controllers\ReservasiSayaController;
use App\Http\Controllers\RiwayatController;

Route::get('/', function () {
    return view('auth.login');
});

Route::post('/postlogin', [AuthController::class, 'postlogin'])->name('postlogin');
Route::get('/login', [AuthController::class, 'index']);
Route::get('/register', [AuthController::class, 'register']);
Route::get('/logout', [AuthController::class, 'logout']);

Route::resource('dashboard', DashboardController::class);
Route::resource('meja', MejaController::class);
Route::resource('menu', MenuController::class);
Route::resource('order', OrderController::class);
Route::resource('pembayaran', PembayaranController::class);
Route::resource('reservasi', ReservasiController::class);
Route::resource('pesanan', PesananController::class);
Route::resource('reservasi-saya', ReservasiSayaController::class);
Route::resource('riwayat', RiwayatController::class);