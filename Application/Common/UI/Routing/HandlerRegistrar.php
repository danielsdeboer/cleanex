<?php

namespace Application\Common\UI\Routing;

use Application\Common\UI\NameProviderInterface;
use Illuminate\Routing\Route;
use Illuminate\Routing\Router;

class HandlerRegistrar
{
	public function __construct(private readonly Router $router)
	{
	}

	/** @param class-string $handler */
	public function addGet(
		string $uri,
		string $handler,
		NameProviderInterface $name,
	): Route {
		return $this->router
			->addRoute('GET', $uri, $handler)
			->name($name->name());
	}

	/** @param class-string $handler */
	public function addPost(
		string $uri,
		string $handler,
		NameProviderInterface $name,
	): Route
	{
		return $this->router
			->addRoute('POST', $uri, $handler)
			->name($name->name());
	}
}
