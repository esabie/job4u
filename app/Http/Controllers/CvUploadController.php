<?php

namespace App\Http\Controllers;

use App\Support\SafeIntendedUrl;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class CvUploadController extends Controller
{
    /**
     * Send candidates to profile CV upload; guests register/login then return there.
     */
    public function __invoke(): RedirectResponse
    {
        $profileWithCv = SafeIntendedUrl::forRoute('profile.edit', fragment: 'cv');

        if (Auth::check()) {
            return Auth::user()->isCandidate()
                ? redirect()->to($profileWithCv)
                : redirect()->route('dashboard');
        }

        session(['url.intended' => $profileWithCv]);

        return redirect()->route('register');
    }
}
