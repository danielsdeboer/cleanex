<?php

namespace Application\Common\QA\Fixtures;

use Application\Common\IO\Config\DatabaseConfigInterface;
use Application\Common\IO\Config\TableNameEnum;
use Carbon\CarbonInterface;
use Faker\Generator;
use Illuminate\Database\ConnectionInterface;
use Illuminate\Database\ConnectionResolverInterface;
use Illuminate\Database\Query\Builder;

abstract class DatabaseFixtureAbstract
{
	public function __construct(
		protected readonly ConnectionResolverInterface $connectionResolver,
		protected readonly DatabaseConfigInterface $databaseConfig,
		private readonly Generator $faker,
		private readonly CarbonInterface $carbon,
	)
	{

	}

	abstract protected function provideTableName(): TableNameEnum;

	protected function provideConnectionName(): string
	{
		return $this->databaseConfig->getDefaultConnectionName();
	}

	protected function getFaker(): Generator
	{
		return $this->faker;
	}

	protected function getCarbon(): CarbonInterface
	{
		return $this->carbon->copy();
	}

	protected function getConnection(): ConnectionInterface
	{
		return $this->connectionResolver->connection(
			$this->provideConnectionName(),
		);
	}

	protected function getQuery(): Builder
	{
		return $this->getConnection()->table($this->provideTableName()->value);
	}
}
