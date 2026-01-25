<?php

namespace App\Http\Controllers\Candidate;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\Controller;
use App\Models\Application;

class ApplicationController extends Controller
{
    public function show(Application $application)
    {
        // 🔐 Only candidates
        abort_if(Auth::user()->role !== 'candidate', 403);

        // 🔐 Only owner can view
        abort_if($application->user_id !== Auth::id(), 403);

        $application->load('job');

        return view('candidate.applications.show', compact('application'));
    }
}
