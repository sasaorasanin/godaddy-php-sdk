<?php

namespace GoDaddy\Services\Certificates\v2\Exceptions;

use GoDaddy\Services\Certificates\v2\Exceptions\CertificatesException;
use GoDaddy\Support\ErrorCode;
use Throwable;

class CustomerCertificateDetailsFetchException extends CertificatesException
{
    public function __construct(
        string $message = 'Failed to fetch customer certificate details.',
        ErrorCode $code = ErrorCode::CERTIFICATE_CUSTOMER_CERTIFICATE_DETAILS_FETCH_FAILED,
        ?Throwable $previous = null
    ) {
        parent::__construct($message, $code, $previous);
    }
}