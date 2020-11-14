<?php

namespace App\Exceptions;

use Exception;
use Symfony\Component\HttpKernel\Exception\HttpException;

class ApiException extends HttpException
{
    //
    protected $data = [];
    public function __construct($message, $code = ExceptionCode::ERROR, $data = [], $statusCode = 400)
    {
        $this->data = $data;
        parent::__construct($statusCode, $message, null, [], $code);
    }
    public function getData()
    {
        return $this->data;
    }
}
