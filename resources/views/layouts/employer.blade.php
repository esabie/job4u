<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Employer Dashboard | Job4U</title>

    <meta name="viewport" content="width=device-width, initial-scale=1">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-slate-50 text-slate-900">

<div class="flex min-h-screen">

    <!-- SIDEBAR -->
    <aside class="w-64 bg-[#1E3A6D]/10 px-6 py-8 hidden md:block">

        <h3 class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-8">
            Menu
        </h3>

        <nav class="space-y-2">

            <a href="{{ route('employer.dashboard') }}"
               class="flex items-center px-4 py-3 rounded-lg
                      bg-[#1E3A6D]/15 text-[#1E3A6D] font-semibold">
                Dashboard
            </a>

            <a href="{{ route('profile.edit') }}"
               class="flex items-center px-4 py-3 rounded-lg
                      text-slate-700 hover:bg-[#1E3A6D]/15 hover:text-[#1E3A6D] transition">
                Profile
            </a>

            <a href="{{ route('employer.jobs.index') }}"
               class="flex items-center px-4 py-3 rounded-lg
                      text-slate-700 hover:bg-[#1E3A6D]/15 hover:text-[#1E3A6D] transition">
                Jobs
            </a>

            <a href="#"
               class="flex items-center px-4 py-3 rounded-lg
                      text-slate-700 hover:bg-[#1E3A6D]/15 hover:text-[#1E3A6D] transition">
                Applications
            </a>

            <a href="#"
               class="flex items-center px-4 py-3 rounded-lg
                      text-slate-700 hover:bg-[#1E3A6D]/15 hover:text-[#1E3A6D] transition">
                Alerts
            </a>

            <a href="#"
               class="flex items-center px-4 py-3 rounded-lg
                      text-slate-700 hover:bg-[#1E3A6D]/15 hover:text-[#1E3A6D] transition">
                Settings
            </a>

        </nav>
    </aside>

    <!-- MAIN AREA -->
    <div class="flex-1 flex flex-col">

        <!-- TOP BAR -->
        <header class="bg-white border-b">
            <div class="max-w-7xl mx-auto px-8 py-4 flex items-center justify-between">

                <span class="text-xl font-extrabold text-[#1E3A6D]">
                    Job4U
                </span>

                <div class="flex items-center gap-4">
                    <span class="text-sm text-slate-600">
                        {{ auth()->user()->name }}
                    </span>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button
                            type="submit"
                            class="inline-flex items-center
                                px-5 py-2.5
                                bg-red-600 text-white
                                rounded-md
                                text-sm font-semibold
                                shadow-sm
                                hover:bg-red-700
                                focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2
                                transition">
                            Logout
                        </button>
                    </form>
                </div>

            </div>
        </header>

        <!-- PAGE CONTENT -->
        <main class="flex-1">
            @yield('content')
        </main>

    </div>
</div>

</body>
</html>
