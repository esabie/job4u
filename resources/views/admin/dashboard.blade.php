@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')

<div class="max-w-7xl mx-auto px-4 sm:px-6 md:px-10 py-8 md:py-10">

    <div class="mb-8">
        <h1 class="text-3xl md:text-4xl font-extrabold text-[#1E3A6D]">
            Admin Dashboard
        </h1>
        <p class="text-slate-600 mt-2">
            Moderate jobs, manage users, and keep Job4U trustworthy.
        </p>
    </div>

    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6 mb-10">
        <div class="bg-white rounded-2xl border p-5">
            <p class="text-sm text-slate-500">Users</p>
            <p class="mt-2 text-3xl font-extrabold text-slate-900">{{ $stats['users'] }}</p>
        </div>
        <div class="bg-white rounded-2xl border p-5">
            <p class="text-sm text-slate-500">Active jobs</p>
            <p class="mt-2 text-3xl font-extrabold text-slate-900">{{ $stats['active_jobs'] }}</p>
        </div>
        <div class="bg-white rounded-2xl border p-5">
            <p class="text-sm text-slate-500">Pending verification</p>
            <p class="mt-2 text-3xl font-extrabold text-amber-600">{{ $stats['unverified_jobs'] }}</p>
        </div>
        <div class="bg-white rounded-2xl border p-5">
            <p class="text-sm text-slate-500">Applications</p>
            <p class="mt-2 text-3xl font-extrabold text-slate-900">{{ $stats['applications'] }}</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 sm:gap-6 mb-10">
        <div class="bg-white rounded-2xl border p-5">
            <p class="text-sm text-slate-500">Employers</p>
            <p class="mt-2 text-2xl font-bold text-slate-900">{{ $stats['employers'] }}</p>
        </div>
        <div class="bg-white rounded-2xl border p-5">
            <p class="text-sm text-slate-500">Candidates</p>
            <p class="mt-2 text-2xl font-bold text-slate-900">{{ $stats['candidates'] }}</p>
        </div>
        <div class="bg-white rounded-2xl border p-5">
            <p class="text-sm text-slate-500">Suspended users</p>
            <p class="mt-2 text-2xl font-bold text-slate-900">{{ $stats['suspended_users'] }}</p>
        </div>
    </div>

    <div class="bg-white rounded-2xl border overflow-hidden">
        <div class="px-5 sm:px-6 py-4 border-b flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <div>
                <h2 class="text-lg font-bold text-slate-900">Pending job verification</h2>
                <p class="text-sm text-slate-500 mt-1">Active listings that still need a Verified badge.</p>
            </div>
            <a href="{{ route('admin.jobs.index', ['status' => 'pending']) }}"
               class="text-sm font-semibold text-[#1E3A6D] hover:underline">
                View all →
            </a>
        </div>

        @if ($pendingJobs->isEmpty())
            <div class="p-8 text-center text-slate-500">
                No jobs waiting for verification.
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full text-sm min-w-[640px]">
                    <thead class="bg-slate-50 text-left text-slate-600">
                        <tr>
                            <th class="px-6 py-3 font-semibold">Job</th>
                            <th class="px-6 py-3 font-semibold">Employer</th>
                            <th class="px-6 py-3 font-semibold">Posted</th>
                            <th class="px-6 py-3 font-semibold"></th>
                        </tr>
                    </thead>
                    <tbody class="divide-y">
                        @foreach ($pendingJobs as $job)
                            <tr>
                                <td class="px-6 py-4">
                                    <p class="font-semibold text-slate-900">{{ $job->title }}</p>
                                    <p class="text-slate-500">{{ $job->company_name }} • {{ $job->location }}</p>
                                </td>
                                <td class="px-6 py-4 text-slate-600">
                                    {{ $job->employer?->name ?? '—' }}
                                </td>
                                <td class="px-6 py-4 text-slate-500">
                                    {{ $job->created_at->diffForHumans() }}
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <a href="{{ route('admin.jobs.show', $job) }}"
                                       class="font-semibold text-[#1E3A6D] hover:underline">
                                        Review
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>

</div>

@endsection
