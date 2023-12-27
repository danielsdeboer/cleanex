<?php

namespace Application\Setup\UI;

use Illuminate\Console\Command;

class InstallPicoCssCommand extends Command
{
	/** @var string */
	protected $signature = 'app:setup:pico';

	/** @var string */
	protected $description = 'Copy the Pico CSS file.';

	public function handle(): int
	{
		$sourcePath = base_path('../vendor/picocss/pico/css/pico.min.css');
		$destinationPath = base_path('public/css/pico.min.css');

		if (!file_exists($sourcePath)) {
			$this->error('The Pico CSS source file is missing. Make sure you\'ve run "composer install".');

			return self::FAILURE;
		}

		if (file_exists($destinationPath)) {
			$this->line('The Pico CSS file already exists');

			return self::SUCCESS;
		}

		copy($sourcePath, $destinationPath);

		$this->info('The Pico CSS file has been copied successfully.');

		return self::SUCCESS;
	}
}
