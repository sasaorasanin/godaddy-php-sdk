<?php

namespace GoDaddy\Services\Aftermarket\v1\Exceptions;

use GoDaddy\Support\ErrorCode;
use Throwable;

class GetAuctionListingsException extends AftermarketException
{
    public function __construct(
        string $message = 'Failed to fetch auction listings.',
        ErrorCode $code = ErrorCode::AFTERMARKET_LISTINGS_FETCH_FAILED,
        ?Throwable $previous = null
    ) {
        parent::__construct($message, $code, $previous);
    }
}
