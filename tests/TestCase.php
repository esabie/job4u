<?php

namespace Tests;

use App\Mail\TwoFactorCodeMail;
use App\Models\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\Mail;
use Illuminate\Testing\TestResponse;

abstract class TestCase extends BaseTestCase
{
    /**
     * Complete a password login and email OTP challenge for the given user.
     */
    protected function loginWithTwoFactor(User $user, string $password = 'password', array $extra = []): TestResponse
    {
        Mail::fake();

        $this->post('/login', array_merge([
            'email' => $user->email,
            'password' => $password,
        ], $extra))->assertRedirect(route('login.verify'));

        $code = $this->lastTwoFactorCode();

        return $this->post(route('login.verify.store'), [
            'code' => $code,
        ]);
    }

    /**
     * Read the plain OTP from the most recently faked TwoFactorCodeMail.
     */
    protected function lastTwoFactorCode(): string
    {
        $code = null;

        Mail::assertSent(TwoFactorCodeMail::class, function (TwoFactorCodeMail $mail) use (&$code) {
            $code = $mail->code;

            return true;
        });

        $this->assertNotNull($code);

        return $code;
    }
}
