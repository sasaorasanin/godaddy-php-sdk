<?php

namespace GoDaddy\Services\Orders\v1\Exceptions;

use GoDaddy\Support\ErrorCode;
use Throwable;

class OrderDetailsFetchException extends OrderException
{
    public function __construct(
        string $message = 'Failed to fetch order details.',
        ErrorCode $code = ErrorCode::ORDER_DETAILS_FETCH_FAILED,
        ?Throwable $previous = null
    ) {
        parent::__construct($message, $code, $previous);
    }
}
