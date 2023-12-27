<?php

namespace Application\Common\Core\Collections;

use ArrayIterator;
use Countable;
use IteratorAggregate;
use OutOfBoundsException;
use Traversable;

/**
 * @template I
 */
abstract class BaseList implements IteratorAggregate, Countable
{
	/** @var array  */
	protected array $items = [];

	/** @param I $item */
	public function put(mixed $item): void
	{
		$this->items[] = $item;
	}

	/** @return I $item */
	public function get(int $index): mixed
	{
		if (!isset($this->items[$index])) {
			throw new OutOfBoundsException(
				sprintf('Index %s is out of bounds', $index)
			);
		}

		return $this->items[$index];
	}

	public function isEmpty(): bool
	{
		return $this->count() === 0;
	}

	/** @return I $item */
	public function first(): mixed
	{
		return $this->get(0);
	}

	/** @return I $item */
	public function last(): mixed
	{
		return $this->get($this->count() - 1);
	}

	public function getIterator(): Traversable
	{
		return new ArrayIterator($this->items);
	}

	public function count(): int
	{
		return count($this->items);
	}
}
