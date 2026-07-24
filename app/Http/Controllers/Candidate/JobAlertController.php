<?php

namespace App\Http\Controllers\Candidate;

use App\Enums\WorkArrangement;
use App\Http\Controllers\Controller;
use App\Models\JobAlert;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class JobAlertController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        abort_if($user->role !== 'candidate', 403);

        $alerts = $user->jobAlerts()->latest()->get();

        $this->logDebug('Job alerts listed', [
            'candidate_id' => $user->id,
            'alert_count' => $alerts->count(),
        ]);

        return view('candidate.alerts.index', compact('alerts'));
    }

    public function store(Request $request)
    {
        abort_if(Auth::user()->role !== 'candidate', 403);

        $validated = $this->validateAlert($request);

        $alert = Auth::user()->jobAlerts()->create($validated);

        $this->logInfo('Job alert created', [
            'alert_id' => $alert->id,
            'candidate_id' => Auth::id(),
        ]);

        return back()->with('success', 'Job alert created. We will notify you when matching jobs are posted.');
    }

    public function update(Request $request, JobAlert $jobAlert)
    {
        abort_unless($jobAlert->user_id === Auth::id(), 403);

        $jobAlert->update([
            'is_active' => $request->boolean('is_active'),
        ]);

        $this->logInfo('Job alert toggled', [
            'alert_id' => $jobAlert->id,
            'is_active' => $jobAlert->is_active,
        ]);

        return back()->with('success', 'Job alert updated.');
    }

    public function destroy(JobAlert $jobAlert)
    {
        abort_unless($jobAlert->user_id === Auth::id(), 403);

        $jobAlert->delete();

        $this->logInfo('Job alert deleted', [
            'alert_id' => $jobAlert->id,
            'candidate_id' => Auth::id(),
        ]);

        return back()->with('success', 'Job alert removed.');
    }

    private function validateAlert(Request $request): array
    {
        $validated = $request->validate([
            'keyword'          => 'nullable|string|max:255',
            'category'         => 'nullable|string|max:255',
            'work_arrangement' => 'nullable|in:'.implode(',', WorkArrangement::values()),
            'location'         => 'nullable|string|max:255',
        ]);

        if (! array_filter($validated)) {
            throw ValidationException::withMessages([
                'keyword' => 'Add at least one criterion (keyword, category, work arrangement, or location).',
            ]);
        }

        $validated['is_active'] = true;

        return $validated;
    }
}
