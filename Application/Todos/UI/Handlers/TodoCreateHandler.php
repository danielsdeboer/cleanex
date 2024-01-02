<?php

namespace Application\Todos\UI\Handlers;

use Application\Common\Core\Exceptions\NotFoundInRepoException;
use Application\Common\UI\Routing\UrlFactory;
use Application\Common\UI\Routing\ViewFactory;
use Application\Todos\Core\Interfaces\BucketRepoInterface;
use Application\Todos\UI\RouteEnum;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Ramsey\Uuid\Exception\InvalidUuidStringException;
use Ramsey\Uuid\Uuid;

class TodoCreateHandler
{
	public function __construct(
		private readonly ViewFactory $viewFactory,
		private readonly UrlFactory $urlFactory,
		private readonly BucketRepoInterface $bucketRepo,
	)
	{
	}

	public function __invoke(Request $request, string $bucketId): View
	{
		try {
			$bucket = $this->bucketRepo->findById(Uuid::fromString($bucketId));
		} catch (NotFoundInRepoException|InvalidUuidStringException) {
			abort(404);
		}

		return $this->viewFactory->make(RouteEnum::TodoCreate)->with([
			'bucketId' => $bucket->getId(),
			'bucketName' => $bucket->getName(),
			'name' => $request->old('name'),
			'storeUrl' => $this->urlFactory->make(RouteEnum::TodoStore, [
				'bucketId' => $bucket->getId(),
			]),
		]);
	}
}
