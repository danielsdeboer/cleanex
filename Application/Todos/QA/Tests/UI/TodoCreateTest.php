<?php
/** @noinspection PhpUnhandledExceptionInspection */

namespace Application\Todos\QA\Tests\UI;

use Application\Common\QA\Cases\WebTestCase;
use Application\Common\QA\Support\Html\HtmlAssert;
use Application\Todos\Core\Entities\Bucket;
use Application\Todos\Core\Interfaces\BucketRepoInterface;
use Application\Todos\QA\Support\Stubs\BucketRepoStub;
use Application\Todos\QA\Support\Stubs\BucketStub;
use Application\Todos\UI\Handlers\TodoCreateHandler;
use Application\Todos\UI\RouteEnum;
use Illuminate\Support\Str;
use Illuminate\Testing\TestResponse;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;

#[CoversClass(TodoCreateHandler::class)]
class TodoCreateTest extends WebTestCase
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

	protected function callRoute(Bucket $bucket): TestResponse
	{
		return $this->callNamedRoute(
			route: RouteEnum::TodoCreate,
			routeParams: ['bucketId' => (string) $bucket->getId()],
		);
	}

	#[Test]
	public function it_gets_the_todo_create(): void
	{
		$oldName = Str::random();
		$bucket = $this->repo->insert(BucketStub::fake());

		$this->addToSessionOldInput('name', $oldName);

		$this->callRoute($bucket)
			->assertOk()
			->assertSee($bucket->getName())
			->assertSee($bucket->getId())
			// Here we check that the old input is properly set on the name
			// input field.
			->assertHtml(fn (HtmlAssert $html) => $html->hasAttributeValue(
				'#todos-create #name',
				'value',
				$oldName,
			));
	}
}
