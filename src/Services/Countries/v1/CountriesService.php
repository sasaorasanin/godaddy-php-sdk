<?php

namespace GoDaddy\Services\Countries\v1;

use GoDaddy\Services\BaseService;
use GoDaddy\Support\ErrorCode;
use GuzzleHttp\Exception\ClientException;
use GoDaddy\Services\Countries\v1\Exceptions\CountryListFetchException;
use GoDaddy\Services\Countries\v1\Exceptions\CountryDetailsFetchException;

class CountriesService extends BaseService
{
    public function getAll(string $marketId): array
    {
        try {
            $response = $this->client->get('/v1/countries', [
                'query' => ['marketId' => $marketId],
            ]);

            return $this->decodeResponse($response);
        } catch (ClientException $e) {
            $this->handleHttpException($e, CountryListFetchException::class, ErrorCode::COUNTRY_LIST_FETCH_FAILED);
        }
    }

    public function getByKey(string $countryKey, string $marketId): array
    {
        try {
            $response = $this->client->get("/v1/countries/{$countryKey}", [
                'query' => ['marketId' => $marketId],
            ]);

            return $this->decodeResponse($response);
        } catch (ClientException $e) {
            $this->handleHttpException($e, CountryDetailsFetchException::class, ErrorCode::COUNTRY_DETAILS_FETCH_FAILED);
        }
    }
}
