<?php

namespace App\Http\Controllers\Employer;

use App\Http\Controllers\Controller;
use App\Models\Job;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JobController extends Controller
{
    public function index()
    {
        $jobs = Job::where('user_id', Auth::id())
            ->latest()
            ->paginate(10);

        return view('employer.jobs.index', compact('jobs'));
    }

    public function destroy(Job $job)
    {
        abort_unless($job->user_id === Auth::id(), 403);

        $job->update([
            'is_active' => false
        ]);

        return back()->with('success', 'Job hidden successfully.');
    }

    public function create()
    {
        return view('employer.jobs.create');
    }

    public function edit(Job $job)
{
    abort_unless($job->user_id === Auth::id(), 403);

    return view('employer.jobs.edit', compact('job'));
}

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'            => 'required|string|max:255',
            'company_name'     => 'required|string|max:255',
            'location'         => 'required|string|max:255',
            'employment_type'  => 'required|string',
            'category'         => 'required|string',
            'currency'        => 'nullable|string|max:5',
            'salary_min'       => 'nullable|integer',
            'salary_max'       => 'nullable|integer|gte:salary_min',
            'description'      => 'required|string',
        ]);

        Job::create([
            'user_id'          => Auth::id(),
            'title'            => $validated['title'],
            'company_name'     => $validated['company_name'],
            'location'         => $validated['location'],
            'employment_type'  => $validated['employment_type'],
            'category'         => $validated['category'],
            'currency'         => $validated['currency'],
            'salary_min'       => $validated['salary_min'],
            'salary_max'       => $validated['salary_max'],
            'description'      => $validated['description'],
            'is_active'        => true,
            'is_verified'      => false,
        ]);

        return redirect()
            ->route('employer.dashboard')
            ->with('success', 'Job posted successfully.');
    }

    public function update(Request $request, Job $job)
    {
        abort_unless($job->user_id === Auth::id(), 403);

        $validated = $request->validate([
            'title'            => 'required|string|max:255',
            'company_name'     => 'required|string|max:255',
            'location'         => 'required|string|max:255',
            'employment_type'  => 'required|string',
            'category'         => 'required|string',
            'currency'         => 'nullable|string|max:5',
            'salary_min'       => 'nullable|integer',
            'salary_max'       => 'nullable|integer|gte:salary_min',
            'description'      => 'required|string',
            'is_active'        => 'required|boolean',
        ]);

        $job->update($validated);

        return redirect()
            ->route('employer.jobs.index')
            ->with('success', 'Job updated successfully.');
    }
}
