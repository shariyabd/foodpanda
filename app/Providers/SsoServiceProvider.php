<?php

namespace App\Providers;

use App\Services\SsoService;
use Illuminate\Support\ServiceProvider;

class SsoServiceProvider extends ServiceProvider
{
    

    public function register(): void
    {
        $this->app->singleton(SsoService::class, function () {
            return new SsoService();
        });
    }

    

    public function boot(): void
    {
        
    }
}