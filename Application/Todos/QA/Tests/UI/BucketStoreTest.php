<?php

namespace Application\Todos\QA\Tests\UI;

use Application\Common\QA\Cases\WebTestCase;
use Application\Common\QA\Support\Validation\ValidationData;
use Application\Common\UI\Routing\UrlFactory;
use Application\Todos\Core\Interfaces\BucketRepoInterface;
use Application\Todos\QA\Support\DataProviders\BucketStoreDataProvider;
use Application\Todos\QA\Support\Stubs\BucketRepoStub;
use Application\Todos\UI\Handlers\BucketStoreHandler;
use Application\Todos\UI\RouteEnum;
use Illuminate\Support\Str;
use Illuminate\Testing\TestResponse;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProviderExternal;
use PHPUnit\Framework\Attributes\Test;

#[CoversClass(BucketStoreHandler::class)]
class BucketStoreTest extends WebTestCase
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

	/** @param array<string, mixed> $requestData */
	protected function callWithData(array $requestData): TestResponse
	{
		return $this->callNamedRoute(
			route: RouteEnum::BucketStore,
			requestData: $requestData,
			requestMethod: 'POST',
		);
	}

	#[Test]
	#[DataProviderExternal(BucketStoreDataProvider::class, 'validationProvider')]
	public function it_validates_the_request(ValidationData $data): void
	{
		$this->callWithData($data->getRequestFragment())
			->assertRedirect()
			->assertInvalid($data->getErrorFragment());
	}

	/** @test */
	public function it_stores_the_bucket(): void
	{
		$name = Str::random();

	    $request = $this->callWithData(['name' => $name]);

		$bucket = $this->repo->getCache()->last();

		$request->assertRedirect(
			$this->getUrlFactory()->make(
				RouteEnum::BucketShow,
				['bucketId' => $bucket->getId()]
			),
		);
	}
}
