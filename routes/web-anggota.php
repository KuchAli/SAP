<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Anggota\DashboardController;
use App\Http\Controllers\Anggota\PeminjamanController;
use App\Http\Controllers\Anggota\BukuController;

Route::prefix('anggota')
    ->middleware(['auth', 'anggota'])
    ->name('anggota.')
    ->group(function () {

        // ================= DASHBOARD =================
        Route::get('/dashboard', [DashboardController::class, 'index'])
            ->name('dashboard');

        Route::resource('/buku', BukuController::class)
        ->only(['index', 'show']);

        Route::resource('/peminjaman', PeminjamanController::class)
        ->only(['index', 'store']);

        

    }
      
);