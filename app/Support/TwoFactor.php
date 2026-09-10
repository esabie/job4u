<?php

namespace App\Support;

use App\Mail\TwoFactorCodeMail;
use App\Models\User;
use Illuminate\Support\Facades\Mail;

class TwoFactor
{
    /**
     * Generate a fresh OTP for the user and email it.
     */
    public static function sendCode(User $user): void
    {
        $code = $user->generateTwoFactorCode();

        Mail::to($user->email)->send(new TwoFactorCodeMail(
            code: $code,
            userName: (string) $user->name,
            expireMinutes: User::TWO_FACTOR_CODE_TTL_MINUTES,
        ));
    }
}
