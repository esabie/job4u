<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
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
        $this->logInfo('Profile update attempt', [
            'user_id' => $request->user()->id,
            'input' => $this->sanitizedInput($request),
        ]);

        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;

            $this->logInfo('Profile email changed, verification reset', [
                'user_id' => $request->user()->id,
            ]);
        }

        $request->user()->save();

        $this->logInfo('Profile updated', [
            'user_id' => $request->user()->id,
        ]);

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    public function destroy(Request $request): RedirectResponse
    {
        $this->logWarning('Account deletion attempt', [
            'user_id' => $request->user()->id,
        ]);

        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();
        $userId = $user->id;

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        $this->logWarning('Account deleted', [
            'user_id' => $userId,
        ]);

        return Redirect::to('/');
    }
}
