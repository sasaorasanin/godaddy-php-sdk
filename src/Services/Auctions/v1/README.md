# Auctions Service

The `AuctionsService` allows you to place multiple bids on aftermarket listings for a customer via GoDaddy's API.

## Usage

```php
use GoDaddy\Services\Auctions\AuctionsService;
use GoDaddy\Services\Auctions\DTO\PlaceBidData;
use GoDaddy\Services\Auctions\DTO\PlaceMultipleBidsData;

$service = new AuctionsService($apiKey, $apiSecret, $baseUrl);

// Place multiple bids
$bid1 = new PlaceBidData(bidAmountUsd: 100.0, tosAccepted: true, listingId: 555555);
$bid2 = new PlaceBidData(bidAmountUsd: 150.0, tosAccepted: true, listingId: 666666);
$data = new PlaceMultipleBidsData(
    customerId: 'customer-1',
    bids: [$bid1, $bid2]
);
$response = $service->placeBids($data);
```

## DTO Reference

- **PlaceBidData**: Represents a single bid (bidAmountUsd, tosAccepted, listingId)
- **PlaceMultipleBidsData**: Represents a request to place multiple bids for a customer (customerId, array of PlaceBidData)

## Error Handling

If the request fails, a `PlaceBidsException` will be thrown. You can catch it as follows:

```php
use GoDaddy\Services\Auctions\Exceptions\PlaceBidsException;

try {
    $response = $service->placeBids($data);
} catch (PlaceBidsException $e) {
    echo "Error: " . $e->getMessage();
}
```
