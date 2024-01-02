<?php

namespace Application\Todos\UI\Handlers;

use Application\Common\Core\Exceptions\NotFoundInRepoException;
use Application\Common\UI\Routing\ViewFactory;
use Application\Todos\Core\Interfaces\BucketRepoInterface;
use Application\Todos\UI\RouteEnum;
use Illuminate\Contracts\View\View;
use Ramsey\Uuid\Exception\InvalidUuidStringException;
use Ramsey\Uuid\Uuid;

class BucketShowHandler
{
	public function __construct(
		private readonly ViewFactory $viewFactory,
		private readonly BucketRepoInterface $bucketRepo,
	)
	{
	}

	public function __invoke(string $bucketId): View
	{
		try {
			$bucket = $this->bucketRepo->findById(Uuid::fromString($bucketId));
		} catch (NotFoundInRepoException|InvalidUuidStringException) {
			abort(404);
		}

		return $this->viewFactory->make(RouteEnum::BucketShow)->with([
			'id' => $bucket->getId(),
			'name' => $bucket->getName(),
		]);
	}
}
