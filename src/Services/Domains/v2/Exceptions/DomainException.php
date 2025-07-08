<?php

namespace GoDaddy\Services\Domains\Exceptions;

use Exception;
use GoDaddy\Support\ErrorCode;
use Throwable;

class DomainException extends Exception
{
    public function __construct(
        string $message = 'An domain-related error occurred.',
        ErrorCode $code = ErrorCode::DOMAIN_FAILED,
        ?Throwable $previous = null
    ) {
        parent::__construct($message, $code->value, $previous);
    }
}
