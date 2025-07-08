<?php

namespace GoDaddy\Services\Countries\v1\Exceptions;

use GoDaddy\Support\ErrorCode;
use Throwable;

class CountryDetailsFetchException extends CountriesException
{
    public function __construct(
        string $message = 'Failed to fetch country details.',
        ErrorCode $code = ErrorCode::COUNTRY_DETAILS_FETCH_FAILED,
        ?Throwable $previous = null
    ) {
        parent::__construct($message, $code, $previous);
    }
}