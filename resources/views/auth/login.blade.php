@extends('layouts.auth')

@section('title', 'Sign In | Job4U')

@section('content')
<style>
    .auth-shell {
        min-height: 100vh;
        display: grid;
        grid-template-columns: 1.15fr 0.85fr;
        font-family: 'Plus Jakarta Sans', ui-sans-serif, system-ui, sans-serif;
        color: #0f172a;
        background: #fff;
    }

    .auth-brand {
        position: relative;
        overflow: hidden;
        background: #0b1220;
        color: #fff;
        padding: 3rem 3.5rem;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }

    .auth-brand::before {
        content: '';
        position: absolute;
        inset: 0;
        background:
            radial-gradient(circle at 18% 20%, rgba(85, 184, 77, 0.18), transparent 36%),
            radial-gradient(circle at 85% 75%, rgba(30, 58, 109, 0.35), transparent 42%);
        pointer-events: none;
    }

    .auth-brand::after {
        content: '';
        position: absolute;
        width: 28rem;
        height: 28rem;
        border: 1px solid rgba(255, 255, 255, 0.08);
        border-radius: 9999px;
        right: -8rem;
        top: -6rem;
        pointer-events: none;
    }

    .auth-brand > * {
        position: relative;
        z-index: 1;
    }

    .auth-brand-logo,
    .auth-form-logo {
        display: inline-flex;
        align-items: center;
        gap: 0.75rem;
        text-decoration: none;
        color: inherit;
        font-weight: 800;
        font-size: 1.05rem;
    }

    .auth-brand-mark {
        width: 2.5rem;
        height: 2.5rem;
        border-radius: 0.65rem;
        background: #fff;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
    }

    .auth-brand-mark img {
        width: 1.6rem;
        height: 1.6rem;
        object-fit: contain;
    }

    .auth-brand-copy {
        max-width: 34rem;
    }

    .auth-brand-copy h1 {
        margin: 0;
        font-size: clamp(2.2rem, 3.4vw, 3.2rem);
        line-height: 1.12;
        font-weight: 800;
        letter-spacing: -0.03em;
    }

    .auth-brand-copy h1 span {
        color: #55b84d;
    }

    .auth-brand-copy p {
        margin: 1.25rem 0 0;
        max-width: 30rem;
        color: #cbd5e1;
        font-size: 1.05rem;
        line-height: 1.65;
    }

    .auth-quote {
        max-width: 30rem;
        border: 1px solid rgba(255, 255, 255, 0.12);
        border-left: 4px solid #55b84d;
        background: rgba(255, 255, 255, 0.05);
        backdrop-filter: blur(8px);
        border-radius: 1rem;
        padding: 1.35rem 1.4rem;
    }

    .auth-quote-person {
        display: flex;
        align-items: center;
        gap: 0.85rem;
        margin-bottom: 0.9rem;
    }

    .auth-quote-avatar {
        width: 2.75rem;
        height: 2.75rem;
        border-radius: 9999px;
        background: rgba(85, 184, 77, 0.2);
        color: #55b84d;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 0.8rem;
        font-weight: 800;
    }

    .auth-quote-person strong {
        display: block;
        font-size: 0.95rem;
    }

    .auth-quote-person span {
        display: block;
        margin-top: 0.15rem;
        font-size: 0.7rem;
        letter-spacing: 0.08em;
        text-transform: uppercase;
        color: #94a3b8;
    }

    .auth-quote p {
        margin: 0;
        color: #e2e8f0;
        font-size: 0.95rem;
        line-height: 1.6;
    }

    .auth-form-panel {
        display: flex;
        flex-direction: column;
        padding: 2rem 2.5rem 1.5rem;
        background: #fff;
    }

    .auth-form-panel-inner {
        flex: 1;
        width: 100%;
        max-width: 26rem;
        margin: 0 auto;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }

    .auth-mobile-logo {
        display: none;
        margin-bottom: 2rem;
    }

    .auth-form-heading h2 {
        margin: 0;
        font-size: 2rem;
        font-weight: 800;
        letter-spacing: -0.03em;
        color: #0b1220;
    }

    .auth-form-heading p {
        margin: 0.65rem 0 0;
        color: #64748b;
        font-size: 0.95rem;
    }

    .auth-form {
        margin-top: 2rem;
        display: grid;
        gap: 1.15rem;
    }

    .auth-label {
        display: block;
        margin-bottom: 0.45rem;
        font-size: 0.9rem;
        font-weight: 600;
        color: #0f172a;
    }

    .auth-label-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 0.45rem;
    }

    .auth-label-row .auth-label {
        margin-bottom: 0;
    }

    .auth-forgot {
        color: #55b84d;
        font-size: 0.9rem;
        font-weight: 600;
        text-decoration: none;
    }

    .auth-forgot:hover {
        color: #44963d;
    }

    .auth-input-wrap {
        position: relative;
    }

    .auth-input-wrap > svg:first-child {
        position: absolute;
        left: 0.9rem;
        top: 50%;
        transform: translateY(-50%);
        width: 1.05rem;
        height: 1.05rem;
        color: #94a3b8;
        pointer-events: none;
    }

    .auth-input {
        width: 100%;
        box-sizing: border-box;
        border: 1px solid #e2e8f0;
        border-radius: 0.7rem;
        padding: 0.85rem 2.75rem 0.85rem 2.7rem;
        font-size: 0.95rem;
        color: #0f172a;
        background: #fff;
        outline: none;
    }

    .auth-input::placeholder {
        color: #94a3b8;
    }

    .auth-input:focus {
        border-color: #1e3a6d;
        box-shadow: 0 0 0 3px rgba(30, 58, 109, 0.12);
    }

    .auth-eye {
        position: absolute;
        right: 0.75rem;
        top: 50%;
        transform: translateY(-50%);
        border: 0;
        background: transparent;
        color: #94a3b8;
        cursor: pointer;
        padding: 0.25rem;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }

    .auth-eye:hover {
        color: #64748b;
    }

    .auth-remember {
        display: flex;
        align-items: center;
        gap: 0.6rem;
        color: #64748b;
        font-size: 0.9rem;
    }

    .auth-remember input {
        width: 1rem;
        height: 1rem;
        accent-color: #55b84d;
    }

    .auth-submit {
        width: 100%;
        border: 0;
        border-radius: 0.7rem;
        background: #2f6b3a;
        color: #fff;
        font-size: 0.95rem;
        font-weight: 700;
        padding: 0.95rem 1.25rem;
        cursor: pointer;
    }

    .auth-submit:hover {
        background: #275c32;
    }

    .auth-switch {
        margin-top: 1.75rem;
        text-align: center;
        color: #64748b;
        font-size: 0.95rem;
    }

    .auth-switch a {
        color: #55b84d;
        font-weight: 700;
        text-decoration: none;
    }

    .auth-switch a:hover {
        color: #44963d;
    }

    .auth-meta {
        margin-top: 2rem;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 1rem;
        color: #94a3b8;
        font-size: 0.68rem;
        letter-spacing: 0.08em;
        text-transform: uppercase;
    }

    .auth-meta-links {
        display: flex;
        gap: 1rem;
    }

    .auth-meta-status {
        display: inline-flex;
        align-items: center;
        gap: 0.45rem;
    }

    .auth-meta-status i {
        width: 0.4rem;
        height: 0.4rem;
        border-radius: 9999px;
        background: #55b84d;
        display: inline-block;
    }

    .auth-error {
        margin-top: 0.4rem;
        color: #dc2626;
        font-size: 0.85rem;
    }

    @media (max-width: 1024px) {
        .auth-shell {
            grid-template-columns: 1fr;
        }

        .auth-brand {
            display: none;
        }

        .auth-mobile-logo {
            display: inline-flex;
            color: #0b1220;
        }

        .auth-form-panel {
            min-height: 100vh;
            padding: 1.5rem 1.25rem 1.25rem;
        }
    }
