<?php
declare(strict_types=1);

namespace app;

abstract class utils
{
	public static function random_string(int $length): string
	{
		if ($length < 2)
		{
			$length = 2;
		}

		return bin2hex(openssl_random_pseudo_bytes($length / 2));
	}
}