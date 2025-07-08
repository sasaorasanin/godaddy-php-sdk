<?php

namespace GoDaddy\Services\Certificates\v1\Exceptions;

use GoDaddy\Support\ErrorCode;
use Throwable;

class CertificateCallbackFetchException extends CertificateException
{
    public function __construct(
        string $message = 'Failed to fetch certificate callback.',
        ErrorCode $code = ErrorCode::CERTIFICATE_CALLBACK_FETCH_FAILED,
        ?Throwable $previous = null
    ) {
        parent::__construct($message, $code, $previous);
    }
}