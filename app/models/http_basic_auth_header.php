<?php
declare(strict_types=1);

namespace app\models;

use InvalidArgumentException;

final class http_basic_auth_header
{
	public readonly string $username;
	public readonly string $password;

	public function __construct(public readonly string $raw_header)
	{
		$header_parts = explode(' ', $this->raw_header);

		if (count($header_parts) !== 2) //Basic B64_CREDENTIALS
		{
			throw new InvalidArgumentException('Invalid raw header data provided');
		}

		if (strtolower($header_parts[0]) !== 'basic')
		{
			throw new InvalidArgumentException('Auth type is not basic');
		}

		$credentials = base64_decode($header_parts[1]);
		$credentials = explode(':', $credentials);

		if (count($credentials) !== 2)
		{
			throw new InvalidArgumentException('Credentials not properly encoded');
		}

		$this->username = $credentials[0];
		$this->password = $credentials[1];
	}

	public function validate_credentials(string $username, string $password): bool
	{
		return $username === $this->username && $password === $this->password;
	}
}