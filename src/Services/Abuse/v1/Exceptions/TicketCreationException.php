<?php

namespace GoDaddy\Services\Abuse\v1\Exceptions;

use GoDaddy\Support\ErrorCode;
use Throwable;

class TicketCreationException extends AbuseException
{
    public function __construct(
        string $message = 'Failed to create abuse ticket.',
        ErrorCode $code = ErrorCode::ABUSE_TICKET_CREATION_FAILED,
        ?Throwable $previous = null
    ) {
        parent::__construct($message, $code, $previous);
    }
} 