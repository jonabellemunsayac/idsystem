<?php

namespace App\Providers;

use App\Models\BlotterRecord;
use App\Models\Asset;
use App\Models\Resident;
use App\Observers\AuditableModelObserver;
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
        // Register observers to track model changes
        BlotterRecord::observe(AuditableModelObserver::class);
        Asset::observe(AuditableModelObserver::class);
        Resident::observe(AuditableModelObserver::class);
    }
}
