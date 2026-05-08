<?php

namespace App\Providers;

use App\Services\OmdbService;
use Illuminate\Support\ServiceProvider;

class OmdbServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(OmdbService::class, function () {
            return new OmdbService();
        });
    }

    public function boot(): void
    {
        //
    }
}
