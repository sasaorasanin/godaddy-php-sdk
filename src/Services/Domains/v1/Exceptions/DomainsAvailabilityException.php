<?php

namespace GoDaddy\Services\Domains\v1\Exceptions;

use GoDaddy\Exceptions\ServiceException;

class DomainsAvailabilityException extends ServiceException
{
    public function __construct(string $message = 'Failed to check domain availability', int $code = 0, ?\Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
} 