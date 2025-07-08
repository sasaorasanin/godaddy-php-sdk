<?php

namespace GoDaddy\Services\Certificates\v1\Exceptions;

use GoDaddy\Support\ErrorCode;
use Throwable;

class CertificateEmailSpecificResendException extends CertificateException
{
    public function __construct(
        string $message = 'Failed to resend email to specific address.',
        ErrorCode $code = ErrorCode::CERTIFICATE_EMAIL_SPECIFIC_RESEND_FAILED,
        ?Throwable $previous = null
    ) {
        parent::__construct($message, $code, $previous);
    }
}