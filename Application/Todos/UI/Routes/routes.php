<?php

use Application\Common\UI\Routing\HandlerRegistrar;
use Application\Todos\UI\Handlers\BucketCreateHandler;
use Application\Todos\UI\Handlers\BucketIndexHandler;
use Application\Todos\UI\Handlers\BucketShowHandler;
use Application\Todos\UI\Handlers\BucketStoreHandler;

$registrar = resolve(HandlerRegistrar::class);

$registrar->addGet(
	uri: '/buckets',
	handler: BucketIndexHandler::class,
	name: 'buckets::index'
);

$registrar->addGet(
	uri: '/buckets/create',
	handler: BucketCreateHandler::class,
	name: 'buckets::create',
);

$registrar->addGet(
	uri: '/buckets/{bucket}',
	handler: BucketShowHandler::class,
	name: 'buckets::show',
);

$registrar->addPost(
	uri: '/buckets',
	handler: BucketStoreHandler::class,
	name: 'buckets::store',
);
