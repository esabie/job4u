<?php

namespace Tests\Feature;

use App\Models\Job;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SavedJobTest extends TestCase
{
    use RefreshDatabase;

    private function createJob(User $employer, array $attributes = []): Job
    {
        return Job::create(array_merge([
            'user_id' => $employer->id,
            'title' => 'Product Designer',
            'company_name' => 'Acme',
            'location' => 'Accra',
            'work_arrangement' => 'Hybrid',
            'employment_type' => 'Full Time',
            'category' => 'Technology',
            'currency' => 'GHS',
            'salary_min' => 4000,
            'salary_max' => 7000,
            'description' => 'Design products',
            'is_active' => true,
            'is_verified' => false,
        ], $attributes));
    }

    public function test_candidate_can_save_and_unsave_a_job(): void
    {
        $employer = User::factory()->create(['role' => 'employer']);
        $candidate = User::factory()->create(['role' => 'candidate']);
        $job = $this->createJob($employer);

        $this->actingAs($candidate)
            ->post(route('candidate.saved.store', $job))
            ->assertRedirect();

        $this->assertTrue($candidate->fresh()->hasSavedJob($job));

        $this->actingAs($candidate)
            ->get(route('candidate.saved.index'))
            ->assertOk()
            ->assertSee('Product Designer');

        $this->actingAs($candidate)
            ->delete(route('candidate.saved.destroy', $job))
            ->assertRedirect();

        $this->assertFalse($candidate->fresh()->hasSavedJob($job));
    }

    public function test_employer_cannot_save_jobs(): void
    {
        $employer = User::factory()->create(['role' => 'employer']);
        $job = $this->createJob($employer);

        $this->actingAs($employer)
            ->post(route('candidate.saved.store', $job))
            ->assertForbidden();
    }

    public function test_guest_is_redirected_when_saving_a_job(): void
    {
        $employer = User::factory()->create(['role' => 'employer']);
        $job = $this->createJob($employer);

        $this->post(route('candidate.saved.store', $job))
            ->assertRedirect(route('login'));
    }
}
