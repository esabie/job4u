@extends('layouts.auth')

@section('title', 'Create Account | Job4U')

@section('content')
<div class="min-h-screen bg-[#F4F6F8]">
    <div class="mx-auto flex min-h-screen max-w-6xl flex-col lg:flex-row lg:items-center gap-10 lg:gap-16 px-5 sm:px-8 py-10 lg:py-16">

        {{-- Left marketing column --}}
        <div class="lg:w-[42%] lg:pr-4">
            <a href="{{ url('/') }}" class="flex justify-center">
                <img
                    src="{{ asset('images/logo.jpg') }}"
                    alt="Job4U"
                    class="h-24 sm:h-28 lg:h-32 w-auto object-contain"
                    style="mix-blend-mode: multiply;"
                >
            </a>

            <h1 class="mt-10 sm:mt-14 text-3xl sm:text-4xl xl:text-5xl font-extrabold leading-tight tracking-tight text-[#0B1220]">
                The structural
                <span class="text-[#55B84D]">integrity</span>
                of your professional future with Job4U.
            </h1>

            <p class="mt-5 text-base text-slate-600 leading-relaxed max-w-md">
                Join Job4U, the connection between talent and opportunity.
                We provide the architecture; you build the career.
            </p>

            <div class="mt-10 sm:mt-14 flex items-stretch gap-0 divide-x divide-slate-300">
                <div class="pr-6 sm:pr-8">
                    <p class="text-2xl sm:text-3xl font-extrabold text-[#0B1220]">12k+</p>
                    <p class="mt-1 text-[11px] font-semibold uppercase tracking-wider text-slate-500">
                        Active Roles
                    </p>
                </div>
                <div class="pl-6 sm:pl-8">
                    <p class="text-2xl sm:text-3xl font-extrabold text-[#0B1220]">850k</p>
                    <p class="mt-1 text-[11px] font-semibold uppercase tracking-wider text-slate-500">
                        Professionals
                    </p>
                </div>
            </div>
        </div>

        {{-- Right form card --}}
        <div class="lg:w-[58%] w-full">
            <div class="relative rounded-2xl border border-slate-200 bg-white shadow-xl shadow-slate-200/60 overflow-hidden">
                <div class="absolute inset-x-0 top-0 h-1 bg-[#55B84D]"></div>
                <div class="pointer-events-none absolute -right-16 -top-16 h-40 w-40 rounded-full bg-[#55B84D]/10 blur-2xl"></div>
                <div class="pointer-events-none absolute -right-10 -bottom-16 h-40 w-40 rounded-full bg-[#55B84D]/10 blur-2xl"></div>

                <div class="relative p-6 sm:p-8 md:p-10">
                    <div class="mb-7">
                        <h2 class="text-2xl sm:text-3xl font-extrabold text-[#0B1220] tracking-tight">
                            Create Your Account
                        </h2>
                        <p class="mt-2 text-sm text-slate-500">
                            Already a member?
                            <a href="{{ route('login') }}" class="font-semibold text-[#55B84D] hover:text-[#44963d]">
                                Log in
                            </a>
                        </p>
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

                    <form method="POST"
                          action="{{ route('register') }}"
                          data-loader-message="Creating your account..."
                          class="space-y-4"
                          x-data="{ showPassword: false, showConfirm: false }">
                        @csrf

                        <div>
                            <label for="name" class="block text-sm font-semibold text-slate-700 mb-1.5">
                                Full Name
                            </label>
                            <input
                                id="name"
                                type="text"
                                name="name"
                                value="{{ old('name') }}"
                                required
                                autofocus
                                autocomplete="name"
                                placeholder="John Doe"
                                class="w-full rounded-lg border border-slate-200 bg-white px-4 py-3 text-sm
                                       placeholder:text-slate-400
                                       focus:border-[#55B84D] focus:ring-2 focus:ring-[#55B84D]/20 outline-none transition"
                            >
                        </div>

                        <div>
                            <label for="email" class="block text-sm font-semibold text-slate-700 mb-1.5">
                                Email Address
                            </label>
                            <input
                                id="email"
                                type="email"
                                name="email"
                                value="{{ old('email') }}"
                                required
                                autocomplete="username"
                                placeholder="name@company.com"
                                class="w-full rounded-lg border border-slate-200 bg-white px-4 py-3 text-sm
                                       placeholder:text-slate-400
                                       focus:border-[#55B84D] focus:ring-2 focus:ring-[#55B84D]/20 outline-none transition"
                            >
                        </div>

                        <div>
                            <label for="role" class="block text-sm font-semibold text-slate-700 mb-1.5">
                                Register as
                            </label>
                            <div class="grid grid-cols-2 gap-2 rounded-lg bg-slate-100 p-1">
                                <label class="cursor-pointer">
                                    <input type="radio" name="role" value="candidate" class="peer sr-only"
                                           @checked(old('role', 'candidate') === 'candidate')>
                                    <span class="flex items-center justify-center rounded-md px-3 py-2.5 text-sm font-semibold text-slate-600
                                                 peer-checked:bg-white peer-checked:text-[#0B1220] peer-checked:shadow-sm transition">
                                        Job Seeker
                                    </span>
                                </label>
                                <label class="cursor-pointer">
                                    <input type="radio" name="role" value="employer" class="peer sr-only"
                                           @checked(old('role') === 'employer')>
                                    <span class="flex items-center justify-center rounded-md px-3 py-2.5 text-sm font-semibold text-slate-600
                                                 peer-checked:bg-white peer-checked:text-[#0B1220] peer-checked:shadow-sm transition">
                                        Employer
                                    </span>
                                </label>
                            </div>
                        </div>

                        <div>
                            <div class="flex items-center justify-between mb-1.5">
                                <label for="password" class="block text-sm font-semibold text-slate-700">
                                    Password
                                </label>
                                <button type="button"
                                        class="text-sm font-semibold text-[#55B84D] hover:text-[#44963d]"
                                        @click="showPassword = !showPassword"
                                        x-text="showPassword ? 'Hide' : 'Show'">
                                    Show
                                </button>
                            </div>
                            <input
                                id="password"
                                :type="showPassword ? 'text' : 'password'"
                                name="password"
                                required
                                autocomplete="new-password"
                                placeholder="••••••••"
                                class="w-full rounded-lg border border-slate-200 bg-white px-4 py-3 text-sm
                                       placeholder:text-slate-400
                                       focus:border-[#55B84D] focus:ring-2 focus:ring-[#55B84D]/20 outline-none transition"
                            >
                            <p class="mt-1.5 text-xs text-slate-500">Must be at least 8 characters.</p>
                        </div>

                        <div>
                            <div class="flex items-center justify-between mb-1.5">
                                <label for="password_confirmation" class="block text-sm font-semibold text-slate-700">
                                    Confirm Password
                                </label>
                                <button type="button"
                                        class="text-sm font-semibold text-[#55B84D] hover:text-[#44963d]"
                                        @click="showConfirm = !showConfirm"
                                        x-text="showConfirm ? 'Hide' : 'Show'">
                                    Show
                                </button>
                            </div>
                            <input
                                id="password_confirmation"
                                :type="showConfirm ? 'text' : 'password'"
                                name="password_confirmation"
                                required
                                autocomplete="new-password"
                                placeholder="••••••••"
                                class="w-full rounded-lg border border-slate-200 bg-white px-4 py-3 text-sm
                                       placeholder:text-slate-400
                                       focus:border-[#55B84D] focus:ring-2 focus:ring-[#55B84D]/20 outline-none transition"
                            >
                        </div>

                        <label class="flex items-start gap-3 text-sm text-slate-600 pt-1">
                            <input
                                type="checkbox"
                                name="terms"
                                value="1"
                                required
                                @checked(old('terms'))
                                class="mt-0.5 rounded border-slate-300 text-[#55B84D] focus:ring-[#55B84D]"
                            >
                            <span>
                                I agree to the
                                <span class="font-semibold text-[#55B84D] underline underline-offset-2">Terms of Service</span>
                                and
                                <span class="font-semibold text-[#55B84D] underline underline-offset-2">Privacy Policy</span>.
                            </span>
                        </label>

                        <button
                            type="submit"
                            data-loading-text="Creating account..."
                            class="inline-flex w-full items-center justify-center gap-2 rounded-lg
                                   bg-[#55B84D] px-6 py-3.5 text-sm font-bold text-white
                                   hover:bg-[#44963d] transition shadow-sm mt-2
                                   disabled:cursor-wait disabled:opacity-80">
                            Create My Account
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
