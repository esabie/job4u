@extends('layouts.employer')

@section('content')

<div class="max-w-7xl mx-auto">

    <!-- HEADER -->
    <div class="mb-10">
        <h1 class="text-4xl font-extrabold text-[#1E3A6D]">
            Applications
        </h1>
        <p class="text-slate-600 mt-2">
            {{ $job->title }} • {{ $job->company_name }}
        </p>
    </div>

    <div class="bg-white rounded-3xl shadow-sm border overflow-hidden">

        @if ($applications->isEmpty())
            <div class="p-12 text-center">
                <p class="text-slate-600">No applications yet.</p>
            </div>
        @else

        <table class="w-full text-sm">
            <thead class="bg-slate-50">
                <tr>
                    <th class="px-6 py-4 text-left">Candidate</th>
                    <th class="px-6 py-4">Applied</th>
                    <th class="px-6 py-4">Status</th>
                    <th class="px-6 py-4 text-right">Actions</th>
                </tr>
            </thead>

            <tbody class="divide-y">
                @foreach ($applications as $application)
                <tr>

                    <td class="px-6 py-4">
                        <p class="font-semibold">
                            {{ $application->candidate->name }}
                        </p>
                        <p class="text-xs text-slate-500">
                            {{ $application->candidate->email }}
                        </p>
                    </td>

                    <td class="px-6 py-4 text-slate-500">
                        {{ $application->created_at->diffForHumans() }}
                    </td>

                    <td class="px-6 py-4">
                        <span class="px-3 py-1 rounded-full text-xs font-semibold
                            @class([
                                'bg-blue-100 text-blue-700' => $application->status === 'new',
                                'bg-yellow-100 text-yellow-700' => $application->status === 'shortlisted',
                                'bg-purple-100 text-purple-700' => $application->status === 'interview',
                                'bg-red-100 text-red-700' => $application->status === 'rejected',
                                'bg-green-100 text-green-700' => $application->status === 'hired',
                            ])">
                            {{ ucfirst($application->status) }}
                        </span>
                    </td>

                    <td class="px-6 py-4 text-right">
                        <form method="POST"
                              action="{{ route('employer.applications.update', $application) }}">
                            @csrf
                            @method('PATCH')

                            <select name="status"
                                    onchange="this.form.submit()"
                                    class="rounded-lg border-gray-300 text-sm">
                                @foreach (['new','shortlisted','interview','rejected','hired'] as $status)
                                    <option value="{{ $status }}"
                                        @selected($application->status === $status)>
                                        {{ ucfirst($status) }}
                                    </option>
                                @endforeach
                            </select>
                        </form>
                    </td>

                </tr>
                @endforeach
            </tbody>
        </table>

        @endif
    </div>

</div>

@endsection
