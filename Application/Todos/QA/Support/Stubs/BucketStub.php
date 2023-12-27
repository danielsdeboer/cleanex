<?php

namespace Application\Todos\QA\Support\Stubs;

use Application\Todos\Core\Entities\Bucket;
use Application\Todos\Core\Values\BucketName;
use Illuminate\Support\Str;

class BucketStub extends Bucket
{
	/**
	 * @throws \Application\Common\Core\Exceptions\InvalidValueException
	 */
	public static function fake(): Bucket
	{
		return new self(
			id: Str::uuid(),
			name: new BucketName(Str::random()),
		);
	}
}
