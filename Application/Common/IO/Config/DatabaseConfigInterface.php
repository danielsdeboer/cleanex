<?php

namespace Application\Common\IO\Config;

interface DatabaseConfigInterface
{
	public function getDefaultConnectionName(): string;
}
