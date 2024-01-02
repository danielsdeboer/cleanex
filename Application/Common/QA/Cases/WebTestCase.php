<?php

namespace Application\Common\QA\Cases;

use Application\Common\QA\Support\Html\HtmlAssert;
use Application\Common\UI\NameProviderInterface;
use Application\Common\UI\Routing\UrlFactory;
use Closure;
use Illuminate\Contracts\Console\Kernel as ConsoleKernelInterface;
use Illuminate\Contracts\Routing\UrlGenerator;
use Illuminate\Contracts\Session\Session;
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

		TestResponse::macro(
			'assertHtml',
			function (Closure $assertions): TestResponse {
				/** @var TestResponse $this */
				$assertions(HtmlAssert::fromResponse($this));

				return $this;
			},
		);

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

	protected function getUrlFactory(): UrlFactory
	{
		/** @var UrlFactory $factory */
		$factory = $this->app->make(UrlFactory::class);

		return $factory;
	}

	protected function getSession(): Session
	{
		/** @var Session $session */
		$session = $this->app->make(Session::class);

		return $session;
	}

	protected function addToSessionOldInput(string $key, string $value): void
	{
		$this->getSession()->put(sprintf('_old_input.%s', $key), $value);
	}

	/**
	 * @param array<string, mixed> $routeParams
	 * @param array<string, mixed> $requestData
	 */
	protected function callNamedRoute(
		NameProviderInterface $route,
		array $routeParams = [],
		array $requestData = [],
		string $requestMethod = 'GET'
	): TestResponse
	{
		$url = $this->app->make(UrlGenerator::class)->route(
			$route->name(),
			$routeParams,
		);

		return $this->call($requestMethod, $url, $requestData);
	}
}
