@extends('layouts.public')

@section('content')

<section class="bg-slate-50 min-h-screen">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 py-8 md:py-12">

        <div class="mb-8 flex flex-col sm:flex-row sm:items-start sm:justify-between gap-4">
            <div class="flex flex-col sm:flex-row sm:items-start gap-4 sm:gap-5 min-w-0">
                <x-company-logo :job="$job" size="xl" />
                <div class="min-w-0">
                    <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900">
                        {{ $job->title }}
                    </h1>
                    <p class="text-slate-600 mt-1">
                        {{ $job->company_name }} • {{ $job->location }}
                    </p>
                </div>
            </div>

            <x-save-job-button :job="$job" :saved="$isSaved ?? false" class="self-start" />
        </div>

        <div class="flex flex-wrap items-center gap-2 sm:gap-3 mb-6 sm:mb-8">
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

        <p class="text-lg font-bold text-slate-900 mb-6">
            @if($job->salary_min && $job->salary_max)
                {{ $job->currency }} {{ number_format($job->salary_min) }} – {{ number_format($job->salary_max) }}
            @else
                Salary negotiable
            @endif
        </p>

        <div class="bg-white rounded-2xl p-5 sm:p-6 shadow-sm mb-8 md:mb-10">
            <h2 class="font-semibold text-slate-800 mb-4">Job Description</h2>
            <div class="job-description text-slate-600 leading-relaxed">
                {!! $job->description !!}
            </div>
        </div>

        {{-- Anchor on a short wrapper (not the tall form) so #apply-form scrolls to the top of the apply section --}}
        <div id="apply-form" class="scroll-mt-6 bg-white rounded-2xl p-5 sm:p-6 shadow-sm">
            <h2 class="font-semibold text-slate-800 mb-4">Apply for this job</h2>

            @if (session('error'))
                <div class="mb-5 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm font-semibold text-red-700"
                     role="alert">
                    {{ session('error') }}
                </div>
            @endif

            @guest
                <p class="text-slate-600 mb-4">
                    Please login to apply for this job.
                </p>

                <a href="{{ route('login', ['redirect' => \App\Support\SafeIntendedUrl::forRoute('jobs.show', $job)]) }}"
                   class="inline-flex items-center justify-center px-6 py-3 rounded-xl bg-[#1E3A6D] text-white font-semibold
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
                    <div class="rounded-xl border border-green-200 bg-green-50 px-4 py-4" role="status">
                        <p class="text-green-800 font-semibold">
                            @if (session('success'))
                                {{ session('success') }}
                            @else
                                You have already applied for this job.
                            @endif
                        </p>
                        <a href="{{ route('candidate.applications.index') }}"
                           class="mt-3 inline-flex text-sm font-semibold text-[#1E3A6D] hover:underline">
                            View my applications
                        </a>
                    </div>
                @else
                    @if (session('success'))
                        <div class="mb-5 rounded-xl border border-green-200 bg-green-50 px-4 py-3 text-sm font-semibold text-green-800"
                             role="alert">
                            {{ session('success') }}
                        </div>
                    @endif
                    <form method="POST"
                          action="{{ route('jobs.apply', $job) }}"
                          enctype="multipart/form-data"
                          data-loader-message="Submitting your application..."
                          class="space-y-5">

                        @csrf

                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-1">
                                CV
                            </label>

                            @if (auth()->user()->hasSavedCv())
                                <div class="mb-3 space-y-3 rounded-xl border border-slate-200 bg-slate-50 p-4"
                                     x-data="{ useSaved: true }">
                                    <label class="flex items-start gap-3 cursor-pointer">
                                        <input type="radio"
                                               name="use_saved_cv"
                                               value="1"
                                               class="mt-1 text-[#1E3A6D] focus:ring-[#1E3A6D]"
                                               x-model="useSaved"
                                               checked>
                                        <span>
                                            <span class="block text-sm font-semibold text-slate-800">Use my saved CV</span>
                                            <a href="{{ asset('storage/'.auth()->user()->cv_path) }}"
                                               target="_blank"
                                               class="text-sm text-[#1E3A6D] font-semibold hover:underline">
                                                Preview saved CV
                                            </a>
                                        </span>
                                    </label>

                                    <label class="flex items-start gap-3 cursor-pointer">
                                        <input type="radio"
                                               name="use_saved_cv"
                                               value="0"
                                               class="mt-1 text-[#1E3A6D] focus:ring-[#1E3A6D]"
                                               x-model="useSaved">
                                        <span class="text-sm font-semibold text-slate-800">Upload a different CV</span>
                                    </label>

                                    <div x-show="useSaved === '0'" x-cloak class="pt-1">
                                        <input
                                            type="file"
                                            name="cv"
                                            accept=".pdf,.doc,.docx,application/pdf,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document"
                                            class="w-full border rounded-lg px-3 py-2 bg-white"
                                            :required="useSaved === '0'"
                                        />
                                    </div>
                                </div>
                                <p class="text-sm text-slate-500">
                                    Manage your saved CV anytime in
                                    <a href="{{ route('profile.edit') }}" class="text-[#1E3A6D] font-semibold hover:underline">Profile</a>.
                                </p>
                            @else
                                <input type="hidden" name="use_saved_cv" value="0">
                                <input
                                    type="file"
                                    name="cv"
                                    accept=".pdf,.doc,.docx,application/pdf,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document"
                                    required
                                    class="w-full border rounded-lg px-3 py-2"
                                />
                                <p class="mt-1 text-sm text-slate-500">
                                    Accepted formats: PDF, DOC, or DOCX. Maximum file size: 2 MB.
                                    <a href="{{ route('profile.edit') }}" class="text-[#1E3A6D] font-semibold hover:underline">
                                        Save a CV on your profile
                                    </a>
                                    to apply faster next time.
                                </p>
                            @endif

                            <x-input-error :messages="$errors->get('cv')" class="mt-1" />
                            <x-input-error :messages="$errors->get('use_saved_cv')" class="mt-1" />
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
                            class="inline-flex w-full sm:w-auto items-center justify-center gap-2 px-8 py-3 rounded-xl bg-[#1E3A6D] text-white font-semibold
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
