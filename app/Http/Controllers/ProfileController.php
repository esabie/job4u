<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function edit(Request $request): View
    {
        $this->logDebug('Profile edit form viewed', [
            'user_id' => $request->user()->id,
        ]);

        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();

        $this->logInfo('Profile update attempt', [
            'user_id' => $user->id,
            'input' => $this->sanitizedInput($request),
        ]);

        if (! $user->isCandidate()) {
            return Redirect::route('profile.edit');
        }

        $validated = $request->validated();
        unset($validated['cv'], $validated['remove_cv'], $validated['name'], $validated['email']);

        $user->fill($validated);

        if ($request->boolean('remove_cv') && $user->cv_path) {
            Storage::disk('public')->delete($user->cv_path);
            $user->cv_path = null;
        }

        if ($request->hasFile('cv')) {
            if ($user->cv_path) {
                Storage::disk('public')->delete($user->cv_path);
            }

            $user->cv_path = $request->file('cv')->store('cvs/profiles', 'public');
        }

        $user->save();

        $this->logInfo('Profile updated', [
            'user_id' => $user->id,
            'has_saved_cv' => $user->hasSavedCv(),
        ]);

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }
}
