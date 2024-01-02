<?php

namespace Application\Auth\Core\Values;

use Application\Common\Core\Values\BoundedLengthStringAbstract;
use Illuminate\Contracts\Hashing\Hasher;

class UserPassword extends BoundedLengthStringAbstract
{
	public function __construct(string $value)
	{
		// TODO: Replace minimum length magic number.
		parent::__construct($value, 8, 255);
	}

	/**
	 * @throws \Application\Common\Core\Exceptions\InvalidValueException
	 */
	public function getHashedPassword(Hasher $hasher): UserPassword
	{
		return new self($hasher->make($this->value()));
	}
}
