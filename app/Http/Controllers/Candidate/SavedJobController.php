<?php

namespace App\Http\Controllers\Candidate;

use App\Http\Controllers\Controller;
use App\Models\Job;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class SavedJobController extends Controller
{
    public function index(): View
    {
        $user = Auth::user();

        abort_unless($user->isCandidate(), 403);

        $jobs = $user->savedJobs()
            ->where('is_active', true)
            ->latest('saved_jobs.created_at')
            ->paginate(10);

        $this->logDebug('Saved jobs listed', [
            'candidate_id' => $user->id,
            'job_count' => $jobs->total(),
        ]);

        return view('candidate.saved.index', compact('jobs'));
    }

    public function store(Job $job): RedirectResponse
    {
        $user = Auth::user();

        abort_unless($user->isCandidate(), 403);
        abort_unless($job->is_active, 404);

        $user->savedJobs()->syncWithoutDetaching([$job->id]);

        $this->logInfo('Job saved', [
            'candidate_id' => $user->id,
            'job_id' => $job->id,
        ]);

        return back()->with('success', 'Job saved.');
    }

    public function destroy(Job $job): RedirectResponse
    {
        $user = Auth::user();

        abort_unless($user->isCandidate(), 403);

        $user->savedJobs()->detach($job->id);

        $this->logInfo('Job unsaved', [
            'candidate_id' => $user->id,
            'job_id' => $job->id,
        ]);

        return back()->with('success', 'Job removed from saved jobs.');
    }
}
