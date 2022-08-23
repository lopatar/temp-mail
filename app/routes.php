<?php
declare(strict_types=1);

namespace app;

use app\middleware\auth;
use app\middleware\header;
use sdk\app;

abstract class routes
{
	private static header $header_middleware;
	private static auth $auth_middleware;

	public static function init(app $app): void
	{
		self::init_middleware();
		$app->add_middleware_array([
			self::$auth_middleware,
			self::$header_middleware
		]);

		$app->get('/', 'app\controllers\main::render');

		$app->post('/api/generate', 'app\controllers\main::handle');
	}

	private static function init_middleware(): void
	{
		self::$header_middleware = new header;
		self::$auth_middleware = new auth;
	}
}