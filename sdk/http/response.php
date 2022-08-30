<?php
declare(strict_types=1);

namespace sdk\http;

final class response
{
	private array $headers = [];
	private response_body $response_body;
	private int $status_code = 200;

	public function __construct()
	{
		$this->response_body = new response_body();
	}

	public function get_status_code(): int
	{
		return $this->status_code;
	}

	public function set_status_code(int $code): self
	{
		$this->status_code = $code;

		return $this;
	}

	public function add_header(string $name, string $value): self
	{
		$this->headers[] = "$name: $value";

		return $this;
	}

	public function add_header_full(string $header): self
	{
		$this->headers[] = $header;

		return $this;
	}

	public function add_headers(array $headers): self
	{
		foreach ($headers as $header) {
			if (is_array($header)) {
				$this->headers[] = "$header[0]: $header[1]";
			} else {
				$this->headers[] = $header;
			}
		}

		return $this;
	}

	public function is_status_ok(): bool
	{
		return $this->status_code === 200;
	}

	public function get_body(): response_body
	{
		return $this->response_body;
	}

	public function send()
	{
		http_response_code($this->status_code);

		foreach ($this->headers as $header) {
			header($header);
		}

		$this->response_body->render();

		die();
	}
}