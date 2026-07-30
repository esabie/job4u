@extends('layouts.admin')

@section('title', $job->title)

@section('content')

<div class="max-w-5xl mx-auto px-4 sm:px-6 md:px-10 py-8 md:py-10">

    <div class="mb-6">
        <a href="{{ route('admin.jobs.index') }}" class="text-sm font-semibold text-[#1E3A6D] hover:underline">
            ← Back to jobs
        </a>
    </div>

    @if (session('success'))
        <div class="mb-6 rounded-xl bg-green-50 border border-green-200 px-4 py-3 text-sm text-green-700">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white rounded-2xl border p-5 sm:p-8 mb-6">
        <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-4 mb-6">
            <div>
                <h1 class="text-3xl font-extrabold text-[#1E3A6D]">{{ $job->title }}</h1>
                <p class="text-slate-600 mt-2">
                    {{ $job->company_name }} • {{ $job->location }}
                    @if ($job->work_arrangement)
                        • {{ $job->work_arrangement }}
                    @endif
                </p>
                <p class="text-sm text-slate-500 mt-2">
                    {{ $job->employment_type }} • {{ $job->category }}
                    • Posted {{ $job->created_at->diffForHumans() }}
                </p>
            </div>

            <div class="flex flex-wrap gap-2">
                @if ($job->is_verified)
                    <span class="text-xs font-semibold text-green-700 bg-green-100 px-3 py-1 rounded-full">Verified</span>
                @else
                    <span class="text-xs font-semibold text-amber-700 bg-amber-100 px-3 py-1 rounded-full">Unverified</span>
                @endif
                @if ($job->is_active)
                    <span class="text-xs font-semibold text-slate-700 bg-slate-100 px-3 py-1 rounded-full">Active</span>
                @else
                    <span class="text-xs font-semibold text-red-700 bg-red-100 px-3 py-1 rounded-full">Hidden</span>
                @endif
            </div>
        </div>

        <div class="mb-6 rounded-xl bg-slate-50 border px-4 py-3 text-sm text-slate-600">
            <p>
                <strong>Employer:</strong>
                @if ($job->employer)
                    <a href="{{ route('admin.users.show', $job->employer) }}" class="text-[#1E3A6D] font-semibold hover:underline">
                        {{ $job->employer->name }}
                    </a>
                    ({{ $job->employer->email }})
                @else
                    —
                @endif
            </p>
        </div>

        <div class="job-description text-slate-700 leading-relaxed mb-8">
            {!! $job->description !!}
        </div>

        <div class="flex flex-col sm:flex-row flex-wrap gap-3">
            @unless ($job->is_verified)
                <form method="POST" action="{{ route('admin.jobs.verify', $job) }}">
                    @csrf
                    @method('PATCH')
                    <button type="submit"
                            class="inline-flex w-full sm:w-auto items-center justify-center px-6 py-3 rounded-xl bg-[#1E3A6D] text-white font-semibold hover:bg-blue-700 transition">
                        Verify job
                    </button>
                </form>
            @else
                <form method="POST" action="{{ route('admin.jobs.unverify', $job) }}">
                    @csrf
                    @method('PATCH')
                    <button type="submit"
                            class="inline-flex w-full sm:w-auto items-center justify-center px-6 py-3 rounded-xl border border-slate-300 text-slate-700 font-semibold hover:bg-slate-100 transition">
                        Remove verification
                    </button>
                </form>
            @endunless

            @if ($job->is_active)
                <form method="POST" action="{{ route('admin.jobs.deactivate', $job) }}">
                    @csrf
                    @method('PATCH')
                    <button type="submit"
                            class="inline-flex w-full sm:w-auto items-center justify-center px-6 py-3 rounded-xl bg-red-600 text-white font-semibold hover:bg-red-700 transition">
                        Hide from board
                    </button>
                </form>
            @else
                <form method="POST" action="{{ route('admin.jobs.activate', $job) }}">
                    @csrf
                    @method('PATCH')
                    <button type="submit"
                            class="inline-flex w-full sm:w-auto items-center justify-center px-6 py-3 rounded-xl border border-slate-300 text-slate-700 font-semibold hover:bg-slate-100 transition">
                        Restore to board
                    </button>
                </form>
            @endif

            <a href="{{ route('jobs.show', $job) }}"
               target="_blank"
               class="inline-flex w-full sm:w-auto items-center justify-center px-6 py-3 rounded-xl border border-slate-300 text-slate-700 font-semibold hover:bg-slate-100 transition">
                View public page
            </a>
        </div>
    </div>

</div>

@endsection
