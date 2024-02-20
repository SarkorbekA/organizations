<?php

namespace App\Exceptions;

use PHPUnit\Event\Code\Throwable;
use Exception;

class BusinessException extends Exception
{
    public function __construct(string $message = "", int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
