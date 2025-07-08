<?php

namespace GoDaddy\Services\Auctions\v1;

use GoDaddy\Services\BaseService;
use GoDaddy\Services\Auctions\v1\DTO\PlaceMultipleBidsData;
use GoDaddy\Services\Auctions\v1\Exceptions\PlaceBidsException;
use GoDaddy\Support\ErrorCode;

class AuctionsService extends BaseService
{
    /**
     * POST /v1/customers/{customerId}/aftermarket/listings/bids
     * Places multiple bids with a single request.
     */
    public function placeBids(PlaceMultipleBidsData $data): array
    {
        try {
            $response = $this->client->post(
                "/v1/customers/{$data->customerId}/aftermarket/listings/bids",
                [
                    'json' => $data->toArray(),
                ]
            );
            return $this->decodeResponse($response);
        } catch (\GuzzleHttp\Exception\ClientException $e) {
            $this->handleHttpException($e, PlaceBidsException::class, ErrorCode::AUCTIONS_PLACE_BIDS_FAILED);
        }
    }
}
