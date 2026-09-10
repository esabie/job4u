<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Notifications\ResetPasswordNotification;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    public const ROLE_CANDIDATE = 'candidate';

    public const ROLE_EMPLOYER = 'employer';

    public const ROLE_ADMIN = 'admin';

    public const TWO_FACTOR_CODE_LENGTH = 6;

    public const TWO_FACTOR_CODE_TTL_MINUTES = 10;

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
        'two_factor_code',
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
            'two_factor_expires_at' => 'datetime',
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

    /**
     * Generate and store a hashed email OTP. Returns the plain code for emailing.
     */
    public function generateTwoFactorCode(): string
    {
        $max = (10 ** self::TWO_FACTOR_CODE_LENGTH) - 1;
        $code = str_pad((string) random_int(0, $max), self::TWO_FACTOR_CODE_LENGTH, '0', STR_PAD_LEFT);

        $this->forceFill([
            'two_factor_code' => Hash::make($code),
            'two_factor_expires_at' => now()->addMinutes(self::TWO_FACTOR_CODE_TTL_MINUTES),
        ])->save();

        return $code;
    }

    public function verifyTwoFactorCode(string $code): bool
    {
        if (! filled($this->two_factor_code) || $this->two_factor_expires_at === null) {
            return false;
        }

        if ($this->two_factor_expires_at->isPast()) {
            return false;
        }

        return Hash::check($code, $this->two_factor_code);
    }

    public function clearTwoFactorCode(): void
    {
        $this->forceFill([
            'two_factor_code' => null,
            'two_factor_expires_at' => null,
        ])->save();
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

    /**
     * Send the password reset notification.
     */
    public function sendPasswordResetNotification(#[\SensitiveParameter] $token): void
    {
        $this->notify(new ResetPasswordNotification($token));
    }
}
