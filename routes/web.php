<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PublicJobController;
use App\Http\Controllers\StripeJobPaymentController;
use App\Http\Controllers\StripeWebhookController;
use App\Http\Controllers\Employer\DashboardController;
use App\Http\Controllers\Candidate\DashboardController as CandidateDashboardController;
use App\Http\Controllers\Candidate\ApplicationController as CandidateApplicationController;
use App\Http\Controllers\Employer\JobController;
use App\Http\Controllers\Employer\ApplicationController;

/*
|--------------------------------------------------------------------------
| Public Routes (NO AUTH)
|--------------------------------------------------------------------------
*/

// LANDING PAGE
Route::get('/', function () {
    return view('public.home');
})->name('home');

// FIND JOBS
Route::get('/jobs', [PublicJobController::class, 'index'])->name('jobs.index');
Route::get('/jobs/{job}', [PublicJobController::class, 'show'])->name('jobs.show');
Route::post('/jobs/{job}/apply', [ApplicationController::class, 'store'])->name('jobs.apply');
Route::post('/employer/jobs/{job}/pay', [StripeJobPaymentController::class, 'checkout'])->name('employer.jobs.pay');
Route::post('/stripe/webhook', [StripeWebhookController::class, 'handle']);

/*
|--------------------------------------------------------------------------
| Authenticated Routes
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    Route::middleware('can:isEmployer')->prefix('employer')->name('employer.')->group(function () {

        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('/jobs', [JobController::class, 'index'])->name('jobs.index');
        Route::delete('/jobs/{job}', [JobController::class, 'destroy'])->name('jobs.destroy');
        Route::get('/jobs/create', [JobController::class, 'create'])->name('jobs.create');
        Route::post('/jobs', [JobController::class, 'store'])->name('jobs.store');
        Route::get('/jobs/{job}/edit', [JobController::class, 'edit'])->name('jobs.edit');
        Route::put('/jobs/{job}', [JobController::class, 'update'])->name('jobs.update');
        Route::delete('/jobs/{job}', [JobController::class, 'destroy'])->name('jobs.destroy');
        Route::get('/jobs/{job}/applications', [ApplicationController::class, 'index'])->name('jobs.applications');
        Route::patch('/applications/{application}', [ApplicationController::class, 'update'])->name('applications.update');

    });

    // Role-based dashboard redirect
    Route::get('/dashboard', function () {
        $user = Auth::user();

        if ($user->role === 'employer') {
            return redirect('/employer/dashboard');
        }

        return redirect('/candidate/dashboard');
    })->name('dashboard');

    Route::get('/candidate/dashboard', [CandidateDashboardController::class, 'index'])->name('candidate/dashboard');

    Route::get('/candidate/applications/{application}', [CandidateApplicationController::class, 'show'])->name('candidate.applications.show');

    // Profile (Breeze)
    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');
});

/*
|--------------------------------------------------------------------------
| Auth Routes (Breeze)
|--------------------------------------------------------------------------
*/

require __DIR__.'/auth.php';
