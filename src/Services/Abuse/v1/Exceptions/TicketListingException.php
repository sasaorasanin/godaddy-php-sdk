<?php

namespace GoDaddy\Services\Abuse\v1\Exceptions;

use GoDaddy\Support\ErrorCode;
use Throwable;

class TicketListingException extends AbuseException
{
    public function __construct(
        string $message = 'Failed to list abuse tickets.',
        ErrorCode $code = ErrorCode::ABUSE_TICKET_LIST_FAILED,
        ?Throwable $previous = null
    ) {
        parent::__construct($message, $code, $previous);
    }
} 