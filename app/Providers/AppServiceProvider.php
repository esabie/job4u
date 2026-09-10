<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if (app()->environment('production')) {
            URL::forceScheme('https');
        }

        // Cookie sessions bloat the Cookie request header and commonly cause HTTP 431.
        if (config('session.driver') === 'cookie') {
            Log::warning(
                'SESSION_DRIVER=cookie is unsafe for this app; use database or redis to avoid HTTP 431.'
            );
        }

        DB::prohibitDestructiveCommands(
            ! app()->environment('testing')
            && ! config('database.allow_destructive_commands', false)
        );

        Gate::define('isEmployer', fn ($user) => $user->role === 'employer');
        Gate::define('isCandidate', fn ($user) => $user->isCandidate());
        Gate::define('isAdmin', fn ($user) => $user->isAdmin());

        // Match the login form copy ("Remember me for 30 days").
        Auth::guard('web')->setRememberDuration(60 * 24 * 30);

        $this->configureRateLimiting();
    }

    /**
     * Configure named rate limiters used by route middleware.
     */
    private function configureRateLimiting(): void
    {
        // Broad protection against scanners and abusive traffic.
        RateLimiter::for('global', function (Request $request) {
            return Limit::perMinute(120)->by($request->ip());
        });

        RateLimiter::for('login', function (Request $request) {
            $email = Str::lower((string) $request->input('email', ''));

            return Limit::perMinute(5)->by($email.'|'.$request->ip());
        });

        RateLimiter::for('register', function (Request $request) {
            return Limit::perMinute(5)->by($request->ip());
        });

        RateLimiter::for('password-reset', function (Request $request) {
            $email = Str::lower((string) $request->input('email', ''));

            return [
                Limit::perMinute(3)->by($request->ip()),
                Limit::perMinute(3)->by($email.'|'.$request->ip()),
            ];
        });

        RateLimiter::for('applications', function (Request $request) {
            $key = $request->user()?->id ?: $request->ip();

            return Limit::perMinute(10)->by('apply|'.$key);
        });

        RateLimiter::for('two-factor', function (Request $request) {
            $key = $request->user()?->id
                ?: $request->session()->get('login.id', 'guest');

            return Limit::perMinute(5)->by($key.'|'.$request->ip());
        });

        RateLimiter::for('two-factor-resend', function (Request $request) {
            $key = $request->user()?->id
                ?: $request->session()->get('login.id', 'guest');

            return Limit::perMinute(1)->by('resend|'.$key.'|'.$request->ip());
        });
    }
}
