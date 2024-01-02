<?php

namespace Application\Common\QA\Tests\Core\Values;

use Application\Common\Core\Exceptions\InvalidValueException;
use Application\Common\Core\Values\EmailAbstract;
use Application\Common\QA\Cases\UnitTestCase;
use Illuminate\Support\Str;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;

#[CoversClass(EmailAbstract::class)]
class EmailAbstractTest extends UnitTestCase
{
	protected function makeStub(string $string): EmailAbstract
	{
		return new class($string) extends EmailAbstract {};
	}

	#[Test]
	public function it_throws_on_invalid_emails(): void
	{
		$this->expectException(InvalidValueException::class);

		$this->makeStub(Str::random());
	}

	#[Test]
	public function it_throws_for_too_short_emails(): void
	{
		$this->expectException(InvalidValueException::class);

		$this->makeStub('x@x');
	}

	#[Test]
	public function it_accepts_a_valid_email_address(): void
	{
		$email = $this->faker()->email();
		$stub = $this->makeStub($email);

		$this->assertInstanceOf(EmailAbstract::class, $stub);
		$this->assertSame($email, $stub->value());
	}
}
