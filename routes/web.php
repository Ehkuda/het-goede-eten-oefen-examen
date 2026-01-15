<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GerechtController;  // ← dit moet er staan!

Route::get('/', function () {
    return view('welcome');
});

// Dashboard met kok-redirect
Route::get('/dashboard', function () {
    if (auth()->check() && auth()->user()->role === 'kok') {
        return redirect()->route('gerechten.index');
    }
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'kok'])->group(function () {
    // Receptenbeheer (CRUD) – correcte class-naam
    Route::resource('gerechten', GerechtController::class);

    // Printen
    Route::get('/gerechten/print', [GerechtController::class, 'print'])
        ->name('gerechten.print');
    
    Route::get('/menukaart', [GerechtController::class, 'menukaart'])->name('menukaart.index');
});

require __DIR__.'/auth.php';