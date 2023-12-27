<?php

namespace Application\Todos\Core\Entities;

use Application\Todos\Core\Values\BucketName;
use Ramsey\Uuid\UuidInterface;

class Bucket
{
	public function __construct(
		private UuidInterface $id,
		private BucketName $name,
	) {
	}

	public function getId(): UuidInterface
	{
		return $this->id;
	}

	public function getName(): BucketName
	{
		return $this->name;
	}
}
