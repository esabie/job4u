@extends('layouts.auth')

@section('title', 'Sign In | Job4U')

@section('content')
<div class="min-h-screen bg-[#eef7f2]">
    <div class="mx-auto flex min-h-screen max-w-6xl flex-col lg:flex-row lg:items-center gap-10 lg:gap-16 px-5 sm:px-8 py-10 lg:py-16">

        {{-- Left marketing column --}}
        <div class="lg:w-[42%] lg:pr-4">
            <a href="{{ url('/') }}" class="flex justify-center lg:justify-start">
                <img
                    src="{{ asset('images/logo.jpg') }}"
                    alt="Job4U"
                    class="h-20 sm:h-24 lg:h-28 w-auto object-contain rounded-xl bg-white p-2"
                >
            </a>

            <h1 class="mt-10 sm:mt-14 text-3xl sm:text-4xl xl:text-5xl font-extrabold leading-tight tracking-tight text-[#1E3A6D]">
                Welcome back to
                <span class="text-[#55B84D]">opportunity.</span>
            </h1>

            <p class="mt-5 text-base text-slate-600 leading-relaxed max-w-md">
                Sign in to continue applying for roles, managing applications,
                and connecting with employers on Job4U.
            </p>

            <div class="mt-10 sm:mt-14 flex items-stretch gap-0 divide-x divide-slate-300">
                <div class="pr-6 sm:pr-8">
                    <p class="text-2xl sm:text-3xl font-extrabold text-[#1E3A6D]">Fast apply</p>
                    <p class="mt-1 text-[11px] font-semibold uppercase tracking-wider text-slate-500">
                        With saved CVs
                    </p>
                </div>
                <div class="pl-6 sm:pl-8">
                    <p class="text-2xl sm:text-3xl font-extrabold text-[#1E3A6D]">Verified</p>
                    <p class="mt-1 text-[11px] font-semibold uppercase tracking-wider text-slate-500">
                        Trusted hiring
                    </p>
                </div>
            </div>
        </div>

        {{-- Right form card --}}
        <div class="lg:w-[58%] w-full">
            <div class="relative rounded-2xl border border-slate-200 bg-white shadow-xl shadow-slate-200/60 overflow-hidden">
                <div class="absolute inset-x-0 top-0 h-1 bg-[#1E3A6D]"></div>
                <div class="pointer-events-none absolute -right-16 -top-16 h-40 w-40 rounded-full bg-[#55B84D]/15 blur-2xl"></div>
                <div class="pointer-events-none absolute -right-10 -bottom-16 h-40 w-40 rounded-full bg-[#1E3A6D]/10 blur-2xl"></div>

                <div class="relative p-6 sm:p-8 md:p-10">
                    <div class="mb-7">
                        <h2 class="text-2xl sm:text-3xl font-extrabold text-[#1E3A6D] tracking-tight">
                            Sign in
                        </h2>
                        <p class="mt-2 text-sm text-slate-500">
                            New to Job4U?
                            <a href="{{ route('register', request()->only('redirect')) }}"
                               class="font-semibold text-[#55B84D] hover:text-[#44963d]">
                                Create an account
                            </a>
                        </p>
                        <p class="mt-3 text-sm text-slate-500">
                            After you sign in with your password, we’ll email a one-time code to verify it’s you.
                        </p>
                    </div>

                    @if (session('status'))
                        <div class="mb-5 rounded-xl border border-green-200 bg-green-50 px-4 py-3 text-sm font-semibold text-green-700">
                            {{ session('status') }}
                        </div>
                    @endif

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
                          action="{{ route('login') }}"
                          data-loader-message="Signing you in..."
                          class="space-y-4"
                          x-data="{ showPassword: false }">
                        @csrf

                        @php
                            $redirectTo = request('redirect', session('url.intended'));
                        @endphp
                        @if (is_string($redirectTo) && $redirectTo !== '')
                            <input type="hidden" name="redirect" value="{{ $redirectTo }}">
                        @endif

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
                                autofocus
                                autocomplete="username"
                                placeholder="name@company.com"
                                class="w-full rounded-lg border border-slate-200 bg-white px-4 py-3 text-sm
                                       placeholder:text-slate-400
                                       focus:border-[#1E3A6D] focus:ring-2 focus:ring-[#1E3A6D]/20 outline-none transition"
                            >
                        </div>

                        <div>
                            <div class="flex items-center justify-between mb-1.5">
                                <label for="password" class="block text-sm font-semibold text-slate-700">
                                    Password
                                </label>
                                <div class="flex items-center gap-3">
                                    @if (Route::has('password.request'))
                                        <a href="{{ route('password.request') }}"
                                           class="text-sm font-semibold text-[#55B84D] hover:text-[#44963d]">
                                            Forgot password?
                                        </a>
                                    @endif
                                    <button type="button"
                                            class="text-sm font-semibold text-[#1E3A6D] hover:text-blue-800"
                                            @click="showPassword = !showPassword"
                                            x-text="showPassword ? 'Hide' : 'Show'">
                                        Show
                                    </button>
                                </div>
                            </div>
                            <input
                                id="password"
                                :type="showPassword ? 'text' : 'password'"
                                name="password"
                                required
                                autocomplete="current-password"
                                placeholder="••••••••"
                                class="w-full rounded-lg border border-slate-200 bg-white px-4 py-3 text-sm
                                       placeholder:text-slate-400
                                       focus:border-[#1E3A6D] focus:ring-2 focus:ring-[#1E3A6D]/20 outline-none transition"
                            >
                        </div>

                        <label class="flex items-center gap-3 text-sm text-slate-600 pt-1">
                            <input
                                type="checkbox"
                                name="remember"
                                value="1"
                                class="rounded border-slate-300 text-[#1E3A6D] focus:ring-[#1E3A6D]"
                            >
                            <span>Remember me</span>
                        </label>

                        <button
                            type="submit"
                            data-loading-text="Signing in..."
                            class="inline-flex w-full items-center justify-center gap-2 rounded-lg
                                   bg-[#1E3A6D] px-6 py-3.5 text-sm font-bold text-white
                                   hover:bg-blue-800 transition shadow-sm mt-2
                                   disabled:cursor-wait disabled:opacity-80">
                            Sign In to Job4U
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
