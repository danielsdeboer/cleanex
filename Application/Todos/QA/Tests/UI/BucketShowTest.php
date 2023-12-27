<?php /** @noinspection PhpUnhandledExceptionInspection */

namespace Application\Todos\QA\Tests\UI;

use Application\Common\QA\Cases\WebTestCase;
use Application\Todos\Core\Entities\Bucket;
use Application\Todos\Core\Interfaces\BucketRepoInterface;
use Application\Todos\QA\Support\Stubs\BucketRepoStub;
use Application\Todos\QA\Support\Stubs\BucketStub;
use Application\Todos\UI\Handlers\BucketIndexHandler;
use Illuminate\Testing\TestResponse;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;

#[CoversClass(BucketIndexHandler::class)]
class BucketShowTest extends WebTestCase
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

	public function callShow(Bucket $bucket): TestResponse
	{
		return $this->callNamedRoute(
			routeName: 'buckets::show',
			routeParams: ['bucket' => (string) $bucket->getId()],
		);
	}

	#[Test]
	public function it_gets_the_bucket_show(): void
	{
		$bucket = $this->repo->insert(BucketStub::fake());

	    $this->callShow($bucket)
			->assertOk()
			->assertSee($bucket->getName())
			->assertSee($bucket->getId());
	}
}
