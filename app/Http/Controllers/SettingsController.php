<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SettingsController extends Controller
{
    public function edit(Request $request): View
    {
        $this->logDebug('Settings viewed', [
            'user_id' => $request->user()->id,
        ]);

        return view('settings.edit', [
            'user' => $request->user(),
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $user = $request->user();

        if ($user->isCandidate()) {
            $user->update([
                'notify_application_updates' => $request->boolean('notify_application_updates'),
                'notify_job_alerts' => $request->boolean('notify_job_alerts'),
            ]);
        } elseif ($user->isEmployer()) {
            $user->update([
                'notify_new_applications' => $request->boolean('notify_new_applications'),
            ]);
        }

        $this->logInfo('Settings updated', [
            'user_id' => $user->id,
            'notify_application_updates' => $user->notify_application_updates,
            'notify_job_alerts' => $user->notify_job_alerts,
            'notify_new_applications' => $user->notify_new_applications,
        ]);

        return back()->with('status', 'settings-updated');
    }
}
