<?php

namespace GoDaddy\Services\Auctions\v1\Exceptions;

use Exception;
use GoDaddy\Support\ErrorCode;
use Throwable;

class AuctionsException extends Exception
{
    public function __construct(
        string $message = 'An auctions-related error occurred.',
        ErrorCode $code = ErrorCode::AUCTIONS_PLACE_BIDS_FAILED,
        ?Throwable $previous = null
    ) {
        parent::__construct($message, $code->value, $previous);
    }
} 