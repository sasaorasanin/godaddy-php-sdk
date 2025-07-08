<?php

namespace GoDaddy\Services\Shoppers\v1\Exceptions;

use GoDaddy\Support\ErrorCode;
use Throwable;

class ShopperStatusFetchException extends ShopperException
{
    public function __construct(
        string $message = 'Failed to fetch shopper status.',
        ErrorCode $code = ErrorCode::SHOPPER_STATUS_FETCH_FAILED,
        ?Throwable $previous = null
    ) {
        parent::__construct($message, $code, $previous);
    }
}