<?php

namespace App\Actions\Fortify;

use Laravel\Fortify\Actions\RedirectIfTwoFactorAuthenticatable as BaseRedirect;
use Laravel\Fortify\TwoFactorAuthenticatable;

class RedirectIfTwoFactorAuthenticatable extends BaseRedirect
{
    public function handle($request, $next)
    {
        $user = $this->validateCredentials($request);

        if (optional($user)->two_factor_confirmed_at &&
            in_array(TwoFactorAuthenticatable::class, class_uses_recursive($user))) {
            
            // Genereer en verstuur code
            $user->generateTwoFactorCode();
            
            return $this->twoFactorChallengeResponse($request, $user);
        }

        return $next($request);
    }
}