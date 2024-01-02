<?php

namespace Application\Auth\Core\Services;

use Application\Auth\Core\Entities\User;
use Application\Auth\Core\Interfaces\UserRepoInterface;
use Application\Auth\Core\Validation\UniqueUserEmailRule;
use Application\Auth\Core\Values\UserEmail;
use Application\Auth\Core\Values\UserName;
use Application\Auth\Core\Values\UserPassword;
use Illuminate\Contracts\Validation\Factory;
use Illuminate\Support\Str;
use Laravel\Fortify\Contracts\CreatesNewUsers;

// This service exists to be called by Fortify package components.
final class UserUpdateService implements CreatesNewUsers
{
	public function __construct(
		private readonly UserRepoInterface $repo,
		private readonly Factory $validator,
	) {
	}

	/**
	 * @throws \Application\Common\Core\Exceptions\InvalidValueException
	 * @throws \Illuminate\Validation\ValidationException
	 */
	public function create(array $input): User
	{
		$validator = $this->validator->make($input, [
			'name' => [
				'required',
				'string',
				'max:255',
			],
			'email' => [
				'required',
				'string',
				'email',
				'max:255',
				new UniqueUserEmailRule($this->repo),
			],
			'password' => [
				'required',
				'string',
				'min:8',
				'confirmed',
			],
		]);

		/** @var array{name: string, email: string, password: string} $validInput */
		$validInput = $validator->validate();

		return $this->repo->insert(
			new User(
				id: Str::uuid(),
				name: new UserName($validInput['name']),
				email: new UserEmail($validInput['email']),
				password: new UserPassword($validInput['password']),
			),
		);
	}
}
