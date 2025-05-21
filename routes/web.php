<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;

Route::get('/', [LoginController::class, 'index'])->name('login')->middleware('guest', 'prevent-back-history');
Route::post('/sign-in', [LoginController::class, 'authenticate'])->name('authentication');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::prefix('dashboard')->middleware('auth')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('index');

    Route::get('/pengguna', [UserController::class, 'index'])->name('user.index');
    Route::get('/pengguna/show/{user}', [UserController::class, 'show'])->name('user.show');
    Route::get('/pengguna/create', [UserController::class, 'create'])->name('user.create');
    Route::post('/pengguna/store', [UserController::class, 'store'])->name('user.store');
    Route::get('/pengguna/edit/{user}', [UserController::class, 'edit'])->name('user.edit');
    Route::put('/pengguna/update/{user}', [UserController::class, 'update'])->name('user.update');
    Route::delete('/pengguna/delete/{user}', [UserController::class, 'destroy'])->name('user.destroy');

});