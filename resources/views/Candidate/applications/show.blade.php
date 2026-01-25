@extends('layouts.public')

@section('content')

<section class="bg-slate-50 min-h-screen">
    <div class="max-w-4xl mx-auto px-6 py-12">

        <!-- BACK -->
        <a href="{{ route('candidate.dashboard') }}"
           class="text-sm font-semibold text-[#1E3A6D] hover:underline">
            ← Back to dashboard
        </a>

        <!-- HEADER -->
        <div class="mt-6 mb-8">
            <h1 class="text-3xl font-extrabold text-slate-900">
                {{ $application->job->title }}
            </h1>
            <p class="text-slate-600 mt-1">
                {{ $application->job->company_name }}
            </p>
        </div>

        <!-- STATUS CARD -->
        <div class="bg-white rounded-2xl p-6 shadow-sm mb-8">
            <div class="flex items-center justify-between">
                <p class="text-sm text-slate-600">
                    Application Status
                </p>

                <span class="px-4 py-1 rounded-full text-sm font-semibold
                    @if($application->status === 'applied') bg-blue-100 text-blue-700
                    @elseif($application->status === 'shortlisted') bg-green-100 text-green-700
                    @elseif($application->status === 'interview') bg-yellow-100 text-yellow-700
                    @else bg-red-100 text-red-700
                    @endif">
                    {{ ucfirst($application->status) }}
                </span>
            </div>

            <p class="text-xs text-slate-500 mt-2">
                Applied {{ $application->created_at->diffForHumans() }}
            </p>
        </div>

        <!-- DETAILS -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">

            <!-- JOB INFO -->
            <div class="bg-white rounded-2xl p-6 shadow-sm">
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

            <!-- APPLICATION INFO -->
            <div class="bg-white rounded-2xl p-6 shadow-sm">
                <h3 class="font-semibold text-slate-800 mb-4">
                    Your Application
                </h3>

                <p class="text-sm text-slate-600 mb-3">
                    <strong>CV:</strong>
                </p>

                <a href="{{ asset('storage/' . $application->cv_path) }}"
                   target="_blank"
                   class="inline-block px-4 py-2 rounded-lg
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

        <!-- JOB DESCRIPTION -->
        <div class="bg-white rounded-2xl p-6 shadow-sm">
            <h3 class="font-semibold text-slate-800 mb-4">
                Job Description
            </h3>

            <p class="text-sm text-slate-600 leading-relaxed whitespace-pre-line">
                {{ $application->job->description }}
            </p>
        </div>

    </div>
</section>

@endsection
