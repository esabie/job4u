@extends('layouts.employer')

@section('content')

<section class="bg-slate-50 min-h-screen">
    <div class="max-w-7xl mx-auto px-6 py-12">

        <!-- HEADER -->
        <div class="mb-10">
            <h1 class="text-3xl font-extrabold text-[#1E3A6D]">
                My Applications
            </h1>
            <p class="text-slate-600 mt-1">
                All the jobs you have successfully applied to.
            </p>
        </div>

        <!-- APPLICATIONS TABLE -->
        <div class="bg-white rounded-2xl shadow-sm overflow-hidden">

            <table class="w-full text-sm">
                <thead class="bg-slate-50">
                    <tr>
                        <th class="px-6 py-3 text-left">Job</th>
                        <th class="px-6 py-3 text-left">Company</th>
                        <th class="px-6 py-3 text-left">Status</th>
                        <th class="px-6 py-3 text-left">Applied</th>
                    </tr>
                </thead>

                <tbody class="divide-y">
                    @forelse($applications as $application)
                        <tr class="hover:bg-slate-50 transition">

                            <td class="px-6 py-4 font-medium">
                                <a href="{{ route('candidate.applications.show', $application) }}"
                                   class="text-[#1E3A6D] hover:underline">
                                    {{ $application->job->title }}
                                </a>
                            </td>

                            <td class="px-6 py-4">
                                {{ $application->job->company_name }}
                            </td>

                            <td class="px-6 py-4">
                                <span class="px-3 py-1 rounded-full text-xs font-semibold
                                    @if($application->status === 'applied')
                                        bg-blue-100 text-blue-700
                                    @elseif($application->status === 'shortlisted')
                                        bg-green-100 text-green-700
                                    @elseif($application->status === 'interview')
                                        bg-yellow-100 text-yellow-700
                                    @else
                                        bg-red-100 text-red-700
                                    @endif">
                                    {{ ucfirst($application->status) }}
                                </span>
                            </td>

                            <td class="px-6 py-4 text-slate-600">
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

        @if($applications->hasPages())
            <div class="mt-8">
                {{ $applications->links() }}
            </div>
        @endif

    </div>
</section>

@endsection
