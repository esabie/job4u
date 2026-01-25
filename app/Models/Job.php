<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
        'location',
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
}
