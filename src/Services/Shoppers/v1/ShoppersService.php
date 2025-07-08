<?php

namespace GoDaddy\Services\Shoppers\v1;

use GoDaddy\Services\BaseService;
use GoDaddy\Services\Shoppers\v1\DTO\{
    CreateSubaccountData,
    UpdateShopperData,
    SetPasswordData,
    DeleteShopperQueryData,
    ShopperIncludesQueryData,
    ShopperStatusQueryData
};
use GoDaddy\Services\Shoppers\v1\Exceptions\{
    ShopperCreateException,
    ShopperFetchException,
    ShopperUpdateException,
    ShopperDeleteException,
    ShopperStatusFetchException,
    ShopperPasswordSetException
};
use GoDaddy\Support\ErrorCode;
use GuzzleHttp\Exception\ClientException;

class ShoppersService extends BaseService
{
    public function createSubaccount(CreateSubaccountData $data): array
    {
        try {
            $response = $this->client->post('/v1/shoppers/subaccount', [
                'json' => $data->toArray(),
            ]);

            return $this->decodeResponse($response);
        } catch (ClientException $e) {
            $this->handleHttpException($e, ShopperCreateException::class, ErrorCode::SHOPPER_CREATE_FAILED);
        }
    }

    public function getShopper(string $shopperId, ?ShopperIncludesQueryData $query = null): array
    {
        try {
            $response = $this->client->get("/v1/shoppers/{$shopperId}", [
                'query' => $query?->toArray() ?? [],
            ]);

            return $this->decodeResponse($response);
        } catch (ClientException $e) {
            $this->handleHttpException($e, ShopperFetchException::class, ErrorCode::SHOPPER_FETCH_FAILED);
        }
    }

    public function updateShopper(string $shopperId, UpdateShopperData $data): array
    {
        try {
            $response = $this->client->post("/v1/shoppers/{$shopperId}", [
                'json' => $data->toArray(),
            ]);

            return $this->decodeResponse($response);
        } catch (ClientException $e) {
            $this->handleHttpException($e, ShopperUpdateException::class, ErrorCode::SHOPPER_UPDATE_FAILED);
        }
    }

    public function deleteShopper(string $shopperId, DeleteShopperQueryData $query): array
    {
        try {
            $response = $this->client->delete("/v1/shoppers/{$shopperId}", [
                'query' => $query->toArray(),
            ]);

            return $this->decodeResponse($response);
        } catch (ClientException $e) {
            $this->handleHttpException($e, ShopperDeleteException::class, ErrorCode::SHOPPER_DELETE_FAILED);
        }
    }

    public function getShopperStatus(string $shopperId, ShopperStatusQueryData $query): array
    {
        try {
            $response = $this->client->get("/v1/shoppers/{$shopperId}/status", [
                'query' => $query->toArray(),
            ]);

            return $this->decodeResponse($response);
        } catch (ClientException $e) {
            $this->handleHttpException($e, ShopperStatusFetchException::class, ErrorCode::SHOPPER_STATUS_FETCH_FAILED);
        }
    }

    public function setPassword(string $shopperId, SetPasswordData $data): array
    {
        try {
            $response = $this->client->put("/v1/shoppers/{$shopperId}/factors/password", [
                'json' => $data->toArray(),
            ]);

            return $this->decodeResponse($response);
        } catch (ClientException $e) {
            $this->handleHttpException($e, ShopperPasswordSetException::class, ErrorCode::SHOPPER_PASSWORD_SET_FAILED);
        }
    }
}
