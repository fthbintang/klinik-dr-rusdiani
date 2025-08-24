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
use App\Http\Controllers\BerandaPasienController;
use App\Http\Controllers\DokterController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\PenjualanObatController;
use App\Http\Controllers\PendaftaranPasienController;
use App\Http\Controllers\PendaftaranAkunPasienController;
use App\Http\Controllers\PoliController;

// PENDAFTARAN AKUN PASIEN
Route::get('/pendaftaran_akun_pasien', [PendaftaranAkunPasienController::class, 'index'])->name('pendaftaran_akun_pasien');
Route::post('/pendaftaran_akun_pasien/register', [PendaftaranAkunPasienController::class, 'store'])->name('pendaftaran_akun_pasien.register');

// AUTENTIKASI
Route::get('/', [LoginController::class, 'index'])->name('login')->middleware('guest', 'prevent-back-history');
Route::post('/sign-in', [LoginController::class, 'authenticate'])->name('authentication');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::prefix('dashboard')->middleware(['auth', 'role:Admin,Dokter,Apotek,Pasien'])->group(function () {
    // PROFILE
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::put('/profile/update/{user}', [ProfileController::class, 'update'])->name('profile.update');
});

Route::prefix('dashboard')->middleware(['auth', 'role:Admin,Dokter,Apotek'])->group(function () {
    // Route::prefix('dashboard')->middleware('auth')->group(function () {
    // DASHBOARD
    Route::get('/', [DashboardController::class, 'index'])->name('index');

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

    Route::get('/pasien/rekam_medis/resep_obat/{id}/rujukan', [ResepObatController::class, 'cetakSuratRujukan'])->name('resep.cetakRujukan');


    // TRANSAKSI
    Route::get('/transaksi', [TransaksiController::class, 'index'])->name('transaksi.index');
    Route::get('/transaksi/create', [TransaksiController::class, 'create'])->name('transaksi.create');
    Route::get('/transaksi/pasien/{pasien}/rekam_medis/{rekam_medis}/resep_obat', [TransaksiController::class, 'transaksi_resep_obat'])->name('transaksi.resep_obat');
    Route::get('/transaksi/pasien/{pasien}/rekam_medis/{rekam_medis}/resep_obat/cetak', [TransaksiController::class, 'cetakResepObat'])->name('resep_obat.cetak');
    Route::post('/transaksi/store', [TransaksiController::class, 'store'])->name('transaksi.store');
    Route::put('/transaksi/{id}/update_status/datang', [TransaksiController::class, 'updateStatusBooking'])->name('transaksi.update_status_booking');
    Route::put('/transaksi/{id}/update_status', [TransaksiController::class, 'updateStatus'])->name('transaksi.update_status');
    Route::delete('/transaksi/delete/{rekam_medis}', [TransaksiController::class, 'destroy'])->name('transaksi.destroy');

    // OBAT MASUK
    Route::get('/obat_masuk', [ObatMasukController::class, 'index'])->name('obat_masuk.index');

    // OBAT KELUAR
    Route::get('/obat_keluar', [ObatKeluarController::class, 'index'])->name('obat_keluar.index');

    // PENJUALAN OBAT
    Route::get('/penjualan_obat', [PenjualanObatController::class, 'index'])->name('penjualan_obat.index');
    Route::get('/penjualan_obat/create', [PenjualanObatController::class, 'create'])->name('penjualan_obat.create');
    Route::get('/penjualan_obat/detail/{penjualan_obat}', [PenjualanObatController::class, 'penjualan_obat_detail_index'])->name('penjualan_obat.detail');
    Route::get('/penjualan-obat/{id}/cetak', [PenjualanObatController::class, 'cetak'])->name('penjualan-obat.cetak');
    Route::post('/penjualan_obat/store', [PenjualanObatController::class, 'store'])->name('penjualan_obat.store');
    Route::post('/penjualan_obat/detail/store', [PenjualanObatController::class, 'store_penjualan_obat_detail'])->name('penjualan_obat_detail.store');
    Route::delete('/penjualan_obat/delete/{penjualan_obat}', [PenjualanObatController::class, 'destroy'])->name('penjualan_obat.destroy');
});

