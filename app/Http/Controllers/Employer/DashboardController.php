<?php

namespace App\Http\Controllers\Employer;

use App\Http\Controllers\Controller;
use App\Models\Application;
use App\Models\Job;
use App\Enums\ApplicationStatus;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $employer = Auth::user();

        $this->logDebug('Employer dashboard viewed', [
            'employer_id' => $employer->id,
        ]);

        $employerJobIds = Job::where('user_id', $employer->id)->pluck('id');

        $activeJobs = Job::where('user_id', $employer->id)
            ->where('is_active', true)
            ->count();

        $newApplicants = Application::whereIn('job_id', $employerJobIds)
            ->where('status', ApplicationStatus::Applied)
            ->count();

        $applicantsByDay = collect(range(6, 0))->map(function (int $daysAgo) use ($employerJobIds) {
            $date = now()->subDays($daysAgo);

            return [
                'label' => $date->format('D'),
                'count' => Application::whereIn('job_id', $employerJobIds)
                    ->whereDate('created_at', $date->toDateString())
                    ->count(),
            ];
        });

        $maxDailyApplicants = max($applicantsByDay->max('count'), 1);

        $applicantsByDay = $applicantsByDay->map(function (array $day) use ($maxDailyApplicants) {
            $day['height'] = $day['count'] > 0
                ? max(12, (int) round(($day['count'] / $maxDailyApplicants) * 120))
                : 4;

            return $day;
        });

        $recentApplications = Application::whereIn('job_id', $employerJobIds)
            ->with(['candidate', 'job'])
            ->latest()
            ->take(5)
            ->get();

        $this->logDebug('Employer dashboard stats loaded', [
            'active_jobs' => $activeJobs,
            'new_applicants' => $newApplicants,
            'recent_applications' => $recentApplications->count(),
        ]);

        return view('employer.dashboard', compact(
            'activeJobs',
            'newApplicants',
            'applicantsByDay',
            'recentApplications',
        ));
    }
}
