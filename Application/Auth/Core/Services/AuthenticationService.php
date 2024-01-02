<?php

namespace Application\Auth\Core\Services;

use Application\Auth\Core\Entities\User;
use Application\Auth\Core\Interfaces\AuthDataRepoInterface;
use Application\Auth\Core\Interfaces\UserRepoInterface;
use Application\Common\Core\Exceptions\NotFoundInRepoException;
use Illuminate\Contracts\Hashing\Hasher;
use Illuminate\Contracts\Validation\Factory;

// This service is invokable since Fortify needs a callable to provide
// authentication.
class AuthenticationService
{
	public function __construct(
		private readonly AuthDataRepoInterface $authDataRepo,
		private readonly UserRepoInterface $userRepo,
		private readonly Factory $validationFactory,
		private readonly Hasher $hasher,
	)
	{
	}

	/**
	 * @throws \Application\Common\Core\Exceptions\InvalidValueException
	 * @throws \Illuminate\Validation\ValidationException
	 */
	public function __invoke(): User|false
	{
		// First, we get the raw auth data and validate it. If validation
		// fails, a validation exception will be thrown.
		$validData = $this->authDataRepo
			->getRawAuthData()
			->validate($this->validationFactory);

		// Then, if validation passes, we try to find a user with the given
		// email. If no user is found, we return false, meaning that
		// authentication has failed.
		try {
			$user = $this->userRepo->findByEmail($validData->email);
		} catch (NotFoundInRepoException) {
			return false;
		}

		// Then, if the user exists, we check to make sure that the validation
		// data's password matches the user's password.
		if (!$user->hasMatchingPassword($this->hasher, $validData->password)) {
			return false;
		}

		// Finally, if all checks pass, we return the user.
		return $user;
	}
}
