@extends('layouts.employer')

@section('content')

<div class="max-w-7xl mx-auto px-4 sm:px-6 md:px-10 py-8 md:py-10">

    <div class="mb-8">
        <a href="{{ route('employer.jobs.index') }}"
           class="text-sm font-semibold text-[#1E3A6D] hover:underline">
            ← Back to jobs
        </a>
        <h1 class="mt-3 text-3xl md:text-4xl font-extrabold text-[#1E3A6D]">
            Applications
        </h1>
        <p class="text-slate-600 mt-2">
            {{ $job->title }} • {{ $job->company_name }}
        </p>
    </div>

    <div class="bg-white rounded-3xl shadow-sm border overflow-hidden">

        @if ($applications->isEmpty())
            <div class="p-8 sm:p-12 text-center">
                <p class="text-slate-600">No applications yet.</p>
            </div>
        @else

            <div class="overflow-x-auto">
                <table class="w-full text-sm min-w-[640px]">
                    <thead class="bg-slate-50">
                        <tr class="text-left text-slate-600 font-semibold">
                            <th class="px-6 py-4">Candidate</th>
                            <th class="px-6 py-4">Applied</th>
                            <th class="px-6 py-4">Status</th>
                            <th class="px-6 py-4 text-right">Actions</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-slate-100">
                        @foreach ($applications as $application)
                            <tr class="hover:bg-slate-50 transition">

                                <td class="px-6 py-4 align-middle">
                                    <p class="font-semibold text-slate-900">
                                        {{ $application->candidate->name }}
                                    </p>
                                    <p class="text-xs text-slate-500">
                                        {{ $application->candidate->email }}
                                    </p>
                                </td>

                                <td class="px-6 py-4 align-middle text-slate-500 whitespace-nowrap">
                                    {{ $application->created_at->diffForHumans() }}
                                </td>

                                <td class="px-6 py-4 align-middle">
                                    <x-application-status-badge :status="$application->status" />
                                </td>

                                <td class="px-6 py-4 align-middle">
                                    <div class="flex items-center justify-end gap-3 whitespace-nowrap">
                                        <a href="{{ route('employer.applications.show', $application) }}"
                                           class="text-[#1E3A6D] font-semibold hover:underline">
                                            View
                                        </a>

                                        <form method="POST"
                                              action="{{ route('employer.applications.update', $application) }}">
                                            @csrf
                                            @method('PATCH')

                                            <select name="status"
                                                    onchange="this.form.submit()"
                                                    class="rounded-lg border-gray-300 text-sm">
                                                @foreach (\App\Enums\ApplicationStatus::cases() as $status)
                                                    <option value="{{ $status->value }}"
                                                        @selected($application->status === $status)>
                                                        {{ $status->label() }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </form>
                                    </div>
                                </td>

                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        @endif
    </div>

</div>

@endsection
