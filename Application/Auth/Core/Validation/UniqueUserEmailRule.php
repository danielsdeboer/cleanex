<?php

namespace Application\Auth\Core\Validation;

use Application\Auth\Core\Interfaces\UserRepoInterface;
use Application\Auth\Core\Values\UserEmail;
use Application\Common\Core\Exceptions\InvalidValueException;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class UniqueUserEmailRule implements ValidationRule
{
	public function __construct(private readonly UserRepoInterface $repo)
	{
	}

	public function validate(string $attribute, mixed $value, Closure $fail): void
	{
		if (!is_string($value)) {
			$fail(sprintf('The %s must be a string.', $attribute));
			return;
		}

		try {
			$email = new UserEmail($value);
		} catch (InvalidValueException) {
			$fail(sprintf('The %s is not a valid email address.', $attribute));
			return;
		}

		if ($this->repo->isEmailAlreadyInUse($email)) {
			$fail(sprintf('The %s has already been taken.', $attribute));
		}
	}
}
