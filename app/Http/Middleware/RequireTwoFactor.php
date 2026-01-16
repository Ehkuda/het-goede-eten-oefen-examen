<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RequireTwoFactor
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = auth()->user();

        // Als geen user, laat auth middleware het afhandelen
        if (!$user) {
            return $next($request);
        }

        // Check of user 2FA heeft ingeschakeld
        if ($user->two_factor_confirmed_at) {
            // Check of 2FA al is geverifieerd in deze sessie
            if (!session('two_factor_verified')) {
                // Redirect naar 2FA challenge
                // NIET opnieuw code genereren (die is al verstuurd bij login)
                return redirect()->route('two-factor.challenge');
            }
        }

        return $next($request);
    }
}