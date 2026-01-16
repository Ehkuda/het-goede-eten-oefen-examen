<?php

namespace App\Actions\Fortify;

use Laravel\Fortify\Fortify;

class ConfirmTwoFactorCode
{
    public function __invoke($user, $code)
    {
        if ($user->hasValidTwoFactorCode($code)) {
            $user->clearTwoFactorCode();
            return true;
        }

        return false;
    }
}