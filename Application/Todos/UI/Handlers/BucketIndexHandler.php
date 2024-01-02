<?php

namespace Application\Todos\UI\Handlers;

use Application\Common\UI\Routing\UrlFactory;
use Application\Common\UI\Routing\ViewFactory;
use Application\Todos\Core\Interfaces\BucketRepoInterface;
use Application\Todos\UI\RouteEnum;
use Illuminate\Contracts\View\View;

class BucketIndexHandler
{
	public function __construct(
		private readonly ViewFactory $viewFactory,
		private readonly UrlFactory $urlFactory,
		private readonly BucketRepoInterface $bucketRepo,
	)
	{
	}

	public function __invoke(): View
	{
		$buckets = $this->bucketRepo->all();

		return $this->viewFactory->make(RouteEnum::BucketIndex)->with([
			'buckets' => $buckets,
			'createRoute' => $this->urlFactory->make(RouteEnum::BucketCreate),
		]);
	}
}
