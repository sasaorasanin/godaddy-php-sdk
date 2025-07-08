<?php

namespace GoDaddy\Services\Aftermarket\v1\Exceptions;

use Exception;
use GoDaddy\Support\ErrorCode;
use Throwable;

class AftermarketException extends Exception
{
    public function __construct(
        string $message = 'An aftermarket-related error occurred.',
        ErrorCode $code = ErrorCode::AFTERMARKET_FAILED,
        ?Throwable $previous = null
    ) {
        parent::__construct($message, $code, $previous);
    }
}
