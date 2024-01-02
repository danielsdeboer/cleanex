<?php
/** @noinspection PhpUnhandledExceptionInspection */

namespace Application\Todos\QA\Support\Stubs;

use Application\Common\QA\Support\Repos\InMemoryRepoAbstract;
use Application\Todos\Core\Entities\Bucket;
use Application\Todos\Core\Entities\BucketList;
use Application\Todos\Core\Interfaces\BucketRepoInterface;
use Application\Todos\Core\Values\BucketName;
use Illuminate\Support\Str;
use Ramsey\Uuid\UuidInterface;

/**
 * @extends \Application\Common\QA\Support\Repos\InMemoryRepoAbstract<\Application\Todos\Core\Entities\BucketList>
 */
class BucketRepoStub extends InMemoryRepoAbstract implements BucketRepoInterface
{
	protected function newCache(): BucketList
	{
		return new BucketList();
	}

	public function all(): BucketList
	{
		return $this->whenCacheIsEmpty(function () {
			for ($iter = 0; $iter < 5; $iter++) {
				$bucket = new Bucket(
					Str::orderedUuid(),
					new BucketName($this->faker->sentence(rand(2, 4))),
				);

				$this->getCache()->put($bucket);
			}
		});
	}

	public function findById(UuidInterface $id): Bucket
	{
		return $this->getCache()->find($id);
	}

	public function insert(Bucket $bucket): Bucket
	{
		// We mock the way the DB would behave here, replacing the identity of
		// the entity with a freshly generated ordered UUID.
		$bucketWithFreshUuid = new Bucket(
			id: Str::orderedUuid(),
			name: $bucket->getName(),
		);

		$this->getCache()->put($bucketWithFreshUuid);

		return $bucketWithFreshUuid;
	}
}
