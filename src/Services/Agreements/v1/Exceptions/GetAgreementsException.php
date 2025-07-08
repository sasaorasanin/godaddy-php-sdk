<?php

namespace GoDaddy\Services\Agreements\v1\Exceptions;

use GoDaddy\Support\ErrorCode;
use Throwable;

class GetAgreementsException extends AgreementsException
{
    public function __construct(
        string $message = 'Failed to retrieve agreements.',
        ErrorCode $code = ErrorCode::AGREEMENTS_GET_FAILED,
        ?Throwable $previous = null
    ) {
        parent::__construct($message, $code, $previous);
    }
} 