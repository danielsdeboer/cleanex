<?php /** @noinspection PhpUnhandledExceptionInspection */

namespace Application\Todos\QA\Tests\Core;

use Application\Common\QA\Cases\UnitTestCase;
use Application\Todos\Core\Entities\Bucket;
use Application\Todos\Core\Entities\BucketList;
use Application\Todos\Core\Values\BucketName;
use Illuminate\Support\Str;
use PHPUnit\Framework\Attributes\Test;

class BucketListTest extends UnitTestCase
{
	protected function makeBucket(): Bucket
	{
		return new Bucket(Str::orderedUuid(), new BucketName(Str::random()));
	}

	#[Test]
	public function it_is_countable(): void
	{
	    $list = new BucketList();

		$this->assertCount(0, $list);

		$list = new BucketList($this->makeBucket());

		$this->assertCount(1, $list);
	}

	#[Test]
	public function it_is_iterable(): void
	{
		$buckets = [$this->makeBucket(), $this->makeBucket()];

		$list = new BucketList(...$buckets);

		foreach ($list as $index => $bucket) {
			$this->assertSame($buckets[$index], $bucket);
		}
	}

}
