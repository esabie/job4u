<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class EmailVerificationNotificationController extends Controller
{
    /**
     * Send a new email verification notification.
     */
    public function store(Request $request): RedirectResponse
    {
        if ($request->user()->hasVerifiedEmail()) {
            $this->logDebug('Verification email not sent, already verified', [
                'user_id' => $request->user()->id,
            ]);

            return redirect()->intended(route('dashboard', absolute: false));
        }

        $request->user()->sendEmailVerificationNotification();

        $this->logInfo('Verification email sent', [
            'user_id' => $request->user()->id,
        ]);

        return back()->with('status', 'verification-link-sent');
    }
}
