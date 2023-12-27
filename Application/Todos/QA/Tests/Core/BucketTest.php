<?php /** @noinspection PhpUnhandledExceptionInspection */

namespace Application\Todos\QA\Tests\Core;

use Application\Common\QA\Cases\UnitTestCase;
use Application\Todos\Core\Entities\Bucket;
use Application\Todos\Core\Values\BucketName;
use Illuminate\Support\Str;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;

#[CoversClass(Bucket::class)]
class BucketTest extends UnitTestCase
{
	#[Test]
	public function it_can_be_created(): void
	{
		$id = Str::orderedUuid();
		$name = new BucketName(Str::random());

		$bucket = new Bucket($id, $name);

		$this->assertSame($id, $bucket->getId());
		$this->assertSame($name, $bucket->getName());
	}
}
