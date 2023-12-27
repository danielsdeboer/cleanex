<?php

namespace Application\Common\QA\Tests\IO\Config;

use Application\Common\IO\Config\DatabaseConfig;
use Application\Common\QA\Cases\UnitTestCase;
use Illuminate\Config\Repository;
use Illuminate\Support\Str;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;

#[CoversClass(DatabaseConfig::class)]
class DatabaseConfigTest extends UnitTestCase
{
	#[Test]
	public function it_provides_the_default_connection_name(): void
	{
		$defaultName = Str::random();
	    $config = new DatabaseConfig(
			new Repository(['database.default' => $defaultName]),
		);

		$this->assertEquals($defaultName, $config->getDefaultConnectionName());
	}
}
