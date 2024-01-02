<?php

namespace Application\Todos\Core\Entities;

use Application\Todos\Core\Values\TodoName;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;
use stdClass;

class Todo
{
	public function __construct(
		/** @phpstan-ignore-next-line  */
		private UuidInterface $id,
		/** @phpstan-ignore-next-line  */
		private TodoName $name,
	) {
	}

	/**
	 * @throws \Application\Common\Core\Exceptions\InvalidValueException
	 */
	public static function fromDb(stdClass $record): self
	{
		return new self(
			Uuid::fromString($record->id),
			new TodoName($record->name),
		);
	}
}
