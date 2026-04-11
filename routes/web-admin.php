<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\BukuController;
use App\Http\Controllers\Admin\TransaksiController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\TarifController;
use App\Http\Controllers\Admin\PeminjamanController;
use App\Http\Controllers\Admin\PengembalianController;
use Illuminate\Support\Facades\Route;


Route::prefix('admin')
    ->middleware(['auth','admin'])
    ->name('admin.')
    ->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::resource('/buku', BukuController::class);
        Route::resource('/user', UserController::class);
        route::resource('/tarif', TarifController::class);
        Route::resource('/transaksi', TransaksiController::class);
        Route::resource('/peminjaman', PeminjamanController::class);
        Route::resource('/pengembalian', PengembalianController::class)
            ->only(['index', 'show', 'destroy']);
        Route::post('/logout', [LogoutController::class, 'logout'])->name('logout');
    });