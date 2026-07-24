<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class EmailVerificationPromptController extends Controller
{
    /**
     * Display the email verification prompt.
     */
    public function __invoke(Request $request): RedirectResponse|View
    {
        if ($request->user()->hasVerifiedEmail()) {
            $this->logDebug('Email verification prompt skipped, already verified', [
                'user_id' => $request->user()->id,
            ]);

            return redirect()->intended(route('dashboard', absolute: false));
        }

        $this->logDebug('Email verification prompt shown', [
            'user_id' => $request->user()->id,
        ]);

        return view('auth.verify-email');
    }
}
