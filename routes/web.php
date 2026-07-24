<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\SimulasiGameController;

Route::get('/', function () {
    $progressModul = collect();
    if (Illuminate\Support\Facades\Auth::check() && Illuminate\Support\Facades\Auth::user()->role === 'Peserta') {
        $progressModul = App\Models\ProgressModul::where('id_user', Illuminate\Support\Facades\Auth::user()->id_user)->get();
        
        // Ensure all 5 modules exist for the user
        $moduls = ['OLT', 'ODC', 'ODP', 'ONT', 'Splicing'];
        foreach ($moduls as $m) {
            if (!$progressModul->contains('nama_modul', $m)) {
                $newProg = App\Models\ProgressModul::create([
                    'id_user' => Illuminate\Support\Facades\Auth::user()->id_user,
                    'nama_modul' => $m,
                    'status_tugas' => 'Belum Selesai'
                ]);
                $progressModul->push($newProg);
            }
        }
    }
    return view('welcome', compact('progressModul'));
})->name('home');

// Auth Routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Peserta Routes
Route::middleware(['auth'])->group(function () {
    // LMS Routes (Peserta)
    Route::get('/modul/{nama_modul}', [App\Http\Controllers\LMSController::class, 'detailModul'])->name('peserta.modul.detail');
    Route::get('/modul/{nama_modul}/materi', [App\Http\Controllers\LMSController::class, 'bacaMateri'])->name('peserta.modul.materi');
    Route::get('/modul/{nama_modul}/kuis', [App\Http\Controllers\LMSController::class, 'kerjakanKuis'])->name('peserta.modul.kuis');
    Route::post('/modul/{nama_modul}/kuis/submit', [App\Http\Controllers\LMSController::class, 'submitKuis'])->name('peserta.modul.kuis.submit');

    // Game
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

    // Kelola Materi & Kuis
    Route::resource('materi', \App\Http\Controllers\MateriController::class, ['as' => 'admin']);
    Route::resource('kuis', \App\Http\Controllers\KuisController::class, ['as' => 'admin']);
});
