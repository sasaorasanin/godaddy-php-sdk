<?php

namespace GoDaddy\Services\Certificates\v1\Exceptions;

use GoDaddy\Support\ErrorCode;
use Throwable;

class CertificateActionsFetchException extends CertificateException
{
    public function __construct(
        string $message = 'Failed to fetch certificate actions.',
        ErrorCode $code = ErrorCode::CERTIFICATE_ACTIONS_FETCH_FAILED,
        ?Throwable $previous = null
    ) {
        parent::__construct($message, $code, $previous);
    }
}