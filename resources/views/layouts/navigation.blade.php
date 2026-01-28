<nav x-data="{ open: false }"
     class="bg-white border-b border-gray-200 relative">

    <div class="max-w-7xl mx-auto px-6">
        <div class="flex items-center justify-between h-16">

            <!-- LEFT: Logo -->
            <div class="flex items-center">
                <a href="{{ route('home') }}" class="flex items-center gap-2">
                    <img
                        src="{{ asset('images/logo.jpg') }}"
                        alt="Job4U Logo"
                        class="h-7 md:h-12 w-auto"
                    />
                </a>
            </div>

            <!-- CENTER: Navigation (desktop) -->
            <div class="hidden md:flex items-center gap-10 text-sm font-semibold text-slate-900">
                <a href="{{ route('register') }}" class="hover:text-[#1E3A6D]">Job Seekers</a>
                <a href="{{ route('register') }}" class="hover:text-[#1E3A6D]">Employer</a>
                <a href="{{ route('jobs.index') }}" class="hover:text-[#1E3A6D]">Find Jobs</a>
            </div>

            <!-- RIGHT: Login (desktop) -->
            <div class="hidden md:flex items-center gap-8 text-sm font-semibold text-slate-900">
                <a href="{{ route('login') }}"
                   class="flex items-center gap-2 hover:text-[#1E3A6D] transition">
                   <svg xmlns="http://www.w3.org/2000/svg"
                         class="h-5 w-5"
                         fill="none"
                         viewBox="0 0 24 24"
                         stroke="currentColor">
                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              stroke-width="2"
                              d="M5.121 17.804A13.937 13.937 0 0112 15c2.5 0 4.847.655 6.879 1.804M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    Login
                </a>
            </div>

            <!-- MOBILE MENU BUTTON -->
            <div class="md:hidden">
                <button
                    @click="open = !open"
                    class="text-slate-700"
                    aria-label="Toggle menu"
                >
                    <svg xmlns="http://www.w3.org/2000/svg"
                         class="h-6 w-6"
                         fill="none"
                         viewBox="0 0 24 24"
                         stroke="currentColor">
                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              stroke-width="2"
                              d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
            </div>

        </div>
    </div>

    <!-- ✅ MOBILE MENU (GOES HERE) -->
    <div
        x-show="open"
        x-transition
        @click.outside="open = false"
        class="md:hidden absolute top-full left-0 w-full bg-white border-t border-gray-200 shadow-lg z-50"
    >
        <div class="flex flex-col p-6 space-y-4 text-sm font-semibold text-slate-900">

            <a href="{{ route('register') }}" class="hover:text-[#1E3A6D]">
                Job Seekers
            </a>

            <a href="{{ route('register') }}" class="hover:text-[#1E3A6D]">
                Employer
            </a>

            <a href="{{ route('jobs.index') }}" class="hover:text-[#1E3A6D]">
                Find Jobs
            </a>

            <a href="{{ route('login') }}" class="hover:text-[#1E3A6D]">
                Login
            </a>

        </div>
    </div>

</nav>
