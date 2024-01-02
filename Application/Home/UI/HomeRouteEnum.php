<?php

namespace Application\Home\UI;

use Application\Common\UI\ModuleEnum;
use Application\Common\UI\NameProviderInterface;

enum HomeRouteEnum: string implements NameProviderInterface
{
	case HomeIndex = 'home.index';

	public function name(): string
	{
		return ModuleEnum::Home->addPrefixTo($this->value);
	}
}
