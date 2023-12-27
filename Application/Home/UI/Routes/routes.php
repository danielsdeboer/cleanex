<?php

use Application\Home\UI\Handlers\HomeIndexHandler;
use Illuminate\Support\Facades\Route;

Route::get('/', HomeIndexHandler::class)->name('home::index');
