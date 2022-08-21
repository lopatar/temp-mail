<?php
declare(strict_types=1);

namespace app;

use app\middleware\header;
use sdk\app;

abstract class routes
{
	private static header $header_middleware;

	public static function init(app $app): void
	{
		self::$header_middleware = new header;
		$app->add_middleware(self::$header_middleware);

		$app->get('/', 'app\\controllers\\main::render');
	}
}