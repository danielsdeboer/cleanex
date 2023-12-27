<?php

namespace Application\Todos\QA\Tests\UI;

use Application\Common\QA\Cases\WebTestCase;
use Application\Todos\Core\Interfaces\BucketRepoInterface;
use Application\Todos\QA\Support\Stubs\BucketRepoStub;
use Application\Todos\UI\Handlers\BucketIndexHandler;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;

#[CoversClass(BucketIndexHandler::class)]
class BucketIndexTest extends WebTestCase
{
	private BucketRepoStub $repo;

	protected function setUp(): void
	{
		parent::setUp();

		$this->repo = $this->bindAndResolve(
			BucketRepoInterface::class,
			BucketRepoStub::class,
		);
	}

	#[Test]
	public function it_gets_the_buckets_index(): void
	{
		$bucketList = $this->repo->all();

	    $response = $this->callNamedRoute('buckets::index')->assertOk();

		/** @var \Application\Todos\Core\Entities\Bucket $todoList */
		foreach ($bucketList as $bucket) {
			$response
				// ->assertSee($bucket->getName())
				->assertSee($bucket->getId());
		}
	}
}
