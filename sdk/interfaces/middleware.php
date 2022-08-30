<?php
declare(strict_types=1);

namespace sdk\interfaces;

use sdk\http\request;
use sdk\http\response;

interface middleware
{
	public function execute(request $request, response $response): response;
}
