<?php

use Application\Common\UI\Routing\HandlerRegistrar;
use Application\Todos\UI\Handlers\BucketCreateHandler;
use Application\Todos\UI\Handlers\BucketIndexHandler;
use Application\Todos\UI\Handlers\BucketShowHandler;
use Application\Todos\UI\Handlers\BucketStoreHandler;
use Application\Todos\UI\Handlers\TodoCreateHandler;
use Application\Todos\UI\RouteEnum;

/** @var HandlerRegistrar $registrar */
$registrar = resolve(HandlerRegistrar::class);

// Buckets //

$registrar->addGet(
	uri: '/buckets',
	handler: BucketIndexHandler::class,
	name: RouteEnum::BucketIndex
);

$registrar->addGet(
	uri: '/buckets/create',
	handler: BucketCreateHandler::class,
	name: RouteEnum::BucketCreate,
);

$registrar->addGet(
	uri: '/buckets/{bucketId}',
	handler: BucketShowHandler::class,
	name: RouteEnum::BucketShow,
);

$registrar->addPost(
	uri: '/buckets',
	handler: BucketStoreHandler::class,
	name: RouteEnum::BucketStore,
);

// Todos //

$registrar->addGet(
	uri: '/buckets/{bucketId}/todos/create',
	handler: TodoCreateHandler::class,
	name: RouteEnum::TodoCreate,
);

$registrar->addPost(
	uri: '/buckets/{bucketId}/todos/create',
	handler: TodoCreateHandler::class,
	name: RouteEnum::TodoStore,
);
