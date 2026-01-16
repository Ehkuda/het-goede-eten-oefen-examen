<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\GerechtController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

/*
|--------------------------------------------------------------------------
| Dashboard
|--------------------------------------------------------------------------
*/
Route::get('/dashboard', function () {
    if (auth()->check() && auth()->user()->role === 'kok') {
        return redirect()->route('gerechten.index');
    }

    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

/*
|--------------------------------------------------------------------------
| Profiel routes (ingelogde gebruikers) - ZONDER two-factor middleware
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {

    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');

    // 2FA Settings pagina (MOET zonder two-factor middleware)
    Route::get('/profile/2fa', function () {
        return view('profile.two-factor');
    })->name('profile.2fa');

    // 2FA Inschakelen
    Route::post('/user/two-factor-authentication', function () {
        $user = auth()->user();
        $user->two_factor_confirmed_at = now();
        $user->save();

        return back()->with('status', '2FA is succesvol ingeschakeld!');
    })->name('two-factor.enable');

    // 2FA Uitschakelen
    Route::delete('/user/two-factor-authentication', function () {
        $user = auth()->user();
        $user->two_factor_confirmed_at = null;
        $user->save();

        return back()->with('status', '2FA is uitgeschakeld.');
    })->name('two-factor.disable');
});

/*
|--------------------------------------------------------------------------
| Kok routes - MET two-factor middleware voor extra beveiliging
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'kok', 'two-factor'])->group(function () {

    // BELANGRIJKE VOLGORDE: specifieke routes eerst

    // Print
    Route::get('/gerechten/print', [GerechtController::class, 'print'])
        ->name('gerechten.print');

    // Menukaart
    Route::get('/menukaart', [GerechtController::class, 'menukaart'])
        ->name('menukaart.index');

    // CRUD gerechten (resource altijd als laatste)
    Route::resource('gerechten', GerechtController::class)
        ->parameter('gerechten', 'gerecht');
});

require __DIR__.'/auth.php';