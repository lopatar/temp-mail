<?php
declare(strict_types=1);

namespace sdk;

use sdk\http\request;
use sdk\http\response;
use sdk\interfaces\middleware;
use sdk\render\view;
use sdk\routing\route;

final class app
{
	private request $request;
	private response $response;
	private array $routes = [];
	private array $middleware = [];
	private ?view $not_found_view = null;

	public function __construct(view $not_found_view = null)
	{
		$this->request = new request();
		$this->response = new response();

		if ($not_found_view !== null) {
			$this->not_found_view = $not_found_view;
		}
	}

	public function set_not_found_view(view $not_found_view): self
	{
		$this->not_found_view = $not_found_view;

		return $this;
	}

	public function run()
	{
		$this->run_middleware();
		$matched_route = $this->match_route();

		if ($matched_route !== null) {
			$this->response = $matched_route->execute($this->request, $this->response);
		} else {
			if ($this->not_found_view !== null) {
				$this->response->get_body()->set_view($this->not_found_view);
			}

			$this->response->set_status_code(404);
			$GLOBALS['ROUTE_PARAMS'] = [];
		}

		$this->response->send();
	}

	private function run_middleware()
	{
		foreach ($this->middleware as $middleware) {
			$this->response = $middleware->execute($this->request, $this->response);

			if (!$this->response->is_status_ok()) {
				$this->response->send();
			}
		}
	}

	private function match_route(): ?route
	{
		$matched_route = null;

		foreach ($this->routes as $route) {
			if ($route->match($this->request)) {
				$matched_route = $route;
				break;
			}
		}

		return $matched_route;
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

	public function get(string $request_uri, callable $callback): route
	{
		return $this->add_route($request_uri, ['GET'], $callback);
	}

	public function add_route(string $request_uri, array $methods, callable $callback): route
	{
		$route = new route($request_uri, $methods, $callback);
		$this->routes[] = $route;

		return $route;
	}

	public function head(string $request_uri, callable $callback): route
	{
		return $this->add_route($request_uri, ['HEAD'], $callback);
	}

	public function post(string $request_uri, callable $callback): route
	{
		return $this->add_route($request_uri, ['POST'], $callback);
	}

	public function put(string $request_uri, callable $callback): route
	{
		return $this->add_route($request_uri, ['PUT'], $callback);
	}

	public function delete(string $request_uri, callable $callback): route
	{
		return $this->add_route($request_uri, ['DELETE'], $callback);
	}
}

