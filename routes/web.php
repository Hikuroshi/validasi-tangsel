<?php

use App\Http\Controllers\JenisPekerjaanController;
use App\Http\Controllers\KontrakController;
use App\Http\Controllers\BadanUsahaController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SubPekerjaanController;
use App\Http\Controllers\TenagaAhliController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard.index', ['title' => 'Dashboard']);
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware('auth')->group(function () {
    Route::resource('/dashboard/kontrak', KontrakController::class);
    Route::resource('/dashboard/tenaga-ahli', TenagaAhliController::class)->except('show');
    Route::resource('/dashboard/badan-usaha', BadanUsahaController::class)->except('show');
    Route::resource('/dashboard/jenis-pekerjaan', JenisPekerjaanController::class)->except('show');
    Route::resource('/dashboard/sub-pekerjaan', SubPekerjaanController::class)->except('show');

    Route::put('/dashboard/kontrak/{kontrak}/selesai', [KontrakController::class, 'kontrakSelesai'])->name('kontrak.selesai');
});

Route::redirect('/', '/dashboard');

require __DIR__.'/auth.php';
