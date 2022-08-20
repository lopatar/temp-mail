<?php

namespace sdk\interfaces;

use sdk\http\request;
use sdk\http\response;

interface controller
{
    public static function render(request $request, response $response, array $args): response;
    public static function handle(request $request, response $response, array $args): response;
}