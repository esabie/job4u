@extends('layouts.admin')

@section('title', 'Jobs')

@section('content')

<div class="max-w-7xl mx-auto px-4 sm:px-6 md:px-10 py-8 md:py-10">

    <div class="mb-8">
        <h1 class="text-3xl font-extrabold text-[#1E3A6D]">Jobs</h1>
        <p class="text-slate-600 mt-2">Verify listings and hide anything that looks wrong.</p>
    </div>

    @if (session('success'))
        <div class="mb-6 rounded-xl bg-green-50 border border-green-200 px-4 py-3 text-sm text-green-700">
            {{ session('success') }}
        </div>
    @endif

    <form method="GET" action="{{ route('admin.jobs.index') }}"
          class="bg-white rounded-2xl border p-4 sm:p-5 mb-6 grid grid-cols-1 sm:grid-cols-3 gap-3">
        <input type="text" name="q" value="{{ request('q') }}" placeholder="Search title, company, location"
               class="rounded-xl border-gray-300 px-4 py-2.5 text-sm">
        <select name="status" class="rounded-xl border-gray-300 px-4 py-2.5 text-sm">
            <option value="">All jobs</option>
            <option value="pending" @selected(request('status') === 'pending')>Pending verification</option>
            <option value="verified" @selected(request('status') === 'verified')>Verified</option>
            <option value="inactive" @selected(request('status') === 'inactive')>Inactive / hidden</option>
        </select>
        <button type="submit"
                class="rounded-xl bg-[#1E3A6D] text-white font-semibold px-4 py-2.5 text-sm hover:bg-blue-700 transition">
            Filter
        </button>
    </form>

    <div class="bg-white rounded-2xl border overflow-hidden">
        @if ($jobs->isEmpty())
            <div class="p-10 text-center text-slate-500">No jobs match these filters.</div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full text-sm min-w-[760px]">
                    <thead class="bg-slate-50 text-left text-slate-600">
                        <tr>
                            <th class="px-6 py-3 font-semibold">Job</th>
                            <th class="px-6 py-3 font-semibold">Employer</th>
                            <th class="px-6 py-3 font-semibold">Status</th>
                            <th class="px-6 py-3 font-semibold">Posted</th>
                            <th class="px-6 py-3 font-semibold"></th>
                        </tr>
                    </thead>
                    <tbody class="divide-y">
                        @foreach ($jobs as $job)
                            <tr>
                                <td class="px-6 py-4">
                                    <p class="font-semibold text-slate-900">{{ $job->title }}</p>
                                    <p class="text-slate-500">{{ $job->company_name }} • {{ $job->location }}</p>
                                </td>
                                <td class="px-6 py-4 text-slate-600">
                                    {{ $job->employer?->name ?? '—' }}
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex flex-wrap gap-2">
                                        @if ($job->is_verified)
                                            <span class="text-xs font-semibold text-green-700 bg-green-100 px-2.5 py-1 rounded-full">Verified</span>
                                        @else
                                            <span class="text-xs font-semibold text-amber-700 bg-amber-100 px-2.5 py-1 rounded-full">Unverified</span>
                                        @endif
                                        @if ($job->is_active)
                                            <span class="text-xs font-semibold text-slate-700 bg-slate-100 px-2.5 py-1 rounded-full">Active</span>
                                        @else
                                            <span class="text-xs font-semibold text-red-700 bg-red-100 px-2.5 py-1 rounded-full">Hidden</span>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-slate-500">
                                    {{ $job->created_at->diffForHumans() }}
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <a href="{{ route('admin.jobs.show', $job) }}"
                                       class="font-semibold text-[#1E3A6D] hover:underline">
                                        Review
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>

    <div class="mt-6">
        {{ $jobs->links() }}
    </div>

</div>

@endsection
