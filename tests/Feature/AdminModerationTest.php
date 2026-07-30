<?php

namespace Tests\Feature;

use App\Models\Job;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminModerationTest extends TestCase
{
    use RefreshDatabase;

    private function createJob(User $employer, array $attributes = []): Job
    {
        return Job::create(array_merge([
            'user_id' => $employer->id,
            'title' => 'Software Engineer',
            'company_name' => 'Acme',
            'location' => 'Accra',
            'work_arrangement' => 'Remote',
            'employment_type' => 'Full Time',
            'category' => 'Technology',
            'currency' => 'GHS',
            'salary_min' => 5000,
            'salary_max' => 8000,
            'description' => 'Build software',
            'is_active' => true,
            'is_verified' => false,
        ], $attributes));
    }

    public function test_non_admin_cannot_access_admin_dashboard(): void
    {
        $employer = User::factory()->create(['role' => 'employer']);

        $this->actingAs($employer)
            ->get(route('admin.dashboard'))
            ->assertForbidden();
    }

    public function test_admin_can_verify_and_hide_jobs(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $employer = User::factory()->create(['role' => 'employer']);
        $job = $this->createJob($employer);

        $this->actingAs($admin)
            ->patch(route('admin.jobs.verify', $job))
            ->assertRedirect();

        $this->assertTrue($job->fresh()->is_verified);
        $this->assertTrue($job->fresh()->is_active);

        $this->actingAs($admin)
            ->patch(route('admin.jobs.deactivate', $job))
            ->assertRedirect();

        $this->assertFalse($job->fresh()->is_active);
    }

    public function test_admin_can_suspend_employer_and_hide_their_jobs(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $employer = User::factory()->create(['role' => 'employer']);
        $job = $this->createJob($employer, ['is_active' => true]);

        $this->actingAs($admin)
            ->patch(route('admin.users.suspend', $employer))
            ->assertRedirect();

        $this->assertTrue($employer->fresh()->is_suspended);
        $this->assertFalse($job->fresh()->is_active);
    }

    public function test_suspended_user_cannot_log_in(): void
    {
        $user = User::factory()->create([
            'role' => 'candidate',
            'email' => 'blocked@example.com',
            'password' => 'password',
            'is_suspended' => true,
        ]);

        $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ])->assertSessionHasErrors('email');

        $this->assertGuest();
    }

    public function test_admin_dashboard_redirects_from_dashboard_route(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $this->actingAs($admin)
            ->get(route('dashboard'))
            ->assertRedirect(route('admin.dashboard'));
    }
}
