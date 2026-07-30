<?php

namespace App\Http\Controllers\Candidate;

use App\Http\Controllers\Controller;
use App\Enums\ApplicationStatus;
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

        $applicationsByDay = collect(range(6, 0))->map(function (int $daysAgo) use ($user) {
            $date = now()->subDays($daysAgo);

            return [
                'label' => $date->format('D'),
                'count' => Application::where('user_id', $user->id)
                    ->whereDate('created_at', $date->toDateString())
                    ->count(),
            ];
        });

        $maxDailyApplications = max($applicationsByDay->max('count'), 1);

        $applicationsByDay = $applicationsByDay->map(function (array $day) use ($maxDailyApplications) {
            $day['height'] = $day['count'] > 0
                ? max(12, (int) round(($day['count'] / $maxDailyApplications) * 120))
                : 4;

            return $day;
        });

        $this->logDebug('Candidate applications loaded', [
            'application_count' => $applications->count(),
        ]);

        return view('Candidate.dashboard', [
            'applications' => $applications,
            'totalApplications' => $applications->count(),
            'shortlisted' => $applications->where('status', ApplicationStatus::Shortlisted)->count(),
            'interviews' => $applications->where('status', ApplicationStatus::Interview)->count(),
            'applicationsByDay' => $applicationsByDay,
        ]);
    }
}
