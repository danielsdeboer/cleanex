<?php

namespace Application\Common\Core\Values;

use Application\Common\Core\Exceptions\InvalidValueException;
use Egulias\EmailValidator\EmailValidator;
use Egulias\EmailValidator\Validation\RFCValidation;

class EmailAbstract extends BoundedLengthStringAbstract
{
	/**
	 * @throws \Application\Common\Core\Exceptions\InvalidValueException
	 */
	public function __construct(string $value)
	{
		if (!(new EmailValidator())->isValid($value, new RFCValidation())) {
			throw new InvalidValueException('Invalid email address.');
		}

		parent::__construct($value, 4, 255);
	}
}
