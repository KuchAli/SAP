<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\BukuController;
use App\Http\Controllers\Admin\TransaksiController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;


Route::prefix('admin')
    ->middleware(['auth','admin'])
    ->name('admin.')
    ->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::resource('/buku', BukuController::class);
        Route::resource('/user', UserController::class);
        Route::resource('/transaksi', TransaksiController::class);
        Route::post('/logout', [LogoutController::class, 'logout'])->name('logout');
    });