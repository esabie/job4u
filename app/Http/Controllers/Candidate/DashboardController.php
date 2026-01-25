<?php

namespace App\Http\Controllers\Candidate;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\Controller;
use App\Models\Application;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $applications = Application::with('job')
            ->where('user_id', $user->id)
            ->latest()
            ->get();

        return view('candidate.dashboard', [
            'applications' => $applications,
            'totalApplications' => $applications->count(),
            'shortlisted' => $applications->where('status', 'shortlisted')->count(),
            'interviews' => $applications->where('status', 'interview')->count(),
        ]);
    }
}
