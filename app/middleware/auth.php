<?php
declare(strict_types=1);

namespace app\middleware;

use app\config;
use app\models\http_basic_auth_header;
use InvalidArgumentException;
use sdk\http\request;
use sdk\http\response;
use sdk\interfaces\middleware;

final class auth implements middleware
{
	public function execute(request $request, response $response): response
	{
		if (!config::AUTH_ENABLED) {
			return $response;
		}

		$header = $request->get_header('Authorization');

		if ($header === null)
		{
			return $this->get_401_response($response);
		}

		try {
			$header = new http_basic_auth_header($header);

			foreach (config::AUTH_USERS as $user) {
				if ($header->validate_credentials($user[0], $user[1])) {
					return $response; //VALIDATED
				}
			}
		} catch (InvalidArgumentException $ex)
		{
			$response->set_status_code(403);
			return $response;
		}

		return $this->get_401_response($response);
	}

	private function get_401_response(response $response): response
	{
		$response->set_status_code(401);
		$response->add_header('WWW-Authenticate', 'Basic realm="Authorization required"');
		return $response;
	}
}
