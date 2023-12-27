<?php

namespace Application\Home;

use Illuminate\Support\ServiceProvider;

class HomeProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->loadRoutesFrom(__DIR__ . '/UI/Routes/routes.php');
        $this->loadViewsFrom(__DIR__ . '/UI/Views', 'home');
    }
}
