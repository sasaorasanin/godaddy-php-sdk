<?php

namespace GoDaddy\Services\Certificates\v1\Exceptions;

use GoDaddy\Support\ErrorCode;
use Throwable;

class CertificateReissueException extends CertificateException
{
    public function __construct(
        string $message = 'Failed to reissue certificate.',
        ErrorCode $code = ErrorCode::CERTIFICATE_REISSUE_FAILED,
        ?Throwable $previous = null
    ) {
        parent::__construct($message, $code, $previous);
    }
}