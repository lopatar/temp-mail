<?php
declare(strict_types=1);

namespace app;

abstract class utils
{
	const ALPHABET = 'abcdefghilkmnopqrstuvwxyz';
	const ALPHABET_LENGTH = 25;

	public static function random_string(int $length): string
	{
		if ($length < 2) {
			$length = 2;
		}

		$string = '';

		for ($i = 0; $i < $length; $i++) {
			$string .= self::ALPHABET[random_int(0, self::ALPHABET_LENGTH - 1)];
		}

		return $string;
	}

	public static function run_sys_command(string $command): array
	{
		$command .= ' 2>&1';

		$output = [];
		exec($command, $output);
		return $output;
	}
}