<?php

namespace Application\Todos\Core\Interfaces;

use Application\Todos\Core\Entities\Bucket;
use Application\Todos\Core\Entities\BucketList;
use Ramsey\Uuid\UuidInterface;

interface BucketRepoInterface
{
	public function all(): BucketList;

	/** @throws \Application\Common\Core\Exceptions\NotFoundInRepoException */
	public function findById(UuidInterface $id): Bucket;

	public function insert(Bucket $bucket): Bucket;
}
