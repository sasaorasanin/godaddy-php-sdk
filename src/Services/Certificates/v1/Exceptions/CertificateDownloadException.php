<?php

namespace GoDaddy\Services\Certificates\v1\Exceptions;

use GoDaddy\Support\ErrorCode;
use Throwable;

class CertificateDownloadException extends CertificateException
{
    public function __construct(
        string $message = 'Failed to download certificate.',
        ErrorCode $code = ErrorCode::CERTIFICATE_DOWNLOAD_FAILED,
        ?Throwable $previous = null
    ) {
        parent::__construct($message, $code, $previous);
    }
}