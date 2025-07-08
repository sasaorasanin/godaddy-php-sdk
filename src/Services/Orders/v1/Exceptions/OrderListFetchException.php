<?php

namespace GoDaddy\Services\Orders\v1\Exceptions;

use GoDaddy\Support\ErrorCode;
use Throwable;

class OrderListFetchException extends OrderException
{
    public function __construct(
        string $message = 'Failed to fetch order list.',
        ErrorCode $code = ErrorCode::ORDER_LIST_FETCH_FAILED,
        ?Throwable $previous = null
    ) {
        parent::__construct($message, $code, $previous);
    }
}
