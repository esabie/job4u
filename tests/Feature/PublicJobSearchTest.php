<?php

namespace Tests\Feature;

use App\Models\Job;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PublicJobSearchTest extends TestCase
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

    public function test_jobs_can_be_filtered_by_location_category_type_and_arrangement(): void
    {
        $employer = User::factory()->create(['role' => 'employer']);

        $matching = $this->createJob($employer, [
            'title' => 'Remote Tech Role',
            'location' => 'Accra, Ghana',
            'category' => 'Technology',
            'employment_type' => 'Full Time',
            'work_arrangement' => 'Remote',
        ]);

        $this->createJob($employer, [
            'title' => 'Onsite Nurse',
            'location' => 'Kumasi',
            'category' => 'Healthcare',
            'employment_type' => 'Part Time',
            'work_arrangement' => 'Onsite',
        ]);

        $response = $this->get(route('jobs.index', [
            'location' => 'Accra',
            'category' => 'Technology',
            'employment_type' => 'Full Time',
            'work_arrangement' => 'Remote',
        ]));

        $response->assertOk();
        $response->assertSee('Remote Tech Role');
        $response->assertDontSee('Onsite Nurse');
        $this->assertTrue($response->viewData('jobs')->contains('id', $matching->id));
    }

    public function test_jobs_can_be_filtered_by_minimum_salary(): void
    {
        $employer = User::factory()->create(['role' => 'employer']);

        $this->createJob($employer, [
            'title' => 'High Pay Role',
            'salary_min' => 10000,
            'salary_max' => 15000,
        ]);

        $this->createJob($employer, [
            'title' => 'Low Pay Role',
            'salary_min' => 2000,
            'salary_max' => 3000,
        ]);

        $response = $this->get(route('jobs.index', [
            'salary_min' => 9000,
        ]));

        $response->assertOk();
        $response->assertSee('High Pay Role');
        $response->assertDontSee('Low Pay Role');
    }

    public function test_jobs_can_be_sorted_by_salary_high_to_low(): void
    {
        $employer = User::factory()->create(['role' => 'employer']);

        $mid = $this->createJob($employer, [
            'title' => 'Mid Salary Role',
            'salary_min' => 4000,
            'salary_max' => 6000,
        ]);
        $mid->forceFill(['created_at' => now()->subDay()])->save();

        $top = $this->createJob($employer, [
            'title' => 'Top Salary Role',
            'salary_min' => 12000,
            'salary_max' => 18000,
        ]);
        $top->forceFill(['created_at' => now()->subDays(2)])->save();

        $response = $this->get(route('jobs.index', [
            'sort' => 'salary_high',
        ]));

        $response->assertOk();

        $titles = $response->viewData('jobs')->pluck('title')->all();

        $this->assertSame(['Top Salary Role', 'Mid Salary Role'], $titles);
    }

    public function test_keyword_search_still_works_with_filters(): void
    {
        $employer = User::factory()->create(['role' => 'employer']);

        $this->createJob($employer, [
            'title' => 'Laravel Developer',
            'company_name' => 'Code Co',
            'category' => 'Technology',
        ]);

        $this->createJob($employer, [
            'title' => 'Nurse',
            'company_name' => 'Health Co',
            'category' => 'Healthcare',
        ]);

        $response = $this->get(route('jobs.index', [
            'q' => 'Laravel',
            'category' => 'Technology',
        ]));

        $response->assertOk();
        $response->assertSee('Laravel Developer');
        $response->assertDontSee('Nurse');
    }

    public function test_inactive_jobs_are_hidden_from_search(): void
    {
        $employer = User::factory()->create(['role' => 'employer']);

        $this->createJob($employer, [
            'title' => 'Hidden Role',
            'is_active' => false,
        ]);

        $response = $this->get(route('jobs.index'));

        $response->assertOk();
        $response->assertDontSee('Hidden Role');
    }
}
