<?php

namespace GoDaddy\Services\Shoppers\v1\Exceptions;

use GoDaddy\Exceptions\ServiceException;
use GoDaddy\Support\ErrorCode;
use Throwable;

class ShopperException extends ServiceException
{
    public function __construct(
        string $message = 'An shopper-related error occurred.',
        ErrorCode $code = ErrorCode::SHOPPER_FAILED,
        ?Throwable $previous = null
    ) {
        parent::__construct($message, $code->value, $previous);
    }
}
