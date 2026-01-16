<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Auth\VerifyEmailController;
use App\Http\Controllers\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;

/*
|--------------------------------------------------------------------------
| Guest routes
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {

    // Login GET (toon login pagina)
    Route::get('/login', [AuthenticatedSessionController::class, 'create'])
        ->name('login');

    // ✅ Custom LOGIN POST met 2FA ondersteuning
    Route::post('/login', function (Request $request) {
        
        $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        $user = User::where('email', $request->email)->first();

        // Check credentials
        if (!$user || !Hash::check($request->password, $user->password)) {
            return back()->withErrors([
                'email' => 'De inloggegevens zijn onjuist.',
            ])->onlyInput('email');
        }

        // ✅ Check of 2FA actief is
        if ($user->two_factor_confirmed_at) {
            // Sla user info op in sessie
            session([
                'login.id' => $user->id,
                'login.remember' => $request->boolean('remember'),
            ]);

            // Genereer en verstuur 2FA code
            $user->generateTwoFactorCode();

            // Redirect naar 2FA challenge
            return redirect()->route('two-factor.challenge');
        }

        // Geen 2FA - gewoon inloggen
        Auth::login($user, $request->boolean('remember'));
        session(['two_factor_verified' => true]);
        
        $request->session()->regenerate();

        return redirect()->intended('/dashboard');
    });

    // Register routes
    Route::get('/register', [RegisteredUserController::class, 'create'])
        ->name('register');

    Route::post('/register', [RegisteredUserController::class, 'store']);

    // Password reset routes
    Route::get('/forgot-password', [PasswordResetLinkController::class, 'create'])
        ->name('password.request');

    Route::post('/forgot-password', [PasswordResetLinkController::class, 'store'])
        ->name('password.email');

    Route::get('/reset-password/{token}', [NewPasswordController::class, 'create'])
        ->name('password.reset');

    Route::post('/reset-password', [NewPasswordController::class, 'store'])
        ->name('password.store');

    // ✅ Two-Factor Challenge routes
    Route::get('/two-factor-challenge', function () {
        if (!session('login.id')) {
            return redirect()->route('login');
        }
        return view('auth.two-factor-challenge');
    })->name('two-factor.challenge');

    Route::post('/two-factor-challenge', function (Request $request) {
        $request->validate([
            'code' => 'required|string',
        ]);

        $userId = session('login.id');
        $user = User::find($userId);

        if (!$user) {
            return redirect()->route('login')->withErrors([
                'email' => 'Sessie verlopen, log opnieuw in.',
            ]);
        }

        if (!$user->hasValidTwoFactorCode($request->code)) {
            return back()->withErrors([
                'code' => 'De verificatiecode is onjuist of verlopen.',
            ]);
        }

        // ✅ Code correct - log gebruiker in
        $user->clearTwoFactorCode();
        Auth::login($user, session('login.remember', false));
        
        // Mark 2FA als geverifieerd in deze sessie
        session(['two_factor_verified' => true]);
        session()->forget(['login.id', 'login.remember']);
        
        $request->session()->regenerate();

        return redirect()->intended('/dashboard');
    })->name('two-factor.verify');
});

/*
|--------------------------------------------------------------------------
| Authenticated routes
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {

    // Email verification
    Route::get('/verify-email', EmailVerificationPromptController::class)
        ->name('verification.notice');

    Route::get('/verify-email/{id}/{hash}', VerifyEmailController::class)
        ->middleware(['signed', 'throttle:6,1'])
        ->name('verification.verify');

    Route::post('/email/verification-notification',
        [EmailVerificationNotificationController::class, 'store']
    )->middleware('throttle:6,1')->name('verification.send');

    // Password confirmation
    Route::get('/confirm-password', [ConfirmablePasswordController::class, 'show'])
        ->name('password.confirm');

    Route::post('/confirm-password', [ConfirmablePasswordController::class, 'store']);

    // Update password
    Route::put('/password', [PasswordController::class, 'update'])
        ->name('password.update');

    // Logout
    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
        ->name('logout');
});