<?php

namespace Application\Auth\Core\Values;

use Application\Common\Core\Values\BoundedLengthStringAbstract;
use Application\Common\Core\Values\StringAbstract;
use Illuminate\Contracts\Hashing\Hasher;
use Stringable;

class RememberToken extends BoundedLengthStringAbstract
{
	public function __construct(string $value)
	{
		parent::__construct($value, 60, 100);
	}

	/**
	 * @throws \Application\Common\Core\Exceptions\InvalidValueException
	 */
	public function getHashedPassword(Hasher $hasher): RememberToken
	{
		return new self($hasher->make($this->value()));
	}

	public function equals(StringAbstract|Stringable|string $subject): bool
	{
		return hash_equals((string) $this, (string) $subject);
	}
}
