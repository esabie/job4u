@extends('layouts.employer')

@section('content')

<section class="bg-slate-50 min-h-screen">
    <div class="max-w-7xl mx-auto px-6 py-12">

        <!-- ===================== -->
        <!-- HEADER -->
        <!-- ===================== -->
        <div class="mb-10">
            <h1 class="text-3xl font-extrabold text-[#1E3A6D]">
                Welcome, {{ auth()->user()->name }}
            </h1>
            <p class="text-slate-600 mt-1">
                Track your job applications and progress.
            </p>
        </div>

        <!-- ===================== -->
        <!-- STATS -->
        <!-- ===================== -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12">

            <div class="bg-white rounded-2xl p-6 shadow-sm">
                <p class="text-sm text-slate-600">Total Applications</p>
                <p class="text-3xl font-extrabold text-[#1E3A6D] mt-1">
                    {{ $totalApplications }}
                </p>
            </div>

            <div class="bg-white rounded-2xl p-6 shadow-sm">
                <p class="text-sm text-slate-600">Shortlisted</p>
                <p class="text-3xl font-extrabold text-green-600 mt-1">
                    {{ $shortlisted }}
                </p>
            </div>

            <div class="bg-white rounded-2xl p-6 shadow-sm">
                <p class="text-sm text-slate-600">Interviews</p>
                <p class="text-3xl font-extrabold text-[#1E3A6D] mt-1">
                    {{ $interviews }}
                </p>
            </div>

        </div>

        <!-- ===================== -->
        <!-- APPLICATIONS TABLE -->
        <!-- ===================== -->
        <div class="bg-white rounded-2xl shadow-sm overflow-hidden">

            <div class="px-6 py-4 border-b">
                <h2 class="font-semibold text-slate-800">
                    My Applications
                </h2>
            </div>

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

                            <!-- JOB -->
                            <td class="px-6 py-4 font-medium">
                                <a href="{{ route('candidate.applications.show', $application) }}"
                                   class="text-[#1E3A6D] hover:underline">
                                    {{ $application->job->title }}
                                </a>
                            </td>

                            <!-- COMPANY -->
                            <td class="px-6 py-4">
                                {{ $application->job->company_name }}
                            </td>

                            <!-- STATUS -->
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

                            <!-- DATE -->
                            <td class="px-6 py-4 text-slate-600">
                                {{ $application->created_at->diffForHumans() }}
                            </td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-12 text-center text-slate-500">
                                You haven’t applied to any jobs yet.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

        </div>

    </div>
</section>

@endsection
