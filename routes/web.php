<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\DashboardController;

Route::get('/', [LoginController::class, 'index'])->name('login')->middleware('guest', 'prevent-back-history');
Route::post('/sign-in', [LoginController::class, 'authenticate'])->name('authentication');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::prefix('dashboard')->name('dashboard.')->middleware('auth')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('index');
});