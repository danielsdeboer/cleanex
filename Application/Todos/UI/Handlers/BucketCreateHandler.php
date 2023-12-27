<?php

namespace Application\Todos\UI\Handlers;

use Illuminate\Contracts\Routing\UrlGenerator;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class BucketCreateHandler
{
	public function __construct(
		private readonly Factory $viewFactory,
		private readonly UrlGenerator $urlGenerator,
	)
	{
	}

	public function __invoke(Request $request): View
	{
		return $this->viewFactory->make('buckets::create')->with([
			'name' => $request->old('name'),
			'storeUrl' => $this->urlGenerator->route('buckets::store'),
		]);
	}
}
