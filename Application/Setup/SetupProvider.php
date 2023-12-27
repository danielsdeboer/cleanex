<?php

namespace Application\Setup;

use Application\Setup\UI\InstallPicoCssCommand;
use Illuminate\Support\ServiceProvider;

class SetupProvider extends ServiceProvider
{
    public function boot(): void
    {
		$this->registerConsoleCommands();
	}

	private function registerConsoleCommands(): void
	{
		if (!$this->app->runningInConsole()) {
			return;
		}

		$this->commands([
			InstallPicoCssCommand::class,
		]);
    }

}
