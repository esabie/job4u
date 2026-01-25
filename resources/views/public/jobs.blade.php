@extends('layouts.public')

@section('content')

<!-- ===================== -->
<!-- PAGE HEADER -->
<!-- ===================== -->
<section class="bg-slate-50 border-b">
    <div class="max-w-7xl mx-auto px-6 pt-20 pb-14 text-center">
        <h1 class="text-5xl font-extrabold text-slate-900 tracking-tight">
            Find Jobs
        </h1>
        <p class="mt-4 text-slate-600 max-w-2xl mx-auto text-lg">
            Explore verified opportunities across industries and take the next step in your career.
        </p>
    </div>
</section>

<!-- ===================== -->
<!-- SEARCH BAR -->
<!-- ===================== -->
<section class="max-w-7xl mx-auto px-6 -mt-8 relative z-10">
    <div class="bg-white rounded-2xl p-6 shadow-lg
                flex flex-col md:flex-row gap-4 items-center">

        <input
            type="text"
            placeholder="Job title, keyword, or company"
            class="w-full md:flex-1 px-5 py-3 rounded-xl border border-gray-300
                   focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
        />

        <input
            type="text"
            placeholder="Location"
            class="w-full md:w-56 px-5 py-3 rounded-xl border border-gray-300
                   focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
        />

        <button
            class="w-full md:w-auto px-12 py-3 rounded-xl bg-[#1E3A6D] text-white font-semibold
                   hover:bg-blue-700 transition shadow">
            Search Jobs
        </button>
    </div>
</section>

<!-- ===================== -->
<!-- CATEGORY FILTERS -->
<!-- ===================== -->


<!-- ===================== -->
<!-- JOB RESULTS -->
<!-- ===================== -->
<section class="bg-slate-50 mt-16">
    <div class="max-w-7xl mx-auto px-6 py-16
                grid grid-cols-1 md:grid-cols-2 gap-10">

        @forelse ($jobs as $job)
            <div class="group bg-white rounded-2xl border
                        p-7 hover:shadow-xl hover:-translate-y-1
                        transition-all duration-200">

                <!-- TOP -->
                <div class="flex items-start justify-between">

                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 rounded-xl bg-blue-50
                                    flex items-center justify-center
                                    text-[#1E3A6D] font-bold text-sm">
                            {{ strtoupper(substr($job->company_name, 0, 2)) }}
                        </div>

                        <div>
                            <h3 class="text-lg font-bold text-slate-900">
                                {{ $job->title }}
                            </h3>

                            <p class="mt-1 text-slate-600 text-sm">
                                {{ $job->company_name }}
                            </p>

                            <p class="mt-1 text-xs text-slate-500">
                                {{ $job->location }} • {{ $job->employment_type }}
                            </p>
                        </div>
                    </div>

                    <div class="flex flex-col items-end gap-2">
                        <button class="text-slate-400 hover:text-red-500 transition text-lg">
                            ♡
                        </button>

                        @if ($job->is_verified)
                            <span class="text-xs font-semibold text-green-700 bg-green-100
                                         px-3 py-1 rounded-full">
                                Verified
                            </span>
                        @endif
                    </div>
                </div>

                <!-- POSTED TIME -->
                <p class="mt-4 text-xs text-slate-500">
                    Posted {{ $job->created_at->diffForHumans() }}
                </p>

                <!-- BOTTOM -->
                <div class="mt-5 pt-5 border-t flex items-center justify-between">
                    <p class="text-xl font-extrabold text-slate-900">
                        {{ $job->currency }} {{ number_format($job->salary_min) }}
                        – {{ number_format($job->salary_max) }}
                    </p>

                    <div class="flex items-center gap-4">
                        <a href="#"
                           class="text-[#1E3A6D] font-semibold text-sm hover:underline">
                            View Job →
                        </a>

                        <button
                            class="px-5 py-2 rounded-xl bg-[#1E3A6D] text-white
                                   text-sm font-semibold hover:bg-blue-700 transition">
                            Apply Now
                        </button>
                    </div>
                </div>
            </div>
        @empty
            <p class="text-slate-500">No jobs found.</p>
        @endforelse
    </div>

    <!-- PAGINATION -->
    <div class="max-w-7xl mx-auto px-6 pb-16">
        {{ $jobs->links() }}
    </div>
</section>

@endsection
