<?php

namespace App\System\Illuminate\Service\Providers;

use App\System\Illuminate\Locale;
use Illuminate\Support\ServiceProvider;

class LocaleServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(Locale::class, function ($app) {
            return new Locale($app);
        });
    }
}
