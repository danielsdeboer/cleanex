<?php

namespace Application\Todos\UI\Handlers;

use Application\Common\UI\Routing\UrlFactory;
use Application\Common\UI\Routing\ViewFactory;
use Application\Todos\UI\RouteEnum;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class BucketCreateHandler
{
	public function __construct(
		private readonly ViewFactory $viewFactory,
		private readonly UrlFactory $urlFactory,
	)
	{
	}

	public function __invoke(Request $request): View
	{
		return $this->viewFactory->make(RouteEnum::BucketCreate)->with([
			'name' => $request->old('name'),
			'storeUrl' => $this->urlFactory->make(RouteEnum::BucketStore),
		]);
	}
}
