<?php

namespace GoDaddy\Services\Auctions\v1\Exceptions;

use GoDaddy\Support\ErrorCode;
use Throwable;

class PlaceBidsException extends AuctionsException
{
    public function __construct(
        string $message = 'Failed to place bids.',
        ErrorCode $code = ErrorCode::AUCTIONS_PLACE_BIDS_FAILED,
        ?Throwable $previous = null
    ) {
        parent::__construct($message, $code, $previous);
    }
} 