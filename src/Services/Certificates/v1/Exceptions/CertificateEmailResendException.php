<?php

namespace GoDaddy\Services\Certificates\v1\Exceptions;

use GoDaddy\Support\ErrorCode;
use Throwable;

class CertificateEmailResendException extends CertificateException
{
    public function __construct(
        string $message = 'Failed to resend certificate email.',
        ErrorCode $code = ErrorCode::CERTIFICATE_EMAIL_RESEND_FAILED,
        ?Throwable $previous = null
    ) {
        parent::__construct($message, $code, $previous);
    }
}