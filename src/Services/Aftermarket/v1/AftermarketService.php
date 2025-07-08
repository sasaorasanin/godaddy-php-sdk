<?php

namespace GoDaddy\Services\Aftermarket\v1;

use GoDaddy\Support\ErrorCode;
use GoDaddy\Services\Aftermarket\v1\DTO\{
    GetAuctionListingsFilter,
    DeleteAuctionListingsData,
    CreateExpiryListingsData
};
use GoDaddy\Services\Aftermarket\v1\Exceptions\{
    GetAuctionListingsException,
    DeleteAuctionListingsException,
    CreateExpiryListingsException
};
use GoDaddy\Services\BaseService;

class AftermarketService extends BaseService
{
    public function getListings(GetAuctionListingsFilter $filter): array
    {
        try {
            $response = $this->client->get("/v1/customers/{$filter->customerId}/auctions/listings", [
                'query' => $filter->toQuery(),
            ]);

            return $this->decodeResponse($response);
        } catch (\GuzzleHttp\Exception\ClientException $e) {
            $this->handleHttpException($e, GetAuctionListingsException::class, ErrorCode::AFTERMARKET_LISTINGS_FETCH_FAILED);
        }
    }

    public function deleteListings(DeleteAuctionListingsData $data): array
    {
        try {
            $response = $this->client->delete('/v1/aftermarket/listings', [
                'query' => $data->toQuery(),
            ]);

            return $this->decodeResponse($response);
        } catch (\GuzzleHttp\Exception\ClientException $e) {
            $this->handleHttpException($e, DeleteAuctionListingsException::class, ErrorCode::AFTERMARKET_LISTINGS_DELETE_FAILED);
        }
    }

    public function createExpiryListings(CreateExpiryListingsData $data): array
    {
        try {
            $response = $this->client->post('/v1/aftermarket/listings/expiry', [
                'json' => $data->toArray(),
            ]);

            return $this->decodeResponse($response);
        } catch (\GuzzleHttp\Exception\ClientException $e) {
            $this->handleHttpException($e, CreateExpiryListingsException::class, ErrorCode::AFTERMARKET_LISTINGS_CREATE_FAILED);
        }
    }
}
