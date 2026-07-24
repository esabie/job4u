<?php

namespace App\Models;

use App\Enums\QuestionType;
use Illuminate\Database\Eloquent\Model;

class JobQuestion extends Model
{
    protected $fillable = [
        'job_id',
        'question',
        'type',
        'is_required',
        'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'is_required' => 'boolean',
            'type' => QuestionType::class,
        ];
    }

    public function job()
    {
        return $this->belongsTo(Job::class);
    }

    public function answers()
    {
        return $this->hasMany(ApplicationAnswer::class);
    }
}
