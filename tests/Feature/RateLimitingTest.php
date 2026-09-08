<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class RateLimitingTest extends TestCase
{
    use RefreshDatabase;

    public function test_password_reset_requests_are_rate_limited(): void
    {
        Notification::fake();

        $user = User::factory()->create();

        for ($i = 0; $i < 3; $i++) {
            $this->post('/forgot-password', ['email' => $user->email])
                ->assertRedirect();
        }

        $this->post('/forgot-password', ['email' => $user->email])
            ->assertStatus(429);
    }

    public function test_login_attempts_are_rate_limited_by_route_throttle(): void
    {
        $user = User::factory()->create();

        for ($i = 0; $i < 5; $i++) {
            $this->post('/login', [
                'email' => $user->email,
                'password' => 'wrong-password',
            ]);
        }

        $this->post('/login', [
            'email' => $user->email,
            'password' => 'wrong-password',
        ])->assertStatus(429);
    }

    public function test_registration_attempts_are_rate_limited(): void
    {
        for ($i = 0; $i < 5; $i++) {
            $this->post('/register', [
                'name' => "User {$i}",
                'email' => "user{$i}@example.com",
                'role' => 'candidate',
                'password' => 'password',
                'password_confirmation' => 'password',
                'terms' => '1',
            ])->assertRedirect();

            $this->post('/logout');
        }

        $this->post('/register', [
            'name' => 'Blocked User',
            'email' => 'blocked@example.com',
            'role' => 'candidate',
            'password' => 'password',
            'password_confirmation' => 'password',
            'terms' => '1',
        ])->assertStatus(429);
    }
}
