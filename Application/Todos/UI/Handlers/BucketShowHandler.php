<?php

namespace Application\Todos\UI\Handlers;

use Application\Common\Core\Exceptions\NotFoundInRepoException;
use Application\Todos\Core\Interfaces\BucketRepoInterface;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Ramsey\Uuid\Uuid;

class BucketShowHandler
{
	public function __construct(
		private readonly Factory $viewFactory,
		private readonly BucketRepoInterface $bucketRepo,
	)
	{
	}

	public function __invoke(string $bucketId): View
	{
		try {
			$bucket = $this->bucketRepo->findById(Uuid::fromString($bucketId));
		} catch (NotFoundInRepoException) {
			abort(404);
		}

		return $this->viewFactory->make('buckets::show')->with([
			'id' => $bucket->getId(),
			'name' => $bucket->getName(),
		]);
	}
}
