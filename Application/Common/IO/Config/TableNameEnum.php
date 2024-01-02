<?php

namespace Application\Common\IO\Config;

enum TableNameEnum: string
{
	case Users = 'users';
	case Buckets = 'buckets';
	case Todos = 'todos';
}
