<?php

namespace App\Http\Controllers\Employer;

use App\Http\Controllers\Controller;
use App\Models\Job;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CompanySuggestionController extends Controller
{
    public function __invoke(Request $request): JsonResponse
    {
        $query = trim($request->string('q')->toString());

        if (strlen($query) < 2) {
            return response()->json([]);
        }

        $employerId = Auth::id();
        $like = '%'.$query.'%';

        $suggestions = Job::query()
            ->select('company_name')
            ->selectRaw('COUNT(*) as job_count')
            ->selectRaw('MAX(CASE WHEN user_id = ? THEN 1 ELSE 0 END) as is_mine', [$employerId])
            ->where('company_name', 'like', $like)
            ->groupBy('company_name')
            ->orderByDesc('is_mine')
            ->orderByDesc('job_count')
            ->orderBy('company_name')
            ->limit(8)
            ->get()
            ->map(fn (Job $job) => [
                'name' => $job->company_name,
                'job_count' => (int) $job->job_count,
                'is_mine' => (bool) $job->is_mine,
            ])
            ->values();

        $this->logDebug('Company name suggestions fetched', [
            'query' => $query,
            'result_count' => $suggestions->count(),
        ]);

        return response()->json($suggestions);
    }
}
