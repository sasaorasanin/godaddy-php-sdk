<?php

namespace GoDaddy\Services\Certificates\v1\Exceptions;

use GoDaddy\Support\ErrorCode;
use Throwable;

class CertificateVerifyDomainException extends CertificateException
{
    public function __construct(
        string $message = 'Failed to verify domain.',
        ErrorCode $code = ErrorCode::CERTIFICATE_VERIFY_DOMAIN_FAILED,
        ?Throwable $previous = null
    ) {
        parent::__construct($message, $code, $previous);
    }
}