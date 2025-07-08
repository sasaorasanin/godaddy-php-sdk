<?php

namespace GoDaddy\Services\Abuse\v2\Exceptions;

use GoDaddy\Support\ErrorCode;
use Throwable;

class TicketRetrievalException extends AbuseException
{
    public function __construct(
        string $message = 'Failed to retrieve abuse ticket.',
        ErrorCode $code = ErrorCode::ABUSE_TICKET_RETRIEVE_FAILED,
        ?Throwable $previous = null
    ) {
        parent::__construct($message, $code, $previous);
    }
}
