<?php

namespace GoDaddy\Services\Aftermarket\v1\Exceptions;

use GoDaddy\Support\ErrorCode;
use Throwable;

class DeleteAuctionListingsException extends AftermarketException
{
    public function __construct(
        string $message = 'Failed to delete auction listings.',
        ErrorCode $code = ErrorCode::AFTERMARKET_LISTINGS_DELETE_FAILED,
        ?Throwable $previous = null
    ) {
        parent::__construct($message, $code, $previous);
    }
}
