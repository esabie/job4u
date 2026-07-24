<?php

namespace App\Http\Controllers;

use App\Models\Job;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PublicJobController extends Controller
{
    public function index(Request $request)
    {
        $query = Job::query()->where('is_active', true);

        if ($request->filled('q')) {
            $term = '%'.$request->string('q')->trim().'%';

            $query->where(function ($builder) use ($term) {
                $builder->where('title', 'like', $term)
                    ->orWhere('company_name', 'like', $term)
                    ->orWhere('category', 'like', $term)
                    ->orWhere('employment_type', 'like', $term)
                    ->orWhere('work_arrangement', 'like', $term)
                    ->orWhere('location', 'like', $term)
                    ->orWhere('description', 'like', $term);
            });
        }

        if ($request->filled('location')) {
            $query->where('location', 'like', '%'.$request->string('location')->trim().'%');
        }

        if ($request->filled('work_arrangement')) {
            $query->where('work_arrangement', $request->string('work_arrangement'));
        }

        $jobs = $query->latest()->paginate(10)->withQueryString();

        $this->logDebug('Public jobs listed', [
            'job_count' => $jobs->total(),
            'filters' => $request->only(['q', 'location', 'work_arrangement']),
        ]);

        return view('public.jobs', compact('jobs'));
    }

    public function show(Job $job)
    {
        abort_if(!$job->is_active, 404);

        $job->load('questions');

        $hasApplied = Auth::check()
            && $job->applications()->where('user_id', Auth::id())->exists();

        $this->logDebug('Public job viewed', [
            'job_id' => $job->id,
            'has_applied' => $hasApplied,
        ]);

        return view('jobs.show', compact('job', 'hasApplied'));
    }
}
