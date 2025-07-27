<?php

namespace GoDaddy\Services\Domains\v1\Exceptions;

use GoDaddy\Exceptions\ServiceException;

class DomainsVerifyRegistrantEmailException extends ServiceException
{
    public function __construct(string $message = 'Failed to verify registrant email', int $code = 0, ?\Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
} 