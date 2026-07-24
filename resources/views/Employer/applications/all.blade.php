@extends('layouts.employer')

@section('content')

<div class="max-w-7xl mx-auto px-6 py-12">

    <!-- HEADER -->
    <div class="mb-10">
        <h1 class="text-4xl font-extrabold text-[#1E3A6D]">
            Applications
        </h1>
        <p class="text-slate-600 mt-2">
            All applications received across your job listings.
        </p>
    </div>

    <div class="bg-white rounded-3xl shadow-sm border overflow-hidden">

        @if ($applications->isEmpty())
            <div class="p-12 text-center">
                <p class="text-slate-600">No applications yet.</p>
            </div>
        @else

        <table class="w-full text-sm">
            <thead class="bg-slate-50">
                <tr>
                    <th class="px-6 py-4 text-left">Candidate</th>
                    <th class="px-6 py-4 text-left">Job</th>
                    <th class="px-6 py-4">Applied</th>
                    <th class="px-6 py-4">Status</th>
                    <th class="px-6 py-4 text-right">Actions</th>
                </tr>
            </thead>

            <tbody class="divide-y">
                @foreach ($applications as $application)
                <tr>

                    <td class="px-6 py-4">
                        <p class="font-semibold">
                            {{ $application->candidate->name }}
                        </p>
                        <p class="text-xs text-slate-500">
                            {{ $application->candidate->email }}
                        </p>
                    </td>

                    <td class="px-6 py-4">
                        <a href="{{ route('employer.jobs.applications', $application->job) }}"
                           class="text-[#1E3A6D] font-medium hover:underline">
                            {{ $application->job->title }}
                        </a>
                    </td>

                    <td class="px-6 py-4 text-slate-500">
                        {{ $application->created_at->diffForHumans() }}
                    </td>

                    <td class="px-6 py-4">
                        <span class="px-3 py-1 rounded-full text-xs font-semibold
                            @class([
                                'bg-blue-100 text-blue-700' => $application->status === 'new',
                                'bg-yellow-100 text-yellow-700' => $application->status === 'shortlisted',
                                'bg-purple-100 text-purple-700' => $application->status === 'interview',
                                'bg-red-100 text-red-700' => $application->status === 'rejected',
                                'bg-green-100 text-green-700' => $application->status === 'hired',
                            ])">
                            {{ ucfirst($application->status) }}
                        </span>
                    </td>

                    <td class="px-6 py-4 text-right">
                        <a href="{{ route('employer.applications.show', $application) }}"
                           class="text-[#1E3A6D] font-semibold hover:underline">
                            View
                        </a>
                    </td>

                </tr>
                @endforeach
            </tbody>
        </table>

        @endif
    </div>

    @if ($applications->hasPages())
        <div class="mt-8">
            {{ $applications->links() }}
        </div>
    @endif

</div>

@endsection
