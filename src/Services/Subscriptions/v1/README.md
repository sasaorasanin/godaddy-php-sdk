# Subscriptions Service v1

This service version uses GoDaddy v1 Subscriptions API endpoints for subscription management.

## Usage

```php
use GoDaddy\Services\Subscriptions\v1\SubscriptionsService;
use GoDaddy\Services\Subscriptions\v1\DTO\{
    SubscriptionListQueryData,
    SubscriptionHeadersData,
    UpdateSubscriptionData
};

$service = new SubscriptionsService($apiKey, $apiSecret, $baseUrl);

// Get list of subscriptions
$query = new SubscriptionListQueryData(
    limit: 10,
    offset: 0,
    status: 'ACTIVE',
    productGroupKeys: ['domains', 'hosting']
);
$headers = new SubscriptionHeadersData('shopper-id-123');
$subscriptions = $service->getSubscriptions($query, $headers);

// Get specific subscription
$headers = new SubscriptionHeadersData('shopper-id-123');
$subscription = $service->getSubscription('subscription-id-456', $headers);

// Cancel subscription
$headers = new SubscriptionHeadersData('shopper-id-123');
$cancelled = $service->cancelSubscription('subscription-id-456', $headers);

// Update subscription
$updateData = new UpdateSubscriptionData(
    quantity: 2,
    autoRenew: true
);
$headers = new SubscriptionHeadersData('shopper-id-123');
$updated = $service->updateSubscription('subscription-id-456', $updateData, $headers);

// Get product groups
$headers = new SubscriptionHeadersData('shopper-id-123');
$productGroups = $service->getProductGroups($headers);
```

## DTO Reference

- **SubscriptionListQueryData**: Data for filtering subscriptions (limit, offset, status, productGroupKeys, productKeys, marketplaceIds, sortField, sortOrder)
- **SubscriptionHeadersData**: Data for headers (shopperId)
- **UpdateSubscriptionData**: Data for updating subscriptions (quantity, autoRenew)

## Methods

- **getSubscriptions(SubscriptionListQueryData $query, SubscriptionHeadersData $headers)**: Get list of subscriptions
- **getSubscription(string $subscriptionId, SubscriptionHeadersData $headers)**: Get specific subscription
- **cancelSubscription(string $subscriptionId, SubscriptionHeadersData $headers)**: Cancel subscription
- **updateSubscription(string $subscriptionId, UpdateSubscriptionData $data, SubscriptionHeadersData $headers)**: Update subscription
- **getProductGroups(SubscriptionHeadersData $headers)**: Get product groups

## Note
This documentation refers exclusively to v1 endpoints.
