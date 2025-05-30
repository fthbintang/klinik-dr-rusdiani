<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ObatController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\JadwalDokterController;
use App\Http\Controllers\PasienController;

// AUTENTIKASI
Route::get('/', [LoginController::class, 'index'])->name('login')->middleware('guest', 'prevent-back-history');
Route::post('/sign-in', [LoginController::class, 'authenticate'])->name('authentication');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::prefix('dashboard')->middleware('auth')->group(function () {
    // DASHBOARD
    Route::get('/', [DashboardController::class, 'index'])->name('index');

    // PROFILE
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::put('/profile/update/{user}', [ProfileController::class, 'update'])->name('profile.update');

    // PENGGUNA
    Route::get('/pengguna', [UserController::class, 'index'])->name('user.index');
    Route::get('/pengguna/show/{user}', [UserController::class, 'show'])->name('user.show');
    Route::get('/pengguna/create', [UserController::class, 'create'])->name('user.create');
    Route::post('/pengguna/store', [UserController::class, 'store'])->name('user.store');
    Route::get('/pengguna/edit/{user}', [UserController::class, 'edit'])->name('user.edit');
    Route::put('/pengguna/update/{user}', [UserController::class, 'update'])->name('user.update');
    Route::delete('/pengguna/delete/{user}', [UserController::class, 'destroy'])->name('user.destroy');

    // JADWAL DOKTER
    Route::get('/jadwal_dokter', [JadwalDokterController::class, 'index'])->name('jadwal_dokter.index');
    Route::post('/jadwal_dokter/store', [JadwalDokterController::class, 'store'])->name('jadwal_dokter.store');

    // OBAT
    Route::get('/obat', [ObatController::class, 'index'])->name('obat.index');
    Route::get('/obat/create', [ObatController::class, 'create'])->name('obat.create');
    Route::post('/obat/store', [ObatController::class, 'store'])->name('obat.store');
    Route::get('/obat/edit/{obat}', [ObatController::class, 'edit'])->name('obat.edit');
    Route::put('/obat/update/{obat}', [ObatController::class, 'update'])->name('obat.update');
    Route::delete('/obat/delete/{obat}', [ObatController::class, 'destroy'])->name('obat.destroy');

    // SUPPLIER
    Route::get('/obat/supplier/index', [SupplierController::class, 'index'])->name('obat.supplier.index');
    Route::get('/obat/supplier/create', [SupplierController::class, 'create'])->name('obat.supplier.create');
    Route::post('/obat/supplier/store', [SupplierController::class, 'store'])->name('obat.supplier.store');
    Route::get('/obat/supplier/edit/{supplier}', [SupplierController::class, 'edit'])->name('obat.supplier.edit');
    Route::put('/obat/supplier/update/{supplier}', [SupplierController::class, 'update'])->name('obat.supplier.update');
    Route::delete('/obat/supplier/delete/{supplier}', [SupplierController::class, 'destroy'])->name('obat.supplier.destroy');

    // PASIEN
    Route::get('/pasien', [PasienController::class, 'index'])->name('pasien.index');
    Route::get('/pasien/create', [PasienController::class, 'create'])->name('pasien.create');
    Route::post('/pasien/store', [PasienController::class, 'store'])->name('pasien.store');
    Route::get('/pasien/edit/{pasien}', [PasienController::class, 'edit'])->name('pasien.edit');
    Route::put('/pasien/update/{pasien}', [PasienController::class, 'update'])->name('pasien.update');
});