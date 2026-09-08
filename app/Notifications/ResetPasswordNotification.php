<?php

namespace App\Notifications;

use App\Mail\ResetPasswordMail;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Contracts\Mail\Mailable;

class ResetPasswordNotification extends ResetPassword
{
    public function toMail($notifiable): Mailable
    {
        if (static::$toMailCallback) {
            return call_user_func(static::$toMailCallback, $notifiable, $this->token);
        }

        $expireMinutes = (int) config(
            'auth.passwords.'.config('auth.defaults.passwords').'.expire',
            60
        );

        return (new ResetPasswordMail(
            url: $this->resetUrl($notifiable),
            userName: (string) ($notifiable->name ?? ''),
            expireMinutes: $expireMinutes,
        ))->to($notifiable->getEmailForPasswordReset());
    }
}
