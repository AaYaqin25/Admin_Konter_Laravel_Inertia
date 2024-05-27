<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KuotaController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PulsaController;
use App\Http\Controllers\SaldoController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['verified'])->name('dashboard');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::post('/profile-picture', [ProfileController::class, 'updateProfilePicture'])->name('profile.picture.update');
    Route::get('/pembelian-saldo', [SaldoController::class, 'index']);
    Route::post('/saldo/beli', [SaldoController::class, 'buySaldo'])->name('saldo.beli');
    Route::get('/penjualan-pulsa', [PulsaController::class, 'index']);
    Route::get('/get-pulsa-options', [PulsaController::class, 'getPulsaOptions']);
    Route::post('/post-penjualan-pulsa', [PulsaController::class, 'jualPulsa'])->name('jual.pulsa');
    Route::get('/penjualan-kuota', [KuotaController::class, 'index']);
    Route::get('/get-kuota-options', [KuotaController::class, 'getKuotaOptions']);
    Route::post('/post-penjualan-kuota', [KuotaController::class, 'jualKuota'])->name('jual.kuota');
});

Route::fallback(function () {
    return redirect('/login');
});

require __DIR__ . '/auth.php';
