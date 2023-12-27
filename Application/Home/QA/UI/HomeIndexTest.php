<?php

namespace Application\Home\QA\UI;

use Application\Common\QA\Cases\WebTestCase;
use PHPUnit\Framework\Attributes\Test;

class HomeIndexTest extends WebTestCase
{
	#[Test]
	public function getting_the_index(): void
	{
	    $this->get('/')
			->assertOk()
			->assertSee('Hello World');
	}
}
