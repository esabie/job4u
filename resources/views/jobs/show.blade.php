@extends('layouts.employer')

@section('content')

<section class="bg-slate-50 min-h-screen">
    <div class="max-w-5xl mx-auto px-6 py-12">

        <!-- HEADER -->
        <div class="mb-8">
            <h1 class="text-3xl font-extrabold text-slate-900">
                {{ $job->title }}
            </h1>
            <p class="text-slate-600 mt-1">
                {{ $job->company_name }} • {{ $job->location }}
            </p>
        </div>

        <!-- META -->
        <div class="flex flex-wrap items-center gap-3 mb-8">
            <span class="px-3 py-1 rounded-full bg-blue-100 text-blue-700 text-sm font-semibold">
                {{ $job->employment_type }}
            </span>

            <span class="px-3 py-1 rounded-full bg-slate-100 text-slate-700 text-sm font-semibold">
                {{ $job->category }}
            </span>

            @if($job->is_verified)
                <span class="px-3 py-1 rounded-full bg-green-100 text-green-700 text-sm font-semibold">
                    Verified
                </span>
            @endif
        </div>

        <!-- SALARY -->
        <p class="text-lg font-bold text-slate-900 mb-6">
            @if($job->salary_min && $job->salary_max)
                GHS {{ number_format($job->salary_min) }} – {{ number_format($job->salary_max) }}
            @else
                Salary negotiable
            @endif
        </p>

        <!-- DESCRIPTION -->
        <div class="bg-white rounded-2xl p-6 shadow-sm mb-10">
            <h2 class="font-semibold text-slate-800 mb-4">Job Description</h2>
            <p class="text-slate-600 leading-relaxed whitespace-pre-line">
                {{ $job->description }}
            </p>
        </div>

        <!-- APPLY SECTION -->
        <div class="bg-white rounded-2xl p-6 shadow-sm">

            @guest
                <p class="text-slate-600 mb-4">
                    Please login to apply for this job.
                </p>

                <a href="{{ route('login') }}"
                   class="inline-block px-6 py-3 rounded-xl bg-[#1E3A6D] text-white font-semibold
                          hover:bg-blue-700 transition">
                    Login to Apply
                </a>
            @endguest

            @auth
                @if(auth()->user()->role !== 'candidate')
                    <p class="text-slate-600">
                        Only candidates can apply for jobs.
                    </p>
                @elseif($hasApplied)
                    <p class="text-green-700 font-semibold">
                        You have already applied for this job.
                    </p>
                @else
                    <!-- APPLY FORM -->
                    <form method="POST"
                          action="{{ route('jobs.apply', $job) }}"
                          enctype="multipart/form-data"
                          class="space-y-5">

                        @csrf

                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-1">
                                Upload CV (PDF / DOC)
                            </label>
                            <input
                                type="file"
                                name="cv"
                                required
                                class="w-full border rounded-lg px-3 py-2"
                            />
                            <x-input-error :messages="$errors->get('cv')" class="mt-1" />
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-1">
                                Cover Letter (optional)
                            </label>
                            <textarea
                                name="cover_letter"
                                rows="4"
                                class="w-full border rounded-lg px-3 py-2"></textarea>
                        </div>

                        <button
                            type="submit"
                            class="px-8 py-3 rounded-xl bg-[#1E3A6D] text-white font-semibold
                                   hover:bg-blue-700 transition">
                            Apply Now
                        </button>
                    </form>
                @endif
            @endauth

        </div>

    </div>
</section>

@endsection
