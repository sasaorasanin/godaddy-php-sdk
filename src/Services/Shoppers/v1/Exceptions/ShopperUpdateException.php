<?php

namespace GoDaddy\Services\Shoppers\v1\Exceptions;

use GoDaddy\Support\ErrorCode;
use Throwable;

class ShopperUpdateException extends ShopperException
{
    public function __construct(
        string $message = 'Failed to update shopper.',
        ErrorCode $code = ErrorCode::SHOPPER_UPDATE_FAILED,
        ?Throwable $previous = null
    ) {
        parent::__construct($message, $code, $previous);
    }
}