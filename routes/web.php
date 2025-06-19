<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ObatController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PasienController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ObatMasukController;
use App\Http\Controllers\ResepObatController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\ObatKeluarController;
use App\Http\Controllers\RekamMedisController;
use App\Http\Controllers\JadwalDokterController;
use App\Http\Controllers\PenjualanObatController;

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
    Route::post('/obat/{id}/tambah_stok', [ObatController::class, 'tambahStok'])->name('obat.tambah_stok');
    Route::post('/obat/store', [ObatController::class, 'store'])->name('obat.store');
    Route::get('/obat/edit/{obat}', [ObatController::class, 'edit'])->name('obat.edit');
    Route::put('/obat/update/{obat}', [ObatController::class, 'update'])->name('obat.update');
    Route::delete('/obat/delete/{obat}', [ObatController::class, 'destroy'])->name('obat.destroy');

    // SUPPLIER
    Route::get('/obat/supplier', [SupplierController::class, 'index'])->name('obat.supplier.index');
    Route::get('/obat/supplier/create', [SupplierController::class, 'create'])->name('obat.supplier.create');
    Route::post('/obat/supplier/store', [SupplierController::class, 'store'])->name('obat.supplier.store');
    Route::get('/obat/supplier/edit/{supplier}', [SupplierController::class, 'edit'])->name('obat.supplier.edit');
    Route::put('/obat/supplier/update/{supplier}', [SupplierController::class, 'update'])->name('obat.supplier.update');
    Route::delete('/obat/supplier/delete/{supplier}', [SupplierController::class, 'destroy'])->name('obat.supplier.destroy');

    // PASIEN
    Route::get('/pasien', [PasienController::class, 'index'])->name('pasien.index');
    Route::get('/pasien/create', [PasienController::class, 'create'])->name('pasien.create');
    Route::get('/pasien/{id}/hubungkan-akun', [PasienController::class, 'hubungkanAkunForm'])->name('pasien.hubungkan-akun');
    Route::get('/pasien/edit/{pasien}', [PasienController::class, 'edit'])->name('pasien.edit');
    Route::get('/pasien/show/{pasien}', [PasienController::class, 'show'])->name('pasien.show');
    Route::post('/pasien/store', [PasienController::class, 'store'])->name('pasien.store');
    Route::post('/pasien/{id}/hubungkan-akun', [PasienController::class, 'hubungkanAkun'])->name('pasien.hubungkan-akun.store');
    Route::put('/pasien/update/{pasien}', [PasienController::class, 'update'])->name('pasien.update');
    Route::delete('/pasien/delete/{pasien}', [PasienController::class, 'destroy'])->name('pasien.destroy');

    // REKAM MEDIS
    Route::get('/pasien/rekam_medis/{pasien}', [RekamMedisController::class, 'index'])->name('pasien.rekam_medis.index');
    Route::get('/pasien/rekam_medis/{pasien}/edit/{rekam_medis}', [RekamMedisController::class, 'edit'])->name('pasien.rekam_medis.edit');
    Route::put('/pasien/rekam_medis/update/{rekam_medis}', [RekamMedisController::class, 'update'])->name('pasien.rekam_medis.update');
    Route::delete('/pasien/rekam_medis/delete/{rekam_medis}', [RekamMedisController::class, 'destroy'])->name('pasien.rekam_medis.destroy');

    // RESEP OBAT
    Route::get('/pasien/rekam_medis/{pasien}/resep_obat/{rekam_medis}', [ResepObatController::class, 'index'])->name('resep_obat.index');
    Route::post('/pasien/rekam_medis/resep_obat/{rekam_medis}/store_keluhan_diagnosis_tindakan', [ResepObatController::class, 'store_keluhan_diagnosis_tindakan'])->name('resep_obat.store_keluhan_diagnosis_tindakan');
    Route::post('/pasien/rekam_medis/resep_obat/{rekam_medis}/store', [ResepObatController::class, 'store'])->name('resep_obat.store');
    Route::post('/pasien/rekam_medis/resep_obat/{rekam_medis}/proses-apotek', [ResepObatController::class, 'proses_apotek'])->name('resep_obat.proses_apotek');
    Route::delete('/pasien/rekam_medis/resep_obat/{resep_obat}/delete', [ResepObatController::class, 'destroy'])->name('resep_obat.destroy');

    // TRANSAKSI
    Route::get('/transaksi', [TransaksiController::class, 'index'])->name('transaksi.index');
    Route::get('/transaksi/create', [TransaksiController::class, 'create'])->name('transaksi.create');
    Route::get('/transaksi/pasien/{pasien}/rekam_medis/{rekam_medis}/resep_obat', [TransaksiController::class, 'transaksi_resep_obat'])->name('transaksi.resep_obat');
    Route::post('/transaksi/store', [TransaksiController::class, 'store'])->name('transaksi.store');
    Route::put('/transaksi/{id}/update_status', [TransaksiController::class, 'updateStatus'])->name('transaksi.update_status');
    Route::delete('/transaksi/delete/{rekam_medis}', [TransaksiController::class, 'destroy'])->name('transaksi.destroy');

    // OBAT MASUK
    Route::get('/obat_masuk', [ObatMasukController::class, 'index'])->name('obat_masuk.index');

    // OBAT KELUAR
    Route::get('/obat_keluar', [ObatKeluarController::class, 'index'])->name('obat_keluar.index');

    // PENJUALAN OBAT
    Route::get('/penjualan_obat', [PenjualanObatController::class, 'index'])->name('penjualan_obat.index');
    Route::get('/penjualan_obat/create', [PenjualanObatController::class, 'create'])->name('penjualan_obat.create');
    Route::post('/penjualan_obat/store', [PenjualanObatController::class, 'store'])->name('penjualan_obat.store');

});