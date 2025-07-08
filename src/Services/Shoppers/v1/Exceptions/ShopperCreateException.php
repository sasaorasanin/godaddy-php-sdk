<?php

namespace GoDaddy\Services\Shoppers\v1\Exceptions;

use GoDaddy\Support\ErrorCode;
use Throwable;

class ShopperCreateException extends ShopperException
{
    public function __construct(
        string $message = 'Failed to create shopper.',
        ErrorCode $code = ErrorCode::SHOPPER_CREATE_FAILED,
        ?Throwable $previous = null
    ) {
        parent::__construct($message, $code, $previous);
    }
}