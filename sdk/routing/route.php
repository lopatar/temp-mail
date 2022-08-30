<?php
declare(strict_types=1);

namespace sdk\routing;

use sdk\http\request;
use sdk\http\response;
use sdk\interfaces\middleware;

final class route
{
	private string $request_uri;
	private array $request_uri_array;
	private array $request_methods;
	private array $middleware = [];
	private $callback;

	private array $extracted_parameters = [];

	public function __construct(string $request_uri, array $methods, callable $callback)
	{
		$this->request_uri = $request_uri;
		$this->request_uri_array = explode('/', $request_uri);
		$this->request_methods = $methods;
		$this->callback = $callback;
	}

	public function match(request $request): bool
	{
		if (!$this->matches_request_method($request)) {
			return false;
		}

		if ($this->has_parameters()) {
			$r_uri = explode('?', $request->get_server_var('REQUEST_URI'))[0];
			$curr_request_uri_array = explode('/', $r_uri);

			if (!$this->matches_request_uri_count($curr_request_uri_array)) {
				return false;
			}

			$parameters = $this->get_parameters();

			if (!$this->matches_parameterless_array($curr_request_uri_array, $parameters)) {
				return false;
			}

			$extracted_parameters = $this->extract_parameters($curr_request_uri_array, $parameters);

			if ($extracted_parameters === []) {
				return false;
			}

			$this->extracted_parameters = $extracted_parameters;
		} else {
			return $this->matches_request_uri($request);
		}

		return true;
	}

	private function matches_request_method(request $request): bool
	{
		return in_array($request->get_server_var('REQUEST_METHOD'), $this->request_methods);
	}

	private function has_parameters(): bool
	{
		foreach ($this->request_uri_array as $uri_part) {
			if (empty($uri_part)) {
				continue;
			}

			$end_index = strlen($uri_part) - 1;

			if ($uri_part[0] === '{' && $uri_part[$end_index] === '}') {
				return true;
			}
		}

		return false;
	}

	private function matches_request_uri_count(array $curr_request_uri_array): bool
	{
		return count($curr_request_uri_array) === count($this->request_uri_array);
	}

	private function get_parameters(): array
	{
		$parameters = [];

		for ($i = 0; $i < count($this->request_uri_array); $i++) {
			$uri_part = $this->request_uri_array[$i];

			if (empty($uri_part)) {
				continue;
			}

			$end_index = strlen($uri_part) - 1;

			if ($uri_part[0] === '{' && $uri_part[$end_index] === '}') {
				$name = str_replace(['{', '}'], '', $uri_part);
				$parameters[$name] = $i;
			}
		}

		return $parameters;
	}

	private function matches_parameterless_array(array $curr_request_uri_array, array $parameters): bool
	{
		return $this->uri_except_parameters($curr_request_uri_array, $parameters) === $this->uri_except_parameters($this->request_uri_array, $parameters);
	}

	private function uri_except_parameters(array $request_uri_array, array $parameters): string
	{
		$uri = '';

		for ($i = 0; $i < count($request_uri_array); $i++) {
			if (in_array($i, $parameters)) {
				continue;
			}

			$uri .= $request_uri_array[$i];
		}

		return $uri;
	}

	private function extract_parameters(array $curr_request_uri_array, array $parameters): array
	{
		$extracted_parameters = [];

		foreach ($parameters as $name => $index) {
			if (empty($curr_request_uri_array[$index])) {
				return [];
			}

			$extracted_parameters[$name] = $curr_request_uri_array[$index];
		}

		return $extracted_parameters;
	}

	private function matches_request_uri(request $request): bool
	{
		$request_uri = explode('?', $request->get_server_var('REQUEST_URI'))[0];
		return $request_uri === $this->request_uri;
	}

	public function add_middleware_array(array $middleware_array): self
	{
		foreach ($middleware_array as $middleware) {
			$this->add_middleware($middleware);
		}

		return $this;
	}

	public function add_middleware(middleware $middleware): self
	{
		$this->middleware[] = $middleware;

		return $this;
	}

	private function run_middleware(request $request, response $response): response
	{
		foreach ($this->middleware as $middleware) {
			$response = $middleware->execute($request, $response);

			if (!$response->is_status_ok()) {
				$response->send();
			}
		}

		return $response;
	}

	public function execute(request $request, response $response): response
	{
		$GLOBALS['ROUTE_PARAMS'] = $this->extracted_parameters;
		$response = $this->run_middleware($request, $response);
		return call_user_func_array($this->callback, [$request, $response, $this->extracted_parameters]);
	}
}