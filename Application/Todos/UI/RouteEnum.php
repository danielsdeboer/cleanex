<?php

namespace Application\Todos\UI;

use Application\Common\UI\ModuleEnum;
use Application\Common\UI\NameProviderInterface;

// In this module, the routes and views have the same prefix and structure, so
// we'll use this enumeration for both.
enum RouteEnum: string implements NameProviderInterface
{
	case BucketIndex = 'buckets.index';
	case BucketCreate = 'buckets.create';
	case BucketStore = 'buckets.store';
	case BucketShow = 'buckets.show';

	case TodoCreate = 'todos.create';
	case TodoStore = 'todos.store';

	public function name(): string
	{
		return ModuleEnum::Todos->addPrefixTo($this->value);
	}
}
