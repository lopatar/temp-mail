<?php
declare(strict_types=1);

namespace app\controllers;

use app\models\mail_account;
use sdk\http\request;
use sdk\http\response;
use sdk\interfaces\controller;
use sdk\render\view;

final class main implements controller
{
	public static function render(request $request, response $response, array $args): response
	{
		$view = new view('main.html');
		$response->get_body()->set_view($view);
		return $response;
	}

	public static function handle(request $request, response $response, array $args): response
	{
		$account = mail_account::generate();
		return $response;
	}
}