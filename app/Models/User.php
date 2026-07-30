<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    const ROLE_CANDIDATE = 'candidate';
    const ROLE_EMPLOYER  = 'employer';
    const ROLE_ADMIN     = 'admin';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'role',
        'password',
        'phone',
        'location',
        'headline',
        'summary',
        'cv_path',
        'notify_application_updates',
        'notify_job_alerts',
        'notify_new_applications',
        'is_suspended',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'notify_application_updates' => 'boolean',
            'notify_job_alerts' => 'boolean',
            'notify_new_applications' => 'boolean',
            'is_suspended' => 'boolean',
        ];
    }

    public function isCandidate()
    {
        return $this->role === self::ROLE_CANDIDATE;
    }

    public function isEmployer()
    {
        return $this->role === self::ROLE_EMPLOYER;
    }

    public function isAdmin()
    {
        return $this->role === self::ROLE_ADMIN;
    }

    public function isSuspended(): bool
    {
        return (bool) $this->is_suspended;
    }

    public function jobs()
    {
        return $this->hasMany(Job::class);
    }

    public function applications()
    {
        return $this->hasMany(Application::class);
    }

    public function jobAlerts()
    {
        return $this->hasMany(JobAlert::class);
    }

    public function savedJobs()
    {
        return $this->belongsToMany(Job::class, 'saved_jobs')->withTimestamps();
    }

    public function hasSavedJob(Job $job): bool
    {
        return $this->savedJobs()->where('job_id', $job->id)->exists();
    }

    public function hasSavedCv(): bool
    {
        return filled($this->cv_path);
    }
}
