<?php /** @noinspection PhpUnhandledExceptionInspection */

namespace Application\Todos\QA\Tests\IO;

use Application\Common\Core\Exceptions\NotFoundInRepoException;
use Application\Common\IO\Config\DefaultConnectionResolver;
use Application\Common\QA\Cases\DatabaseTestCase;
use Application\Todos\Core\Entities\Bucket;
use Application\Todos\Core\Interfaces\BucketRepoInterface;
use Application\Todos\Core\Values\BucketName;
use Application\Todos\IO\BucketRepo;
use Application\Todos\QA\Support\Seeds\BucketSeed;
use Faker\Factory;
use Illuminate\Support\Str;
use PHPUnit\Framework\Attributes\CoversClass;
use Ramsey\Uuid\Uuid;

#[CoversClass(BucketRepo::class)]
class BucketRepoTest extends DatabaseTestCase
{
	protected BucketSeed $bucketSeed;
	protected BucketRepoInterface $bucketRepo;

	protected function setUp(): void
	{
		parent::setUp();

		$this->bucketSeed = new BucketSeed(
			$this->app->make(DefaultConnectionResolver::class),
			Factory::create(),
		);

		$this->bucketRepo = $this->app->make(BucketRepo::class);
	}

	/** @test */
	public function it_gets_all_buckets(): void
	{
		$this->bucketSeed->count(10)->insert();

		$this->assertCount(10, $this->bucketRepo->all());
	}

	/** @test */
	public function it_finds_by_id(): void
	{
	    $record = $this->bucketSeed->insert()[0];

		$bucket = $this->bucketRepo->findById(
			Uuid::fromString($record['id']),
		);

		$this->assertTrue($bucket->getId()->equals($record['id']));
		$this->assertTrue($bucket->getName()->equals($record['name']));
	}

	/** @test */
	public function it_throws_when_not_found_by_id(): void
	{
		$this->expectException(NotFoundInRepoException::class);

		$this->bucketRepo->findById(Str::orderedUuid());
	}

	/** @test */
	public function it_inserts_a_bucket(): void
	{
	    $toInsert = new Bucket(
			id: Str::orderedUuid(),
			name: new BucketName(Str::random()),
		);

		$inserted = $this->bucketRepo->insert($toInsert);

		$this->assertFalse($inserted->getId()->equals($toInsert->getId()));
		$this->assertTrue($inserted->getName()->equals($toInsert->getName()));
	}
}
