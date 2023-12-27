<?php

namespace Application\Common\QA\Cases;

use Illuminate\Contracts\Console\Kernel as ConsoleKernelInterface;
use Illuminate\Contracts\Routing\UrlGenerator;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Testing\TestCase;
use Illuminate\Routing\RouteCollectionInterface;
use Illuminate\Routing\Router;
use Illuminate\Testing\TestResponse;

abstract class WebTestCase extends TestCase
{
	public function createApplication(): Application
	{
		$app = require __DIR__.'/../../../../Framework/bootstrap/app.php';

		$app->make(ConsoleKernelInterface::class)->bootstrap();

		return $app;
	}

	/**
	 * @template T of object
	 * @param class-string<T> $concretion
	 * @return T
	 */
	protected function bindAndResolve(
		string $abstraction,
		string $concretion,
	): object
	{
		$this->app->bind($abstraction, $concretion);

		/** @var T $concretion */
		$concretion = $this->app->make($abstraction);

		return $concretion;
	}

	protected function getRoutes(): RouteCollectionInterface
	{
		$routes = $this->app->make(Router::class)->getRoutes();
		$routes->refreshNameLookups();

		return $routes;
	}

	protected function callNamedRoute(
		string $routeName,
		array $routeParams = [],
		array $requestData = [],
		string $requestMethod = 'GET'
	): TestResponse
	{
		$url = $this->app->make(UrlGenerator::class)->route(
			$routeName,
			$routeParams,
		);

		return $this->call($requestMethod, $url, $requestData);
	}
}
