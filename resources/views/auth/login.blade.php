@extends('layouts.public')

<section
    class="min-h-screen flex items-center justify-center px-6
           bg-gradient-to-br from-[#1E3A6D]/10 via-[#55B84D]/10 to-slate-100">

    <!-- Animated wrapper -->
    <div class="w-full max-w-md animate-fade-in-up">

        <!-- Card -->
        <div
            class="bg-white/90 backdrop-blur
                   rounded-3xl shadow-xl
                   p-8 border border-slate-200
                   hover:-translate-y-1 hover:shadow-2xl
                   transition-all duration-300">

            <!-- Logo -->
            <div class="flex justify-center mb-8">
                <img
                    src="{{ asset('images/logo.jpg') }}"
                    alt="Job4U"
                    class="h-20 w-auto"
                />
            </div>

            <!-- Session Status -->
            <x-auth-session-status class="my-4" :status="session('status')" />

            <!-- Form -->
            <form method="POST" action="{{ route('login') }}" class="mt-8 space-y-5">
                @csrf

                <!-- Email -->
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1">
                        Email address
                    </label>
                    <input
                        type="email"
                        name="email"
                        value="{{ old('email') }}"
                        required
                        autofocus
                        class="w-full px-4 py-3 rounded-xl
                               border border-slate-300
                               focus:ring-2 focus:ring-[#1E3A6D]
                               focus:border-[#1E3A6D]
                               transition"
                    />
                    <x-input-error :messages="$errors->get('email')" class="mt-1" />
                </div>

                <!-- Password -->
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1">
                        Password
                    </label>
                    <input
                        type="password"
                        name="password"
                        required
                        class="w-full px-4 py-3 rounded-xl
                               border border-slate-300
                               focus:ring-2 focus:ring-[#1E3A6D]
                               focus:border-[#1E3A6D]
                               transition"
                    />
                    <x-input-error :messages="$errors->get('password')" class="mt-1" />
                </div>

                <!-- Remember + Forgot -->
                <div class="flex items-center justify-between text-sm">
                    <label class="flex items-center gap-2 text-slate-600">
                        <input
                            type="checkbox"
                            name="remember"
                            class="rounded border-slate-300
                                   text-[#1E3A6D] focus:ring-[#1E3A6D]">
                        Remember me
                    </label>

                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}"
                           class="text-[#1E3A6D] font-semibold hover:underline">
                            Forgot password?
                        </a>
                    @endif
                </div>

                <!-- Submit -->
                <button
                    type="submit"
                    class="w-full mt-4 px-6 py-3 rounded-xl
                           bg-[#1E3A6D] text-white font-semibold
                           hover:bg-[#162E56] hover:-translate-y-0.5
                           transition-all duration-200
                           shadow-md hover:shadow-lg">
                    Sign In
                </button>
            </form>

            <!-- Divider -->
            <div class="flex items-center gap-4 my-6">
                <div class="flex-1 h-px bg-slate-200"></div>
                <span class="text-xs text-slate-500">OR</span>
                <div class="flex-1 h-px bg-slate-200"></div>
            </div>

            <!-- Register -->
            <p class="text-center text-sm text-slate-600">
                Don’t have an account?
                <a href="{{ route('register') }}"
                   class="text-[#55B84D] font-semibold hover:underline">
                    Create one
                </a>
            </p>

        </div>
    </div>

</section>
