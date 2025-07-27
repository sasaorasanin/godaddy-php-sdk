<?php

namespace GoDaddy\Services\Domains\v2\Exceptions;

use GoDaddy\Exceptions\ServiceException;

class DomainsDetailsV2Exception extends ServiceException
{
    public function __construct(string $message = 'Failed to get domain details', int $code = 0, ?\Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
} 