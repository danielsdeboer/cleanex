<?php

namespace Application\Auth;

use Application\Auth\Core\Interfaces\AuthDataRepoInterface;
use Application\Auth\Core\Interfaces\UserRepoInterface;
use Application\Auth\Core\Services\AuthenticationService;
use Application\Auth\Core\Services\UserUpdateService;
use Application\Auth\IO\AuthDataRepo;
use Application\Auth\IO\UserRepo;
use Application\Auth\UI\RouteEnum;
use Application\Common\UI\Routing\ViewFactory;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Laravel\Fortify\Fortify;
use Laravel\Fortify\FortifyServiceProvider;

class AuthProvider extends ServiceProvider
{
	public function register(): void
	{
		$this->app->bind(UserRepoInterface::class, UserRepo::class);
		$this->app->bind(AuthDataRepoInterface::class, AuthDataRepo::class);
	}

	public function boot(
		AuthenticationService $authenticationService,
		ViewFactory $viewFactory,
	): void
	{
		$this->loadViewsFrom(__DIR__ . '/UI/Views', 'auth');

		$this->app->register(FortifyServiceProvider::class);

		// Fortify Features //

		Fortify::createUsersUsing(UserUpdateService::class);
		Fortify::authenticateUsing($authenticationService);

		// Fortify Views //

		Fortify::loginView(
			fn () => $viewFactory->make(RouteEnum::LoginCreate),
		);

		Fortify::registerView(
			fn () => $viewFactory->make(RouteEnum::RegisterCreate),
		);

		// Fortify::updateUserProfileInformationUsing(UpdateUserProfileInformation::class);
		// Fortify::updateUserPasswordsUsing(UpdateUserPassword::class);
		// Fortify::resetUserPasswordsUsing(ResetUserPassword::class);

		RateLimiter::for('login', function (Request $request) {
			if ($this->app->isLocal()) {
				return Limit::none();
			}

			$asciiUserName = Str::transliterate(
				$request->input(Fortify::username()),
			);

			$throttleKey = Str::lower($asciiUserName.'|'.$request->ip());

			return Limit::perMinute(5)->by($throttleKey);
		});

		//
		// RateLimiter::for('two-factor', function (Request $request) {
		// 	return Limit::perMinute(5)->by($request->session()->get('login.id'));
		// });
	}
}
