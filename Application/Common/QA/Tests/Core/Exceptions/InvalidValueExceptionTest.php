<?php

namespace Application\Common\QA\Tests\Core\Exceptions;

use Application\Common\Core\Exceptions\InvalidValueException;
use Application\Common\QA\Cases\UnitTestCase;
use Illuminate\Support\Str;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;

#[CoversClass(InvalidValueException::class)]
class InvalidValueExceptionTest extends UnitTestCase
{
	#[Test]
	public function asserting_a_string_is_not_empty(): void
	{
		/** @noinspection PhpUnhandledExceptionInspection */
		InvalidValueException::assertNotEmpty(self::class, Str::random());

	    $this->expectException(InvalidValueException::class);
		$this->expectExceptionMessage('may not be empty');

		InvalidValueException::assertNotEmpty(self::class, '');
	}
}
