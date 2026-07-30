@extends('layouts.employer')

@section('content')

<div class="max-w-5xl mx-auto px-4 sm:px-6 md:px-10 py-8 md:py-10">

    <div class="mb-8">
        <h1 class="text-3xl font-extrabold text-[#1E3A6D]">
            Job Alerts
        </h1>
        <p class="text-slate-600 mt-1">
            Tell us what you are looking for and we will email you when matching jobs are posted.
        </p>
    </div>

    @if (session('success'))
        <div class="mb-6 rounded-xl bg-green-50 border border-green-200 px-4 py-3 text-sm text-green-700">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white rounded-2xl shadow-sm border p-6 sm:p-8 mb-8 md:mb-10">
        <h2 class="text-lg font-bold text-slate-900 mb-6">
            Create a new alert
        </h2>

        <form method="POST" action="{{ route('candidate.alerts.store') }}"
              data-loader-message="Saving your alert..."
              class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @csrf

            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">Keyword</label>
                <input type="text" name="keyword" value="{{ old('keyword') }}"
                       placeholder="e.g. Product Manager"
                       class="w-full rounded-xl border-gray-300 px-4 py-3
                              focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                @error('keyword')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">Location</label>
                <input type="text" name="location" value="{{ old('location') }}"
                       placeholder="e.g. Accra"
                       class="w-full rounded-xl border-gray-300 px-4 py-3
                              focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
            </div>

            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">Category</label>
                <select name="category"
                        class="w-full rounded-xl border-gray-300 px-4 py-3
                               focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    <option value="">Any category</option>
                    @foreach (['Administration','Construction','Finance','Healthcare','Hospitality','Legal','Technology','Other'] as $cat)
                        <option value="{{ $cat }}" @selected(old('category') === $cat)>{{ $cat }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <x-work-arrangement-select-optional :value="old('work_arrangement')" />
            </div>

            <div class="md:col-span-2 flex justify-end">
                <button type="submit"
                        data-loading-text="Saving..."
                        class="inline-flex w-full sm:w-auto items-center justify-center gap-2 px-8 py-3 rounded-xl bg-[#1E3A6D] text-white
                               font-semibold hover:bg-blue-700 transition disabled:cursor-wait disabled:opacity-80">
                    Create Alert
                </button>
            </div>
        </form>
    </div>

    <div class="space-y-4">
        @forelse ($alerts as $alert)
            <div class="bg-white rounded-2xl shadow-sm border p-5 sm:p-6 flex flex-col sm:flex-row sm:items-start sm:justify-between gap-4">
                <div class="min-w-0">
                    <div class="flex flex-wrap items-center gap-2 mb-2">
                        @foreach (array_filter([$alert->keyword, $alert->category, $alert->work_arrangement, $alert->location]) as $criterion)
                            <span class="px-3 py-1 rounded-full bg-slate-100 text-slate-700 text-sm font-semibold">
                                {{ $criterion }}
                            </span>
                        @endforeach

                        @unless ($alert->is_active)
                            <span class="px-3 py-1 rounded-full bg-slate-200 text-slate-500 text-xs font-semibold">
                                Paused
                            </span>
                        @endunless
                    </div>

                    <p class="text-sm text-slate-500">
                        {{ $alert->matchingJobsQuery()->count() }} matching job(s) right now •
                        <a href="{{ route('jobs.index', ['q' => $alert->keyword, 'location' => $alert->location, 'work_arrangement' => $alert->work_arrangement]) }}"
                           class="text-[#1E3A6D] font-semibold hover:underline">
                            View
                        </a>
                    </p>
                </div>

                <div class="flex items-center gap-2 shrink-0">
                    <form method="POST" action="{{ route('candidate.alerts.update', $alert) }}" data-no-loader>
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="is_active" value="{{ $alert->is_active ? 0 : 1 }}">
                        <button type="submit"
                                class="px-4 py-2 rounded-lg border border-slate-300 text-slate-600 text-sm font-semibold hover:bg-slate-100 transition">
                            {{ $alert->is_active ? 'Pause' : 'Resume' }}
                        </button>
                    </form>

                    <form method="POST" action="{{ route('candidate.alerts.destroy', $alert) }}" data-no-loader
                          onsubmit="return confirm('Remove this job alert?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                                class="px-4 py-2 rounded-lg border border-red-200 text-red-600 text-sm font-semibold hover:bg-red-50 transition">
                            Delete
                        </button>
                    </form>
                </div>
            </div>
        @empty
            <div class="bg-white rounded-2xl shadow-sm border p-8 text-center text-slate-500">
                You have no job alerts yet. Create one above to get notified about new jobs.
            </div>
        @endforelse
    </div>

</div>

@endsection
