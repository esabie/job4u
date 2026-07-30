<?php

namespace App\Http\Controllers\Employer;

use App\Http\Controllers\Controller;
use App\Enums\ApplicationStatus;
use App\Models\Application;
use App\Models\Job;
use App\Notifications\ApplicationStatusNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class ApplicationController extends Controller
{
    public function all()
    {
        $applications = Application::whereHas('job', function ($query) {
                $query->where('user_id', Auth::id());
            })
            ->with(['candidate', 'job'])
            ->latest()
            ->paginate(15);

        $this->logDebug('Employer all applications listed', [
            'employer_id' => Auth::id(),
            'application_count' => $applications->total(),
        ]);

        return view('employer.applications.all', compact('applications'));
    }

    public function index(Job $job)
    {
        abort_unless($job->user_id === Auth::id(), 403);

        $applications = $job->applications()
            ->with('candidate')
            ->latest()
            ->get();

        $this->logDebug('Employer job applications listed', [
            'job_id' => $job->id,
            'application_count' => $applications->count(),
        ]);

        return view('employer.applications.index', compact('job', 'applications'));
    }

    public function show(Application $application)
    {
        abort_unless($application->job->user_id === Auth::id(), 403);

        $application->load(['job', 'candidate', 'answers.jobQuestion']);

        $this->logDebug('Employer application viewed', [
            'application_id' => $application->id,
            'job_id' => $application->job_id,
        ]);

        return view('employer.applications.show', compact('application'));
    }

    public function update(Request $request, Application $application)
    {
        abort_unless($application->job->user_id === Auth::id(), 403);

        $this->logInfo('Application status update attempt', [
            'application_id' => $application->id,
            'job_id' => $application->job_id,
            'current_status' => $application->status,
            'input' => $this->sanitizedInput($request),
        ]);

        $request->validate([
            'status' => ['required', Rule::enum(ApplicationStatus::class)],
        ]);

        $application->update([
            'status' => $request->enum('status', ApplicationStatus::class),
        ]);

        $this->logInfo('Application status updated', [
            'application_id' => $application->id,
            'status' => $application->status?->value,
        ]);

        $candidate = $application->candidate;

        if ($candidate && $candidate->notify_application_updates) {
            $candidate->notify(new ApplicationStatusNotification($application));

            $this->logInfo('Application status notification sent', [
                'application_id' => $application->id,
                'candidate_id' => $candidate->id,
            ]);
        }

        return back()->with('success', 'Application status updated.');
    }
}
