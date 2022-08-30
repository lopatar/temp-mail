<?php
declare(strict_types=1);

namespace app\database;

use Exception;

abstract class connection
{
	private static ?mysqli_wrapper $connection;

	public static function init(string $host, string $username, string $password, string $db): void
	{
		self::$connection = new mysqli_wrapper($host, $username, $password, $db);
	}

	/**
	 * @throws Exception
	 */
	public static function get(): mysqli_wrapper
	{
		if (self::$connection === null) {
			throw new Exception('Cannot get connection before calling init()');
		}

		return self::$connection;
	}
}