<?php

namespace GoDaddy\Services\Certificates\v1\Exceptions;

use GoDaddy\Support\ErrorCode;
use Throwable;

class CertificateAlternateEmailException extends CertificateException
{
    public function __construct(
        string $message = 'Failed to add alternate email and resend.',
        ErrorCode $code = ErrorCode::CERTIFICATE_ALTERNATE_EMAIL_FAILED,
        ?Throwable $previous = null
    ) {
        parent::__construct($message, $code, $previous);
    }
}