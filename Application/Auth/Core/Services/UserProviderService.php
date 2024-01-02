<?php

namespace Application\Auth\Core\Services;

use Application\Auth\Core\Entities\User;
use Application\Auth\Core\Interfaces\UserRepoInterface;
use Application\Auth\Core\Values\RememberToken;
use Application\Auth\Core\Values\UserEmail;
use Application\Auth\Core\Values\UserPassword;
use Application\Common\Core\Exceptions\NotFoundInRepoException;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Auth\UserProvider;
use Illuminate\Contracts\Hashing\Hasher;
use Illuminate\Support\Arr;
use Ramsey\Uuid\Uuid;
use RuntimeException;

class UserProviderService implements UserProvider
{
	public function __construct(
		private readonly UserRepoInterface $repo,
		private readonly Hasher $hasher,
	) {
	}

	/** @param string $identifier */
	public function retrieveById($identifier): User|null
	{
		try {
			return $this->repo->findById(Uuid::fromString($identifier));
		} catch (NotFoundInRepoException) {
			return null;
		}
	}

	/**
	 * @param string $identifier
	 * @param string $token
	 * @throws \Application\Common\Core\Exceptions\InvalidValueException
	 */
	public function retrieveByToken($identifier, $token): User|null
	{
		$user = $this->retrieveById($identifier);

		if ($user === null) {
			return null;
		}

		return (new RememberToken($token))->equals($user->getRememberToken())
			? $user
			: null;
	}

	/**
	 * @param string $token
	 * @throws \Application\Common\Core\Exceptions\InvalidValueException
	 */
	public function updateRememberToken(Authenticatable $user, $token): void
	{
		$user = $this->assertIsUser($user);

		$user->setRememberToken($token);

		$this->repo->updateRememberToken($user);
	}

	/**
	 * @throws \Application\Common\Core\Exceptions\InvalidValueException
	 */
	public function retrieveByCredentials(array $credentials): User|null
	{
		$subset = Arr::only($credentials, ['email', 'password']);

		if (count($subset) !== 2) {
			return null;
		}

		try {
			$user = $this->repo->findByEmail(new UserEmail($subset['email']));
		} catch (NotFoundInRepoException) {
			return null;
		}

		if (!$this->validateCredentials($user, $subset)) {
			return null;
		}

		return $user;
	}

	/**
	 * @param array{password: string} $credentials
	 * @throws \Application\Common\Core\Exceptions\InvalidValueException
	 */
	public function validateCredentials(
		Authenticatable $user,
		array $credentials
	): bool
	{
		return $this->assertIsUser($user)->hasMatchingPassword(
			$this->hasher,
			new UserPassword($credentials['password']),
		);
	}

	// Internals //

	private function assertIsUser(mixed $user): User
	{
		if ($user instanceof User) {
			return $user;
		}

		throw new RuntimeException(
			sprintf('User must be instance of %s.', User::class),
		);
	}
}
