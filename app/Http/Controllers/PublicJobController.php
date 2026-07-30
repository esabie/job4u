<?php

namespace App\Http\Controllers;

use App\Enums\WorkArrangement;
use App\Models\Job;
use App\Support\JobListingOptions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class PublicJobController extends Controller
{
    public function index(Request $request)
    {
        $validated = $request->validate([
            'q' => ['nullable', 'string', 'max:255'],
            'location' => ['nullable', 'string', 'max:255'],
            'category' => ['nullable', 'string', 'max:255'],
            'employment_type' => ['nullable', 'string', 'max:255'],
            'work_arrangement' => ['nullable', Rule::in(WorkArrangement::values())],
            'salary_min' => ['nullable', 'integer', 'min:0'],
            'sort' => ['nullable', Rule::in(array_keys(JobListingOptions::sortOptions()))],
        ]);

        $query = Job::query()->where('is_active', true);

        if (! empty($validated['q'])) {
            $term = '%'.trim($validated['q']).'%';

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

        if (! empty($validated['location'])) {
            $query->where('location', 'like', '%'.trim($validated['location']).'%');
        }

        if (! empty($validated['category'])) {
            $query->where('category', $validated['category']);
        }

        if (! empty($validated['employment_type'])) {
            $query->where('employment_type', $validated['employment_type']);
        }

        if (! empty($validated['work_arrangement'])) {
            $query->where('work_arrangement', $validated['work_arrangement']);
        }

        if (isset($validated['salary_min'])) {
            $minSalary = (int) $validated['salary_min'];

            $query->where(function ($builder) use ($minSalary) {
                $builder->where('salary_max', '>=', $minSalary)
                    ->orWhere('salary_min', '>=', $minSalary);
            });
        }

        $sort = $validated['sort'] ?? 'newest';

        match ($sort) {
            'oldest' => $query->orderBy('created_at'),
            'salary_high' => $query->orderByRaw('salary_max is null')
                ->orderByDesc('salary_max')
                ->orderByDesc('created_at'),
            'salary_low' => $query->orderByRaw('salary_min is null')
                ->orderBy('salary_min')
                ->orderByDesc('created_at'),
            default => $query->latest(),
        };

        $jobs = $query->paginate(10)->withQueryString();

        $categories = collect(JobListingOptions::categories())
            ->merge(
                Job::query()
                    ->where('is_active', true)
                    ->whereNotNull('category')
                    ->distinct()
                    ->pluck('category')
            )
            ->filter()
            ->unique()
            ->sort()
            ->values();

        $filters = [
            'q' => $validated['q'] ?? null,
            'location' => $validated['location'] ?? null,
            'category' => $validated['category'] ?? null,
            'employment_type' => $validated['employment_type'] ?? null,
            'work_arrangement' => $validated['work_arrangement'] ?? null,
            'salary_min' => $validated['salary_min'] ?? null,
            'sort' => $sort,
        ];

        $hasActiveFilters = collect($filters)
            ->except('sort')
            ->filter(fn ($value) => filled($value))
            ->isNotEmpty()
            || $sort !== 'newest';

        $this->logDebug('Public jobs listed', [
            'job_count' => $jobs->total(),
            'filters' => $filters,
        ]);

        $savedJobIds = [];
        $appliedJobIds = [];

        if (Auth::check() && Auth::user()->isCandidate()) {
            $jobIds = $jobs->getCollection()->pluck('id');

            $savedJobIds = Auth::user()
                ->savedJobs()
                ->whereIn('jobs.id', $jobIds)
                ->pluck('jobs.id')
                ->all();

            $appliedJobIds = Auth::user()
                ->applications()
                ->whereIn('job_id', $jobIds)
                ->pluck('job_id')
                ->all();
        }

        return view('public.jobs', [
            'jobs' => $jobs,
            'filters' => $filters,
            'categories' => $categories,
            'employmentTypes' => JobListingOptions::employmentTypes(),
            'sortOptions' => JobListingOptions::sortOptions(),
            'hasActiveFilters' => $hasActiveFilters,
            'savedJobIds' => $savedJobIds,
            'appliedJobIds' => $appliedJobIds,
        ]);
    }

    public function show(Job $job)
    {
        abort_if(! $job->is_active, 404);

        $job->load('questions');

        $user = Auth::user();

        $hasApplied = $user
            && $job->applications()->where('user_id', $user->id)->exists();

        $isSaved = $user && $user->isCandidate() && $user->hasSavedJob($job);

        $this->logDebug('Public job viewed', [
            'job_id' => $job->id,
            'has_applied' => $hasApplied,
            'is_saved' => $isSaved,
        ]);

        return view('jobs.show', compact('job', 'hasApplied', 'isSaved'));
    }
}
