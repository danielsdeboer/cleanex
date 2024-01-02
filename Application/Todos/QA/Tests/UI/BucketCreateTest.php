<?php

namespace Application\Todos\QA\Tests\UI;

use Application\Common\QA\Cases\WebTestCase;
use Application\Todos\UI\Handlers\BucketCreateHandler;
use Application\Todos\UI\RouteEnum;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;

#[CoversClass(BucketCreateHandler::class)]
class BucketCreateTest extends WebTestCase
{
	#[Test]
	public function it_provides_the_bucket_create_form(): void
	{
	    $this->callNamedRoute(RouteEnum::BucketCreate)
			->assertOk()
			->assertSee('id="name"', escape: false)
			->assertSee('id="submit"', escape: false);
	}
}
