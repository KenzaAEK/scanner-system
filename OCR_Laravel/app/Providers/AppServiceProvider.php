<?php

namespace App\Providers;

use App\Services\FileService;
use App\Services\OCRApiService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
        $this->app->singleton(FileService::class, function ($app) {
            return new FileService();
        });

        $this->app->singleton(OCRApiService::class, function ($app) {
            return new OCRApiService();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
