<?php

namespace Tests\Feature;

use App\Models\User;
use App\Support\SafeIntendedUrl;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class UploadCvRedirectTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_upload_cv_redirects_to_register_and_sets_intended_profile(): void
    {
        $this->get(route('cv.upload'))
            ->assertRedirect(route('register'));

        $this->assertSame(
            SafeIntendedUrl::forRoute('profile.edit', fragment: 'cv'),
            session('url.intended')
        );
    }

    public function test_guest_returns_to_profile_cv_after_registering_via_upload_cv(): void
    {
        Mail::fake();

        $this->get(route('cv.upload'))->assertRedirect(route('register'));

        $this->post('/register', [
            'name' => 'Jane Candidate',
            'email' => 'jane@example.com',
            'role' => 'candidate',
            'password' => 'password',
            'password_confirmation' => 'password',
            'terms' => '1',
        ])->assertRedirect(route('login.verify'));

        $this->post(route('login.verify.store'), [
            'code' => $this->lastTwoFactorCode(),
        ])->assertRedirect(SafeIntendedUrl::forRoute('profile.edit', fragment: 'cv'));

        $this->assertAuthenticated();
    }

    public function test_guest_returns_to_profile_cv_after_logging_in_via_upload_cv(): void
    {
        Mail::fake();

        $user = User::factory()->create([
            'role' => 'candidate',
            'password' => bcrypt('password'),
        ]);

        $this->get(route('cv.upload'))->assertRedirect(route('register'));

        $this->loginWithTwoFactor($user)
            ->assertRedirect(SafeIntendedUrl::forRoute('profile.edit', fragment: 'cv'));

        $this->assertAuthenticatedAs($user);
    }

    public function test_authenticated_candidate_upload_cv_goes_to_profile(): void
    {
        $candidate = User::factory()->create(['role' => 'candidate']);

        $this->actingAs($candidate)
            ->get(route('cv.upload'))
            ->assertRedirect(SafeIntendedUrl::forRoute('profile.edit', fragment: 'cv'));
    }

    public function test_authenticated_employer_upload_cv_goes_to_dashboard(): void
    {
        $employer = User::factory()->create(['role' => 'employer']);

        $this->actingAs($employer)
            ->get(route('cv.upload'))
            ->assertRedirect(route('dashboard'));
    }
}
