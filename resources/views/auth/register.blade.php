<x-guest-layout>

<section
    <!-- Logo -->
    <div class="flex justify-center mb-8">
        <img
            src="{{ asset('images/logo.jpg') }}"
            alt="Job4U"
            class="h-14"
        />
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-5">
        @csrf

        <div>
            <label class="block text-sm font-semibold text-slate-700 mb-2">
                Full name
            </label>
            <input
                type="text"
                name="name"
                value="{{ old('name') }}"
                required
                autofocus
                class="w-full rounded-xl border border-slate-300
                       px-4 py-3 focus:ring-2 focus:ring-[#1E3A6D]/30
                       focus:border-[#1E3A6D]"
            />
        </div>

        <div>
            <label class="block text-sm font-semibold text-slate-700 mb-2">
                Email address
            </label>
            <input
                type="email"
                name="email"
                value="{{ old('email') }}"
                required
                class="w-full rounded-xl border border-slate-300
                       px-4 py-3 focus:ring-2 focus:ring-[#1E3A6D]/30
                       focus:border-[#1E3A6D]"
            />
        </div>

        <div>
            <label class="block text-sm font-semibold text-slate-700 mb-2">
                Register as
            </label>
            <select
                name="role"
                class="w-full rounded-xl border border-slate-300
                       px-4 py-3 focus:ring-2 focus:ring-[#1E3A6D]/30
                       focus:border-[#1E3A6D]"
            >
                <option value="candidate">Job Seeker</option>
                <option value="employer">Employer</option>
            </select>
        </div>

        <div>
            <label class="block text-sm font-semibold text-slate-700 mb-2">
                Password
            </label>
            <input
                type="password"
                name="password"
                required
                class="w-full rounded-xl border border-slate-300
                       px-4 py-3 focus:ring-2 focus:ring-[#1E3A6D]/30
                       focus:border-[#1E3A6D]"
            />
        </div>

        <div>
            <label class="block text-sm font-semibold text-slate-700 mb-2">
                Confirm password
            </label>
            <input
                type="password"
                name="password_confirmation"
                required
                class="w-full rounded-xl border border-slate-300
                       px-4 py-3 focus:ring-2 focus:ring-[#1E3A6D]/30
                       focus:border-[#1E3A6D]"
            />
        </div>

        <button
            type="submit"
            class="w-full bg-[#1E3A6D] text-white py-3 rounded-xl
                   font-semibold hover:bg-[#162d57] transition"
        >
            Create Account
        </button>

        <div class="flex items-center gap-4 my-6">
            <div class="flex-1 h-px bg-slate-200"></div>
            <span class="text-xs text-slate-400 font-semibold">OR</span>
            <div class="flex-1 h-px bg-slate-200"></div>
        </div>

        <p class="text-center text-sm text-slate-600">
            Already have an account?
            <a href="{{ route('login') }}" class="text-green-600 font-semibold">
                Sign in
            </a>
        </p>
    </form>

</x-guest-layout>
