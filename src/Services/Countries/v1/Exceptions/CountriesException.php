<?php

namespace GoDaddy\Services\Countries\v1\Exceptions;

use GoDaddy\Exceptions\ServiceException;
use GoDaddy\Support\ErrorCode;
use Throwable;

class CountriesException extends ServiceException
{
    public function __construct(
        string $message = 'An countries-related error occurred.',
        ErrorCode $code = ErrorCode::COUNTRY_LIST_FETCH_FAILED,
        ?Throwable $previous = null
    ) {
        parent::__construct($message, $code->value, $previous);
    }
}