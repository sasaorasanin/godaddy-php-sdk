<?php

namespace GoDaddy\Services\Subscriptions\v1\Exceptions;

use GoDaddy\Services\Subscriptions\v1\Exceptions\SubscriptionException;
use GoDaddy\Support\ErrorCode;
use Throwable;

class SubscriptionProductGroupsFetchException extends SubscriptionException
{
    public function __construct(
        string $message = 'Failed to fetch subscription product groups.',
        ErrorCode $code = ErrorCode::SUBSCRIPTION_PRODUCT_GROUPS_FETCH_FAILED,
        ?Throwable $previous = null
    ) {
        parent::__construct($message, $code, $previous);
    }
}