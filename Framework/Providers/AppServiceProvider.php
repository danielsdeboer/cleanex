<?php

namespace Framework\Providers;

use Application\Auth\Core\Services\UserProviderService;
use Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider;
use Illuminate\Auth\AuthManager;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
	public function register(): void
	{
		if ($this->app->isLocal() && $this->app->runningInConsole()) {
			$this->app->register(IdeHelperServiceProvider::class);
		}
	}

	public function boot(AuthManager $auth): void
	{
		$auth->provider('entity', function (Application $app) {
			return $app->make(UserProviderService::class);
		});
	}
}
