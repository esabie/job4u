@extends('layouts.employer')

@section('content')

<div class="flex bg-slate-50 min-h-screen">

    <main class="flex-1 py-10 bg-slate-50">
    <div class="max-w-7xl pl-16 pr-10">

    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-3xl font-extrabold text-[#1E3A6D]">
                Welcome, {{ auth()->user()->name }}
            </h1>
            <p class="text-slate-600 mt-1">
                Post roles, review candidates and track performance.
            </p>
        </div>

        <a href="{{ route('employer.jobs.create') }}"
           class="px-6 py-3 rounded-xl bg-[#1E3A6D] text-white font-semibold
                  hover:bg-blue-700 transition">
            + Post Job
        </a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-3 gap-12 mb-12">

        <div class="bg-white rounded-2xl px-2 py-6 shadow-sm border">
            <p class="text-sm font-medium text-slate-600">
                Active Listings
            </p>
            <p class="text-4xl font-extrabold text-[#1E3A6D] mt-2">
                {{ $activeJobs }}
            </p>
        </div>

        <div class="bg-white rounded-2xl px-8 py-6 shadow-sm border">
            <p class="text-sm font-medium text-slate-600">
                New Applicants
            </p>
            <p class="text-4xl font-extrabold text-[#1E3A6D] mt-2">
                {{ $newApplicants }}
            </p>
        </div>

    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-10">

        <div class="bg-blue-50 rounded-3xl p-8">
            <h3 class="font-semibold text-slate-800 mb-6">
                Applicants By Day
            </h3>

            @if ($applicantsByDay->sum('count') === 0)
                <p class="text-sm text-slate-500 h-40 flex items-center justify-center">
                    No applications in the last 7 days.
                </p>
            @else
                <div class="flex items-end justify-between h-40 gap-2">
                    @foreach ($applicantsByDay as $day)
                        <div class="flex flex-col items-center gap-2 flex-1">
                            <span class="text-xs font-semibold text-slate-600">
                                {{ $day['count'] }}
                            </span>
                            <div class="bg-[#1E3A6D] rounded-lg w-full max-w-10"
                                 style="height: {{ $day['height'] }}px"
                                 title="{{ $day['label'] }}: {{ $day['count'] }} applicant(s)">
                            </div>
                            <span class="text-xs text-slate-500">
                                {{ $day['label'] }}
                            </span>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        <div class="bg-blue-50 rounded-3xl p-8">
            <h3 class="font-semibold text-slate-800 mb-4">
                Recent Applications
            </h3>

            @if ($recentApplications->isEmpty())
                <p class="text-sm text-slate-500 py-8 text-center">
                    No applications yet. Post a job to start receiving candidates.
                </p>
            @else
                <table class="w-full text-sm">
                    <thead>
                        <tr class="bg-blue-100 text-left">
                            <th class="px-4 py-2 rounded-l-lg">Name</th>
                            <th class="px-4 py-2">Role</th>
                            <th class="px-4 py-2 rounded-r-lg">Stage</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-blue-200">
                        @foreach ($recentApplications as $application)
                            <tr>
                                <td class="px-4 py-3 font-medium">
                                    {{ $application->candidate->name }}
                                </td>
                                <td class="px-4 py-3">
                                    {{ $application->job->title }}
                                </td>
                                <td class="px-4 py-3 font-semibold">
                                    @switch($application->status)
                                        @case('applied')
                                            Review
                                            @break
                                        @case('shortlisted')
                                            Shortlist
                                            @break
                                        @case('interview')
                                            Interview
                                            @break
                                        @case('rejected')
                                            Rejected
                                            @break
                                        @default
                                            {{ ucfirst($application->status) }}
                                    @endswitch
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>

    </div>

    </div>

    </main>

</div>

@endsection
