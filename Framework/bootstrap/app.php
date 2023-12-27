<?php

/*
|--------------------------------------------------------------------------
| Create The Application
|--------------------------------------------------------------------------
|
| The first thing we will do is create a new Laravel application instance
| which serves as the "glue" for all the components of Laravel, and is
| the IoC container for the system binding all of the various parts.
|
*/

use Framework\ConsoleKernel;
use Framework\ExceptionHandler;
use Framework\HttpKernel;
use Illuminate\Foundation\Application;

// Because we're using a non-standard directory structure, we need to add a
// macro to set the application namespace, otherwise commands like route:list
// will fail when trying to detect the namespace.
Application::macro('setNamespace', function (string $namespace) {
	/** @var \Illuminate\Foundation\Application $this */
	$this->namespace = $namespace;
});

$app = new Application($_ENV['APP_BASE_PATH'] ?? dirname(__DIR__));

// Because we're using a non-standard directory structure, we need to tell the
// framework where to find the environment file(s).
$app->useEnvironmentPath(__DIR__ . '/../../');

/** @noinspection PhpUndefinedMethodInspection */
$app->setNamespace('Application');

/*
|--------------------------------------------------------------------------
| Bind Important Interfaces
|--------------------------------------------------------------------------
|
| Next, we need to bind some important interfaces into the container so
| we will be able to resolve them when needed. The kernels serve the
| incoming requests to this application from both the web and CLI.
|
*/

$app->singleton(
    Illuminate\Contracts\Http\Kernel::class,
    HttpKernel::class,
);

$app->singleton(
    Illuminate\Contracts\Console\Kernel::class,
    ConsoleKernel::class
);

$app->singleton(
    Illuminate\Contracts\Debug\ExceptionHandler::class,
    ExceptionHandler::class
);

/*
|--------------------------------------------------------------------------
| Return The Application
|--------------------------------------------------------------------------
|
| This script returns the application instance. The instance is given to
| the calling script so we can separate the building of the instances
| from the actual running of the application and sending responses.
|
*/

return $app;
