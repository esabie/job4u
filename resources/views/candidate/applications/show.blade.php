@extends('layouts.employer')

@section('content')

<div class="max-w-4xl mx-auto px-4 sm:px-6 md:px-10 py-8 md:py-10">

    <a href="{{ route('candidate.dashboard') }}"
       class="text-sm font-semibold text-[#1E3A6D] hover:underline">
        ← Back to dashboard
    </a>

    <div class="mt-6 mb-8">
        <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900">
            {{ $application->job->title }}
        </h1>
        <p class="text-slate-600 mt-1">
            {{ $application->job->company_name }}
        </p>
    </div>

    <div class="bg-white rounded-2xl p-5 sm:p-6 shadow-sm border mb-6 sm:mb-8">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <p class="text-sm text-slate-600">
                Application Status
            </p>

            <span class="inline-flex self-start">
                <x-application-status-badge :status="$application->status" class="!text-sm !px-4 !py-1" />
            </span>
        </div>

        <p class="text-xs text-slate-500 mt-2">
            Applied {{ $application->created_at->diffForHumans() }}
        </p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6 sm:mb-8">

        <div class="bg-white rounded-2xl p-5 sm:p-6 shadow-sm border">
            <h3 class="font-semibold text-slate-800 mb-4">
                Job Details
            </h3>

            <p class="text-sm text-slate-600">
                <strong>Location:</strong> {{ $application->job->location }}
            </p>

            <p class="text-sm text-slate-600 mt-2">
                <strong>Type:</strong> {{ $application->job->employment_type }}
            </p>

            <p class="text-sm text-slate-600 mt-2">
                <strong>Category:</strong> {{ $application->job->category }}
            </p>
        </div>

        <div class="bg-white rounded-2xl p-5 sm:p-6 shadow-sm border">
            <h3 class="font-semibold text-slate-800 mb-4">
                Your Application
            </h3>

            <p class="text-sm text-slate-600 mb-3">
                <strong>CV:</strong>
            </p>

            <a href="{{ asset('storage/' . $application->cv_path) }}"
               target="_blank"
               class="inline-flex px-4 py-2 rounded-lg
                      bg-[#1E3A6D] text-white text-sm font-semibold
                      hover:bg-blue-700 transition">
                Download CV
            </a>

            @if($application->cover_letter)
                <div class="mt-4">
                    <p class="text-sm font-semibold text-slate-700 mb-1">
                        Cover Letter
                    </p>
                    <p class="text-sm text-slate-600 whitespace-pre-line">
                        {{ $application->cover_letter }}
                    </p>
                </div>
            @endif
        </div>

    </div>

    <x-application-answers :answers="$application->answers" class="mb-6 sm:mb-8" />

    <div class="bg-white rounded-2xl p-5 sm:p-6 shadow-sm border">
        <h3 class="font-semibold text-slate-800 mb-4">
            Job Description
        </h3>

        <div class="job-description text-sm text-slate-600 leading-relaxed">
            {!! $application->job->description !!}
        </div>
    </div>

</div>

@endsection
