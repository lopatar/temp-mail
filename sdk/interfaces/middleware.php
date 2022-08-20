<?php
declare(strict_types=1);

namespace sdk\interfaces;

use sdk\http\response;
use sdk\http\request;

interface middleware
{
    public function execute(request $request, response $response) : response;
}
