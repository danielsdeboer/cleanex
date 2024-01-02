<?php

namespace Application\Todos\IO;

use Application\Common\Core\Exceptions\NotFoundInRepoException;
use Application\Common\IO\Config\TableNameEnum;
use Application\Todos\Core\Entities\Bucket;
use Application\Todos\Core\Entities\BucketList;
use Application\Todos\Core\Interfaces\BucketRepoInterface;
use Application\Todos\Core\Values\BucketName;
use Illuminate\Database\DatabaseManager;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Str;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;
use stdClass;

class BucketRepo implements BucketRepoInterface
{
	public function __construct(private readonly DatabaseManager $db)
	{
	}

	public function all(): BucketList
	{
		$todoLists = $this->query()->get()->map(
			fn (stdClass $record) => new Bucket(
				Uuid::fromString($record->id),
				new BucketName($record->name),
			),
		);

		return new BucketList(...$todoLists);
	}

	/**
	 * @throws \Application\Common\Core\Exceptions\NotFoundInRepoException
	 * @throws \Application\Common\Core\Exceptions\InvalidValueException
	 */
	public function findById(UuidInterface $id): Bucket
	{
		/** @var object{ id: string, name: string }|null $record */
		$record = $this->query()->where('id', $id)->first();

		if (!$record) {
			throw new NotFoundInRepoException(
				sprintf("Bucket with id %s not found in repo", $id),
			);
		}

		return new Bucket(
			Uuid::fromString($record->id),
			new BucketName($record->name),
		);
	}

	public function insert(Bucket $bucket): Bucket
	{
		$id = Str::orderedUuid();

		// We replace the temporary UUID with a real one at this step.
		$this->query()->insert([
			'id' => $id,
			'name' => $bucket->getName()->value(),
			'created_at' => now(),
			'updated_at' => now(),
		]);

		return new Bucket(
			$id,
			$bucket->getName(),
		);
	}

	// Internals //

	private function query(): Builder
	{
		return $this->db->table(TableNameEnum::Buckets->value);
	}

}
