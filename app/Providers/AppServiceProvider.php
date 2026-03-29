<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

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
        // Register settings helper
        require_once app_path('Helpers/SettingsHelper.php');

        // Register Policies
        \Illuminate\Support\Facades\Gate::policy(\App\Models\ClientRequest::class, \App\Policies\ClientRequestPolicy::class);

        // Observers eliminados del starter kit (Tasks, etc)
    }
}
