<?php

namespace GoDaddy\Exceptions;

use Throwable;

class ForbiddenException extends ServiceException
{
    public function __construct(
        string $message = 'Forbidden.',
        int $code = 403,
        ?Throwable $previous = null
    ) {
        parent::__construct($message, $code, $previous);
    }
}
