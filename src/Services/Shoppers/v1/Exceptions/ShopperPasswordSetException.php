<?php

namespace GoDaddy\Services\Shoppers\v1\Exceptions;

use GoDaddy\Support\ErrorCode;
use Throwable;

class ShopperPasswordSetException extends ShopperException
{
    public function __construct(
        string $message = 'Failed to set shopper password.',
        ErrorCode $code = ErrorCode::SHOPPER_PASSWORD_SET_FAILED,
        ?Throwable $previous = null
    ) {
        parent::__construct($message, $code, $previous);
    }
}