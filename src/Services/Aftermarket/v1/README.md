# Aftermarket Service

The `AftermarketService` allows you to interact with GoDaddy's Aftermarket API endpoints for auction listings.

## Usage

```php
use GoDaddy\Services\Aftermarket\v1\AftermarketService;
use GoDaddy\Services\Aftermarket\v1\DTO\GetAuctionListingsFilter;
use GoDaddy\Services\Aftermarket\v1\DTO\DeleteAuctionListingsData;
use GoDaddy\Services\Aftermarket\v1\DTO\CreateExpiryListingsData;
use GoDaddy\Services\Aftermarket\v1\DTO\ExpiryListingItem;

$service = new AftermarketService($apiKey, $apiSecret, $baseUrl);

// Get auction listings
$filter = new GetAuctionListingsFilter(
    customerId: 'customer-1',
    domains: 'example.com',
    listingStatus: 'active',
    limit: 10
);
$listings = $service->getListings($filter);

// Delete auction listings
$deleteData = new DeleteAuctionListingsData(['example.com', 'test.com']);
$deleteResponse = $service->deleteListings($deleteData);

// Create expiry listings
$item1 = new ExpiryListingItem('example.com', '2024-01-01', 123, 10, 20);
$item2 = new ExpiryListingItem('test.com', '2024-02-01', 456);
$expiryData = new CreateExpiryListingsData([$item1, $item2]);
$createResponse = $service->createExpiryListings($expiryData);
```

## DTO Reference

- **GetAuctionListingsFilter**: Filter for fetching auction listings.
- **DeleteAuctionListingsData**: Data for deleting auction listings (array of domains).
- **CreateExpiryListingsData**: Data for creating expiry listings (array of ExpiryListingItem).
- **ExpiryListingItem**: Represents a single expiry listing item (domain, expiresAt, losingRegistrarId, pageViewsMonthly, revenueMonthly).
