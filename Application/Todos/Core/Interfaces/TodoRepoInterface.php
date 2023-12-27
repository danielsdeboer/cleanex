<?php

namespace Application\Todos\Core\Interfaces;

use Application\Todos\Core\Entities\TodoList;

interface TodoRepoInterface
{
	public function all(): TodoList;
}
