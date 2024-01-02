<?php

namespace Application\Todos\UI\Handlers;

use Application\Common\UI\Routing\RedirectFactory;
use Application\Todos\Core\Entities\Bucket;
use Application\Todos\Core\Interfaces\BucketRepoInterface;
use Application\Todos\UI\RouteEnum;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class BucketStoreHandler
{
	public function __construct(
		private readonly RedirectFactory $redirectFactory,
		private readonly BucketRepoInterface $repo,
	)
	{
	}

	/**
	 * @throws \Application\Common\Core\Exceptions\InvalidValueException
	 */
	public function __invoke(Request $request): RedirectResponse
	{
		$validated = $request->validate([
			'name' => ['required', 'string', 'max:255'],
		]);

		$bucket = $this->repo->insert(Bucket::fromValidated($validated));

		return $this->redirectFactory->make(RouteEnum::BucketShow, [
			'bucketId' => $bucket->getId(),
		]);
	}
}
