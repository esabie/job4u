@extends('layouts.employer')

@section('content')

<div class="max-w-7xl mx-auto px-4 sm:px-6 md:px-10 py-8 md:py-10">

    <div class="mb-8 flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">
        <div>
            <h1 class="text-3xl font-extrabold text-[#1E3A6D]">
                Welcome, {{ auth()->user()->name }}
            </h1>
            <p class="text-slate-600 mt-1">
                Track your job applications and progress.
            </p>
        </div>

        <a href="{{ route('jobs.index') }}"
           class="inline-flex items-center justify-center shrink-0 px-6 py-3 rounded-xl bg-[#1E3A6D] text-white font-semibold
                  hover:bg-blue-700 transition shadow-md">
            Find a Job
        </a>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 sm:gap-6 mb-8 md:mb-12">

        <div class="bg-white rounded-2xl p-6 shadow-sm border">
            <p class="text-sm text-slate-600">Total Applications</p>
            <p class="text-3xl font-extrabold text-[#1E3A6D] mt-1">
                {{ $totalApplications }}
            </p>
        </div>

        <div class="bg-white rounded-2xl p-6 shadow-sm border">
            <p class="text-sm text-slate-600">Shortlisted</p>
            <p class="text-3xl font-extrabold text-green-600 mt-1">
                {{ $shortlisted }}
            </p>
        </div>

        <div class="bg-white rounded-2xl p-6 shadow-sm border">
            <p class="text-sm text-slate-600">Interviews</p>
            <p class="text-3xl font-extrabold text-[#1E3A6D] mt-1">
                {{ $interviews }}
            </p>
        </div>

    </div>

    <div class="bg-blue-50 rounded-3xl p-6 md:p-8 mb-8 md:mb-12">
        <h3 class="font-semibold text-slate-800 mb-6">
            Applications By Day
        </h3>

        <div class="flex items-end justify-between h-40 gap-2">
            @foreach ($applicationsByDay as $day)
                <div class="flex flex-col items-center gap-2 flex-1 min-w-0">
                    <span class="text-xs font-semibold text-slate-600">
                        {{ $day['count'] }}
                    </span>
                    <div class="rounded-lg w-full max-w-10 {{ $day['count'] > 0 ? 'bg-[#1E3A6D]' : 'bg-[#1E3A6D]/25' }}"
                         style="height: {{ $day['height'] }}px"
                         title="{{ $day['label'] }}: {{ $day['count'] }} application(s)">
                    </div>
                    <span class="text-xs text-slate-500">
                        {{ $day['label'] }}
                    </span>
                </div>
            @endforeach
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border overflow-hidden">

        <div class="px-6 py-4 border-b">
            <h2 class="font-semibold text-slate-800">
                My Applications
            </h2>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm min-w-[560px]">
                <thead class="bg-slate-50">
                    <tr class="text-left text-slate-600 font-semibold">
                        <th class="px-6 py-3">Job</th>
                        <th class="px-6 py-3">Company</th>
                        <th class="px-6 py-3">Status</th>
                        <th class="px-6 py-3">Applied</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-slate-100">
                    @forelse($applications as $application)
                        <tr class="hover:bg-slate-50 transition">

                            <td class="px-6 py-4 font-medium align-middle">
                                <a href="{{ route('candidate.applications.show', $application) }}"
                                   class="text-[#1E3A6D] hover:underline">
                                    {{ $application->job->title }}
                                </a>
                            </td>

                            <td class="px-6 py-4 align-middle">
                                {{ $application->job->company_name }}
                            </td>

                            <td class="px-6 py-4 align-middle">
                                <x-application-status-badge :status="$application->status" />
                            </td>

                            <td class="px-6 py-4 text-slate-600 align-middle whitespace-nowrap">
                                {{ $application->created_at->diffForHumans() }}
                            </td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-12 text-center text-slate-500">
                                You haven’t applied to any jobs yet.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>

</div>

@endsection
