<?php

namespace GoDaddy\Services\Certificates\v2\Exceptions;

use GoDaddy\Services\Certificates\v2\Exceptions\CertificatesException;
use GoDaddy\Support\ErrorCode;
use Throwable;

class CertificateDownloadByEntitlementException extends CertificatesException
{
    public function __construct(
        string $message = 'Failed to download certificate by entitlement.',
        ErrorCode $code = ErrorCode::CERTIFICATE_DOWNLOAD_FAILED,
        ?Throwable $previous = null
    ) {
        parent::__construct($message, $code, $previous);
    }
}