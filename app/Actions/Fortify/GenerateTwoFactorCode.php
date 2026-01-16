<?php

namespace App\Actions\Fortify;

use Laravel\Fortify\Contracts\TwoFactorAuthenticationProvider;

class GenerateTwoFactorCode
{
    public function __invoke($user)
    {
        $user->generateTwoFactorCode();
    }
}