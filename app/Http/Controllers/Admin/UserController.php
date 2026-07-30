<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Job;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class UserController extends Controller
{
    public function index(Request $request): View
    {
        $query = User::query()->latest();

        if ($request->filled('role')) {
            $query->where('role', $request->string('role'));
        }

        if ($request->string('status')->toString() === 'suspended') {
            $query->where('is_suspended', true);
        }

        if ($request->filled('q')) {
            $term = '%'.$request->string('q')->trim().'%';

            $query->where(function ($builder) use ($term) {
                $builder->where('name', 'like', $term)
                    ->orWhere('email', 'like', $term);
            });
        }

        $users = $query->paginate(20)->withQueryString();

        $this->logDebug('Admin users listed', [
            'user_count' => $users->total(),
            'filters' => $request->only(['role', 'status', 'q']),
        ]);

        return view('admin.users.index', compact('users'));
    }

    public function show(User $user): View
    {
        $user->loadCount(['jobs', 'applications']);

        $recentJobs = $user->isEmployer()
            ? $user->jobs()->latest()->limit(5)->get()
            : collect();

        $this->logDebug('Admin user viewed', [
            'viewed_user_id' => $user->id,
        ]);

        return view('admin.users.show', compact('user', 'recentJobs'));
    }

    public function suspend(Request $request, User $user): RedirectResponse
    {
        if ($user->is($request->user())) {
            throw ValidationException::withMessages([
                'user' => 'You cannot suspend your own account.',
            ]);
        }

        if ($user->isAdmin()) {
            throw ValidationException::withMessages([
                'user' => 'Admin accounts cannot be suspended from here.',
            ]);
        }

        $user->update(['is_suspended' => true]);

        if ($user->isEmployer()) {
            Job::query()
                ->where('user_id', $user->id)
                ->where('is_active', true)
                ->update(['is_active' => false]);
        }

        $this->logWarning('Admin suspended user', [
            'suspended_user_id' => $user->id,
            'role' => $user->role,
        ]);

        return back()->with('success', 'User suspended. Their active job listings were hidden.');
    }

    public function unsuspend(User $user): RedirectResponse
    {
        $user->update(['is_suspended' => false]);

        $this->logInfo('Admin unsuspended user', [
            'unsuspended_user_id' => $user->id,
        ]);

        return back()->with('success', 'User account restored. They can sign in again.');
    }
}
