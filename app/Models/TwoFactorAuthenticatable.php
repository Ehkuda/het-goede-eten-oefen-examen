<?php

namespace App\Models;

use App\Notifications\TwoFactorCode;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

trait TwoFactorAuthenticatable
{
    public function generateTwoFactorCode()
    {
        $code = Str::random(6); // of rand(100000, 999999) voor cijfers

        Cache::put('two-factor-code:' . $this->id, $code, now()->addMinutes(10));

        $this->notify(new TwoFactorCode($code));
    }

    public function getTwoFactorCode()
    {
        return Cache::get('two-factor-code:' . $this->id);
    }

    public function hasValidTwoFactorCode($code)
    {
        $cachedCode = Cache::get('two-factor-code:' . $this->id);

        return $cachedCode && $cachedCode === $code;
    }

    public function clearTwoFactorCode()
    {
        Cache::forget('two-factor-code:' . $this->id);
    }
}