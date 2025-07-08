<?php

namespace GoDaddy\Services\Certificates\v2\Exceptions;

use GoDaddy\Services\Certificates\v2\Exceptions\CertificatesException;
use GoDaddy\Support\ErrorCode;
use Throwable;

class AcmeExternalAccountBindingFetchException extends CertificatesException
{
    public function __construct(
        string $message = 'Failed to fetch ACME external account binding.',
        ErrorCode $code = ErrorCode::CERTIFICATE_ACME_EXTERNAL_ACCOUNT_BINDING_FETCH_FAILED,
        ?Throwable $previous = null
    ) {
        parent::__construct($message, $code, $previous);
    }
}