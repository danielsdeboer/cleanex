<?php

namespace Application\Common\QA\Support\Validation;

use ArrayIterator;
use IteratorAggregate;
use Traversable;

class ValidationIterator implements IteratorAggregate
{
	private array $items;

	public function __construct(ValidationData ...$items)
	{
		// This may seem strange, but due to how PHPUnit data providers work,
		// we need to return an array, which will then be destructured into
		// the test method's arguments.
		foreach ($items as $item) {
			$this->items[$item->name] = [$item];
		}
	}

	public function getIterator(): Traversable
	{
		return new ArrayIterator($this->items);
	}
}
