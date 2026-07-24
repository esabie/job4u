<?php

namespace Tests\Feature;

use App\Models\Job;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CompanySuggestionTest extends TestCase
{
    use RefreshDatabase;

    public function test_employer_can_fetch_company_name_suggestions(): void
    {
        $employer = User::factory()->create(['role' => 'employer']);
        $otherEmployer = User::factory()->create(['role' => 'employer']);

        Job::create([
            'user_id' => $employer->id,
            'title' => 'Network Engineer',
            'company_name' => 'MTN Ghana',
            'location' => 'Accra, Ghana',
            'employment_type' => 'Full Time',
            'category' => 'Technology',
            'description' => 'Test job description',
            'is_active' => true,
            'is_verified' => false,
        ]);

        Job::create([
            'user_id' => $employer->id,
            'title' => 'Product Manager',
            'company_name' => 'MTN Group',
            'location' => 'Accra, Ghana',
            'employment_type' => 'Full Time',
            'category' => 'Technology',
            'description' => 'Test job description',
            'is_active' => true,
            'is_verified' => false,
        ]);

        Job::create([
            'user_id' => $otherEmployer->id,
            'title' => 'Sales Lead',
            'company_name' => 'MTN Mobile Money',
            'location' => 'Accra, Ghana',
            'employment_type' => 'Full Time',
            'category' => 'Finance',
            'description' => 'Test job description',
            'is_active' => true,
            'is_verified' => false,
        ]);

        $response = $this->actingAs($employer)->getJson(
            route('employer.companies.suggest', ['q' => 'MTN'])
        );

        $response->assertOk()
            ->assertJsonCount(3)
            ->assertJsonFragment(['name' => 'MTN Ghana', 'is_mine' => true])
            ->assertJsonFragment(['name' => 'MTN Mobile Money', 'is_mine' => false]);
    }

    public function test_company_suggestions_require_at_least_two_characters(): void
    {
        $employer = User::factory()->create(['role' => 'employer']);

        Job::create([
            'user_id' => $employer->id,
            'title' => 'Customer Service Rep',
            'company_name' => 'Vodafone Ghana',
            'location' => 'Accra, Ghana',
            'employment_type' => 'Full Time',
            'category' => 'Technology',
            'description' => 'Test job description',
            'is_active' => true,
            'is_verified' => false,
        ]);

        $this->actingAs($employer)
            ->getJson(route('employer.companies.suggest', ['q' => 'V']))
            ->assertOk()
            ->assertExactJson([]);

        $this->actingAs($employer)
            ->getJson(route('employer.companies.suggest', ['q' => 'Vo']))
            ->assertOk()
            ->assertJsonFragment(['name' => 'Vodafone Ghana']);
    }

    public function test_candidates_cannot_access_company_suggestions(): void
    {
        $candidate = User::factory()->create(['role' => 'candidate']);

        $this->actingAs($candidate)
            ->getJson(route('employer.companies.suggest', ['q' => 'MTN']))
            ->assertForbidden();
    }
}
