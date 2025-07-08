<?php

namespace GoDaddy\Services\Certificates\v1\Exceptions;

use GoDaddy\Support\ErrorCode;
use Throwable;

class CertificateRevokeException extends CertificateException
{
    public function __construct(
        string $message = 'Failed to revoke certificate.',
        ErrorCode $code = ErrorCode::CERTIFICATE_REVOKE_FAILED,
        ?Throwable $previous = null
    ) {
        parent::__construct($message, $code, $previous);
    }
}