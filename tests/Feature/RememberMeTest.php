<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Auth\Recaller;
use Illuminate\Cookie\CookieValuePrefix;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Route;
use Tests\TestCase;

class RememberMeTest extends TestCase
{
    use RefreshDatabase;

    public function test_remember_cookie_is_set_after_two_factor(): void
    {
        $user = User::factory()->create([
            'password' => bcrypt('password'),
        ]);

        $response = $this->loginWithTwoFactor($user, 'password', ['remember' => '1']);

        $response->assertRedirect(route('dashboard', absolute: false));
        $this->assertAuthenticatedAs($user);
        $response->assertCookie(Auth::guard()->getRecallerName());
    }

    public function test_without_remember_does_not_set_cookie(): void
    {
        $user = User::factory()->create([
            'password' => bcrypt('password'),
        ]);

        $response = $this->loginWithTwoFactor($user, 'password');

        $this->assertNull($response->getCookie(Auth::guard()->getRecallerName()));
    }

    public function test_remember_cookie_restores_auth_without_existing_session(): void
    {
        $user = User::factory()->create([
            'password' => bcrypt('password'),
            'role' => 'candidate',
        ]);

        $response = $this->loginWithTwoFactor($user, 'password', ['remember' => '1']);
        $name = Auth::guard()->getRecallerName();
        $encrypted = $response->getCookie($name, decrypt: false)->getValue();
        $plain = CookieValuePrefix::remove(Crypt::decryptString($encrypted));

        $recaller = new Recaller($plain);
        $this->assertTrue($recaller->valid());
        $this->assertNotNull(
            Auth::getProvider()->retrieveByToken($recaller->id(), $recaller->token())
        );

        $this->defaultCookies = [];
        $this->unencryptedCookies = [];
        $this->flushSession();
        $this->app['auth']->forgetGuards();
        $this->disableCookieEncryption();

        Route::get('/__remember_probe', function () {
            return response()->json([
                'auth' => Auth::check(),
                'id' => Auth::id(),
                'via' => Auth::viaRemember(),
            ]);
        });

        $this->withCookie($name, $plain)
            ->get('/__remember_probe')
            ->assertOk()
            ->assertJson([
                'auth' => true,
                'via' => true,
                'id' => $user->id,
            ]);
    }

    public function test_password_step_does_not_invalidate_existing_remember_token(): void
    {
        $user = User::factory()->create([
            'password' => bcrypt('password'),
            'remember_token' => 'existing-remember-token-value-1234567890',
        ]);

        $original = $user->remember_token;

        $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
            'remember' => '1',
        ])->assertRedirect(route('login.verify'));

        $this->assertSame($original, $user->fresh()->remember_token);
        $this->assertGuest();
    }
}
