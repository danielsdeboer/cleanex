<?php

namespace Application\Todos\Core\Values;

use Application\Common\Core\Values\BoundedLengthStringAbstract;

class BucketName extends BoundedLengthStringAbstract
{
	/**
	 * @throws \Application\Common\Core\Exceptions\InvalidValueException
	 */
	public function __construct(string $value)
	{
		parent::__construct($value, 1, 255);
	}
}
