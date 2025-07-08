<?php

namespace GoDaddy\Services\Aftermarket\v1\Exceptions;

use GoDaddy\Support\ErrorCode;
use Throwable;

class CreateExpiryListingsException extends AftermarketException
{
    public function __construct(
        string $message = 'Failed to create expiry listings.',
        ErrorCode $code = ErrorCode::AFTERMARKET_LISTINGS_CREATE_FAILED,
        ?Throwable $previous = null
    ) {
        parent::__construct($message, $code, $previous);
    }
}
