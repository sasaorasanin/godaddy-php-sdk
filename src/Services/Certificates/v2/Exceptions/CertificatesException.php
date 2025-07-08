<?php

namespace GoDaddy\Services\Certificates\v2\Exceptions;

use GoDaddy\Exceptions\ServiceException;
use GoDaddy\Support\ErrorCode;
use Throwable;

class CertificatesException extends ServiceException
{
    public function __construct(
        string $message = 'An certificates-related error occurred.',
        ErrorCode $code = ErrorCode::CERTIFICATES_FAILED,
        ?Throwable $previous = null
    ) {
        parent::__construct($message, $code->value, $previous);
    }
}
