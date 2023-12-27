<?php

namespace Application\Common\Core\Values;

use Stringable;

class StringAbstract implements Stringable
{
	public function __construct(private readonly string $value)
	{
	}

	public function value(): string
	{
		return $this->value;
	}

	public function equals(string|Stringable|self $subject): bool
	{
		return (string) $this === (string) $subject;
	}

	public function __toString(): string
	{
		return $this->value;
	}
}
