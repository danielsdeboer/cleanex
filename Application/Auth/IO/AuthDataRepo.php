<?php

namespace Application\Auth\IO;

use Application\Auth\Core\Data\RawAuthenticationData;
use Application\Auth\Core\Interfaces\AuthDataRepoInterface;
use Illuminate\Http\Request;

class AuthDataRepo implements AuthDataRepoInterface
{
	public function __construct(private readonly Request $request)
	{
	}

	public function getRawAuthData(): RawAuthenticationData
	{
		return new RawAuthenticationData(
			(string) $this->request->input('email'),
			(string) $this->request->input('password'),
		);
	}
}
