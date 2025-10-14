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
        // Register view composers
        view()->composer('*', \App\View\Composers\SettingsComposer::class);
        view()->composer('partials.importer-sidebar', \App\View\Composers\ImporterSidebarComposer::class);
    }
}
