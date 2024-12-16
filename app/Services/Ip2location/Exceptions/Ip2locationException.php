<?php

namespace App\Services\Ip2location\Exceptions;

use Exception;
use Illuminate\Http\Client\Response;

class Ip2locationException extends Exception
{
    public function __construct(Response $response)
    {
        parent::__construct($response->json('error.error_message'));
    }
}
