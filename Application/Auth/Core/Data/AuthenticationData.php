<?php

namespace Application\Auth\Core\Data;

use Application\Auth\Core\Values\UserEmail;
use Application\Auth\Core\Values\UserPassword;

class AuthenticationData
{
	public function __construct(
		public readonly UserEmail $email,
		public readonly UserPassword $password,
	)
	{
	}
}
