<?php

namespace Application\Common\IO\Config;

use Illuminate\Database\ConnectionInterface;
use Illuminate\Database\Query\Builder;

interface ConnectionResolverInterface
{
	public function getConnection(): ConnectionInterface;
	public function getBuilder(TableNameEnum $tableName): Builder;
}
