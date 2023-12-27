<?php

namespace Application\Todos\IO;

use Application\Todos\Core\Entities\Todo;
use Application\Todos\Core\Entities\TodoList;
use Application\Todos\Core\Interfaces\TodoRepoInterface;
use Application\Todos\Core\Values\TodoName;
use Illuminate\Database\DatabaseManager;
use Illuminate\Database\Query\Builder;
use Ramsey\Uuid\Uuid;
use stdClass;

class TodoRepo implements TodoRepoInterface
{
	public function __construct(private readonly DatabaseManager $db)
	{
	}

	public function all(): TodoList
	{
		$todos = $this->query()->get()->map(
			fn (stdClass $record) => new Todo(
				Uuid::fromString($record->uuid),
				new TodoName($record->name),
			),
		);

		return new TodoList(...$todos);
	}

	private function query(): Builder
	{
		return $this->db->table('todos');
	}
}
