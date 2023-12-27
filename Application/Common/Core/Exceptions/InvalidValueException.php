<?php

namespace Application\Common\Core\Exceptions;

use Exception;

class InvalidValueException extends Exception
{
	/**
	 * @throws \Application\Common\Core\Exceptions\InvalidValueException
	 */
	public static function assertLengthWithinBounds(
		string $string,
		int $min,
		int|null $max,
	): void {
		if (strlen($string) < $min) {
			throw new self(
				sprintf(
					'The given string is below the minimum length of %d',
					$min,
				),
			);
		}

		if ($max !== null && strlen($string) > $max) {
			throw new self(
				sprintf(
					'The given string is above the maximum length of %d',
					$max,
				),
			);
		}
	}



	public static function assertNotEmpty(string $class, string $value): void
	{
		if (strlen($value) > 0) {
			return;
		}

		throw self::valueMayNotBeEmpty($class);
	}

	public static function valueMayNotBeEmpty(string $class): self
	{
		return new self(sprintf('%s may not be empty', $class));
	}
}
