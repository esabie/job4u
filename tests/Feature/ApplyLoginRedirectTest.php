<?php

namespace Tests\Feature;

use App\Models\Job;
use App\Models\User;
use App\Support\SafeIntendedUrl;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ApplyLoginRedirectTest extends TestCase
{
    use RefreshDatabase;

    private function createJob(User $employer): Job
    {
        return Job::create([
            'user_id' => $employer->id,
            'title' => 'Backend Engineer',
            'company_name' => 'Acme',
            'location' => 'Accra',
            'work_arrangement' => 'Hybrid',
            'employment_type' => 'Full Time',
            'category' => 'Technology',
            'currency' => 'GHS',
            'salary_min' => 5000,
            'salary_max' => 8000,
            'description' => 'Build APIs',
            'is_active' => true,
            'is_verified' => false,
        ]);
    }

    public function test_login_to_apply_returns_user_to_the_job_listing(): void
    {
        $employer = User::factory()->create(['role' => 'employer']);
        $candidate = User::factory()->create([
            'role' => 'candidate',
            'password' => bcrypt('password'),
        ]);
        $job = $this->createJob($employer);

        $intended = SafeIntendedUrl::forRoute('jobs.show', $job);

        $this->get(route('login', ['redirect' => $intended]))
            ->assertOk();

        $this->assertSame($intended, session('url.intended'));

        $this->post('/login', [
            'email' => $candidate->email,
            'password' => 'password',
            'redirect' => $intended,
        ])
            ->assertRedirect($intended);

        $this->assertAuthenticatedAs($candidate);
    }

    public function test_login_accepts_absolute_url_when_host_differs_from_app_url(): void
    {
        config(['app.url' => 'http://localhost']);

        $employer = User::factory()->create(['role' => 'employer']);
        $candidate = User::factory()->create([
            'role' => 'candidate',
            'password' => bcrypt('password'),
        ]);
        $job = $this->createJob($employer);

        $absolute = 'http://127.0.0.1/jobs/'.$job->id;
        $relative = '/jobs/'.$job->id;

        $this->get('http://127.0.0.1/login?redirect='.urlencode($absolute))
            ->assertOk();

        $this->assertSame($relative, session('url.intended'));

        $this->post('http://127.0.0.1/login', [
            'email' => $candidate->email,
            'password' => 'password',
            'redirect' => $absolute,
        ])
            ->assertRedirect($relative);
    }

    public function test_registering_after_login_to_apply_returns_to_the_job_listing(): void
    {
        $employer = User::factory()->create(['role' => 'employer']);
        $job = $this->createJob($employer);

        $intended = SafeIntendedUrl::forRoute('jobs.show', $job);

        $this->get(route('login', ['redirect' => $intended]))->assertOk();

        $this->get(route('register', ['redirect' => $intended]))->assertOk();

        $this->post('/register', [
            'name' => 'New Candidate',
            'email' => 'new.candidate@example.com',
            'role' => 'candidate',
            'password' => 'password',
            'password_confirmation' => 'password',
            'terms' => '1',
            'redirect' => $intended,
        ])
            ->assertRedirect($intended);

        $this->assertAuthenticated();
    }

    public function test_external_redirect_query_is_ignored(): void
    {
        $this->get(route('login', ['redirect' => 'https://evil.example/phish']))
            ->assertOk();

        $this->assertNull(session('url.intended'));
    }

    public function test_job_show_login_to_apply_link_includes_relative_redirect(): void
    {
        $employer = User::factory()->create(['role' => 'employer']);
        $job = $this->createJob($employer);

        $this->get(route('jobs.show', $job))
            ->assertOk()
            ->assertSee(
                'redirect='.urlencode(SafeIntendedUrl::forRoute('jobs.show', $job)),
                false
            );
    }
}
