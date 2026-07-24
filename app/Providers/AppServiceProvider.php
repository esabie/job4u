<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\DB;

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
        if (app()->environment('production')) {URL::forceScheme('https');}

        DB::prohibitDestructiveCommands(
            ! app()->environment('testing')
            && ! config('database.allow_destructive_commands', false)
        );

        Gate::define('isEmployer', fn ($user) => $user->role === 'employer');
    }
}
