<?php

namespace Application\Auth\Core\Data;

use Application\Auth\Core\Values\UserEmail;
use Application\Auth\Core\Values\UserPassword;
use Illuminate\Contracts\Validation\Factory;

class RawAuthenticationData
{
	public function __construct(
		public readonly string $email,
		public readonly string $password,
	)
	{
	}

	/**
	 * @throws \Application\Common\Core\Exceptions\InvalidValueException
	 * @throws \Illuminate\Validation\ValidationException
	 */
	public function validate(Factory $validator): AuthenticationData
	{
		$validationData = [
			'email' => $this->email,
			'password' => $this->password,
		];

		$validationRules = [
			'email' => ['required', 'email'],
			// TODO: Add a custom rule for password validation.
			'password' => ['required', 'min:8'],
		];

		$validator
			->make($validationData, $validationRules)
			->validate();

		return new AuthenticationData(
			email: new UserEmail($this->email),
			password: new UserPassword($this->password),
		);
	}
}
