<?php

namespace Application\Todos\QA\Tests\UI;

use Application\Common\QA\Cases\WebTestCase;
use Application\Common\QA\Support\Validation\ValidationData;
use Application\Todos\Core\Interfaces\BucketRepoInterface;
use Application\Todos\QA\Support\DataProviders\BucketStoreDataProvider;
use Application\Todos\QA\Support\Stubs\BucketRepoStub;
use Application\Todos\UI\Handlers\BucketCreateHandler;
use Illuminate\Support\Str;
use Illuminate\Testing\TestResponse;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProviderExternal;
use PHPUnit\Framework\Attributes\Test;

#[CoversClass(BucketCreateHandler::class)]
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

	protected function callWithData(array $requestData): TestResponse
	{
		return $this->callNamedRoute(
			routeName: 'buckets::store',
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

	    $this->callWithData(['name' => $name])
			->assertRedirect(route('buckets::index'));

		$this->assertTrue(
			$this->repo::$entityCache->last()->getName()->equals($name)
		);
	}
}
