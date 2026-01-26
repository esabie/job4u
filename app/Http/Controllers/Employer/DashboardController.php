<?php

namespace App\Http\Controllers\Employer;

use App\Http\Controllers\Controller;
use App\Models\Job;
use App\Models\Application;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $employer = Auth::user();

        $totalJobs = Job::where('user_id', $employer->id)->count();

        $activeJobs = Job::where('user_id', $employer->id)
            ->where('is_active', true)
            ->count();

        $applicationsReceived = Application::whereHas('job', function ($q) use ($employer) {
            $q->where('user_id', $employer->id);
        })->count();

        $recentJobs = Job::where('user_id', $employer->id)
            ->latest()
            ->take(5)
            ->get();

        return view('Employer.dashboard', compact(
            'totalJobs',
            'activeJobs',
            'applicationsReceived',
            'recentJobs'
        ));
    }
}
