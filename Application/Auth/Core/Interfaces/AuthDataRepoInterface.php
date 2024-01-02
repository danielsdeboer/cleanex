<?php

namespace Application\Auth\Core\Interfaces;

use Application\Auth\Core\Data\RawAuthenticationData;

interface AuthDataRepoInterface
{
	public function getRawAuthData(): RawAuthenticationData;
}
