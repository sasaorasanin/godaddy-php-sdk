<?php

namespace GoDaddy\Services\Certificates\v1\Exceptions;

use GoDaddy\Support\ErrorCode;
use Throwable;

class CertificateCallbackUnregisterException extends CertificateException
{
    public function __construct(
        string $message = 'Failed to unregister certificate callback.',
        ErrorCode $code = ErrorCode::CERTIFICATE_CALLBACK_UNREGISTER_FAILED,
        ?Throwable $previous = null
    ) {
        parent::__construct($message, $code, $previous);
    }
}