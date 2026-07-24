<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Job extends Model
{
    use HasFactory;

    /**
     * Mass assignable fields
     */
    protected $fillable = [
        'user_id',
        'title',
        'company_name',
        'company_logo',
        'location',
        'work_arrangement',
        'employment_type',
        'category',
        'currency',
        'salary_min',
        'salary_max',
        'description',
        'is_active',
        'is_verified',
    ];

    /**
     * Employer who posted the job
     */
    public function employer()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Job category (Tech, Healthcare, etc)
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Applications for this job
     */
    public function applications()
    {
        return $this->hasMany(Application::class);
    }

    public function questions()
    {
        return $this->hasMany(JobQuestion::class)->orderBy('sort_order');
    }

    public function companyLogoUrl(): ?string
    {
        return $this->company_logo
            ? Storage::disk('public')->url($this->company_logo)
            : null;
    }
}
