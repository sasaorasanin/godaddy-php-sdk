# Parking Service v1

This service version uses GoDaddy v1 Parking API endpoints for retrieving parking page metrics.

## Usage

```php
use GoDaddy\Services\Parking\v1\ParkingService;
use GoDaddy\Services\Parking\v1\DTO\ParkingMetricsQueryData;
use GoDaddy\Services\Parking\v1\DTO\MetricsByDomainQueryData;
use GoDaddy\Services\Parking\v1\DTO\ParkingHeadersData;

$service = new ParkingService($apiKey, $apiSecret, $baseUrl);

// Get parking metrics
$queryData = new ParkingMetricsQueryData(
    startDate: '2024-01-01',
    endDate: '2024-01-31',
    groupBy: 'day'
);
$headers = new ParkingHeadersData('shopper-id-123');
$metrics = $service->getMetrics('customer-id-456', $queryData, $headers);

// Get parking metrics by domain
$domainQueryData = new MetricsByDomainQueryData(
    startDate: '2024-01-01',
    endDate: '2024-01-31',
    domains: ['example.com', 'test.com'],
    groupBy: 'domain'
);
$headers = new ParkingHeadersData('shopper-id-123');
$domainMetrics = $service->getMetricsByDomain('customer-id-456', $domainQueryData, $headers);
```

## DTO Reference

- **ParkingMetricsQueryData**: Data for retrieving parking metrics (startDate, endDate, groupBy)
- **MetricsByDomainQueryData**: Data for retrieving parking metrics by domain (startDate, endDate, domains, groupBy)
- **ParkingHeadersData**: Data for headers (shopperId)

## Methods

- **getMetrics(string $customerId, ParkingMetricsQueryData $data, ParkingHeadersData $headers)**: Get parking metrics
- **getMetricsByDomain(string $customerId, MetricsByDomainQueryData $data, ParkingHeadersData $headers)**: Get parking metrics by domain

## Note
This documentation refers exclusively to v1 endpoints.
