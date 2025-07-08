<?php

namespace GoDaddy\Exceptions;

use Exception;
use Throwable;

abstract class ServiceException extends Exception
{
    public function __construct(
        string $message = 'An error occurred while interacting with the service.',
        int $code = 0,
        ?Throwable $previous = null
    ) {
        parent::__construct($message, $code, $previous);
    }
}