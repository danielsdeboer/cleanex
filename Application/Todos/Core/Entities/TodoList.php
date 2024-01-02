<?php

namespace Application\Todos\Core\Entities;

use Application\Common\Core\Collections\BaseList;

/** @extends BaseList<Todo> */
class TodoList extends BaseList
{
	public function __construct(Todo ...$items)
	{
		$this->items = array_values($items);
	}
}
