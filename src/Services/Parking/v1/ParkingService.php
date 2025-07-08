<?php

namespace GoDaddy\Services\Parking\v1;

use GoDaddy\Services\BaseService;
use GoDaddy\Services\Parking\v1\DTO\MetricsByDomainQueryData;
use GoDaddy\Services\Parking\v1\DTO\ParkingMetricsQueryData;
use GoDaddy\Services\Parking\v1\DTO\ParkingHeadersData;
use GoDaddy\Services\Parking\v1\Exceptions\ParkingMetricsByDomainFetchException;
use GoDaddy\Services\Parking\v1\Exceptions\ParkingMetricsFetchException;
use GoDaddy\Support\ErrorCode;
use GuzzleHttp\Exception\ClientException;

class ParkingService extends BaseService
{
    public function getMetrics(string $customerId, ParkingMetricsQueryData $data, ParkingHeadersData $headers): array
    {
        try {
            $response = $this->client->get("/v1/customers/{$customerId}/parking/metrics", [
                'query' => $data->toArray(),
                'headers' => $headers->toArray(),
            ]);

            return $this->decodeResponse($response);
        } catch (ClientException $e) {
            $this->handleHttpException($e, ParkingMetricsFetchException::class, ErrorCode::PARKING_METRICS_FETCH_FAILED);
        }
    }

    public function getMetricsByDomain(string $customerId, MetricsByDomainQueryData $data, ParkingHeadersData $headers): array
    {
        try {
            $response = $this->client->get("/v1/customers/{$customerId}/parking/metricsByDomain", [
                'query' => $data->toArray(),
                'headers' => $headers->toArray(),
            ]);

            return $this->decodeResponse($response);
        } catch (ClientException $e) {
            $this->handleHttpException($e, ParkingMetricsByDomainFetchException::class, ErrorCode::PARKING_METRICS_BY_DOMAIN_FETCH_FAILED);
        }
    }
}