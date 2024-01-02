<?php

namespace Application\Todos\Core\Interfaces;

use Application\Todos\Core\Entities\TodoList;
use Ramsey\Uuid\UuidInterface;

interface TodoRepoInterface
{
	public function allInBucket(UuidInterface $bucketId): TodoList;
}
