<?php

namespace App\Http\Controllers\Candidate;

use App\Http\Controllers\Controller;
use App\Models\Application;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $this->logDebug('Candidate dashboard viewed', [
            'candidate_id' => $user->id,
        ]);

        $applications = Application::with('job')
            ->where('user_id', $user->id)
            ->latest()
            ->get();

        $this->logDebug('Candidate applications loaded', [
            'application_count' => $applications->count(),
        ]);

        return view('Candidate.dashboard', [
            'applications' => $applications,
            'totalApplications' => $applications->count(),
            'shortlisted' => $applications->where('status', 'shortlisted')->count(),
            'interviews' => $applications->where('status', 'interview')->count(),
        ]);
    }
}