</style>

<div class="auth-shell">
    <aside class="auth-brand">
        <a href="{{ url('/') }}" class="auth-brand-logo">
            <span class="auth-brand-mark">
                <img src="{{ asset('images/icon.png') }}" alt="">
            </span>
            <span>Job4U</span>
        </a>

        <div class="auth-brand-copy">
            <h1>
                Precision tools for the
                <span>modern professional.</span>
            </h1>
            <p>
                Connect with high-stakes opportunities at the world's most innovative companies.
                Your next career milestone starts with a single click.
            </p>
        </div>

        <blockquote class="auth-quote">
            <div class="auth-quote-person">
                <div class="auth-quote-avatar">CA</div>
                <div>
                    <strong>Kevin Addae Poku</strong>
                    <span>Head of Engineering - TechFlow</span>
                </div>
            </div>
            <p>
                “Job4U isn't just a job board; it's a strategic partner. I found my current role
                within three weeks of using the service.”
            </p>
        </blockquote>
    </aside>

    <section class="auth-form-panel">
        <div class="auth-form-panel-inner">
            <a href="{{ url('/') }}" class="auth-brand-logo auth-mobile-logo">
                <span class="auth-brand-mark">
                    <img src="{{ asset('images/icon.png') }}" alt="">
                </span>
                <span>Job4U</span>
            </a>

            <div class="auth-form-heading">
                <h2>Welcome Back</h2>
                <p>Enter your credentials to access your professional dashboard.</p>
            </div>

            <x-auth-session-status class="mt-4" :status="session('status')" />

            <form method="POST"
                  action="{{ route('login') }}"
                  data-loader-message="Signing you in..."
                  class="auth-form"
                  x-data="{ show: false }">
                @csrf

                <div>
                    <label for="email" class="auth-label">Email Address</label>
                    <div class="auth-input-wrap">
                        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.9 5.3a2 2 0 002.2 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                        <input
                            id="email"
                            type="email"
                            name="email"
                            value="{{ old('email') }}"
                            required
                            autofocus
                            autocomplete="username"
                            placeholder="name@company.com"
                            class="auth-input"
                            style="padding-right: 1rem;"
                        >
                    </div>
                    @error('email')
                        <p class="auth-error">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <div class="auth-label-row">
                        <label for="password" class="auth-label">Password</label>
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="auth-forgot">Forgot password?</a>
                        @endif
                    </div>
                    <div class="auth-input-wrap">
                        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 10-8 0v4h8z"/>
                        </svg>
                        <input
                            id="password"
                            :type="show ? 'text' : 'password'"
                            name="password"
                            required
                            autocomplete="current-password"
                            class="auth-input"
                        >
                        <button type="button"
                                class="auth-eye"
                                @click="show = !show"
                                :aria-label="show ? 'Hide password' : 'Show password'">
                            <svg x-show="!show" width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.5 12S6 5.5 12 5.5 21.5 12 21.5 12 18 18.5 12 18.5 2.5 12 2.5 12z"/>
                            </svg>
                            <svg x-cloak x-show="show" width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 3l18 18M10.6 10.6A3 3 0 0012 15a3 3 0 002.4-1.2M9.9 5.7A10.4 10.4 0 0112 5.5C18 5.5 21.5 12 21.5 12a18.4 18.4 0 01-4.1 4.8M6.1 6.1A18.5 18.5 0 002.5 12S6 18.5 12 18.5c1.1 0 2.1-.2 3.1-.5"/>
                            </svg>
                        </button>
                    </div>
                    @error('password')
                        <p class="auth-error">{{ $message }}</p>
                    @enderror
                </div>

                <label class="auth-remember">
                    <input type="checkbox" name="remember">
                    Remember me for 30 days
                </label>

                <button type="submit" class="auth-submit" data-loading-text="Signing in...">
                    Sign In to Job4U
                </button>
            </form>

            <p class="auth-switch">
                New to the platform?
                <a href="{{ route('register') }}">Create an account</a>
            </p>

            <div class="auth-meta">
            </div>
        </div>
    </section>
</div>
@endsection
