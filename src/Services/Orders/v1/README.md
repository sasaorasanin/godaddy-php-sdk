# Orders Service v1

This service version uses GoDaddy v1 Orders API endpoints for order management.

## Usage

```php
use GoDaddy\Services\Orders\v1\OrdersService;
use GoDaddy\Services\Orders\v1\DTO\ListOrdersQueryData;
use GoDaddy\Services\Orders\v1\DTO\OrdersHeadersData;

$service = new OrdersService($apiKey, $apiSecret, $baseUrl);

// Get all orders
$query = new ListOrdersQueryData(
    limit: 10,
    offset: 0,
    status: 'ACTIVE',
    orderId: 'order-123'
);
$headers = new OrdersHeadersData('shopper-id-456');
$orders = $service->getAll($query, $headers, 'list');

// Get specific order
$headers = new OrdersHeadersData('shopper-id-456');
$orderDetails = $service->getById('order-id-789', $headers, 'single');
```

## DTO Reference

- **ListOrdersQueryData**: Data for filtering orders (limit, offset, status, orderId, orderDateFrom, orderDateTo, productGroupKeys, productKeys, customerId, shopperId, marketplaceIds, sortField, sortOrder)
- **OrdersHeadersData**: Data for headers (shopperId)

## Methods

- **getAll(ListOrdersQueryData $query, OrdersHeadersData $headers, string $context = 'list')**: Get list of orders
- **getById(string $orderId, OrdersHeadersData $headers, string $context = 'single')**: Get details for a specific order

## Note
This documentation refers exclusively to v1 endpoints.
