@extends('layouts.public')

@section('content')

<section class="bg-slate-50 border-b">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 pt-12 sm:pt-16 md:pt-20 pb-10 sm:pb-14 text-center">
        <h1 class="text-3xl sm:text-4xl md:text-5xl font-extrabold text-slate-900 tracking-tight">
            Find Jobs
        </h1>
        <p class="mt-4 text-slate-600 max-w-2xl mx-auto text-base sm:text-lg">
            Explore verified opportunities across industries and take the next step in your career.
        </p>
    </div>
</section>

<section class="max-w-7xl mx-auto px-4 sm:px-6 -mt-8 relative z-10">
    <form method="GET"
          action="{{ route('jobs.index') }}"
          class="bg-white rounded-2xl p-4 sm:p-6 shadow-lg space-y-4">

        <div class="flex flex-col md:flex-row gap-3 sm:gap-4 items-stretch md:items-center">
            <input
                type="text"
                name="q"
                value="{{ $filters['q'] }}"
                placeholder="Job title, keyword, or company"
                class="w-full md:flex-1 px-5 py-3 rounded-xl border border-gray-300
                       focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
            />

            <button
                type="submit"
                class="w-full md:w-auto px-8 md:px-12 py-3 rounded-xl bg-[#1E3A6D] text-white font-semibold
                       hover:bg-blue-700 transition shadow shrink-0">
                Search Jobs
            </button>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-6 gap-3 sm:gap-4">
            <div>
                <label for="location" class="block text-xs font-semibold text-slate-600 mb-1.5">Location</label>
                <input
                    id="location"
                    type="text"
                    name="location"
                    value="{{ $filters['location'] }}"
                    placeholder="e.g. Accra"
                    class="w-full px-4 py-2.5 rounded-xl border border-gray-300 text-sm
                           focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                />
            </div>

            <div>
                <label for="category" class="block text-xs font-semibold text-slate-600 mb-1.5">Category</label>
                <select
                    id="category"
                    name="category"
                    class="w-full px-4 py-2.5 rounded-xl border border-gray-300 text-sm
                           focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    <option value="">Any category</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category }}" @selected($filters['category'] === $category)>
                            {{ $category }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="employment_type" class="block text-xs font-semibold text-slate-600 mb-1.5">Employment type</label>
                <select
                    id="employment_type"
                    name="employment_type"
                    class="w-full px-4 py-2.5 rounded-xl border border-gray-300 text-sm
                           focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    <option value="">Any type</option>
                    @foreach ($employmentTypes as $type)
                        <option value="{{ $type }}" @selected($filters['employment_type'] === $type)>
                            {{ $type }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="work_arrangement" class="block text-xs font-semibold text-slate-600 mb-1.5">Work arrangement</label>
                <select
                    id="work_arrangement"
                    name="work_arrangement"
                    class="w-full px-4 py-2.5 rounded-xl border border-gray-300 text-sm
                           focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    <option value="">Any arrangement</option>
                    @foreach (\App\Enums\WorkArrangement::cases() as $arrangement)
                        <option value="{{ $arrangement->value }}" @selected($filters['work_arrangement'] === $arrangement->value)>
                            {{ $arrangement->value }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="salary_min" class="block text-xs font-semibold text-slate-600 mb-1.5">Min salary</label>
                <input
                    id="salary_min"
                    type="number"
                    name="salary_min"
                    min="0"
                    step="100"
                    value="{{ $filters['salary_min'] }}"
                    placeholder="e.g. 5000"
                    class="w-full px-4 py-2.5 rounded-xl border border-gray-300 text-sm
                           focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                />
            </div>

            <div>
                <label for="sort" class="block text-xs font-semibold text-slate-600 mb-1.5">Sort by</label>
                <select
                    id="sort"
                    name="sort"
                    class="w-full px-4 py-2.5 rounded-xl border border-gray-300 text-sm
                           focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    @foreach ($sortOptions as $value => $label)
                        <option value="{{ $value }}" @selected($filters['sort'] === $value)>
                            {{ $label }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        @if ($hasActiveFilters)
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 pt-1">
                <p class="text-sm text-slate-500">
                    Showing {{ $jobs->total() }} {{ $jobs->total() === 1 ? 'result' : 'results' }}
                </p>
                <a href="{{ route('jobs.index') }}"
                   class="text-sm font-semibold text-[#1E3A6D] hover:underline">
                    Clear filters
                </a>
            </div>
        @endif
    </form>
</section>

<section class="bg-slate-50 mt-10 sm:mt-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 py-10 sm:py-16
                grid grid-cols-1 lg:grid-cols-2 gap-6 sm:gap-8 md:gap-10">

        @forelse ($jobs as $job)
            <div class="group bg-white rounded-2xl border
                        p-5 sm:p-7 hover:shadow-xl hover:-translate-y-1
                        transition-all duration-200">

                <div class="flex items-start justify-between gap-3">

                    <div class="flex items-start gap-3 sm:gap-4 min-w-0">
                        <x-company-logo :job="$job" size="md" />

                        <div class="min-w-0">
                            <h3 class="text-base sm:text-lg font-bold text-slate-900">
                                {{ $job->title }}
                            </h3>

                            <p class="mt-1 text-slate-600 text-sm truncate">
                                {{ $job->company_name }}
                            </p>

                            <p class="mt-1 text-xs text-slate-500">
                                {{ $job->location }} • {{ $job->employment_type }}
                                @if ($job->work_arrangement)
                                    • {{ $job->work_arrangement }}
                                @endif
                                @if ($job->category)
                                    • {{ $job->category }}
                                @endif
                            </p>
                        </div>
                    </div>

                    <div class="flex flex-col items-end gap-2 shrink-0">
                        @if ($job->is_verified)
                            <span class="text-xs font-semibold text-green-700 bg-green-100
                                         px-3 py-1 rounded-full">
                                Verified
                            </span>
                        @endif

                        <x-save-job-button
                            :job="$job"
                            :saved="in_array($job->id, $savedJobIds ?? [], true)"
                        />
                    </div>
                </div>

                <p class="mt-4 text-xs text-slate-500">
                    Posted {{ $job->created_at->diffForHumans() }}
                </p>

                <div class="mt-5 pt-5 border-t flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                    <p class="text-lg sm:text-xl font-extrabold text-slate-900">
                        @if ($job->salary_min || $job->salary_max)
                            {{ $job->currency }}
                            {{ $job->salary_min ? number_format($job->salary_min) : '—' }}
                            –
                            {{ $job->salary_max ? number_format($job->salary_max) : '—' }}
                        @else
                            Salary negotiable
                        @endif
                    </p>

                    <div class="flex flex-col sm:flex-row sm:items-center gap-3 sm:gap-4">
                        <a href="{{ route('jobs.show', $job) }}"
                           class="text-[#1E3A6D] font-semibold text-sm hover:underline">
                            View Job →
                        </a>

                        @if (in_array($job->id, $appliedJobIds ?? [], true))
                            <span class="inline-flex items-center justify-center px-4 py-2 rounded-xl
                                         border border-green-200 bg-green-50 text-green-800
                                         text-sm font-semibold">
                                Already Applied
                            </span>
                        @else
                            <a
                                href="{{ route('jobs.show', $job) }}"
                                class="inline-flex items-center justify-center px-5 py-2 rounded-xl bg-[#1E3A6D] text-white
                                       text-sm font-semibold hover:bg-blue-700 transition">
                                Apply Now
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <div class="lg:col-span-2 text-center py-12">
                <p class="text-slate-500">No jobs found.</p>
                @if ($hasActiveFilters)
                    <a href="{{ route('jobs.index') }}"
                       class="inline-block mt-4 text-sm font-semibold text-[#1E3A6D] hover:underline">
                        Clear filters and try again
                    </a>
                @endif
            </div>
        @endforelse
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 pb-12 sm:pb-16">
        {{ $jobs->links() }}
    </div>
</section>

@endsection
