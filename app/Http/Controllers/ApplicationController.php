<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\Job;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ApplicationController extends Controller
{
    public function store(Request $request, Job $job)
    {
        // Only candidates can apply
        abort_if(Auth::user()->role !== 'candidate', 403);

        // Prevent applying to hidden jobs
        abort_if(!$job->is_active, 403);

        // Prevent duplicate applications
        if ($job->applications()->where('user_id', Auth::id())->exists()) {
            return back()->with('error', 'You have already applied to this job.');
        }

        $validated = $request->validate([
            'cv' => 'required|mimes:pdf,doc,docx|max:2048',
            'cover_letter' => 'nullable|string',
        ]);

        $cvPath = $request->file('cv')->store('cvs', 'public');

        Application::create([
            'job_id'       => $job->id,
            'user_id'      => Auth::id(),
            'cv_path'      => $cvPath,
            'cover_letter' => $validated['cover_letter'] ?? null,
        ]);

        return back()->with('success', 'Application submitted successfully.');
    }
}
