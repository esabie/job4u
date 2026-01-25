@extends('layouts.public')

@section('content')

    <!-- HERO SECTION -->
    <section class="max-w-7xl mx-auto px-6 mt-12">
        <div class="bg-[#eef7f2] rounded-[40px] px-8 py-20 text-center">

            <h1 class="text-[42px] md:text-[56px] font-extrabold text-[#1E3A6D] leading-tight">
                Where Opportunity Meets Talent
            </h1>

            <p class="mt-6 text-lg text-slate-600 max-w-3xl mx-auto">
                A modern job marketplace built for ambitious professionals and forward-thinking employers.
            </p>

            <p class="mt-2 font-semibold text-slate-900">
                Search smarter. Apply faster. Get hired with confidence.
            </p>

        </div>
    </section>

    <!-- CTA BAR -->
    <section class="max-w-7xl mx-auto px-6 mt-12">
        <div class="bg-gray-100 rounded-xl px-6 py-6
                    flex flex-col md:flex-row items-center justify-between gap-6">

            <!-- Search Icon -->
            <div class="hidden md:flex items-center text-slate-600">
                <svg xmlns="http://www.w3.org/2000/svg"
                     class="h-6 w-6"
                     fill="none"
                     viewBox="0 0 24 24"
                     stroke="currentColor">
                    <path stroke-linecap="round"
                          stroke-linejoin="round"
                          stroke-width="2"
                          d="M21 21l-4.35-4.35M16.65 16.65A7.5 7.5 0 1010.5 18a7.5 7.5 0 006.15-3.35z" />
                </svg>
            </div>

            <!-- CTA BUTTONS -->
            <div class="flex flex-col md:flex-row gap-4 mx-auto">

                <a href="{{ route('jobs.index') }}"
                   class="px-8 py-3 rounded-full bg-[#1E3A6D] text-white font-bold text-sm
                          hover:bg-blue-700 transition transform hover:scale-105 text-center">
                    Find Jobs
                </a>

                <a href="{{ route('register') }}"
                   class="px-8 py-3 rounded-full bg-[#1E3A6D] text-white font-bold text-sm
                          hover:bg-blue-700 transition transform hover:scale-105 text-center">
                    Upload CV
                </a>

                <a href="{{ route('register') }}"
                   class="px-8 py-3 rounded-full bg-[#1E3A6D] text-white font-bold text-sm
                          hover:bg-blue-700 transition transform hover:scale-105 text-center">
                    Post a Job
                </a>

            </div>
        </div>
    </section>

    <!-- FEATURES -->
    <section class="max-w-7xl mx-auto px-6 mt-20 grid grid-cols-1 md:grid-cols-3 gap-10">

        <div class="bg-gray-100 p-10 rounded-xl text-center hover:shadow-lg transition">
            <h3 class="text-[#1E3A6D] font-bold text-lg mb-4">
                Fast Applications
            </h3>
            <p class="text-sm text-slate-600 leading-relaxed">
                Quick Apply with CV so candidates can move from discovery to submission in minutes.
            </p>
        </div>

        <div class="bg-gray-100 p-10 rounded-xl text-center hover:shadow-lg transition">
            <h3 class="text-[#1E3A6D] font-bold text-lg mb-4">
                Relevant matches
            </h3>
            <p class="text-sm text-slate-600 leading-relaxed">
                Profile-based matching and alerts reduce noise and increase fit.
            </p>
        </div>

        <div class="bg-gray-100 p-10 rounded-xl text-center hover:shadow-lg transition">
            <h3 class="text-[#1E3A6D] font-bold text-lg mb-4">
                Verified environment
            </h3>
            <p class="text-sm text-slate-600 leading-relaxed">
                A verification-led approach that protects candidates and supports fair recruitment.
            </p>
        </div>

    </section>

    <div class="h-24"></div>

@endsection
