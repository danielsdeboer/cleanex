<?php

namespace Application\Home\UI\Handlers;

use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;

class HomeIndexHandler
{
	public function __construct(private readonly Factory $view)
	{
	}

	public function __invoke(): View
	{
		return $this->view->make('home::index');
	}
}
