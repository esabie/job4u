@extends('layouts.employer')

@section('content')

<div class="max-w-7xl mx-auto">

    <!-- ===================== -->
    <!-- HEADER -->
    <!-- ===================== -->
    <div class="mb-10 flex items-center justify-between">
        <div>
            <h1 class="text-4xl font-extrabold text-[#1E3A6D]">
                My Jobs
            </h1>
            <p class="mt-2 text-slate-600">
                Manage all jobs you’ve posted.
            </p>
        </div>

        <a href="{{ route('employer.jobs.create') }}"
           class="px-6 py-3 rounded-xl bg-[#1E3A6D] text-white font-semibold
                  hover:bg-blue-700 transition shadow-md">
            + Post Job
        </a>
    </div>

    <!-- ===================== -->
    <!-- JOBS TABLE -->
    <!-- ===================== -->
    <div class="bg-white rounded-3xl shadow-sm border overflow-hidden">

        @if ($jobs->count() === 0)

            <!-- EMPTY STATE -->
            <div class="p-12 text-center">
                <h3 class="text-lg font-semibold text-slate-800">
                    No jobs posted yet
                </h3>
                <p class="text-slate-600 mt-2">
                    Create your first job listing to start receiving applications.
                </p>

                <a href="{{ route('employer.jobs.create') }}"
                   class="inline-block mt-6 px-6 py-3 rounded-xl bg-[#1E3A6D]
                          text-white font-semibold hover:bg-blue-700 transition">
                    Post Your First Job
                </a>
            </div>

        @else

            <table class="w-full text-sm">
                <thead class="bg-slate-50">
                    <tr class="text-left text-slate-600 font-semibold">
                        <th class="px-6 py-4">Job</th>
                        <th class="px-6 py-4">Category</th>
                        <th class="px-6 py-4">Status</th>
                        <th class="px-6 py-4">Posted</th>
                        <th class="px-6 py-4 text-right">Actions</th>
                    </tr>
                </thead>

                <tbody class="divide-y">

                    @foreach ($jobs as $job)
                        <tr class="hover:bg-slate-50 transition">

                            <!-- JOB INFO -->
                            <td class="px-6 py-4">
                                <p class="font-semibold text-slate-900">
                                    {{ $job->title }}
                                </p>
                                <p class="text-slate-500 text-xs">
                                    {{ $job->location }} • {{ $job->employment_type }}
                                </p>
                            </td>

                            <!-- CATEGORY -->
                            <td class="px-6 py-4">
                                {{ $job->category }}
                            </td>

                            <!-- STATUS -->
                            <td class="px-6 py-4">
                                @if ($job->is_active)
                                    <span class="px-3 py-1 rounded-full
                                                 text-xs font-semibold
                                                 bg-green-100 text-green-700">
                                        Active
                                    </span>
                                @else
                                    <span class="px-3 py-1 rounded-full
                                                 text-xs font-semibold
                                                 bg-gray-200 text-gray-700">
                                        Hidden
                                    </span>
                                @endif
                            </td>

                            <!-- POSTED -->
                            <td class="px-6 py-4 text-slate-500">
                                {{ $job->created_at->diffForHumans() }}
                            </td>

                            <!-- ACTIONS -->
                            <td class="px-6 py-4 text-right">
                                <div class="flex items-center justify-end gap-4">

                                    <a href="{{ route('employer.jobs.applications', $job) }}"
                                       class="text-[#1E3A6D] font-semibold hover:underline">
                                        Applications
                                    </a>

                                    <a href="{{ route('employer.jobs.edit', $job) }}"
                                       class="text-[#1E3A6D] font-semibold hover:underline">
                                        Edit
                                    </a>

                                    <form method="POST"
                                          action="{{ route('employer.jobs.destroy', $job) }}"
                                          onsubmit="return confirm('Hide this job?')">
                                        @csrf
                                        @method('DELETE')

                                        <button
                                            class="text-red-500 font-semibold hover:underline">
                                            Hide
                                        </button>
                                    </form>

                                </div>
                            </td>

                        </tr>
                    @endforeach

                </tbody>
            </table>

            <!-- PAGINATION -->
            <div class="px-6 py-4 bg-slate-50">
                {{ $jobs->links() }}
            </div>

        @endif

    </div>

</div>

@endsection
