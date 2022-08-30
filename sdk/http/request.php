<?php
declare(strict_types=1);

namespace sdk\http;

final class request
{
	private string $uri;
	private string $path;
	private string $method;
	private array $post_array;
	private array $get_array;
	private array $server_array;
	private array $cookie_array;
	private array $headers;
	private bool $is_https;

	public function __construct()
	{
		$this->post_array = $_POST;
		$this->get_array = $_GET;
		$this->server_array = $_SERVER;
		$this->cookie_array = $_COOKIE;
		$this->headers = getallheaders();
		$this->method = $this->get_server_var('REQUEST_METHOD');
		$this->is_https = $this->get_server_var('REQUEST_SCHEME') === 'https';
		$this->uri = $this->get_server_var('REQUEST_URI');
		$this->path = explode('?', $this->uri)[0];
	}

	public function get_server_var(string $key)
	{
		return $this->server_array[$key] ?? null;
	}

	public function get_uri(): string
	{
		return $this->uri;
	}

	public function get_path(): string
	{
		return $this->path;
	}

	public function is_https(): bool
	{
		return $this->is_https;
	}

	public function get_method(): string
	{
		return $this->method;
	}

	public function get_post(string $key)
	{
		return $this->post_array[$key] ?? null;
	}

	public function get_get(string $key)
	{
		return $this->get_array[$key] ?? null;
	}

	public function get_header(string $key)
	{
		return $this->headers[$key] ?? null;
	}

	public function get_headers(): array
	{
		return $this->headers;
	}

	public function get_cookie(string $key)
	{
		return $this->cookie_array[$key] ?? null;
	}
}