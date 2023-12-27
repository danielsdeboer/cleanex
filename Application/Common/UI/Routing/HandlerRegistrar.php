<?php

namespace Application\Common\UI\Routing;

use Illuminate\Routing\Route;
use Illuminate\Routing\Router;

class HandlerRegistrar
{
	public function __construct(private readonly Router $router)
	{
	}

	public function addGet(string $uri, string $handler, string $name): Route
	{
		return $this->router->addRoute('GET', $uri, $handler)->name($name);
	}

	public function addPost(string $uri, string $handler, string $name): Route
	{
		return $this->router->addRoute('POST', $uri, $handler)->name($name);
	}
}
