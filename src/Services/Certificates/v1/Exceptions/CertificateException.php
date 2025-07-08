<?php

namespace GoDaddy\Services\Certificates\v1\Exceptions;

use GoDaddy\Exceptions\ServiceException;
use GoDaddy\Support\ErrorCode;
use Throwable;

class CertificateException extends ServiceException
{
    public function __construct(
        string $message = 'An certificates-related error occurred.',
        ErrorCode $code = ErrorCode::CERTIFICATES_FAILED,
        ?Throwable $previous = null
    ) {
        parent::__construct($message, $code->value, $previous);
    }
}
