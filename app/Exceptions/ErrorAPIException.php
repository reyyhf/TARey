<?php

namespace App\Exceptions;

use App\Helpers\ApiResponseTrait;
use Exception;

class ErrorAPIException extends Exception
{
    use ApiResponseTrait;

    public function __construct($message = '', $code = 0, ?Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

    public function render()
    {
        return $this->resultResponse('error', $this->message, $this->code);
    }
}
