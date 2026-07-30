@extends('layouts.admin')

@section('title', $user->name)

@section('content')

<div class="max-w-5xl mx-auto px-4 sm:px-6 md:px-10 py-8 md:py-10">

    <div class="mb-6">
        <a href="{{ route('admin.users.index') }}" class="text-sm font-semibold text-[#1E3A6D] hover:underline">
            ← Back to users
        </a>
    </div>

    @if (session('success'))
        <div class="mb-6 rounded-xl bg-green-50 border border-green-200 px-4 py-3 text-sm text-green-700">
            {{ session('success') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="mb-6 rounded-xl bg-red-50 border border-red-200 px-4 py-3 text-sm text-red-700">
            {{ $errors->first() }}
        </div>
    @endif

    <div class="bg-white rounded-2xl border p-5 sm:p-8 mb-6">
        <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-4">
            <div>
                <h1 class="text-3xl font-extrabold text-[#1E3A6D]">{{ $user->name }}</h1>
                <p class="text-slate-600 mt-2">{{ $user->email }}</p>
                <p class="text-sm text-slate-500 mt-2 capitalize">
                    {{ $user->role }}
                    • Joined {{ $user->created_at->toFormattedDateString() }}
                </p>
            </div>

            @if ($user->is_suspended)
                <span class="text-xs font-semibold text-red-700 bg-red-100 px-3 py-1 rounded-full self-start">Suspended</span>
            @else
                <span class="text-xs font-semibold text-green-700 bg-green-100 px-3 py-1 rounded-full self-start">Active</span>
            @endif
        </div>

        <div class="grid grid-cols-2 gap-4 mt-8">
            <div class="rounded-xl bg-slate-50 border p-4">
                <p class="text-sm text-slate-500">Jobs posted</p>
                <p class="mt-1 text-2xl font-bold text-slate-900">{{ $user->jobs_count }}</p>
            </div>
            <div class="rounded-xl bg-slate-50 border p-4">
                <p class="text-sm text-slate-500">Applications</p>
                <p class="mt-1 text-2xl font-bold text-slate-900">{{ $user->applications_count }}</p>
            </div>
        </div>

        <div class="mt-8 flex flex-col sm:flex-row gap-3">
            @if ($user->isAdmin())
                <p class="text-sm text-slate-500">Admin accounts cannot be suspended here.</p>
            @elseif ($user->id === auth()->id())
                <p class="text-sm text-slate-500">You cannot suspend your own account.</p>
            @elseif ($user->is_suspended)
                <form method="POST" action="{{ route('admin.users.unsuspend', $user) }}">
                    @csrf
                    @method('PATCH')
                    <button type="submit"
                            class="inline-flex items-center justify-center px-6 py-3 rounded-xl bg-[#1E3A6D] text-white font-semibold hover:bg-blue-700 transition">
                        Restore account
                    </button>
                </form>
            @else
                <form method="POST" action="{{ route('admin.users.suspend', $user) }}"
                      onsubmit="return confirm('Suspend this user? Active job listings will be hidden.')">
                    @csrf
                    @method('PATCH')
                    <button type="submit"
                            class="inline-flex items-center justify-center px-6 py-3 rounded-xl bg-red-600 text-white font-semibold hover:bg-red-700 transition">
                        Suspend user
                    </button>
                </form>
            @endif
        </div>
    </div>

    @if ($recentJobs->isNotEmpty())
        <div class="bg-white rounded-2xl border overflow-hidden">
            <div class="px-5 sm:px-6 py-4 border-b">
                <h2 class="text-lg font-bold text-slate-900">Recent jobs</h2>
            </div>
            <div class="divide-y">
                @foreach ($recentJobs as $job)
                    <div class="px-5 sm:px-6 py-4 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                        <div>
                            <p class="font-semibold text-slate-900">{{ $job->title }}</p>
                            <p class="text-sm text-slate-500">{{ $job->company_name }}</p>
                        </div>
                        <a href="{{ route('admin.jobs.show', $job) }}"
                           class="text-sm font-semibold text-[#1E3A6D] hover:underline">
                            Review job
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

</div>

@endsection
