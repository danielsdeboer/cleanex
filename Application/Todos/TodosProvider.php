<?php

namespace Application\Todos;

use Application\Todos\Core\Interfaces\BucketRepoInterface;
use Application\Todos\IO\BucketRepo;
use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;

class TodosProvider extends ServiceProvider
{
	public function register(): void
	{
		$this->app->bind(BucketRepoInterface::class, BucketRepo::class);
	}

	public function boot(Router $router): void
    {
		$router
			->middleware(['web', 'auth'])
			->group(function () {
				$this->loadRoutesFrom(__DIR__ . '/UI/Routes/routes.php');
			});

        $this->loadViewsFrom(__DIR__ . '/UI/Views', 'todos');
    }
}
