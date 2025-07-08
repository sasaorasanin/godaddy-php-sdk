<?php

namespace GoDaddy\Services\Parking\v1\Exceptions;

use GoDaddy\Exceptions\ServiceException;
use GoDaddy\Support\ErrorCode;
use Throwable;

class ParkingException extends ServiceException
{
    public function __construct(
        string $message = 'An parking-related error occurred.',
        ErrorCode $code = ErrorCode::PARKING_FAILED,
        ?Throwable $previous = null
    ) {
        parent::__construct($message, $code->value, $previous);
    }
}
