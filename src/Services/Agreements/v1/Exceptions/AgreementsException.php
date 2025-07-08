<?php

namespace GoDaddy\Services\Agreements\v1\Exceptions;

use Exception;
use GoDaddy\Support\ErrorCode;
use Throwable;

class AgreementsException extends Exception
{
    public function __construct(
        string $message = 'An agreements-related error occurred.',
        ErrorCode $code = ErrorCode::AGREEMENTS_GET_FAILED,
        ?Throwable $previous = null
    ) {
        parent::__construct($message, $code->value, $previous);
    }
}
