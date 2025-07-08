<?php

namespace GoDaddy\Services\Certificates\v1\Exceptions;

use GoDaddy\Support\ErrorCode;
use Throwable;

class CertificateCreationException extends CertificateException
{
    public function __construct(
        string $message = 'Failed to create certificate.',
        ErrorCode $code = ErrorCode::CERTIFICATE_CREATION_FAILED,
        ?Throwable $previous = null
    ) {
        parent::__construct($message, $code, $previous);
    }
}