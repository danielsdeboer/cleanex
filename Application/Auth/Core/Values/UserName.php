<?php

namespace Application\Auth\Core\Values;

use Application\Common\Core\Values\BoundedLengthStringAbstract;

class UserName extends BoundedLengthStringAbstract
{
	/**
	 * @throws \Application\Common\Core\Exceptions\InvalidValueException
	 */
	public function __construct(string $value)
	{
		parent::__construct($value, 1, 255);
	}
}
