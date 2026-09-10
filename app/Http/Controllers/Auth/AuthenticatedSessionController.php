<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Support\SafeIntendedUrl;
use App\Support\TwoFactor;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(Request $request): View
    {
        SafeIntendedUrl::rememberFromRequest($request);

        $this->logDebug('Login form viewed');

        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $this->logInfo('Login attempt', [
            'email' => $request->input('email'),
            'remember' => $request->boolean('remember'),
        ]);

        $user = $request->authenticate();

        SafeIntendedUrl::rememberFromRequest($request);

        $request->session()->put([
            'login.id' => $user->id,
            'login.remember' => $request->boolean('remember'),
        ]);

        TwoFactor::sendCode($user->fresh());

        $this->logInfo('Two-factor challenge started', [
            'user_id' => $user->id,
        ]);

        return redirect()->route('login.verify');
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $userId = Auth::id();

        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        $this->logInfo('User logged out', [
            'user_id' => $userId,
        ]);

        return redirect('/');
    }
}
