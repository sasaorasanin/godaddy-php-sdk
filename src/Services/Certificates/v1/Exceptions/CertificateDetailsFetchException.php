<?php

namespace GoDaddy\Services\Certificates\v1\Exceptions;

use GoDaddy\Support\ErrorCode;
use Throwable;

class CertificateDetailsFetchException extends CertificateException
{
    public function __construct(
        string $message = 'Failed to fetch certificate details.',
        ErrorCode $code = ErrorCode::CERTIFICATE_DETAILS_FETCH_FAILED,
        ?Throwable $previous = null
    ) {
        parent::__construct($message, $code, $previous);
    }
}
