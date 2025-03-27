<?php

namespace App\Providers;

use App\Services\JobFilterService;
use App\Services\JobService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(JobService::class, function () {
            return new JobService();
        });

        $this->app->bind(JobFilterService::class, function () {
            return new JobFilterService();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {

    }
}
