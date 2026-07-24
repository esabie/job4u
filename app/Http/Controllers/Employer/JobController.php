<?php

namespace App\Http\Controllers\Employer;

use App\Http\Controllers\Controller;
use App\Enums\QuestionType;
use App\Enums\WorkArrangement;
use App\Models\Job;
use App\Models\JobAlert;
use App\Notifications\JobAlertMatchNotification;
use App\Support\JobDescriptionSanitizer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class JobController extends Controller
{
    public function index()
    {
        $jobs = Job::where('user_id', Auth::id())
            ->latest()
            ->paginate(10);

        $this->logDebug('Employer jobs listed', [
            'job_count' => $jobs->total(),
        ]);

        return view('employer.jobs.index', compact('jobs'));
    }

    public function destroy(Job $job)
    {
        abort_unless($job->user_id === Auth::id(), 403);

        $this->logInfo('Hiding job', [
            'job_id' => $job->id,
            'title' => $job->title,
        ]);

        $job->update([
            'is_active' => false
        ]);

        $this->logInfo('Job hidden', [
            'job_id' => $job->id,
        ]);

        return back()->with('success', 'Job hidden successfully.');
    }

    public function create()
    {
        $this->logDebug('Job create form viewed');

        return view('employer.jobs.create');
    }

    public function edit(Job $job)
    {
        abort_unless($job->user_id === Auth::id(), 403);

        $this->logDebug('Job edit form viewed', [
            'job_id' => $job->id,
        ]);

        $job->load('questions');

        return view('employer.jobs.edit', compact('job'));
    }

    public function store(Request $request)
    {
        $this->logInfo('Job creation attempt', [
            'input' => $this->sanitizedInput($request),
        ]);

        $validated = $request->validate([
            'title'            => 'required|string|max:255',
            'company_name'     => 'required|string|max:255',
            'company_logo'     => 'nullable|image|mimes:jpeg,jpg,png|max:2048',
            'location'         => 'required|string|max:255',
            'work_arrangement' => 'required|in:'.implode(',', WorkArrangement::values()),
            'employment_type'  => 'required|string',
            'category'         => 'required|string',
            'currency'        => 'nullable|string|max:5',
            'salary_min'       => 'nullable|integer',
            'salary_max'       => 'nullable|integer|gte:salary_min',
            'description'      => ['required', 'string', $this->descriptionRule()],
            'questions'        => 'nullable|array|max:10',
            'questions.*.question' => 'required|string|max:500',
            'questions.*.type' => 'required|in:'.implode(',', QuestionType::values()),
            'questions.*.is_required' => 'nullable|boolean',
            'questions.*.id'   => 'nullable|integer',
        ], $this->uploadMessages());

        $job = Job::create([
            'user_id'          => Auth::id(),
            'title'            => $validated['title'],
            'company_name'     => $validated['company_name'],
            'company_logo'     => $this->storeCompanyLogo($request),
            'location'         => $validated['location'],
            'work_arrangement' => $validated['work_arrangement'],
            'employment_type'  => $validated['employment_type'],
            'category'         => $validated['category'],
            'currency'         => $validated['currency'],
            'salary_min'       => $validated['salary_min'],
            'salary_max'       => $validated['salary_max'],
            'description'      => JobDescriptionSanitizer::clean($validated['description']),
            'is_active'        => true,
            'is_verified'      => false,
        ]);

        $this->logInfo('Job created', [
            'job_id' => $job->id,
            'title' => $job->title,
        ]);

        $this->notifyMatchingAlerts($job);

        $this->syncQuestions($job, $request->input('questions', []));

        return redirect()
            ->route('employer.dashboard')
            ->with('success', 'Job posted successfully.');
    }

    public function update(Request $request, Job $job)
    {
        abort_unless($job->user_id === Auth::id(), 403);

        $this->logInfo('Job update attempt', [
            'job_id' => $job->id,
            'input' => $this->sanitizedInput($request),
        ]);

        $validated = $request->validate([
            'title'            => 'required|string|max:255',
            'company_name'     => 'required|string|max:255',
            'company_logo'     => 'nullable|image|mimes:jpeg,jpg,png|max:2048',
            'location'         => 'required|string|max:255',
            'work_arrangement' => 'required|in:'.implode(',', WorkArrangement::values()),
            'employment_type'  => 'required|string',
            'category'         => 'required|string',
            'currency'         => 'nullable|string|max:5',
            'salary_min'       => 'nullable|integer',
            'salary_max'       => 'nullable|integer|gte:salary_min',
            'description'      => ['required', 'string', $this->descriptionRule()],
            'is_active'        => 'required|boolean',
            'questions'        => 'nullable|array|max:10',
            'questions.*.question' => 'required|string|max:500',
            'questions.*.type' => 'required|in:'.implode(',', QuestionType::values()),
            'questions.*.is_required' => 'nullable|boolean',
            'questions.*.id'   => 'nullable|integer',
        ], $this->uploadMessages());

        $validated['description'] = JobDescriptionSanitizer::clean($validated['description']);
        $validated['company_logo'] = $this->storeCompanyLogo($request, $job);

        $job->update($validated);

        $this->syncQuestions($job, $request->input('questions', []));

        $this->logInfo('Job updated', [
            'job_id' => $job->id,
            'is_active' => $job->is_active,
        ]);

        return redirect()
            ->route('employer.jobs.index')
            ->with('success', 'Job updated successfully.');
    }

    private function descriptionRule(): \Closure
    {
        return function (string $attribute, mixed $value, \Closure $fail): void {
            if (! is_string($value) || JobDescriptionSanitizer::isEmpty($value)) {
                $fail('The job description is required.');
            }
        };
    }

    private function uploadMessages(): array
    {
        return [
            'company_logo.max' => 'The company logo must not be larger than 2 MB.',
            'company_logo.mimes' => 'The company logo must be a JPG or PNG file.',
        ];
    }

    private function storeCompanyLogo(Request $request, ?Job $job = null): ?string
    {
        if (! $request->hasFile('company_logo')) {
            return $job?->company_logo;
        }

        if ($job?->company_logo) {
            Storage::disk('public')->delete($job->company_logo);
        }

        return $request->file('company_logo')->store('company-logos', 'public');
    }

    private function syncQuestions(Job $job, ?array $questions): void
    {
        $questions = $questions ?? [];
        $keptIds = [];

        foreach ($questions as $index => $questionData) {
            $text = trim($questionData['question'] ?? '');

            if ($text === '') {
                continue;
            }

            $data = [
                'question' => $text,
                'type' => $questionData['type'],
                'is_required' => ! empty($questionData['is_required']),
                'sort_order' => $index,
            ];

            if (! empty($questionData['id'])) {
                $existing = $job->questions()->find($questionData['id']);

                if ($existing) {
                    $existing->update($data);
                    $keptIds[] = $existing->id;
                    continue;
                }
            }

            $created = $job->questions()->create($data);
            $keptIds[] = $created->id;
        }

        if ($keptIds) {
            $job->questions()->whereNotIn('id', $keptIds)->delete();
        } else {
            $job->questions()->delete();
        }
    }

    private function notifyMatchingAlerts(Job $job): void
    {
        $notified = [];

        JobAlert::with('user')
            ->where('is_active', true)
            ->get()
            ->each(function (JobAlert $alert) use ($job, &$notified) {
                $user = $alert->user;

                if (! $user || ! $user->notify_job_alerts || in_array($user->id, $notified, true)) {
                    return;
                }

                if ($alert->matches($job)) {
                    $user->notify(new JobAlertMatchNotification($job));
                    $notified[] = $user->id;
                }
            });

        if ($notified) {
            $this->logInfo('Job alert notifications sent', [
                'job_id' => $job->id,
                'candidate_count' => count($notified),
            ]);
        }
    }
}
