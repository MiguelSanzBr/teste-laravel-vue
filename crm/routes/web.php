<?php

use App\Http\Controllers\ColaboradorController;
use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});


// Dashboard
Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Colaboradores
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/colaboradores', [ColaboradorController::class, 'index'])->name('colaboradores.index');
    Route::post('/colaboradores', [ColaboradorController::class, 'store'])->name('colaboradores.store');
    Route::put('/colaboradores/{colaborador}', [ColaboradorController::class, 'update'])->name('colaboradores.update');
    Route::delete('/colaboradores/{colaborador}', [ColaboradorController::class, 'destroy'])->name('colaboradores.destroy');
    
    // Rotas adicionais
    Route::get('/colaboradores/inativos', [ColaboradorController::class, 'inativos'])->name('colaboradores.inativos');
    Route::post('/colaboradores/{colaborador}/restore', [ColaboradorController::class, 'restore'])->name('colaboradores.restore');
    Route::get('/colaboradores/search', [ColaboradorController::class, 'search'])->name('colaboradores.search');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
