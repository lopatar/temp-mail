<?php
declare(strict_types=1);

namespace app\models;

use app\config;
use app\database\connection;
use app\utils;

final class mail_account
{
	public function __construct(public readonly string $username, public readonly string $password, public readonly int $expires_timestamp) {}

	public static function generate(): self
	{
		$username = '';

		do {
			$username = utils::random_string(12);
		} while (self::exists($username));

		$password = utils::random_string(32);
		$expires = time() + config::MAIL_ACCOUNT_EXPIRES;

		connection::get()->query('INSERT INTO mail(username, password, expires) VALUES(?,?,?)', [$username, $password, $expires]);

		return new self($username, $password, $expires);
	}

	public static function get_all(): array
	{
		$query = connection::get()->query('SELECT username,password,expires FROM mail');
		$data = $query->fetch_all(1);
		$accounts = [];

		foreach ($data as $entry)
		{
			$accounts[] = new self($entry['username'], $entry['password'], $entry['expires']);
		}

		return $accounts;
	}

	public static function exists(string $username): bool
	{
		return connection::get()->query('SELECT id FROM email WHERE username=?', [$username])->num_rows === 1;
	}

	public function get_expires_string(): string
	{
		return date('F j, Y, g:i a', $this->expires_timestamp);
	}

	public function is_expired(): bool
	{
		return time() >= $this->expires_timestamp;
	}

	public function delete(): void
	{
		connection::get()->query('DELETE FROM email WHERE username=?', [$this->username]);
	}

	public function get_roundcube_link(): string
	{
		return config::ROUNDCUBE_LINK . '?' . config::ROUNDCUBE_USER_PARAM . "=$this->username";
	}
}