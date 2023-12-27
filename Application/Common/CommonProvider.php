<?php

namespace Application\Common;

use Application\Common\IO\Config\DatabaseConfig;
use Application\Common\IO\Config\DatabaseConfigInterface;
use Carbon\CarbonImmutable;
use Carbon\CarbonInterface;
use Illuminate\Support\ServiceProvider;

class CommonProvider extends ServiceProvider
{
	public function register(): void
	{
		$this->app->bind(
			DatabaseConfigInterface::class,
			DatabaseConfig::class,
		);

		$this->app->bind(
			CarbonInterface::class,
			CarbonImmutable::class,
		);
	}

    public function boot(): void
    {
        $this->loadViewsFrom(__DIR__ . '/UI/Views', 'common');
    }
}
