<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Application;
use App\Models\Job;
use App\Models\User;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $stats = [
            'users' => User::query()->count(),
            'employers' => User::query()->where('role', User::ROLE_EMPLOYER)->count(),
            'candidates' => User::query()->where('role', User::ROLE_CANDIDATE)->count(),
            'active_jobs' => Job::query()->where('is_active', true)->count(),
            'unverified_jobs' => Job::query()->where('is_active', true)->where('is_verified', false)->count(),
            'suspended_users' => User::query()->where('is_suspended', true)->count(),
            'applications' => Application::query()->count(),
        ];

        $pendingJobs = Job::query()
            ->with('employer')
            ->where('is_active', true)
            ->where('is_verified', false)
            ->latest()
            ->limit(8)
            ->get();

        $this->logDebug('Admin dashboard viewed');

        return view('admin.dashboard', compact('stats', 'pendingJobs'));
    }
}
