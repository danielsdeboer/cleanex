<?php

namespace Application\Home\Web;

use Illuminate\Support\ServiceProvider;

class HomeProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->loadRoutesFrom(__DIR__ . '/Routes/routes.php');
        $this->loadViewsFrom(__DIR__ . '/Views', 'home');
    }

}
