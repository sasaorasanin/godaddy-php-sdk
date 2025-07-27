<?php

namespace GoDaddy\Services\Domains\v2\Exceptions;

use Exception;

class DomainRenewException extends Exception
{
    public function __construct(string $message = '', int $code = 0, ?Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
} 