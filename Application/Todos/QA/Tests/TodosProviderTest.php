<?php

namespace Application\Todos\QA\Tests;

use Application\Common\QA\Cases\WebTestCase;
use Application\Todos\TodosProvider;
use Illuminate\Contracts\View\Factory;
use PHPUnit\Framework\Attributes\CoversClass;

#[CoversClass(TodosProvider::class)]
class TodosProviderTest extends WebTestCase
{
	/** @test */
	public function it_provides_views_and_routes(): void
	{
	    $this->assertTrue(
			$this->app->make(Factory::class)->exists('todos::buckets.index'),
		);

		$this->assertTrue($this->getRoutes()->hasNamedRoute('todos::buckets.index'));
	}
}
