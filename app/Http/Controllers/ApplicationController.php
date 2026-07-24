<?php

namespace App\Http\Controllers;

use App\Enums\QuestionType;
use App\Models\Application;
use App\Models\ApplicationAnswer;
use App\Models\Job;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class ApplicationController extends Controller
{
    public function store(Request $request, Job $job)
    {
        $this->logInfo('Job application attempt', [
            'job_id' => $job->id,
            'user_id' => Auth::id(),
        ]);

        abort_if(Auth::user()->role !== 'candidate', 403);

        abort_if(!$job->is_active, 403);

        if ($job->applications()->where('user_id', Auth::id())->exists()) {
            $this->logWarning('Duplicate job application blocked', [
                'job_id' => $job->id,
                'user_id' => Auth::id(),
            ]);

            return back()->with('error', 'You have already applied to this job.');
        }

        $job->load('questions');

        $rules = [
            'cv' => 'required|mimes:pdf,doc,docx|max:2048',
            'cover_letter' => 'nullable|string|max:5000',
            'answers' => 'nullable|array',
        ];

        foreach ($job->questions as $question) {
            $key = 'answers.'.$question->id;

            if ($question->type === QuestionType::YesNo) {
                $rules[$key] = $question->is_required
                    ? ['required', Rule::in(['yes', 'no'])]
                    : ['nullable', Rule::in(['yes', 'no'])];
            } elseif ($question->type === QuestionType::Textarea) {
                $rules[$key] = $question->is_required
                    ? 'required|string|max:5000'
                    : 'nullable|string|max:5000';
            } else {
                $rules[$key] = $question->is_required
                    ? 'required|string|max:255'
                    : 'nullable|string|max:255';
            }
        }

        $validated = $request->validate($rules, [
            'cv.max' => 'The CV must not be larger than 2 MB.',
            'cv.mimes' => 'The CV must be a PDF, DOC, or DOCX file.',
        ]);

        $cvPath = $request->file('cv')->store('cvs', 'public');

        $application = Application::create([
            'job_id'       => $job->id,
            'user_id'      => Auth::id(),
            'cv_path'      => $cvPath,
            'cover_letter' => $validated['cover_letter'] ?? null,
        ]);

        foreach ($job->questions as $question) {
            $answer = $validated['answers'][$question->id] ?? null;

            if ($answer === null || $answer === '') {
                continue;
            }

            ApplicationAnswer::create([
                'application_id' => $application->id,
                'job_question_id' => $question->id,
                'answer' => $answer,
            ]);
        }

        $this->logInfo('Job application submitted', [
            'application_id' => $application->id,
            'job_id' => $job->id,
            'cv_path' => $cvPath,
            'answer_count' => $application->answers()->count(),
        ]);

        return back()->with('success', 'Application submitted successfully.');
    }
}
