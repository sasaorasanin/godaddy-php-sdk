<?php

namespace GoDaddy\Services\Subscriptions\v1\Exceptions;

use GoDaddy\Services\Subscriptions\v1\Exceptions\SubscriptionException;
use GoDaddy\Support\ErrorCode;
use Throwable;

class SubscriptionCancelException extends SubscriptionException
{
    public function __construct(
        string $message = 'Failed to cancel subscription.',
        ErrorCode $code = ErrorCode::SUBSCRIPTION_CANCEL_FAILED,
        ?Throwable $previous = null
    ) {
        parent::__construct($message, $code, $previous);
    }
}