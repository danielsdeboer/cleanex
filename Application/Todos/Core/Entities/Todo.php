<?php

namespace Application\Todos\Core\Entities;

use Application\Todos\Core\Values\TodoName;
use Ramsey\Uuid\UuidInterface;

class Todo
{
	public function __construct(
		private UuidInterface $id,
		private TodoName $name,
	) {
	}
}
