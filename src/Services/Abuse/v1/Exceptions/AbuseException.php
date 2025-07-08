<?php

namespace GoDaddy\Services\Abuse\v1\Exceptions;

use Exception;
use GoDaddy\Support\ErrorCode;
use Throwable;

class AbuseException extends Exception
{
    public function __construct(
        string $message = 'An abuse-related error occurred.',
        ErrorCode $code = ErrorCode::ABUSE_TICKET_FAILED,
        ?Throwable $previous = null
    ) {
        parent::__construct($message, $code->value, $previous);
    }
}
