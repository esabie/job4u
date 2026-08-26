@extends('layouts.employer')

@section('content')

<div class="max-w-7xl mx-auto px-4 sm:px-6 md:px-10 py-8 md:py-10">

    <div class="mb-8 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-3xl md:text-4xl font-extrabold text-[#1E3A6D]">
                Welcome, {{ auth()->user()->name }}
            </h1>
            <p class="text-slate-600 mt-1">
                Post roles, review candidates and track performance.
            </p>
        </div>

        <a href="{{ route('employer.jobs.create') }}"
           class="inline-flex items-center justify-center px-6 py-3 rounded-xl bg-[#1E3A6D] text-white font-semibold
                  hover:bg-blue-700 transition shrink-0">
            + Post Job
        </a>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-6 mb-8 md:mb-12">

        <div class="bg-white rounded-2xl px-6 py-6 shadow-sm border">
            <p class="text-sm font-medium text-slate-600">
                Active Listings
            </p>
            <p class="text-4xl font-extrabold text-[#1E3A6D] mt-2">
                {{ $activeJobs }}
            </p>
        </div>

        <div class="bg-white rounded-2xl px-6 py-6 shadow-sm border">
            <p class="text-sm font-medium text-slate-600">
                New Applicants
            </p>
            <p class="text-4xl font-extrabold text-[#1E3A6D] mt-2">
                {{ $newApplicants }}
            </p>
        </div>

    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 md:gap-8">

        <div class="bg-blue-50 rounded-3xl p-6 md:p-8">
            <h3 class="font-semibold text-slate-800 mb-6">
                Applicants By Day
            </h3>

            <div class="flex items-end justify-between h-40 gap-2">
                @foreach ($applicantsByDay as $day)
                    <div class="flex flex-col items-center gap-2 flex-1 min-w-0">
                        <span class="text-xs font-semibold text-slate-600">
                            {{ $day['count'] }}
                        </span>
                        <div class="rounded-lg w-full max-w-10 {{ $day['count'] > 0 ? 'bg-[#1E3A6D]' : 'bg-[#1E3A6D]/25' }}"
                             style="height: {{ $day['height'] }}px"
                             title="{{ $day['label'] }}: {{ $day['count'] }} applicant(s)">
                        </div>
                        <span class="text-xs text-slate-500">
                            {{ $day['label'] }}
                        </span>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="bg-blue-50 rounded-3xl p-6 md:p-8">
            <h3 class="font-semibold text-slate-800 mb-4">
                Recent Applications
            </h3>

            @if ($recentApplications->isEmpty())
                <p class="text-sm text-slate-500 py-8 text-center">
                    No applications yet. Post a job to start receiving candidates.
                </p>
            @else
                <div class="overflow-x-auto -mx-2 sm:mx-0">
                    <table class="w-full text-sm min-w-[420px]">
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
                                    <td class="px-4 py-3 font-medium whitespace-nowrap">
                                        {{ $application->candidate->name }}
                                    </td>
                                    <td class="px-4 py-3">
                                        {{ $application->job->title }}
                                    </td>
                                    <td class="px-4 py-3 font-semibold whitespace-nowrap">
                                        {{ $application->status?->employerLabel() ?? ucfirst((string) $application->status) }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>

    </div>

</div>

@endsection
