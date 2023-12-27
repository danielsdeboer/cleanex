<?php

namespace Application\Common\IO\Config;

use Illuminate\Database\ConnectionInterface;
use Illuminate\Database\ConnectionResolverInterface as LaravelConnectionResolverInterface;
use Illuminate\Database\Query\Builder;

class DefaultConnectionResolver implements ConnectionResolverInterface
{
	public function __construct(
		private readonly LaravelConnectionResolverInterface $connectionResolver,
		private readonly DatabaseConfigInterface $databaseConfig,
	)
	{
	}

	public function getConnection(): ConnectionInterface
	{
		return $this->connectionResolver->connection(
			$this->databaseConfig->getDefaultConnectionName(),
		);
	}

	public function getBuilder(TableNameEnum $tableName): Builder
	{
		return $this->getConnection()->table($tableName->value);
	}
}
