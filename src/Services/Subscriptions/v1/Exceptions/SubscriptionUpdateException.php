<?php

namespace GoDaddy\Services\Subscriptions\v1\Exceptions;

use GoDaddy\Services\Subscriptions\v1\Exceptions\SubscriptionException;
use GoDaddy\Support\ErrorCode;
use Throwable;

class SubscriptionUpdateException extends SubscriptionException
{
    public function __construct(
        string $message = 'Failed to update subscription.',
        ErrorCode $code = ErrorCode::SUBSCRIPTION_UPDATE_FAILED,
        ?Throwable $previous = null
    ) {
        parent::__construct($message, $code, $previous);
    }
}