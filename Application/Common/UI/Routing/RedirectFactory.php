<?php

namespace Application\Common\UI\Routing;

use Application\Common\UI\NameProviderInterface;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;

class RedirectFactory
{
	public function __construct(private readonly Redirector $redirector)
	{
	}

	/** @param array<string, mixed> $routeParams */
	public function make(
		NameProviderInterface $routeEnum,
		array $routeParams = [],
	): RedirectResponse {
		return $this->redirector->route(
			$routeEnum->name(),
			$routeParams,
		);
	}
}
