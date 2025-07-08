<?php

namespace GoDaddy\Services\Subscriptions\v1\Exceptions;

use GoDaddy\Exceptions\ServiceException;
use GoDaddy\Support\ErrorCode;
use Throwable;

class SubscriptionException extends ServiceException
{
    public function __construct(
        string $message = 'An subscription-related error occurred.',
        ErrorCode $code = ErrorCode::SUBSCRIPTION_FAILED,
        ?Throwable $previous = null
    ) {
        parent::__construct($message, $code->value, $previous);
    }
}
