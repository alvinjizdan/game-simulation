<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\SimulasiGameController;

Route::get('/', function () {
    return view('welcome');
})->name('home');

// Auth Routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Peserta Routes
Route::middleware(['auth'])->group(function () {
    Route::get('/simulasi/game/{kategori?}', [SimulasiGameController::class, 'index'])->name('simulasi.game');
    Route::post('/api/selesaikan-tugas', [SimulasiGameController::class, 'selesaikanTugas'])->name('api.selesai.tugas');
});

// Admin Routes
Route::prefix('admin')->middleware(['auth'])->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    
    // Kelola Peserta
    Route::get('/peserta', [AdminController::class, 'indexPeserta'])->name('admin.peserta');
    Route::post('/peserta', [AdminController::class, 'storePeserta'])->name('admin.peserta.store');
    Route::get('/peserta/{id}/edit', [AdminController::class, 'editPeserta'])->name('admin.peserta.edit');
    Route::put('/peserta/{id}', [AdminController::class, 'updatePeserta'])->name('admin.peserta.update');
    Route::delete('/peserta/{id}', [AdminController::class, 'destroyPeserta'])->name('admin.peserta.destroy');
    Route::post('/peserta/{id}/reset', [AdminController::class, 'resetProgress'])->name('admin.peserta.reset');
    Route::post('/update-level-modul', [AdminController::class, 'updateLevelModul'])->name('admin.update_level');
});
