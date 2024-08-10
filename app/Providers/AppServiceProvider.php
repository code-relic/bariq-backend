<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;

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
        if (in_array(request()->getHost(), ['localhost', '127.0.0.1'])) {
            URL::forceScheme('http');
        } else {
            URL::forceScheme('https');
        }
    }
}
