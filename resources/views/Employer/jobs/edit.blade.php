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
                    <input type="text" name="company_name"
                           value="{{ old('company_name', $job->company_name) }}"
                           class="w-full rounded-xl border-gray-300 px-4 py-3"
                           required>
                </div>

                <div>
                    <label class="block text-sm font-semibold mb-2">Location</label>
                    <input type="text" name="location"
                           value="{{ old('location', $job->location) }}"
                           class="w-full rounded-xl border-gray-300 px-4 py-3"
                           required>
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
            <textarea name="description" rows="7"
                      class="w-full rounded-xl border-gray-300 px-4 py-4"
                      required>{{ $job->description }}</textarea>
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
                class="px-8 py-3 rounded-xl bg-[#1E3A6D] text-white font-semibold
                       hover:bg-blue-700 transition">
                Save Changes
            </button>
        </div>

    </form>

</div>

@endsection
