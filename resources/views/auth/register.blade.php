<x-guest-layout>

    <div class="flex justify-center mb-8">
        <img
            src="{{ asset('images/logo.jpg') }}"
            alt="Job4U"
            class="h-14"
        />
    </div>

    @if ($errors->any())
        <div class="mb-5 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
            <p class="font-semibold">Please fix the following:</p>
            <ul class="mt-2 list-disc space-y-1 pl-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('register') }}" data-loader-message="Creating your account..." class="space-y-5">
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
            <x-input-error :messages="$errors->get('name')" class="mt-1" />
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
            <x-input-error :messages="$errors->get('email')" class="mt-1" />
        </div>

        <div>
            <label class="block text-sm font-semibold text-slate-700 mb-2">
                Register as
            </label>
            <select
                name="role"
                required
                class="w-full rounded-xl border border-slate-300
                       px-4 py-3 focus:ring-2 focus:ring-[#1E3A6D]/30
                       focus:border-[#1E3A6D]"
            >
                <option value="candidate" @selected(old('role', 'candidate') === 'candidate')>Job Seeker</option>
                <option value="employer" @selected(old('role') === 'employer')>Employer</option>
            </select>
            <x-input-error :messages="$errors->get('role')" class="mt-1" />
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
            <x-input-error :messages="$errors->get('password')" class="mt-1" />
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
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1" />
        </div>

        <button
            type="submit"
            data-loading-text="Creating account..."
            class="inline-flex w-full items-center justify-center gap-2 bg-[#1E3A6D] text-white py-3 rounded-xl
                   font-semibold hover:bg-[#162d57] transition disabled:cursor-wait disabled:opacity-80"
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
