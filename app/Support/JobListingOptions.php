<?php

namespace App\Support;

class JobListingOptions
{
    public static function categories(): array
    {
        return [
            'Administration',
            'Construction',
            'Finance',
            'Healthcare',
            'Hospitality',
            'Legal',
            'Technology',
            'Other',
        ];
    }

    public static function employmentTypes(): array
    {
        return [
            'Full Time',
            'Part Time',
            'Contract',
        ];
    }

    public static function sortOptions(): array
    {
        return [
            'newest' => 'Newest first',
            'oldest' => 'Oldest first',
            'salary_high' => 'Salary: high to low',
            'salary_low' => 'Salary: low to high',
        ];
    }
}
