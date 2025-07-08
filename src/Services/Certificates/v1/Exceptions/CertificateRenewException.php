<?php

namespace GoDaddy\Services\Certificates\v1\Exceptions;

use GoDaddy\Support\ErrorCode;
use Throwable;

class CertificateRenewException extends CertificateException
{
    public function __construct(
        string $message = 'Failed to renew certificate.',
        ErrorCode $code = ErrorCode::CERTIFICATE_RENEW_FAILED,
        ?Throwable $previous = null
    ) {
        parent::__construct($message, $code, $previous);
    }
}