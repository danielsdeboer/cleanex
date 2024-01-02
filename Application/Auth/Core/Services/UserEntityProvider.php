<?php

namespace Application\Auth\Core\Services;

use Application\Auth\Core\Entities\User;
use Application\Auth\Core\Interfaces\UserRepoInterface;
use Application\Auth\Core\Values\RememberToken;
use Application\Common\Core\Exceptions\NotFoundInRepoException;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Auth\UserProvider;
use Illuminate\Contracts\Hashing\Hasher;
use Ramsey\Uuid\Uuid;
use RuntimeException;

class UserEntityProvider implements UserProvider
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

	public function retrieveByCredentials(array $credentials): User|null
	{
		dd($credentials);
	}

	/**
	 * @param array{password: string} $credentials
	 */
	public function validateCredentials(
		Authenticatable $user,
		array $credentials
	): bool
	{
		$user = $this->assertIsUser($user);

		return $this->hasher->check(
			$credentials['password'],
			$user->getAuthPassword(),
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
