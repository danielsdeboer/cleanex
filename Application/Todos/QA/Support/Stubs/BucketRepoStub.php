<?php
/** @noinspection PhpUnhandledExceptionInspection */

namespace Application\Todos\QA\Support\Stubs;

use Application\Todos\Core\Entities\Bucket;
use Application\Todos\Core\Entities\BucketList;
use Application\Todos\Core\Interfaces\BucketRepoInterface;
use Application\Todos\Core\Values\BucketName;
use Faker\Generator;
use Illuminate\Support\Str;
use Ramsey\Uuid\UuidInterface;

class BucketRepoStub implements BucketRepoInterface
{
	public static BucketList $entityCache;

	public function __construct(private readonly Generator $faker)
	{
		if (isset(self::$entityCache)) {
			return;
		}

		self::$entityCache = new BucketList();
	}

	public function all(): BucketList
	{
		if (!self::$entityCache->isEmpty()) {
			return self::$entityCache;
		}

		for ($iter = 0; $iter < 5; $iter++) {
			$bucket = new Bucket(
				Str::orderedUuid(),
				new BucketName($this->faker->sentence(rand(2, 4))),
			);

			self::$entityCache->put($bucket);
		}

		return self::$entityCache;
	}

	public function findById(UuidInterface $id): Bucket
	{
		return self::$entityCache->find($id);
	}

	public function insert(Bucket $bucket): Bucket
	{
		// We mock the way the DB would behave here, replacing the identity of
		// the entity with a freshly generated ordered UUID.
		$bucketWithFreshUuid = new Bucket(
			id: Str::orderedUuid(),
			name: $bucket->getName(),
		);

		self::$entityCache->put($bucketWithFreshUuid);

		return $bucketWithFreshUuid;
	}
}
