<?php
/** @noinspection PhpUnhandledExceptionInspection */

namespace Application\Todos\QA\Support\Stubs;

use Application\Common\QA\Support\Repos\InMemoryRepoAbstract;
use Application\Todos\Core\Entities\TodoList;
use Application\Todos\Core\Interfaces\TodoRepoInterface;
use Ramsey\Uuid\UuidInterface;

/** @extends InMemoryRepoAbstract<TodoList> */
class TodoRepoStub extends InMemoryRepoAbstract implements TodoRepoInterface
{
	protected function newCache(): TodoList
	{
		return new TodoList();
	}


	public function allInBucket(UuidInterface $bucketId): TodoList
	{
		return new TodoList();
	}
}
