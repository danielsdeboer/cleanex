<?php

namespace Application\Common\UI\Routing;

use Application\Common\UI\NameProviderInterface;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;

class ViewFactory
{
	public function __construct(private readonly Factory $viewFactory)
	{
	}

	public function make(NameProviderInterface $routeEnum): View {
		return $this->viewFactory->make($routeEnum->name());
	}
}
