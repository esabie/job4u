@extends('layouts.employer')

@section('content')

<div class="flex bg-slate-50 min-h-screen">



    <!-- ===================== -->
    <!-- MAIN CONTENT -->
    <!-- ===================== -->
    <main class="flex-1 py-10 bg-slate-50">
    <div class="max-w-7xl pl-16 pr-10">

    <!-- HEADER -->
    <div class="flex items-center justify-between mb-8">
    <div>
        <h1 class="text-3xl font-extrabold text-[#1E3A6D]">
            Welcome, {{ auth()->user()->name }}
        </h1>
        <p class="text-slate-600 mt-1">
            Post roles, review candidates and track performance.
        </p>
    </div>

    <a href="{{ route('employer.jobs.create') }}"
       class="px-6 py-3 rounded-xl bg-[#1E3A6D] text-white font-semibold
              hover:bg-blue-700 transition">
        + Post Job
        
    </a>
</div>


    <!-- ===================== -->
    <!-- STATS ROW -->
    <!-- ===================== -->
    <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-3 gap-12 mb-12">

        <!-- Active Listings -->
        <div class="bg-white rounded-2xl px-2 py-6 shadow-sm border">
            <p class="text-sm font-medium text-slate-600">
                Active Listings
            </p>
            <p class="text-4xl font-extrabold text-[#1E3A6D] mt-2">
                {{ $activeJobs ?? 0 }}
            </p>
        </div>

        <!-- New Applicants -->
        <div class="bg-white rounded-2xl px-8 py-6 shadow-sm border">
            <p class="text-sm font-medium text-slate-600">
                New Applicants
            </p>
            <p class="text-4xl font-extrabold text-[#1E3A6D] mt-2">
                {{ $newApplicants ?? 0 }}
            </p>
        </div>


    </div>


    <!-- ===================== -->
    <!-- CHART + TABLE -->
    <!-- ===================== -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-10">

        <!-- Applicants By Day -->
        <div class="bg-blue-50 rounded-3xl p-8">
            <h3 class="font-semibold text-slate-800 mb-6">
                Applicants By Day
            </h3>

            <div class="flex items-end justify-between h-40">
                @foreach ([40, 90, 70, 120, 30, 55, 80] as $height)
                    <div class="bg-[#1E3A6D] rounded-lg w-10"
                         style="height: {{ $height }}px"></div>
                @endforeach
            </div>
        </div>

        <!-- Recent Applications -->
        <div class="bg-blue-50 rounded-3xl p-8">
            <h3 class="font-semibold text-slate-800 mb-4">
                Recent Applications
            </h3>

            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-blue-100 text-left">
                        <th class="px-4 py-2 rounded-l-lg">Name</th>
                        <th class="px-4 py-2">Role</th>
                        <th class="px-4 py-2 rounded-r-lg">Stage</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-blue-200">
                    <tr>
                        <td class="px-4 py-3 font-medium">A. Mensah</td>
                        <td class="px-4 py-3">Clinical Lead</td>
                        <td class="px-4 py-3 font-semibold">Shortlist</td>
                    </tr>
                    <tr>
                        <td class="px-4 py-3 font-medium">S. Patel</td>
                        <td class="px-4 py-3">Support Worker</td>
                        <td class="px-4 py-3 font-semibold">Interview</td>
                    </tr>
                    <tr>
                        <td class="px-4 py-3 font-medium">J. Taylor</td>
                        <td class="px-4 py-3">Admin</td>
                        <td class="px-4 py-3 font-semibold">Review</td>
                    </tr>
                </tbody>
            </table>
        </div>

    </div>

    <!-- ===================== -->
    <!-- TIP BANNER -->
    <!-- ===================== -->
    <div class="bg-slate-100 rounded-full px-10 py-5 text-[#1E3A6D] font-semibold max-w-4xl">
        Tip: Use Premium Listings to boost visibility and reach qualified candidates faster
    </div>

    </div>

</main>

</div>

@endsection
