<?php

namespace Application\Todos\UI\Handlers;

use Application\Todos\Core\Entities\Bucket;
use Application\Todos\Core\Interfaces\BucketRepoInterface;
use Application\Todos\Core\Values\BucketName;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Str;

class BucketStoreHandler
{
	public function __construct(
		private readonly Redirector $redirector,
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

		$this->repo->insert(
			new Bucket(
				id: Str::uuid(),
				name: new BucketName($validated['name']),
			),
		);

		return $this->redirector->route('buckets::index');
	}
}
