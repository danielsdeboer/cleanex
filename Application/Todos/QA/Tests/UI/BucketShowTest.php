<?php /** @noinspection PhpUnhandledExceptionInspection */

namespace Application\Todos\QA\Tests\UI;

use Application\Common\QA\Cases\WebTestCase;
use Application\Todos\Core\Entities\Bucket;
use Application\Todos\Core\Interfaces\BucketRepoInterface;
use Application\Todos\QA\Support\Stubs\BucketRepoStub;
use Application\Todos\QA\Support\Stubs\BucketStub;
use Application\Todos\UI\Handlers\BucketShowHandler;
use Application\Todos\UI\RouteEnum;
use Illuminate\Testing\TestResponse;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;

#[CoversClass(BucketShowHandler::class)]
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

	public function callRoute(Bucket $bucket): TestResponse
	{
		return $this->callNamedRoute(
			route: RouteEnum::BucketShow,
			routeParams: ['bucketId' => (string) $bucket->getId()],
		);
	}

	#[Test]
	public function it_gets_the_bucket_show(): void
	{
		$bucket = $this->repo->insert(BucketStub::fake());

	    $this->callRoute($bucket)
			->assertOk()
			->assertSee($bucket->getName())
			->assertSee($bucket->getId());
	}

	/** @test */
	public function it_catches_bad_uuids(): void
	{
		$this->callNamedRoute(
			route: RouteEnum::BucketShow,
			routeParams: ['bucketId' => 'not-a-uuid'],
		)->assertNotFound();
	}
}
