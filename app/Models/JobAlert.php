<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class JobAlert extends Model
{
    protected $fillable = [
        'user_id',
        'keyword',
        'category',
        'work_arrangement',
        'location',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Determine whether a given job matches this alert's criteria.
     */
    public function matches(Job $job): bool
    {
        if ($this->keyword) {
            $haystack = strtolower(implode(' ', [
                $job->title,
                $job->company_name,
                $job->category,
                $job->description,
            ]));

            if (! str_contains($haystack, strtolower($this->keyword))) {
                return false;
            }
        }

        if ($this->category && $this->category !== $job->category) {
            return false;
        }

        if ($this->work_arrangement && $this->work_arrangement !== $job->work_arrangement) {
            return false;
        }

        if ($this->location && ! str_contains(strtolower($job->location), strtolower($this->location))) {
            return false;
        }

        return true;
    }

    /**
     * Build a query of active jobs matching this alert's criteria.
     */
    public function matchingJobsQuery(): Builder
    {
        $query = Job::query()->where('is_active', true);

        if ($this->keyword) {
            $term = '%'.$this->keyword.'%';

            $query->where(function (Builder $builder) use ($term) {
                $builder->where('title', 'like', $term)
                    ->orWhere('company_name', 'like', $term)
                    ->orWhere('category', 'like', $term)
                    ->orWhere('description', 'like', $term);
            });
        }

        if ($this->category) {
            $query->where('category', $this->category);
        }

        if ($this->work_arrangement) {
            $query->where('work_arrangement', $this->work_arrangement);
        }

        if ($this->location) {
            $query->where('location', 'like', '%'.$this->location.'%');
        }

        return $query;
    }
}
