<?php

namespace GoDaddy\Services\Certificates\v1\Exceptions;

use GoDaddy\Support\ErrorCode;
use Throwable;

class CertificateCancelException extends CertificateException
{
    public function __construct(
        string $message = 'Failed to cancel certificate.',
        ErrorCode $code = ErrorCode::CERTIFICATE_CANCEL_FAILED,
        ?Throwable $previous = null
    ) {
        parent::__construct($message, $code, $previous);
    }
}