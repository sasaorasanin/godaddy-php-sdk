<?php

namespace GoDaddy\Services\Certificates\v1\Exceptions;

use GoDaddy\Support\ErrorCode;
use Throwable;

class CertificateValidationException extends CertificateException
{
    public function __construct(
        string $message = 'Failed to validate certificate.',
        ErrorCode $code = ErrorCode::CERTIFICATE_VALIDATION_FAILED,
        ?Throwable $previous = null
    ) {
        parent::__construct($message, $code, $previous);
    }
}
