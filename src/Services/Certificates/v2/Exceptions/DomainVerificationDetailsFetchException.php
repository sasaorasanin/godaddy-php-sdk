<?php

namespace GoDaddy\Services\Certificates\v2\Exceptions;

use GoDaddy\Services\Certificates\v2\Exceptions\CertificatesException;
use GoDaddy\Support\ErrorCode;
use Throwable;

class DomainVerificationDetailsFetchException extends CertificatesException
{
    public function __construct(
        string $message = 'Failed to fetch domain verification details.',
        ErrorCode $code = ErrorCode::CERTIFICATE_DOMAIN_VERIFICATION_DETAILS_FETCH_FAILED,
        ?Throwable $previous = null
    ) {
        parent::__construct($message, $code, $previous);
    }
}