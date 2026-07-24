@extends('layouts.employer')

@section('content')

<div class="max-w-5xl mx-auto px-6 py-12">

    <a href="{{ route('employer.jobs.applications', $application->job) }}"
       class="text-sm font-semibold text-[#1E3A6D] hover:underline">
        ← Back to applications
    </a>

    <div class="mt-6 mb-8 flex items-start justify-between gap-4">
        <div>
            <h1 class="text-3xl font-extrabold text-[#1E3A6D]">
                {{ $application->candidate->name }}
            </h1>
            <p class="text-slate-600 mt-1">
                Applied for {{ $application->job->title }}
            </p>
        </div>

        <span class="px-4 py-1 rounded-full text-sm font-semibold
            @class([
                'bg-blue-100 text-blue-700' => $application->status === 'new',
                'bg-yellow-100 text-yellow-700' => $application->status === 'shortlisted',
                'bg-purple-100 text-purple-700' => $application->status === 'interview',
                'bg-red-100 text-red-700' => $application->status === 'rejected',
                'bg-green-100 text-green-700' => $application->status === 'hired',
            ])">
            {{ ucfirst($application->status) }}
        </span>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
        <div class="bg-white rounded-2xl p-6 shadow-sm border">
            <h3 class="font-semibold text-slate-800 mb-4">Candidate</h3>
            <p class="text-sm text-slate-600"><strong>Email:</strong> {{ $application->candidate->email }}</p>
            <p class="text-sm text-slate-600 mt-2"><strong>Applied:</strong> {{ $application->created_at->format('M j, Y g:i A') }}</p>
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
        <form method="POST" action="{{ route('employer.applications.update', $application) }}" class="flex items-center gap-4">
            @csrf
            @method('PATCH')
            <select name="status" class="rounded-lg border-gray-300 text-sm">
                @foreach (['new','shortlisted','interview','rejected','hired'] as $status)
                    <option value="{{ $status }}" @selected($application->status === $status)>
                        {{ ucfirst($status) }}
                    </option>
                @endforeach
            </select>
            <button type="submit"
                    class="px-5 py-2 rounded-lg bg-[#1E3A6D] text-white text-sm font-semibold hover:bg-blue-700 transition">
                Save Status
            </button>
        </form>
    </div>

</div>

@endsection
