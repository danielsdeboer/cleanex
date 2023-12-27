<?php

namespace Application\Common\QA\Tests\Core\Values;

use Application\Common\Core\Values\StringAbstract;
use Application\Common\QA\Cases\UnitTestCase;
use Illuminate\Support\Str;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;

#[CoversClass(StringAbstract::class)]
class StringAbstractTest extends UnitTestCase
{
	protected function makeStub(string $string): StringAbstract
	{
		return new class($string) extends StringAbstract {};
	}

	#[Test]
	public function it_contains_a_string_value(): void
	{
		$baseValues = ['', Str::random()];

		foreach ($baseValues as $baseValue) {
			$value = $this->makeStub($baseValue);

			$this->assertEquals($baseValue, $value->value());
			$this->assertEquals($baseValue, (string) $value);
		}
	}
}
