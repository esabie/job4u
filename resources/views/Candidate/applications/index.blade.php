@extends('layouts.employer')

@section('content')

<div class="max-w-7xl mx-auto px-4 sm:px-6 md:px-10 py-8 md:py-10">

    <div class="mb-8">
        <h1 class="text-3xl font-extrabold text-[#1E3A6D]">
            My Applications
        </h1>
        <p class="text-slate-600 mt-1">
            All the jobs you have successfully applied to.
        </p>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border overflow-hidden">

        <div class="overflow-x-auto">
            <table class="w-full text-sm min-w-[560px]">
                <thead class="bg-slate-50">
                    <tr class="text-left text-slate-600 font-semibold">
                        <th class="px-6 py-3">Job</th>
                        <th class="px-6 py-3">Company</th>
                        <th class="px-6 py-3">Status</th>
                        <th class="px-6 py-3">Applied</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-slate-100">
                    @forelse($applications as $application)
                        <tr class="hover:bg-slate-50 transition">

                            <td class="px-6 py-4 font-medium align-middle">
                                <a href="{{ route('candidate.applications.show', $application) }}"
                                   class="text-[#1E3A6D] hover:underline">
                                    {{ $application->job->title }}
                                </a>
                            </td>

                            <td class="px-6 py-4 align-middle">
                                {{ $application->job->company_name }}
                            </td>

                            <td class="px-6 py-4 align-middle">
                                <x-application-status-badge :status="$application->status" />
                            </td>

                            <td class="px-6 py-4 text-slate-600 align-middle whitespace-nowrap">
                                {{ $application->created_at->diffForHumans() }}
                            </td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-12 text-center text-slate-500">
                                You haven’t applied to any jobs yet.
                                <a href="{{ route('jobs.index') }}"
                                   class="text-[#1E3A6D] font-semibold hover:underline">
                                    Browse jobs
                                </a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>

    @if($applications->hasPages())
        <div class="mt-6">
            {{ $applications->links() }}
        </div>
    @endif

</div>

@endsection
