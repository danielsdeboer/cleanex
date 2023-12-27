<?php

namespace Application\Todos\UI\Handlers;

use Application\Todos\Core\Interfaces\BucketRepoInterface;
use Illuminate\Contracts\Routing\UrlGenerator;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;

class BucketIndexHandler
{
	public function __construct(
		private readonly Factory $viewFactory,
		private readonly UrlGenerator $urlGenerator,
		private readonly BucketRepoInterface $bucketRepo,
	)
	{
	}

	public function __invoke(): View
	{
		$buckets = $this->bucketRepo->all();

		return $this->viewFactory->make('buckets::index')->with([
			'buckets' => $buckets,
			'createRoute' => $this->urlGenerator->route('buckets::create'),
		]);
	}
}
