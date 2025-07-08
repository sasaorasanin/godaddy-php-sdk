<?php

namespace GoDaddy\Services\Countries\v1\Exceptions;

use GoDaddy\Support\ErrorCode;
use Throwable;

class CountryListFetchException extends CountriesException
{
    public function __construct(
        string $message = 'Failed to fetch country list.',
        ErrorCode $code = ErrorCode::COUNTRY_LIST_FETCH_FAILED,
        ?Throwable $previous = null
    ) {
        parent::__construct($message, $code, $previous);
    }
}