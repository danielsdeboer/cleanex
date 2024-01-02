<?php

namespace Application\Common\UI;

enum ModuleEnum: string
{
	case Auth = 'auth';
	case Todos = 'todos';
	case Setup = 'setup';
	case Home = 'home';

	public function addPrefixTo(string $valueToPrefix): string
	{
		return sprintf('%s::%s', $this->value, $valueToPrefix);
	}
}
