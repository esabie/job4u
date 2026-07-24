@extends('layouts.public')

@section('content')

<section class="bg-slate-50 min-h-screen">
    <div class="max-w-5xl mx-auto px-6 py-12">

        <!-- HEADER -->
        <div class="mb-8 flex items-start gap-5">
            <x-company-logo :job="$job" size="xl" />
            <div>
                <h1 class="text-3xl font-extrabold text-slate-900">
                    {{ $job->title }}
                </h1>
                <p class="text-slate-600 mt-1">
                    {{ $job->company_name }} • {{ $job->location }}
                </p>
            </div>
        </div>

        <!-- META -->
        <div class="flex flex-wrap items-center gap-3 mb-8">
            <span class="px-3 py-1 rounded-full bg-blue-100 text-blue-700 text-sm font-semibold">
                {{ $job->employment_type }}
            </span>

            <span class="px-3 py-1 rounded-full bg-slate-100 text-slate-700 text-sm font-semibold">
                {{ $job->category }}
            </span>

            @if ($job->work_arrangement)
                <span class="px-3 py-1 rounded-full bg-indigo-100 text-indigo-700 text-sm font-semibold">
                    {{ $job->work_arrangement }}
                </span>
            @endif

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
            <div class="job-description text-slate-600 leading-relaxed">
                {!! $job->description !!}
            </div>
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
                    <form id="apply-form"
                          method="POST"
                          action="{{ route('jobs.apply', $job) }}"
                          enctype="multipart/form-data"
                          data-loader-message="Submitting your application..."
                          class="space-y-5">

                        @csrf

                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-1">
                                Upload CV
                            </label>
                            <input
                                type="file"
                                name="cv"
                                accept=".pdf,.doc,.docx,application/pdf,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document"
                                required
                                class="w-full border rounded-lg px-3 py-2"
                            />
                            <p class="mt-1 text-sm text-slate-500">
                                Accepted formats: PDF, DOC, or DOCX. Maximum file size: 2 MB.
                            </p>
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

                        <x-application-questions :questions="$job->questions" />

                        <button
                            type="submit"
                            data-loading-text="Applying..."
                            class="inline-flex items-center justify-center gap-2 px-8 py-3 rounded-xl bg-[#1E3A6D] text-white font-semibold
                                   hover:bg-blue-700 transition disabled:cursor-wait disabled:opacity-80">
                            Apply Now
                        </button>
                    </form>
                @endif
            @endauth

        </div>

    </div>
</section>

@endsection
