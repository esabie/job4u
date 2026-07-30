<?php

namespace App\Http\Controllers;

use App\Enums\QuestionType;
use App\Models\Application;
use App\Models\ApplicationAnswer;
use App\Models\Job;
use App\Notifications\NewApplicationNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class ApplicationController extends Controller
{
    public function store(Request $request, Job $job)
    {
        $user = Auth::user();

        $this->logInfo('Job application attempt', [
            'job_id' => $job->id,
            'user_id' => $user->id,
        ]);

        abort_if($user->role !== 'candidate', 403);

        abort_if(!$job->is_active, 403);

        if ($job->applications()->where('user_id', $user->id)->exists()) {
            $this->logWarning('Duplicate job application blocked', [
                'job_id' => $job->id,
                'user_id' => $user->id,
            ]);

            return back()->with('error', 'You have already applied to this job.');
        }

        $job->load('questions');

        $useSavedCv = $request->boolean('use_saved_cv');

        $rules = [
            'use_saved_cv' => ['nullable', 'boolean'],
            'cover_letter' => 'nullable|string|max:5000',
            'answers' => 'nullable|array',
        ];

        if ($useSavedCv) {
            if (! $user->hasSavedCv() || ! Storage::disk('public')->exists($user->cv_path)) {
                throw ValidationException::withMessages([
                    'use_saved_cv' => 'You do not have a saved CV. Please upload one on your profile or attach a file.',
                ]);
            }
        } else {
            $rules['cv'] = 'required|mimes:pdf,doc,docx|max:2048';
        }

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

        if ($useSavedCv) {
            $extension = pathinfo($user->cv_path, PATHINFO_EXTENSION) ?: 'pdf';
            $cvPath = 'cvs/'.Str::uuid().'.'.$extension;
            Storage::disk('public')->copy($user->cv_path, $cvPath);
        } else {
            $cvPath = $request->file('cv')->store('cvs', 'public');
        }

        $application = Application::create([
            'job_id'       => $job->id,
            'user_id'      => $user->id,
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
            'used_saved_cv' => $useSavedCv,
            'answer_count' => $application->answers()->count(),
        ]);

        $application->load(['job', 'candidate']);
        $employer = $job->employer;

        if ($employer && $employer->notify_new_applications) {
            $employer->notify(new NewApplicationNotification($application));
        }

        return redirect()
            ->to(route('jobs.show', $job).'#apply-form')
            ->with('success', 'You have successfully applied for this job.');
    }
}
