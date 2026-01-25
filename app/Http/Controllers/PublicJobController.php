<?php

namespace App\Http\Controllers;

use App\Models\Job;
use Illuminate\Support\Facades\Auth;

class PublicJobController extends Controller
{
    public function index()
    {
        $jobs = Job::where('is_active', true)->latest() ->paginate(10);


        return view('public.jobs', compact('jobs'));
    }

    public function show(Job $job)
    {
        abort_if(!$job->is_active, 404);

        $hasApplied = Auth::check()
            && $job->applications()->where('user_id', Auth::id())->exists();

        return view('jobs.show', compact('job', 'hasApplied'));
    }

}
