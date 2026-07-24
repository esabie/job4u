<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ApplicationAnswer extends Model
{
    protected $fillable = [
        'application_id',
        'job_question_id',
        'answer',
    ];

    public function application()
    {
        return $this->belongsTo(Application::class);
    }

    public function jobQuestion()
    {
        return $this->belongsTo(JobQuestion::class);
    }
}
