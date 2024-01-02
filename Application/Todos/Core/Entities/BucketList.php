<?php

namespace Application\Todos\Core\Entities;

use Application\Common\Core\Collections\BaseList;
use Application\Common\Core\Exceptions\NotFoundInCollectionException;
use Ramsey\Uuid\UuidInterface;

/** @extends BaseList<Bucket> */
class BucketList extends BaseList
{
	public function __construct(Bucket ...$items)
	{
		$this->items = array_values($items);
	}

	/**
	 * @throws \Application\Common\Core\Exceptions\NotFoundInCollectionException
	 */
	public function find(UuidInterface $id): Bucket
	{
		/** @var \Application\Todos\Core\Entities\Bucket $item */
		foreach ($this->items as $item) {
			if ($item->getId()->equals($id)) {
				return $item;
			}
		}

		throw new NotFoundInCollectionException(
			sprintf("Could not find a Bucket with the ID %s.", $id->toString()),
		);
	}
}
