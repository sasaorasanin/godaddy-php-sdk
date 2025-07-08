<?php

namespace GoDaddy\Services\Certificates\v1\Exceptions;

use GoDaddy\Support\ErrorCode;
use Throwable;

class CertificateEmailHistoryFetchException extends CertificateException
{
    public function __construct(
        string $message = 'Failed to fetch certificate email history.',
        ErrorCode $code = ErrorCode::CERTIFICATE_EMAIL_HISTORY_FETCH_FAILED,
        ?Throwable $previous = null
    ) {
        parent::__construct($message, $code, $previous);
    }
}