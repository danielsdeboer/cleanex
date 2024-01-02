<?php

namespace Application\Auth\UI;

use Application\Common\UI\ModuleEnum;
use Application\Common\UI\NameProviderInterface;

// In this module, the routes and views have the same prefix and structure, so
// we'll use this enumeration for both.
enum RouteEnum: string implements NameProviderInterface
{
	case LoginCreate = 'logins.create';
	case RegisterCreate = 'registrations.create';

	public function name(): string
	{
		return ModuleEnum::Auth->addPrefixTo($this->value);
	}
}
