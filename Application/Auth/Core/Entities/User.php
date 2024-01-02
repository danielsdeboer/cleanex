<?php

namespace Application\Auth\Core\Entities;

use Application\Auth\Core\Values\RememberToken;
use Application\Auth\Core\Values\UserEmail;
use Application\Auth\Core\Values\UserName;
use Application\Auth\Core\Values\UserPassword;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Hashing\Hasher;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;
use stdClass;

class User implements Authenticatable
{
	public function __construct(
		private readonly UuidInterface $id,
		private UserName $name,
		private UserEmail $email,
		private UserPassword $password,
		private RememberToken|null $rememberToken = null,
	) {
	}

	/**
	 * @param stdClass{
	 *     id: string,
	 *     name: string,
	 *     email: string,
	 *     password: string,
	 *     created_at: string,
	 *     updated_at: string,
	 * } $record
	 * @throws \Application\Common\Core\Exceptions\InvalidValueException
	 */
	public static function fromRecord(stdClass $record): self
	{
		return new self(
			id: Uuid::fromString($record->id),
			name: new UserName($record->name),
			email: new UserEmail($record->email),
			password: new UserPassword($record->password),
		);
	}

	// Getters //

	public function getId(): UuidInterface
	{
		return $this->id;
	}

	public function getName(): UserName
	{
		return $this->name;
	}

	public function getEmail(): UserEmail
	{
		return $this->email;
	}

	public function getPassword(): UserPassword
	{
		return $this->password;
	}

	// Public Api //

	public function hasMatchingPassword(
		Hasher $hasher,
		UserPassword $password,
	): bool {
		return $hasher->check($password->value(), $this->password->value());
	}

	// Presenters //

	public function getDbInsertPresentation(): array
	{
		return [
			'name' => (string) $this->name,
			'email' => (string) $this->email,
		];
	}

	// Authenticatable //

	public function getAuthIdentifierName(): string
	{
		return 'id';
	}

	public function getAuthIdentifier(): string
	{
		return $this->id->toString();
	}

	public function getAuthPassword(): string
	{
		return $this->password->value();
	}

	public function getRememberToken(): string|null
	{
		return $this->rememberToken?->value();
	}

	/**
	 * @param string|RememberToken $value
	 * @throws \Application\Common\Core\Exceptions\InvalidValueException
	 */
	public function setRememberToken($value): void
	{
		if (!is_string($value) && !($value instanceof RememberToken)) {
			throw new \RuntimeException(
				'The remember token value must be a string or instance of RememberToken.'
			);
		}

		$this->rememberToken = is_string($value)
			? new RememberToken($value)
			: $value;
	}

	public function getRememberTokenName(): string
	{
		return 'remember_token';
	}
}
