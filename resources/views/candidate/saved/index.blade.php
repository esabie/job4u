@extends('layouts.employer')

@section('content')

<div class="max-w-7xl mx-auto px-4 sm:px-6 md:px-10 py-8 md:py-10">

    <div class="mb-8 flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">
        <div>
            <h1 class="text-3xl font-extrabold text-[#1E3A6D]">
                Saved Jobs
            </h1>
            <p class="text-slate-600 mt-1">
                Roles you’ve bookmarked to review or apply to later.
            </p>
        </div>

        <a href="{{ route('jobs.index') }}"
           class="inline-flex items-center justify-center shrink-0 px-6 py-3 rounded-xl bg-[#1E3A6D] text-white font-semibold
                  hover:bg-blue-700 transition shadow-md">
            Find more jobs
        </a>
    </div>

    @if (session('success'))
        <div class="mb-6 rounded-xl bg-green-50 border border-green-200 px-4 py-3 text-sm text-green-700">
            {{ session('success') }}
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        @forelse ($jobs as $job)
            <div class="bg-white rounded-2xl border p-5 sm:p-6">
                <div class="flex items-start justify-between gap-3">
                    <div class="flex items-start gap-3 sm:gap-4 min-w-0">
                        <x-company-logo :job="$job" size="md" />
                        <div class="min-w-0">
                            <h2 class="text-lg font-bold text-slate-900">{{ $job->title }}</h2>
                            <p class="mt-1 text-sm text-slate-600 truncate">{{ $job->company_name }}</p>
                            <p class="mt-1 text-xs text-slate-500">
                                {{ $job->location }} • {{ $job->employment_type }}
                                @if ($job->work_arrangement)
                                    • {{ $job->work_arrangement }}
                                @endif
                            </p>
                        </div>
                    </div>

                    <x-save-job-button :job="$job" :saved="true" />
                </div>

                <div class="mt-5 pt-5 border-t flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                    <p class="text-lg font-extrabold text-slate-900">
                        @if ($job->salary_min || $job->salary_max)
                            {{ $job->currency }}
                            {{ $job->salary_min ? number_format($job->salary_min) : '—' }}
                            –
                            {{ $job->salary_max ? number_format($job->salary_max) : '—' }}
                        @else
                            Salary negotiable
                        @endif
                    </p>

                    <div class="flex items-center gap-3 sm:gap-4">
                        <a href="{{ route('jobs.show', $job) }}"
                           class="text-[#1E3A6D] font-semibold text-sm hover:underline">
                            View Job →
                        </a>

                        <a href="{{ route('jobs.show', $job) }}"
                           class="inline-flex items-center justify-center px-5 py-2 rounded-xl bg-[#1E3A6D] text-white
                                  text-sm font-semibold hover:bg-blue-700 transition">
                            Apply Now
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <div class="lg:col-span-2 bg-white rounded-2xl border p-10 text-center">
                <p class="text-slate-500">You haven’t saved any jobs yet.</p>
                <a href="{{ route('jobs.index') }}"
                   class="inline-block mt-4 text-sm font-semibold text-[#1E3A6D] hover:underline">
                    Browse jobs and save ones you like
                </a>
            </div>
        @endforelse
    </div>

    <div class="mt-8">
        {{ $jobs->links() }}
    </div>

</div>

@endsection
