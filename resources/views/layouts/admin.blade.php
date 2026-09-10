<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Admin') | Job4U</title>

    <meta name="viewport" content="width=device-width, initial-scale=1">

    @include('layouts.partials.favicon')

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-slate-50 text-slate-900" x-data="{ sidebarOpen: false }">

@php
    $navClass = function (bool $active): string {
        return $active
            ? 'flex items-center px-4 py-3 rounded-lg bg-[#1E3A6D]/15 text-[#1E3A6D] font-semibold'
            : 'flex items-center px-4 py-3 rounded-lg text-slate-700 hover:bg-[#1E3A6D]/15 hover:text-[#1E3A6D] transition';
    };
@endphp

<div class="flex min-h-screen">

    <div
        x-show="sidebarOpen"
        x-transition.opacity
        @click="sidebarOpen = false"
        class="fixed inset-0 z-40 bg-slate-900/40 md:hidden"
        style="display: none;"
    ></div>

    <aside
        class="fixed inset-y-0 left-0 z-50 w-64 shrink-0 bg-[#1E3A6D]/10 px-6 py-8
               transform transition-transform duration-200 ease-out
               md:static md:translate-x-0 md:block"
        :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full md:translate-x-0'"
    >
        <div class="flex items-center justify-between mb-8 md:block">
            <h3 class="text-xs font-bold text-slate-500 uppercase tracking-wider">
                Admin
            </h3>
            <button
                type="button"
                @click="sidebarOpen = false"
                class="md:hidden text-slate-500 hover:text-slate-800"
                aria-label="Close menu"
            >
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <nav class="space-y-2">
            <a href="{{ route('admin.dashboard') }}"
               class="{{ $navClass(request()->routeIs('admin.dashboard')) }}">
                Dashboard
            </a>

            <a href="{{ route('admin.jobs.index') }}"
               class="{{ $navClass(request()->routeIs('admin.jobs.*')) }}">
                Jobs
            </a>

            <a href="{{ route('admin.users.index') }}"
               class="{{ $navClass(request()->routeIs('admin.users.*')) }}">
                Users
            </a>

            <a href="{{ route('jobs.index') }}"
               class="{{ $navClass(false) }}">
                Public board
            </a>
        </nav>
    </aside>

    <div class="flex-1 flex flex-col min-w-0">
        <header class="bg-white border-b sticky top-0 z-30">
            <div class="px-4 sm:px-6 md:px-10 py-4 flex items-center justify-between gap-4">
                <div class="flex items-center gap-3">
                    <button
                        type="button"
                        @click="sidebarOpen = true"
                        class="md:hidden inline-flex items-center justify-center rounded-lg p-2 text-slate-700 hover:bg-slate-100"
                        aria-label="Open menu"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>

                    <span class="text-xl font-extrabold text-[#1E3A6D]">
                        Job4U Admin
                    </span>
                </div>

                <div class="flex items-center gap-3 sm:gap-4">
                    <x-profile-nav-link />

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button
                            type="submit"
                            class="inline-flex items-center px-3 sm:px-5 py-2 sm:py-2.5 bg-red-600 text-white rounded-md
                                   text-sm font-semibold shadow-sm hover:bg-red-700 transition">
                            Logout
                        </button>
                    </form>
                </div>
            </div>
        </header>

        <main class="flex-1">
            @yield('content')
        </main>
    </div>
</div>

@include('layouts.partials.loading-overlay')

</body>
</html>
