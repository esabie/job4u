@extends('layouts.employer')

@section('content')

<div class="max-w-5xl mx-auto">

    <!-- HEADER -->
    <div class="mb-10 flex items-start justify-between">
        <div>
            <h1 class="text-4xl font-extrabold text-[#1E3A6D]">
                Edit Job
            </h1>
            <p class="mt-2 text-slate-600">
                Update your job details or change its status.
            </p>
        </div>

        <a href="{{ route('employer.jobs.index') }}"
           class="px-5 py-2.5 rounded-xl border border-slate-300
                  text-slate-600 font-semibold hover:bg-slate-100 transition">
            Back to Jobs
        </a>
    </div>

    <!-- FORM -->
    <form method="POST"
          action="{{ route('employer.jobs.update', $job) }}"
          enctype="multipart/form-data"
          data-loader-message="Saving your changes..."
          class="bg-white rounded-3xl shadow-sm border p-10 space-y-10">
        @csrf
        @method('PUT')

        <!-- JOB INFO -->
        <div>
            <h2 class="text-lg font-bold text-slate-900 mb-6">
                Job Information
            </h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                <div>
                    <label class="block text-sm font-semibold mb-2">Job Title</label>
                    <input type="text" name="title"
                           value="{{ old('title', $job->title) }}"
                           class="w-full rounded-xl border-gray-300 px-4 py-3"
                           required>
                </div>

                <div>
                    <label class="block text-sm font-semibold mb-2">Company Name</label>
                    <x-company-name-input :value="old('company_name', $job->company_name)" />
                    @error('company_name')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="md:col-span-2">
                    <x-company-logo-upload :job="$job" />
                </div>

                <div>
                    <label class="block text-sm font-semibold mb-2">Location</label>
                    <input type="text" name="location"
                           value="{{ old('location', $job->location) }}"
                           class="w-full rounded-xl border-gray-300 px-4 py-3"
                           required>
                </div>

                <div>
                    <x-work-arrangement-select :value="$job->work_arrangement" />
                </div>

                <div>
                    <label class="block text-sm font-semibold mb-2">Employment Type</label>
                    <select name="employment_type"
                            class="w-full rounded-xl border-gray-300 px-4 py-3">
                        @foreach (['Full Time','Part Time','Contract'] as $type)
                            <option value="{{ $type }}"
                                @selected($job->employment_type === $type)>
                                {{ $type }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-semibold mb-2">Category</label>
                    <select name="category"
                            class="w-full rounded-xl border-gray-300 px-4 py-3">
                        @foreach (['Tech','Healthcare','Admin','Construction','Hospitality'] as $cat)
                            <option value="{{ $cat }}"
                                @selected($job->category === $cat)>
                                {{ $cat }}
                            </option>
                        @endforeach
                    </select>
                </div>

            </div>
        </div>

        <!-- SALARY -->
        <div>
            <h2 class="text-lg font-bold mb-6">Salary</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <input type="number" name="salary_min"
                       value="{{ $job->salary_min }}"
                       placeholder="Minimum"
                       class="rounded-xl border-gray-300 px-4 py-3">
                <input type="number" name="salary_max"
                       value="{{ $job->salary_max }}"
                       placeholder="Maximum"
                       class="rounded-xl border-gray-300 px-4 py-3">
            </div>
        </div>

        <!-- DESCRIPTION -->
        <div>
            <h2 class="text-lg font-bold mb-6">Job Description</h2>
            <x-rich-text-editor :value="old('description', $job->description)" />
            @error('description')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- APPLICATION QUESTIONS -->
        <div>
            <x-job-questions-builder :questions="$job->questions" />
        </div>

        <!-- STATUS -->
        <div>
            <label class="block text-sm font-semibold mb-2">Job Status</label>
            <select name="is_active"
                    class="rounded-xl border-gray-300 px-4 py-3">
                <option value="1" @selected($job->is_active)>Active</option>
                <option value="0" @selected(!$job->is_active)>Hidden</option>
            </select>
        </div>

        <!-- ACTIONS -->
        <div class="flex justify-end gap-4 pt-6 border-t">
            <a href="{{ route('employer.jobs.index') }}"
               class="px-6 py-3 rounded-xl border text-slate-600 hover:bg-gray-100">
                Cancel
            </a>

            <button
                type="submit"
                data-loading-text="Saving..."
                class="inline-flex items-center justify-center gap-2 px-8 py-3 rounded-xl bg-[#1E3A6D] text-white font-semibold
                       hover:bg-blue-700 transition disabled:cursor-wait disabled:opacity-80">
                Save Changes
            </button>
        </div>

    </form>

</div>

@endsection
