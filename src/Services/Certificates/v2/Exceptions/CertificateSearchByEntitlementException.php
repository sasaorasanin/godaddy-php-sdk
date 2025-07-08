<?php

namespace GoDaddy\Services\Certificates\v2\Exceptions;

use GoDaddy\Services\Certificates\v2\Exceptions\CertificatesException;
use GoDaddy\Support\ErrorCode;
use Throwable;

class CertificateSearchByEntitlementException extends CertificatesException
{
    public function __construct(
        string $message = 'Failed to search certificate by entitlement.',
        ErrorCode $code = ErrorCode::CERTIFICATE_SEARCH_FAILED,
        ?Throwable $previous = null
    ) {
        parent::__construct($message, $code, $previous);
    }
}