<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Job;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class JobController extends Controller
{
    public function index(Request $request): View
    {
        $query = Job::query()->with('employer')->latest();

        if ($request->string('status')->toString() === 'pending') {
            $query->where('is_active', true)->where('is_verified', false);
        } elseif ($request->string('status')->toString() === 'verified') {
            $query->where('is_verified', true);
        } elseif ($request->string('status')->toString() === 'inactive') {
            $query->where('is_active', false);
        }

        if ($request->filled('q')) {
            $term = '%'.$request->string('q')->trim().'%';

            $query->where(function ($builder) use ($term) {
                $builder->where('title', 'like', $term)
                    ->orWhere('company_name', 'like', $term)
                    ->orWhere('location', 'like', $term);
            });
        }

        $jobs = $query->paginate(20)->withQueryString();

        $this->logDebug('Admin jobs listed', [
            'job_count' => $jobs->total(),
            'filters' => $request->only(['status', 'q']),
        ]);

        return view('admin.jobs.index', compact('jobs'));
    }

    public function show(Job $job): View
    {
        $job->load(['employer', 'questions']);

        $this->logDebug('Admin job viewed', [
            'job_id' => $job->id,
        ]);

        return view('admin.jobs.show', compact('job'));
    }

    public function verify(Job $job): RedirectResponse
    {
        $job->update([
            'is_verified' => true,
            'is_active' => true,
        ]);

        $this->logInfo('Admin verified job', [
            'job_id' => $job->id,
        ]);

        return back()->with('success', 'Job verified and published.');
    }

    public function unverify(Job $job): RedirectResponse
    {
        $job->update(['is_verified' => false]);

        $this->logInfo('Admin unverified job', [
            'job_id' => $job->id,
        ]);

        return back()->with('success', 'Verification removed from job.');
    }

    public function activate(Job $job): RedirectResponse
    {
        $job->update(['is_active' => true]);

        $this->logInfo('Admin activated job', [
            'job_id' => $job->id,
        ]);

        return back()->with('success', 'Job is now active on the public board.');
    }

    public function deactivate(Job $job): RedirectResponse
    {
        $job->update(['is_active' => false]);

        $this->logInfo('Admin deactivated job', [
            'job_id' => $job->id,
        ]);

        return back()->with('success', 'Job hidden from the public board.');
    }
}
