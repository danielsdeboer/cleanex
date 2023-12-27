<?php

namespace Application\Common\Core\Values;

use Application\Common\Core\Exceptions\InvalidValueException;

abstract class BoundedLengthStringAbstract extends StringAbstract
{
	/**
	 * @throws \Application\Common\Core\Exceptions\InvalidValueException
	 */
	public function __construct(
		string $value,
		int $min = 0,
		int|null $max = null,
	) {
		InvalidValueException::assertLengthWithinBounds($value, $min, $max);

		parent::__construct($value);
	}
}
