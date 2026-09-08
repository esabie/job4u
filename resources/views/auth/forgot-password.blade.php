@extends('layouts.auth')

@section('title', 'Forgot Password | Job4U')

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

    .auth-brand-logo {
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

    .auth-steps {
        display: grid;
        gap: 0.85rem;
        max-width: 28rem;
    }

    .auth-step {
        display: flex;
        align-items: flex-start;
        gap: 0.85rem;
        border: 1px solid rgba(255, 255, 255, 0.12);
        background: rgba(255, 255, 255, 0.05);
        backdrop-filter: blur(8px);
        border-radius: 1rem;
        padding: 0.95rem 1.05rem;
    }

    .auth-step-num {
        width: 1.75rem;
        height: 1.75rem;
        border-radius: 9999px;
        background: rgba(85, 184, 77, 0.2);
        color: #55b84d;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 0.75rem;
        font-weight: 800;
        flex-shrink: 0;
    }

    .auth-step strong {
        display: block;
        font-size: 0.92rem;
    }

    .auth-step span {
        display: block;
        margin-top: 0.2rem;
        font-size: 0.82rem;
        line-height: 1.45;
        color: #94a3b8;
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

    .auth-back {
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
        margin-bottom: 1.75rem;
        color: #64748b;
        font-size: 0.9rem;
        font-weight: 600;
        text-decoration: none;
    }

    .auth-back:hover {
        color: #1e3a6d;
    }

    .auth-back svg {
        width: 1rem;
        height: 1rem;
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
        line-height: 1.55;
    }

    .auth-status {
        margin-top: 1.25rem;
        border: 1px solid #bbf7d0;
        background: #f0fdf4;
        color: #166534;
        border-radius: 0.85rem;
        padding: 0.9rem 1rem;
        font-size: 0.9rem;
        line-height: 1.5;
        font-weight: 600;
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
        padding: 0.85rem 1rem 0.85rem 2.7rem;
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
                Regain access in
                <span>a few steps.</span>
            </h1>
            <p>
                Enter the email linked to your Job4U account and we will send a secure reset link
                so you can get back to your opportunities.
            </p>
        </div>

        <div class="auth-steps">
            <div class="auth-step">
                <span class="auth-step-num">1</span>
                <div>
                    <strong>Confirm your email</strong>
                    <span>Use the address associated with your account.</span>
                </div>
            </div>
            <div class="auth-step">
                <span class="auth-step-num">2</span>
                <div>
                    <strong>Open the reset link</strong>
                    <span>Check your inbox for a message from Job4U.</span>
                </div>
            </div>
            <div class="auth-step">
                <span class="auth-step-num">3</span>
                <div>
                    <strong>Choose a new password</strong>
                    <span>Set a strong password and sign back in.</span>
                </div>
            </div>
        </div>
    </aside>

    <section class="auth-form-panel">
        <div class="auth-form-panel-inner">
            <a href="{{ url('/') }}" class="auth-brand-logo auth-mobile-logo">
                <span class="auth-brand-mark">
                    <img src="{{ asset('images/icon.png') }}" alt="">
                </span>
                <span>Job4U</span>
            </a>

            <a href="{{ route('login') }}" class="auth-back">
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
                </svg>
                Back to sign in
            </a>

            <div class="auth-form-heading">
                <h2>Forgot password?</h2>
                <p>
                    No problem. Enter your email and we will send you a link to reset it.
                </p>
            </div>

            @if (session('status'))
                <div class="auth-status" role="status">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST"
                  action="{{ route('password.email') }}"
                  data-loader-message="Sending reset link..."
                  class="auth-form">
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
                        >
                    </div>
                    @error('email')
                        <p class="auth-error">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit" class="auth-submit" data-loading-text="Sending...">
                    Email Reset Link
                </button>
            </form>

            <p class="auth-switch">
                Remembered your password?
                <a href="{{ route('login') }}">Sign in</a>
            </p>
        </div>
    </section>
</div>
@endsection
