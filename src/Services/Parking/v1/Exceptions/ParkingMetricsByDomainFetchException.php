<?php

namespace GoDaddy\Services\Parking\v1\Exceptions;

use GoDaddy\Support\ErrorCode;
use Throwable;

class ParkingMetricsByDomainFetchException extends ParkingException
{
    public function __construct(
        string $message = 'Failed to fetch parking metrics by domain.',
        ErrorCode $code = ErrorCode::PARKING_METRICS_BY_DOMAIN_FETCH_FAILED,
        ?Throwable $previous = null
    ) {
        parent::__construct($message, $code, $previous);
    }
}