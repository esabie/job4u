@extends('layouts.auth')

@section('title', 'Verify Sign In | Job4U')

@section('content')
<div class="min-h-screen bg-[#eef7f2]">
    <div class="mx-auto flex min-h-screen max-w-6xl flex-col lg:flex-row lg:items-center gap-10 lg:gap-16 px-5 sm:px-8 py-10 lg:py-16">

        <div class="lg:w-[42%] lg:pr-4">
            <a href="{{ url('/') }}" class="flex justify-center lg:justify-start">
                <img
                    src="{{ asset('images/logo.jpg') }}"
                    alt="Job4U"
                    class="h-20 sm:h-24 lg:h-28 w-auto object-contain rounded-xl bg-white p-2"
                >
            </a>

            <h1 class="mt-10 sm:mt-14 text-3xl sm:text-4xl xl:text-5xl font-extrabold leading-tight tracking-tight text-[#1E3A6D]">
                Confirm it’s
                <span class="text-[#55B84D]">really you.</span>
            </h1>

            <p class="mt-5 text-base text-slate-600 leading-relaxed max-w-md">
                We emailed a 6-digit verification code to your account address.
                Enter it below to finish signing in.
            </p>
        </div>

        <div class="lg:w-[58%] w-full">
            <div class="relative rounded-2xl border border-slate-200 bg-white shadow-xl shadow-slate-200/60 overflow-hidden">
                <div class="absolute inset-x-0 top-0 h-1 bg-[#1E3A6D]"></div>
                <div class="pointer-events-none absolute -right-16 -top-16 h-40 w-40 rounded-full bg-[#55B84D]/15 blur-2xl"></div>
                <div class="pointer-events-none absolute -right-10 -bottom-16 h-40 w-40 rounded-full bg-[#1E3A6D]/10 blur-2xl"></div>

                <div class="relative p-6 sm:p-8 md:p-10">
                    <a href="{{ route('login') }}"
                       class="inline-flex items-center gap-1.5 text-sm font-semibold text-slate-500 hover:text-[#1E3A6D] mb-6">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
                        </svg>
                        Back to sign in
                    </a>

                    <div class="mb-7">
                        <h2 class="text-2xl sm:text-3xl font-extrabold text-[#1E3A6D] tracking-tight">
                            Enter verification code
                        </h2>
                        <p class="mt-2 text-sm text-slate-500">
                            The code expires in {{ \App\Models\User::TWO_FACTOR_CODE_TTL_MINUTES }} minutes.
                            Check spam if you do not see the email.
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
                          action="{{ route('login.verify.store') }}"
                          data-loader-message="Verifying code..."
                          class="space-y-4">
                        @csrf

                        <div>
                            <label for="code" class="block text-sm font-semibold text-slate-700 mb-1.5">
                                Verification code
                            </label>
                            <input
                                id="code"
                                type="text"
                                name="code"
                                value="{{ old('code') }}"
                                required
                                autofocus
                                inputmode="numeric"
                                autocomplete="one-time-code"
                                maxlength="6"
                                pattern="[0-9]{6}"
                                placeholder="------"
                                class="w-full rounded-lg border border-slate-200 bg-white px-4 py-3 text-center text-2xl font-extrabold tracking-[0.35em] text-[#1E3A6D]
                                       placeholder:text-slate-300 placeholder:tracking-[0.35em] placeholder:font-extrabold
                                       focus:border-[#1E3A6D] focus:ring-2 focus:ring-[#1E3A6D]/20 outline-none transition"
                            >
                        </div>

                        <button
                            type="submit"
                            data-loading-text="Verifying..."
                            class="inline-flex w-full items-center justify-center gap-2 rounded-lg
                                   bg-[#1E3A6D] px-6 py-3.5 text-sm font-bold text-white
                                   hover:bg-blue-800 transition shadow-sm mt-2
                                   disabled:cursor-wait disabled:opacity-80">
                            Verify and continue
                        </button>
                    </form>

                    <form method="POST"
                          action="{{ route('login.verify.resend') }}"
                          data-loader-message="Sending a new code..."
                          class="mt-4">
                        @csrf
                        <button type="submit"
                                class="w-full text-sm font-semibold text-[#55B84D] hover:text-[#44963d]">
                            Resend code
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
