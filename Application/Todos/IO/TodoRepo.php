<?php

namespace Application\Todos\IO;

use Application\Todos\Core\Entities\Todo;
use Application\Todos\Core\Entities\TodoList;
use Application\Todos\Core\Interfaces\TodoRepoInterface;
use Illuminate\Database\DatabaseManager;
use Illuminate\Database\Query\Builder;
use Ramsey\Uuid\UuidInterface;

class TodoRepo implements TodoRepoInterface
{
	public function __construct(private readonly DatabaseManager $db)
	{
	}

	public function all(): TodoList
	{
		return new TodoList(
			...$this->query()->get()->map([Todo::class, 'fromDb']),
		);
	}

	public function allInBucket(UuidInterface $bucketId): TodoList
	{
		return new TodoList(
			...$this->query()
				->where('bucket_id', $bucketId->toString())
				->get()
				->map([Todo::class, 'fromDb']),
		);
	}

	// Internals //

	private function query(): Builder
	{
		return $this->db->table('todos');
	}
}
