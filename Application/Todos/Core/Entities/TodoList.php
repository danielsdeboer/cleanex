<?php

namespace Application\Todos\Core\Entities;

use Application\Common\Core\Collections\BaseList;
use Application\Todos\Core\Entities\Todo;

/** @extends \Application\Common\Core\Collections\BaseList<\Application\Todos\Core\Entities\Todo> */
class TodoList extends BaseList
{
	public function __construct(Todo ...$items)
	{
		$this->items = $items;
	}
}
