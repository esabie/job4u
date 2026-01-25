<?php

namespace App\Http\Controllers\Employer;

use App\Http\Controllers\Controller;
use App\Models\Application;
use App\Models\Job;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ApplicationController extends Controller
{
    public function index(Job $job)
    {
        abort_unless($job->user_id === Auth::id(), 403);

        $applications = $job->applications()
            ->with('candidate')
            ->latest()
            ->get();

        return view('employer.applications.index', compact('job', 'applications'));
    }

    public function update(Request $request, Application $application)
    {
        abort_unless($application->job->user_id === Auth::id(), 403);

        $request->validate([
            'status' => 'required|in:new,shortlisted,interview,rejected,hired',
        ]);

        $application->update([
            'status' => $request->status,
        ]);

        return back()->with('success', 'Application status updated.');
    }
}
