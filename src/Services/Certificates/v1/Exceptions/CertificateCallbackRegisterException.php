<?php

namespace GoDaddy\Services\Certificates\v1\Exceptions;

use GoDaddy\Support\ErrorCode;
use Throwable;

class CertificateCallbackRegisterException extends CertificateException
{
    public function __construct(
        string $message = 'Failed to register/replace certificate callback.',
        ErrorCode $code = ErrorCode::CERTIFICATE_CALLBACK_REGISTER_FAILED,
        ?Throwable $previous = null
    ) {
        parent::__construct($message, $code, $previous);
    }
}