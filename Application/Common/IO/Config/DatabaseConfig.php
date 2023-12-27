<?php

namespace Application\Common\IO\Config;

use Illuminate\Contracts\Config\Repository;

class DatabaseConfig implements DatabaseConfigInterface
{
	public function __construct(private readonly Repository $config)
	{
	}

	public function getDefaultConnectionName(): string
	{
		return $this->config->get('database.default');
	}
}
