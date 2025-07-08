<?php

namespace GoDaddy\Services\Orders\v1\Exceptions;

use GoDaddy\Exceptions\ServiceException;
use GoDaddy\Support\ErrorCode;
use Throwable;

class OrderException extends ServiceException
{
    public function __construct(
        string $message = 'An order-related error occurred.',
        ErrorCode $code = ErrorCode::ORDER_FAILED,
        ?Throwable $previous = null
    ) {
        parent::__construct($message, $code->value, $previous);
    }
}
