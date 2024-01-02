<?php

namespace Application\Common\UI\Routing;

use Application\Common\UI\NameProviderInterface;
use Illuminate\Contracts\Routing\UrlGenerator;

class UrlFactory
{
	public function __construct(private readonly UrlGenerator $urlGenerator)
	{
	}

	/** @param array<string, mixed> $routeParams */
	public function make(
		NameProviderInterface $routeEnum,
		array $routeParams = [],
	): string {
		return $this->urlGenerator->route($routeEnum->name(), $routeParams);
	}
}
