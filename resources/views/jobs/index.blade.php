@extends('layouts.employer')

@section('content')

<div class="max-w-7xl mx-auto py-8">
    <h1 class="text-3xl font-bold mb-6">Find Jobs</h1>

    <div class="grid md:grid-cols-2 gap-6">
        @foreach($jobs as $job)
            <div class="border rounded-lg p-5 hover:shadow">
                <div class="flex justify-between">
                    <h2 class="font-bold text-lg">{{ $job->title }}</h2>

                    @if($job->is_verified)
                        <span class="text-green-600 text-sm font-semibold">
                            ✔ Verified
                        </span>
                    @endif
                </div>

                <p class="text-gray-600">{{ $job->company_name }}</p>

                <p class="text-sm text-gray-500">
                    {{ $job->location }} • {{ $job->employment_type }}
                </p>

                @if($job->salary_min)
                    <p class="mt-2 font-medium">
                        {{ $job->currency }} {{ number_format($job->salary_min) }} – {{ number_format($job->salary_max) }}
                    </p>
                @endif

                <a href="{{ route('jobs.show', $job) }}"
                   class="inline-block mt-4 text-[#1E3A6D] font-semibold hover:underline">
                    View Job →
                </a>
            </div>
        @endforeach
    </div>

    <div class="mt-8">
        {{ $jobs->links() }}
    </div>
</div>

@endsection
