<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProfileTest extends TestCase
{
    use RefreshDatabase;

    public function test_profile_page_is_displayed(): void
    {
        $user = User::factory()->create([
            'role' => User::ROLE_CANDIDATE,
        ]);

        $response = $this
            ->actingAs($user)
            ->get('/profile');

        $response->assertOk();
        $response->assertDontSee('Delete Account');
    }

    public function test_candidate_profile_details_can_be_updated_without_changing_name_or_email(): void
    {
        $user = User::factory()->create([
            'role' => User::ROLE_CANDIDATE,
            'name' => 'Original Name',
            'email' => 'original@example.com',
        ]);

        $response = $this
            ->actingAs($user)
            ->patch('/profile', [
                'name' => 'Hacker Name',
                'email' => 'hacker@example.com',
                'phone' => '0551234567',
                'location' => 'Accra, Ghana',
                'headline' => 'Software Engineer',
                'summary' => 'Experienced developer.',
            ]);

        $response
            ->assertSessionHasNoErrors()
            ->assertRedirect('/profile');

        $user->refresh();

        $this->assertSame('Original Name', $user->name);
        $this->assertSame('original@example.com', $user->email);
        $this->assertSame('0551234567', $user->phone);
        $this->assertSame('Accra, Ghana', $user->location);
        $this->assertSame('Software Engineer', $user->headline);
        $this->assertSame('Experienced developer.', $user->summary);
    }

    public function test_account_deletion_is_not_available(): void
    {
        $user = User::factory()->create([
            'role' => User::ROLE_CANDIDATE,
        ]);

        $response = $this
            ->actingAs($user)
            ->delete('/profile', [
                'password' => 'password',
            ]);

        $response->assertMethodNotAllowed();
        $this->assertNotNull($user->fresh());
    }
}
