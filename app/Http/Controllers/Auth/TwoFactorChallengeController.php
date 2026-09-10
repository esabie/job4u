<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Support\TwoFactor;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class TwoFactorChallengeController extends Controller
{
    public function create(Request $request): View|RedirectResponse
    {
        if (! $request->session()->has('login.id')) {
            return redirect()->route('login');
        }

        return view('auth.login-verify');
    }

    public function store(Request $request): RedirectResponse
    {
        $user = $this->pendingUser($request);

        $validated = $request->validate([
            'code' => ['required', 'string', 'size:'.User::TWO_FACTOR_CODE_LENGTH],
        ]);

        if (! $user->verifyTwoFactorCode($validated['code'])) {
            $this->logWarning('Two-factor challenge failed', [
                'user_id' => $user->id,
            ]);

            throw ValidationException::withMessages([
                'code' => 'The verification code is invalid or has expired.',
            ]);
        }

        $remember = (bool) $request->session()->pull('login.remember', false);

        $user->clearTwoFactorCode();
        $request->session()->forget('login.id');

        Auth::login($user, $remember);
        $request->session()->regenerate();

        $this->logInfo('Two-factor challenge passed', [
            'user_id' => $user->id,
        ]);

        return redirect()->intended(route('dashboard', absolute: false));
    }

    public function resend(Request $request): RedirectResponse
    {
        $user = $this->pendingUser($request);

        TwoFactor::sendCode($user);

        $this->logInfo('Two-factor code resent', [
            'user_id' => $user->id,
        ]);

        return back()->with(
            'status',
            'A new verification code has been emailed to you. If you do not see it, check your spam folder.'
        );
    }

    private function pendingUser(Request $request): User
    {
        $userId = $request->session()->get('login.id');

        if (! $userId) {
            throw ValidationException::withMessages([
                'code' => 'Your login session has expired. Please sign in again.',
            ]);
        }

        $user = User::query()->find($userId);

        if (! $user || $user->isSuspended()) {
            $request->session()->forget(['login.id', 'login.remember']);

            throw ValidationException::withMessages([
                'code' => 'Your login session has expired. Please sign in again.',
            ]);
        }

        return $user;
    }
}
