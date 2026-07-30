<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\JobController as AdminJobController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\PublicJobController;
use App\Http\Controllers\Candidate\JobAlertController;
use App\Http\Controllers\Candidate\SavedJobController;
use App\Http\Controllers\Employer\DashboardController;
use App\Http\Controllers\Candidate\DashboardController as CandidateDashboardController;
use App\Http\Controllers\Candidate\ApplicationController as CandidateApplicationController;
use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\Employer\JobController;
use App\Http\Controllers\Employer\CompanySuggestionController;
use App\Http\Controllers\Employer\ApplicationController as EmployerApplicationController;

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

/*
|--------------------------------------------------------------------------
| Authenticated Routes
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    Route::middleware('can:isAdmin')->prefix('admin')->name('admin.')->group(function () {
        Route::redirect('/', '/admin/dashboard');
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

        Route::get('/jobs', [AdminJobController::class, 'index'])->name('jobs.index');
        Route::get('/jobs/{job}', [AdminJobController::class, 'show'])->name('jobs.show');
        Route::patch('/jobs/{job}/verify', [AdminJobController::class, 'verify'])->name('jobs.verify');
        Route::patch('/jobs/{job}/unverify', [AdminJobController::class, 'unverify'])->name('jobs.unverify');
        Route::patch('/jobs/{job}/activate', [AdminJobController::class, 'activate'])->name('jobs.activate');
        Route::patch('/jobs/{job}/deactivate', [AdminJobController::class, 'deactivate'])->name('jobs.deactivate');

        Route::get('/users', [AdminUserController::class, 'index'])->name('users.index');
        Route::get('/users/{user}', [AdminUserController::class, 'show'])->name('users.show');
        Route::patch('/users/{user}/suspend', [AdminUserController::class, 'suspend'])->name('users.suspend');
        Route::patch('/users/{user}/unsuspend', [AdminUserController::class, 'unsuspend'])->name('users.unsuspend');
    });

    Route::middleware('can:isEmployer')->prefix('employer')->name('employer.')->group(function () {

        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('/jobs', [JobController::class, 'index'])->name('jobs.index');
        Route::delete('/jobs/{job}', [JobController::class, 'destroy'])->name('jobs.destroy');
        Route::get('/jobs/create', [JobController::class, 'create'])->name('jobs.create');
        Route::get('/companies/suggest', CompanySuggestionController::class)->name('companies.suggest');
        Route::post('/jobs', [JobController::class, 'store'])->name('jobs.store');
        Route::get('/jobs/{job}/edit', [JobController::class, 'edit'])->name('jobs.edit');
        Route::put('/jobs/{job}', [JobController::class, 'update'])->name('jobs.update');
        Route::delete('/jobs/{job}', [JobController::class, 'destroy'])->name('jobs.destroy');
        Route::get('/applications', [EmployerApplicationController::class, 'all'])->name('applications.index');
        Route::get('/jobs/{job}/applications', [EmployerApplicationController::class, 'index'])->name('jobs.applications');
        Route::get('/applications/{application}', [EmployerApplicationController::class, 'show'])->name('applications.show');
        Route::patch('/applications/{application}', [EmployerApplicationController::class, 'update'])->name('applications.update');

    });

    // Role-based dashboard redirect
    Route::get('/dashboard', function () {
        $user = Auth::user();

        if ($user->isAdmin()) {
            return redirect()->route('admin.dashboard');
        }

        if ($user->isEmployer()) {
            return redirect('/employer/dashboard');
        }

        return redirect('/candidate/dashboard');
    })->name('dashboard');

    Route::get('/candidate/dashboard', [CandidateDashboardController::class, 'index'])->name('candidate.dashboard');

    Route::get('/candidate/applications', [CandidateApplicationController::class, 'index'])->name('candidate.applications.index');

    Route::get('/candidate/applications/{application}', [CandidateApplicationController::class, 'show'])->name('candidate.applications.show');

    Route::middleware('can:isCandidate')->group(function () {
        Route::get('/candidate/saved-jobs', [SavedJobController::class, 'index'])->name('candidate.saved.index');
        Route::post('/jobs/{job}/save', [SavedJobController::class, 'store'])->name('candidate.saved.store');
        Route::delete('/jobs/{job}/save', [SavedJobController::class, 'destroy'])->name('candidate.saved.destroy');
    });

    // Job Alerts (candidates)
    Route::get('/candidate/alerts', [JobAlertController::class, 'index'])->name('candidate.alerts.index');
    Route::post('/candidate/alerts', [JobAlertController::class, 'store'])->name('candidate.alerts.store');
    Route::patch('/candidate/alerts/{jobAlert}', [JobAlertController::class, 'update'])->name('candidate.alerts.update');
    Route::delete('/candidate/alerts/{jobAlert}', [JobAlertController::class, 'destroy'])->name('candidate.alerts.destroy');

    // Settings
    Route::get('/settings', [SettingsController::class, 'edit'])->name('settings.edit');
    Route::patch('/settings', [SettingsController::class, 'update'])->name('settings.update');

    // Profile (Breeze)
    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');
});

/*
|--------------------------------------------------------------------------
| Auth Routes (Breeze)
|--------------------------------------------------------------------------
*/


require __DIR__.'/auth.php';
