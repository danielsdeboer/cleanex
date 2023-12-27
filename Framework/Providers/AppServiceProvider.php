<?php

namespace Framework\Providers;

use Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
	public function register(): void
	{
		if ($this->app->isLocal() && $this->app->runningInConsole()) {
			$this->app->register(IdeHelperServiceProvider::class);
		}
	}
}
