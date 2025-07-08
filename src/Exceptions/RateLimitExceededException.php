<?php

namespace GoDaddy\Exceptions;

use Throwable;

class RateLimitExceededException extends ServiceException
{
    public function __construct(
        string $message = 'Rate limit exceeded.',
        int $code = 429,
        ?Throwable $previous = null
    ) {
        parent::__construct($message, $code, $previous);
    }
}
