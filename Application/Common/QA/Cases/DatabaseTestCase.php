<?php

namespace Application\Common\QA\Cases;

use Application\Common\IO\Config\DatabaseConfig;
use Application\Common\IO\Config\DatabaseConfigInterface;
use Faker\Factory;
use Faker\Generator;
use Illuminate\Contracts\Console\Kernel as ConsoleKernelInterface;
use Illuminate\Database\Connection;
use Illuminate\Database\DatabaseManager;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase;

abstract class DatabaseTestCase extends TestCase
{
	use RefreshDatabase;

	public function createApplication(): Application
	{
		$app = require __DIR__.'/../../../../Framework/bootstrap/app.php';

		$app->make(ConsoleKernelInterface::class)->bootstrap();

		return $app;
	}

	protected function getFaker(): Generator
	{
		return Factory::create();
	}

	protected function getDatabaseConfig(): DatabaseConfigInterface
	{
		return $this->app->make(DatabaseConfigInterface::class);
	}

	protected function getDefaultConnection(): Connection
	{
		return $this->app->make(DatabaseManager::class)->connection(
			$this->getDatabaseConfig()->getDefaultConnectionName(),
		);
	}
}
