<?php

namespace App\Http\Controllers\Candidate;

use App\Http\Controllers\Controller;
use App\Models\Application;
use Illuminate\Support\Facades\Auth;

class ApplicationController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        abort_if($user->role !== 'candidate', 403);

        $applications = Application::with('job')
            ->where('user_id', $user->id)
            ->latest()
            ->paginate(10);

        $this->logDebug('Candidate applications listed', [
            'candidate_id' => $user->id,
            'application_count' => $applications->total(),
        ]);

        return view('candidate.applications.index', compact('applications'));
    }

    public function show(Application $application)
    {
        abort_if(Auth::user()->role !== 'candidate', 403);

        abort_if($application->user_id !== Auth::id(), 403);

        $application->load(['job', 'answers.jobQuestion']);

        $this->logDebug('Candidate application viewed', [
            'application_id' => $application->id,
            'job_id' => $application->job_id,
        ]);

        return view('candidate.applications.show', compact('application'));
    }
}
