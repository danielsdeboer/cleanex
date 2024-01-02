<?php

namespace Application\Home\UI\Handlers;

use Application\Common\UI\Routing\UrlFactory;
use Application\Common\UI\Routing\ViewFactory;
use Application\Home\UI\HomeRouteEnum;
use Application\Todos\UI\RouteEnum;
use Illuminate\Contracts\View\View;

class HomeIndexHandler
{
	public function __construct(
		private readonly ViewFactory $viewFactory,
		private readonly UrlFactory $urlFactory,
	)
	{
	}

	public function __invoke(): View
	{
		return $this->viewFactory->make(HomeRouteEnum::HomeIndex)->with([
			'todosUrl' => $this->urlFactory->make(RouteEnum::BucketIndex),
		]);
	}
}
