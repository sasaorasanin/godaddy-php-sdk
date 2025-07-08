<?php

namespace GoDaddy\Services\Domains\v1\Exceptions;

use GoDaddy\Exceptions\ServiceException;

class DomainsContactValidationException extends ServiceException
{
    public function __construct(string $message = 'Failed to validate domain contacts', int $code = 0, ?\Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
} 