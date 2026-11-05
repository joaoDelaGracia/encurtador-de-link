<?php

namespace App\Providers;

use App\Repositories\Contracts\AnalyticRepositoryInterface;
use App\Repositories\Eloquent\AnalyticRepository;
use Illuminate\Support\ServiceProvider;

class AnalyticRepositoryProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(AnalyticRepositoryInterface::class, AnalyticRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
