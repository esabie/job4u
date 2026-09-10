<?php

namespace Tests\Feature;

use App\Mail\TwoFactorCodeMail;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class TwoFactorAuthenticationTest extends TestCase
{
    use RefreshDatabase;

    public function test_login_always_requires_email_verification_code(): void
    {
        Mail::fake();

        $user = User::factory()->create([
            'password' => bcrypt('password'),
        ]);

        $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ])
            ->assertRedirect(route('login.verify'));

        $this->assertGuest();
        $this->assertTrue(session()->has('login.id'));

        $code = $this->lastTwoFactorCode();

        $this->post(route('login.verify.store'), [
            'code' => '999999',
        ])->assertSessionHasErrors('code');

        $this->assertGuest();

        $this->post(route('login.verify.store'), [
            'code' => $code,
        ])->assertRedirect(route('dashboard', absolute: false));

        $this->assertAuthenticatedAs($user);
        $this->assertNull($user->fresh()->two_factor_code);
    }

    public function test_registration_requires_email_verification_code(): void
    {
        Mail::fake();

        $this->post('/register', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'role' => 'candidate',
            'password' => 'password',
            'password_confirmation' => 'password',
            'terms' => '1',
        ])->assertRedirect(route('login.verify'));

        $this->assertGuest();

        $code = $this->lastTwoFactorCode();

        $this->post(route('login.verify.store'), [
            'code' => $code,
        ])->assertRedirect(route('dashboard', absolute: false));

        $this->assertAuthenticated();
    }

    public function test_expired_two_factor_code_is_rejected(): void
    {
        Mail::fake();

        $user = User::factory()->create([
            'password' => bcrypt('password'),
        ]);

        $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ])->assertRedirect(route('login.verify'));

        $code = $this->lastTwoFactorCode();

        $user->forceFill([
            'two_factor_expires_at' => now()->subMinute(),
        ])->save();

        $this->post(route('login.verify.store'), [
            'code' => $code,
        ])->assertSessionHasErrors('code');

        $this->assertGuest();
    }

    public function test_two_factor_resend_is_rate_limited(): void
    {
        Mail::fake();

        $user = User::factory()->create([
            'password' => bcrypt('password'),
        ]);

        $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ])->assertRedirect(route('login.verify'));

        $this->post(route('login.verify.resend'))->assertRedirect();
        $this->post(route('login.verify.resend'))->assertStatus(429);
    }

    public function test_challenge_page_redirects_without_pending_login(): void
    {
        $this->get(route('login.verify'))
            ->assertRedirect(route('login'));
    }
}
