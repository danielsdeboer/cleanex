<?php

namespace Application\Todos\Core\Entities;

use Application\Todos\Core\Values\BucketName;
use Illuminate\Support\Str;
use Ramsey\Uuid\UuidInterface;

class Bucket
{
	public function __construct(
		private UuidInterface $id,
		private BucketName $name,
	) {
	}

	/**
	 * @param array<string, mixed> $validated
	 * @throws \Application\Common\Core\Exceptions\InvalidValueException
	 */
	public static function fromValidated(array $validated): self
	{
		return new self(
			id: Str::uuid(),
			name: new BucketName($validated['name']),
		);
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
