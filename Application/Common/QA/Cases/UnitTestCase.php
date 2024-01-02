<?php

namespace Application\Common\QA\Cases;

use Faker\Factory;
use Faker\Generator;
use PHPUnit\Framework\TestCase;

abstract class UnitTestCase extends TestCase
{
	public function faker(): Generator
	{
		return Factory::create();
	}
}
