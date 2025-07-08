<?php

namespace GoDaddy\Services\Subscriptions\v1;

use GoDaddy\Services\BaseService;
use GoDaddy\Services\Subscriptions\v1\DTO\SubscriptionHeadersData;
use GoDaddy\Services\Subscriptions\v1\DTO\SubscriptionListQueryData;
use GoDaddy\Services\Subscriptions\v1\DTO\UpdateSubscriptionData;
use GoDaddy\Services\Subscriptions\v1\Exceptions\{
    SubscriptionListFetchException,
    SubscriptionDetailsFetchException,
    SubscriptionCancelException,
    SubscriptionUpdateException,
    SubscriptionProductGroupsFetchException,
};
use GoDaddy\Support\ErrorCode;
use GuzzleHttp\Exception\ClientException;

class SubscriptionsService extends BaseService
{
    public function getSubscriptions(SubscriptionListQueryData $query, SubscriptionHeadersData $headers): array
    {
        try {
            $response = $this->client->get('/v1/subscriptions', [
                'query' => $query->toArray(),
                'headers' => $headers->toArray(),
            ]);

            return $this->decodeResponse($response);
        } catch (ClientException $e) {
            $this->handleHttpException($e, SubscriptionListFetchException::class, ErrorCode::SUBSCRIPTION_LIST_FETCH_FAILED);
        }
    }

    public function getSubscription(string $subscriptionId, SubscriptionHeadersData $headers): array
    {
        try {
            $response = $this->client->get("/v1/subscriptions/{$subscriptionId}", [
                'headers' => $headers->toArray(),
            ]);

            return $this->decodeResponse($response);
        } catch (ClientException $e) {
            $this->handleHttpException($e, SubscriptionDetailsFetchException::class, ErrorCode::SUBSCRIPTION_DETAIL_FETCH_FAILED);
        }
    }

    public function cancelSubscription(string $subscriptionId, SubscriptionHeadersData $headers): bool
    {
        try {
            $this->client->delete("/v1/subscriptions/{$subscriptionId}", [
                'headers' => $headers->toArray(),
            ]);

            return true;
        } catch (ClientException $e) {
            $this->handleHttpException($e, SubscriptionCancelException::class, ErrorCode::SUBSCRIPTION_CANCEL_FAILED);
        }
    }

    public function updateSubscription(string $subscriptionId, UpdateSubscriptionData $data, SubscriptionHeadersData $headers): bool
    {
        try {
            $this->client->patch("/v1/subscriptions/{$subscriptionId}", [
                'headers' => $headers->toArray(),
                'json' => $data->toArray(),
            ]);

            return true;
        } catch (ClientException $e) {
            $this->handleHttpException($e, SubscriptionUpdateException::class, ErrorCode::SUBSCRIPTION_UPDATE_FAILED);
        }
    }

    public function getProductGroups(SubscriptionHeadersData $headers): array
    {
        try {
            $response = $this->client->get('/v1/subscriptions/productGroups', [
                'headers' => $headers->toArray(),
            ]);

            return $this->decodeResponse($response);
        } catch (ClientException $e) {
            $this->handleHttpException($e, SubscriptionProductGroupsFetchException::class, ErrorCode::SUBSCRIPTION_PRODUCT_GROUPS_FETCH_FAILED);
        }
    }
}
