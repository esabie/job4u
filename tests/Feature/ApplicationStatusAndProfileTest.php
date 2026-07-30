<?php

namespace Tests\Feature;

use App\Enums\ApplicationStatus;
use App\Models\Application;
use App\Models\Job;
use App\Models\User;
use App\Notifications\NewApplicationNotification;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ApplicationStatusAndProfileTest extends TestCase
{
    use RefreshDatabase;

    public function test_employer_can_set_hired_status(): void
    {
        $employer = User::factory()->create(['role' => 'employer']);
        $candidate = User::factory()->create(['role' => 'candidate']);

        $job = Job::create([
            'user_id' => $employer->id,
            'title' => 'Engineer',
            'company_name' => 'Acme',
            'location' => 'Accra',
            'employment_type' => 'Full Time',
            'category' => 'Technology',
            'description' => 'Build things',
            'is_active' => true,
            'is_verified' => false,
        ]);

        $application = Application::create([
            'job_id' => $job->id,
            'user_id' => $candidate->id,
            'cv_path' => 'cvs/test.pdf',
            'status' => ApplicationStatus::Applied,
        ]);

        $this->actingAs($employer)
            ->patch(route('employer.applications.update', $application), [
                'status' => ApplicationStatus::Hired->value,
            ])
            ->assertRedirect();

        $this->assertSame(ApplicationStatus::Hired, $application->fresh()->status);
    }

    public function test_candidate_can_save_profile_and_cv(): void
    {
        Storage::fake('public');

        $candidate = User::factory()->create(['role' => 'candidate']);
        $cv = UploadedFile::fake()->create('resume.pdf', 100, 'application/pdf');

        $this->actingAs($candidate)
            ->patch('/profile', [
                'phone' => '+233200000000',
                'location' => 'Accra, Ghana',
                'headline' => 'Backend Developer',
                'summary' => 'I build APIs.',
                'cv' => $cv,
            ])
            ->assertSessionHasNoErrors()
            ->assertRedirect('/profile');

        $candidate->refresh();

        $this->assertSame('+233200000000', $candidate->phone);
        $this->assertSame('Accra, Ghana', $candidate->location);
        $this->assertSame('Backend Developer', $candidate->headline);
        $this->assertNotNull($candidate->cv_path);
        Storage::disk('public')->assertExists($candidate->cv_path);
    }

    public function test_candidate_can_apply_with_saved_cv_and_employer_is_notified(): void
    {
        Storage::fake('public');
        Notification::fake();

        $employer = User::factory()->create(['role' => 'employer']);
        $candidate = User::factory()->create([
            'role' => 'candidate',
            'cv_path' => 'cvs/profiles/saved.pdf',
        ]);

        Storage::disk('public')->put($candidate->cv_path, 'fake-cv');

        $job = Job::create([
            'user_id' => $employer->id,
            'title' => 'Engineer',
            'company_name' => 'Acme',
            'location' => 'Accra',
            'employment_type' => 'Full Time',
            'category' => 'Technology',
            'description' => 'Build things',
            'is_active' => true,
            'is_verified' => false,
        ]);

        $this->actingAs($candidate)
            ->post(route('jobs.apply', $job), [
                'use_saved_cv' => '1',
                'cover_letter' => 'I am interested.',
            ])
            ->assertSessionHasNoErrors()
            ->assertRedirect();

        $application = Application::where('job_id', $job->id)->where('user_id', $candidate->id)->first();

        $this->assertNotNull($application);
        $this->assertSame(ApplicationStatus::Applied, $application->status);
        $this->assertNotSame($candidate->cv_path, $application->cv_path);
        Storage::disk('public')->assertExists($application->cv_path);

        Notification::assertSentTo($employer, NewApplicationNotification::class);
    }

    public function test_employer_is_not_notified_when_new_application_emails_are_disabled(): void
    {
        Storage::fake('public');
        Notification::fake();

        $employer = User::factory()->create([
            'role' => 'employer',
            'notify_new_applications' => false,
        ]);
        $candidate = User::factory()->create(['role' => 'candidate']);
        $cv = UploadedFile::fake()->create('resume.pdf', 100, 'application/pdf');

        $job = Job::create([
            'user_id' => $employer->id,
            'title' => 'Engineer',
            'company_name' => 'Acme',
            'location' => 'Accra',
            'employment_type' => 'Full Time',
            'category' => 'Technology',
            'description' => 'Build things',
            'is_active' => true,
            'is_verified' => false,
        ]);

        $this->actingAs($candidate)
            ->post(route('jobs.apply', $job), [
                'cv' => $cv,
            ])
            ->assertSessionHasNoErrors()
            ->assertRedirect();

        Notification::assertNotSentTo($employer, NewApplicationNotification::class);
    }

    public function test_employer_can_update_new_application_notification_preference(): void
    {
        $employer = User::factory()->create([
            'role' => 'employer',
            'notify_new_applications' => true,
        ]);

        $this->actingAs($employer)
            ->patch(route('settings.update'), [])
            ->assertRedirect();

        $this->assertFalse($employer->fresh()->notify_new_applications);

        $this->actingAs($employer)
            ->patch(route('settings.update'), [
                'notify_new_applications' => '1',
            ])
            ->assertRedirect();

        $this->assertTrue($employer->fresh()->notify_new_applications);
    }
}
