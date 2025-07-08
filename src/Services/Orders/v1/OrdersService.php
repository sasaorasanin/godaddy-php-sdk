<?php

namespace GoDaddy\Services\Orders\v1;

use GoDaddy\Services\BaseService;
use GoDaddy\Services\Orders\v1\DTO\ListOrdersQueryData;
use GoDaddy\Services\Orders\v1\DTO\OrdersHeadersData;
use GoDaddy\Support\ErrorCode;
use GuzzleHttp\Exception\ClientException;
use GoDaddy\Services\Orders\v1\Exceptions\OrderListFetchException;
use GoDaddy\Services\Orders\v1\Exceptions\OrderDetailsFetchException;

class OrdersService extends BaseService
{
    public function getAll(ListOrdersQueryData $query, OrdersHeadersData $headers, string $context = 'list'): array
    {
        try {
            $response = $this->client->get('/v1/orders', [
                'query' => $query->toArray(),
                'headers' => $headers->toArray($context),
            ]);

            return $this->decodeResponse($response);
        } catch (ClientException $e) {
            $this->handleHttpException($e, OrderListFetchException::class, ErrorCode::ORDER_LIST_FETCH_FAILED);
        }
    }

    public function getById(string $orderId, OrdersHeadersData $headers, string $context = 'single'): array
    {
        try {
            $response = $this->client->get("/v1/orders/{$orderId}", [
                'headers' => $headers->toArray($context),
            ]);

            return $this->decodeResponse($response);
        } catch (ClientException $e) {
            $this->handleHttpException($e, OrderDetailsFetchException::class, ErrorCode::ORDER_DETAILS_FETCH_FAILED);
        }
    }
}
