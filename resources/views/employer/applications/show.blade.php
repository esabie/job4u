@extends('layouts.employer')

@section('content')

<div class="max-w-5xl mx-auto px-4 sm:px-6 md:px-10 py-8 md:py-10">

    <a href="{{ route('employer.jobs.applications', $application->job) }}"
       class="text-sm font-semibold text-[#1E3A6D] hover:underline">
        ← Back to applications
    </a>

    <div class="mt-6 mb-8 flex flex-col gap-3 sm:flex-row sm:items-start sm:justify-between">
        <div>
            <h1 class="text-3xl font-extrabold text-[#1E3A6D]">
                {{ $application->candidate->name }}
            </h1>
            <p class="text-slate-600 mt-1">
                Applied for {{ $application->job->title }}
            </p>
            @if ($application->candidate->headline || $application->candidate->location || $application->candidate->phone)
                <p class="text-sm text-slate-500 mt-2">
                    {{ collect([$application->candidate->headline, $application->candidate->location, $application->candidate->phone])->filter()->implode(' • ') }}
                </p>
            @endif
        </div>

        <x-application-status-badge :status="$application->status" class="!text-sm !px-4 !py-1 self-start" />
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
        <div class="bg-white rounded-2xl p-6 shadow-sm border">
            <h3 class="font-semibold text-slate-800 mb-4">Candidate</h3>
            <p class="text-sm text-slate-600"><strong>Email:</strong> {{ $application->candidate->email }}</p>
            @if ($application->candidate->phone)
                <p class="text-sm text-slate-600 mt-2"><strong>Phone:</strong> {{ $application->candidate->phone }}</p>
            @endif
            @if ($application->candidate->location)
                <p class="text-sm text-slate-600 mt-2"><strong>Location:</strong> {{ $application->candidate->location }}</p>
            @endif
            <p class="text-sm text-slate-600 mt-2"><strong>Applied:</strong> {{ $application->created_at->format('M j, Y g:i A') }}</p>
            @if ($application->candidate->summary)
                <div class="mt-4">
                    <p class="text-sm font-semibold text-slate-700 mb-1">Summary</p>
                    <p class="text-sm text-slate-600 whitespace-pre-line">{{ $application->candidate->summary }}</p>
                </div>
            @endif
        </div>

        <div class="bg-white rounded-2xl p-6 shadow-sm border">
            <h3 class="font-semibold text-slate-800 mb-4">Documents</h3>
            <a href="{{ asset('storage/'.$application->cv_path) }}"
               target="_blank"
               class="inline-block px-4 py-2 rounded-lg bg-[#1E3A6D] text-white text-sm font-semibold hover:bg-blue-700 transition">
                Download CV
            </a>

            @if ($application->cover_letter)
                <div class="mt-4">
                    <p class="text-sm font-semibold text-slate-700 mb-1">Cover Letter</p>
                    <p class="text-sm text-slate-600 whitespace-pre-line">{{ $application->cover_letter }}</p>
                </div>
            @endif
        </div>
    </div>

    <x-application-answers :answers="$application->answers" class="mb-8" />

    <div class="bg-white rounded-2xl p-6 shadow-sm border">
        <h3 class="font-semibold text-slate-800 mb-4">Update Status</h3>
        <form method="POST"
              action="{{ route('employer.applications.update', $application) }}"
              class="flex flex-col sm:flex-row sm:items-center gap-3 sm:gap-4">
            @csrf
            @method('PATCH')
            <select name="status" class="rounded-lg border-gray-300 text-sm w-full sm:w-auto">
                @foreach (\App\Enums\ApplicationStatus::cases() as $status)
                    <option value="{{ $status->value }}" @selected($application->status === $status)>
                        {{ $status->label() }}
                    </option>
                @endforeach
            </select>
            <button type="submit"
                    class="inline-flex justify-center px-5 py-2 rounded-lg bg-[#1E3A6D] text-white text-sm font-semibold hover:bg-blue-700 transition">
                Save Status
            </button>
        </form>
    </div>

</div>

@endsection
