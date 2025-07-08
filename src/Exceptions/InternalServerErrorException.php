<?php

namespace GoDaddy\Exceptions;

use Throwable;

class InternalServerErrorException extends ServiceException
{
    public function __construct(
        string $message = 'Internal server error.',
        int $code = 500,
        ?Throwable $previous = null
    ) {
        parent::__construct($message, $code, $previous);
    }
}
