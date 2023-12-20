<?php

namespace Framework\Providers;

use Application\Home\Web\HomeProvider;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    /** @var string */
    public const HOME = '/';

    public function register(): void
    {
        $this->app->register(HomeProvider::class);
    }
}
