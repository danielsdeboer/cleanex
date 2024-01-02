<?php

namespace Application\Auth\IO;

use Application\Auth\Core\Entities\User;
use Application\Auth\Core\Interfaces\UserRepoInterface;
use Application\Auth\Core\Values\UserEmail;
use Application\Common\Core\Exceptions\NotFoundInRepoException;
use Application\Common\IO\Config\TableNameEnum;
use Illuminate\Contracts\Hashing\Hasher;
use Illuminate\Database\DatabaseManager;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Str;
use Ramsey\Uuid\UuidInterface;

/**
 * @phpstan-type UserRecord object{
 *     id: string,
 *     name: string,
 *     email: string,
 *     password: string,
 *     created_at: string,
 *     updated_at: string,
 * }
 */
class UserRepo implements UserRepoInterface
{
	public function __construct(
		private readonly DatabaseManager $db,
		private readonly Hasher $hasher,
	) {
	}

	/**
	 * @throws \Application\Common\Core\Exceptions\NotFoundInRepoException
	 * @throws \Application\Common\Core\Exceptions\InvalidValueException
	 */
	public function findById(UuidInterface $id): User
	{
		return $this->findOrFail(
			fn () => $this->query()->where('id', $id)->first(),
			sprintf('User with id %s not found in repo.', $id),
		);
	}

	/**
	 * @throws \Application\Common\Core\Exceptions\NotFoundInRepoException
	 * @throws \Application\Common\Core\Exceptions\InvalidValueException
	 */
	public function findByEmail(UserEmail $email): User
	{
		return $this->findOrFail(
			fn () => $this->query()->where('email', $email)->first(),
			sprintf('User with email %s not found in repo.', $email),
		);
	}

	public function isEmailAlreadyInUse(UserEmail $email): bool
	{
		return $this->query()->where('email', $email)->exists();
	}

	/**
	 * @throws \Application\Common\Core\Exceptions\InvalidValueException
	 */
	public function insert(User $user): User
	{
		$id = Str::orderedUuid();
		$hashedPassword = $user
			->getPassword()
			->getHashedPassword($this->hasher);

		// We replace the temporary UUID with a real one at this step.
		$this->query()->insert(array_merge($user->getDbInsertPresentation(), [
			'id' => $id,
			'password' => $hashedPassword,
			'created_at' => now(),
			'updated_at' => now(),
		]));

		return new User(
			id: $id,
			name: $user->getName(),
			email: $user->getEmail(),
			password: $hashedPassword,
		);
	}

	public function updateRememberToken(User $user): User
	{
		$this->query()->where('id', $user->getAuthIdentifier())->update([
			$user->getRememberTokenName() => $user->getRememberToken(),
		]);

		return $user;
	}

	// Internals //

	/**
	 * @throws \Application\Common\Core\Exceptions\NotFoundInRepoException
	 * @throws \Application\Common\Core\Exceptions\InvalidValueException
	 */
	private function findOrFail(\Closure $query, string $error): User
	{
		$record = $query();

		if ($record === null) {
			throw new NotFoundInRepoException($error);
		}

		return User::fromRecord($record);
	}

	private function query(): Builder
	{
		return $this->db->table(TableNameEnum::Users->value);
	}
}