Route::prefix('dashboard')->middleware(['auth', 'role:Admin'])->group(function () {
    // PENGGUNA
    Route::get('/pengguna', [UserController::class, 'index'])->name('user.index');
    Route::get('/pengguna/show/{user}', [UserController::class, 'show'])->name('user.show');
    Route::get('/pengguna/create', [UserController::class, 'create'])->name('user.create');
    Route::post('/pengguna/store', [UserController::class, 'store'])->name('user.store');
    Route::get('/pengguna/edit/{user}', [UserController::class, 'edit'])->name('user.edit');
    Route::put('/pengguna/update/{user}', [UserController::class, 'update'])->name('user.update');
    Route::delete('/pengguna/delete/{user}', [UserController::class, 'destroy'])->name('user.destroy');

    // POLI
    Route::get('/poli', [PoliController::class, 'index'])->name('poli.index');
    Route::get('/poli/edit/{poli}', [PoliController::class, 'edit'])->name('poli.edit');
    Route::get('/poli/create', [PoliController::class, 'create'])->name('poli.create');
    Route::post('/poli/store', [PoliController::class, 'store'])->name('poli.store');
    Route::put('/poli/update/{poli}', [PoliController::class, 'update'])->name('poli.update');
    Route::delete('/poli/delete/{poli}', [PoliController::class, 'destroy'])->name('poli.destroy');

    // DOKTER
    Route::get('/dokter', [DokterController::class, 'index'])->name('dokter.index');
    Route::get('/dokter/create', [DokterController::class, 'create'])->name('dokter.create');
    Route::post('/dokter/store', [DokterController::class, 'store'])->name('dokter.store');
    Route::get('/dokter/edit/{dokter}', [DokterController::class, 'edit'])->name('dokter.edit');
    Route::put('/dokter/update/{dokter}', [DokterController::class, 'update'])->name('dokter.update');
    Route::delete('/dokter/delete/{dokter}', [DokterController::class, 'destroy'])->name('dokter.destroy');

    // JADWAL DOKTER
    Route::get('/jadwal_dokter', [JadwalDokterController::class, 'index'])->name('jadwal_dokter.index');
    Route::post('/jadwal_dokter/store', [JadwalDokterController::class, 'store'])->name('jadwal_dokter.store');

    // LAPORAN
    Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
    Route::get('/laporan/cetak-obat', [LaporanController::class, 'exportObat'])->name('laporan.export-obat');
    Route::get('/laporan/cetak-obat-masuk', [LaporanController::class, 'exportObatMasuk'])->name('laporan.export-obat-masuk');
    Route::get('/laporan/cetak-obat-keluar', [LaporanController::class, 'exportObatKeluar'])->name('laporan.export-obat-keluar');
    Route::get('/laporan/cetak-transaksi-obat', [LaporanController::class, 'exportTransaksiObat'])->name('laporan.export-transaksi-obat');

    Route::get('/laporan/cetak-detail-transaksi-obat', [LaporanController::class, 'exportDetailTransaksiObat'])->name('laporan.export-detail-transaksi-obat');
    Route::get('/laporan/get-penjualan-obat-by-date', [LaporanController::class, 'getPenjualanObatByDate'])->name('laporan.get-penjualan-obat-by-date');

    Route::get('/laporan/cetak-transaksi', [LaporanController::class, 'exportTransaksi'])->name('laporan.export-transaksi');

    Route::get('/laporan/cetak-resep-obat', [LaporanController::class, 'exportResepObat'])->name('laporan.export-resep-obat');
    Route::get('/laporan/get-rekam-medis-by-date', [LaporanController::class, 'getRekamMedisByDate'])->name('laporan.get-rekam-medis-by-date');

    Route::get('/laporan/cetak-pasien-terdaftar', [LaporanController::class, 'exportPasien'])->name('laporan.export-pasien-terdaftar');
});

Route::prefix('dashboard')->middleware(['auth', 'role:Admin,Apotek'])->group(function () {
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
});

// ============================================= LOGIN PASIEN ==============================================
Route::prefix('pasien')->middleware(['auth', 'role:Pasien'])->group(function () {
    Route::get('/beranda', [BerandaPasienController::class, 'index'])->name('beranda_pasien.index');
    Route::get('/beranda/antrean/terdepan', [BerandaPasienController::class, 'antreanTerdepanPasien']);
    Route::get('/beranda/pendaftaran', [PendaftaranPasienController::class, 'index'])->name('pendaftaran_pasien.index');
    Route::get('/beranda/pendaftaran/create', [PendaftaranPasienController::class, 'create'])->name('pendaftaran_pasien.create');
    Route::post('/beranda/pendaftaran/store', [PendaftaranPasienController::class, 'store'])->name('pendaftaran_pasien.store');
    Route::get('/beranda/pendaftaran/pasien/rekam_medis/{pasien}/resep_obat/{rekam_medis}', [PendaftaranPasienController::class, 'detail_resep_obat'])->name('pendaftaran_pasien.resep_obat.index');
});