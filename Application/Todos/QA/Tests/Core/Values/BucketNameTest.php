<?php /** @noinspection PhpUnhandledExceptionInspection */

namespace Application\Todos\QA\Tests\Core\Values;

use Application\Common\Core\Exceptions\InvalidValueException;
use Application\Common\QA\Cases\UnitTestCase;
use Application\Todos\Core\Values\BucketName;
use Illuminate\Support\Str;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;

#[CoversClass(BucketName::class)]
class BucketNameTest extends UnitTestCase
{
	#[Test]
	public function it_has_a_value(): void
	{
		$value = Str::random();
		$name = new BucketName($value);

		$this->assertSame($value, $name->value());
	}

	#[Test]
	public function it_may_not_be_empty(): void
	{
	    $this->expectException(InvalidValueException::class);

		new BucketName('');
	}
}
