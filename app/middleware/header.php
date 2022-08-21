<?php
declare(strict_types=1);

namespace app\middleware;

use sdk\http\request;
use sdk\http\response;
use sdk\interfaces\middleware;
use sdk\render\view;

final class header implements middleware
{
	public function execute(request $request, response $response): response
	{
		(new view('header.html'))->render();
		return $response;
	}
}