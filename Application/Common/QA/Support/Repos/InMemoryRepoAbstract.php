<?php

namespace Application\Common\QA\Support\Repos;

use Closure;
use Faker\Generator;

/**
 * @template T of \Application\Common\Core\Collections\BaseList
 */
abstract class InMemoryRepoAbstract
{
	/** @var T|null  */
	private static mixed $entityCache = null;

	public function __construct(protected readonly Generator $faker)
	{
	}

	/** @return T */
	abstract protected function newCache();

	/** @return T */
	public function getCache()
	{
		if (self::$entityCache === null) {
			self::$entityCache = $this->newCache();
		}

		return self::$entityCache;
	}

	/** @return T */
	public function whenCacheIsEmpty(Closure $procedure)
	{
		if ($this->getCache()->isEmpty()) {
			$procedure();
		}

		return $this->getCache();
	}
}
