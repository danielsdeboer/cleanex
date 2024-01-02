<?php

namespace Application\Todos\QA\Support\DataProviders;

use Application\Common\QA\Support\Validation\ValidationData;
use Application\Common\QA\Support\Validation\ValidationIterator;

final class BucketStoreDataProvider
{
	public static function validationProvider(): ValidationIterator
	{
		return new ValidationIterator(
			ValidationData::required('name'),
			ValidationData::string('name'),
			ValidationData::maxLength('name', 255),
		);
	}
}
