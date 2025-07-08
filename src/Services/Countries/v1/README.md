# Countries Service v1

This service version uses GoDaddy v1 Countries API endpoints for retrieving country information.

## Usage

```php
use GoDaddy\Services\Countries\v1\CountriesService;

$service = new CountriesService($apiKey, $apiSecret, $baseUrl);

// Get all countries for a specific market
$countries = $service->getAll('US');

// Get details for a specific country
$countryDetails = $service->getByKey('US', 'US');
```

## Methods

- **getAll(string $marketId)**: Get list of all countries for a specific market
- **getByKey(string $countryKey, string $marketId)**: Get details for a specific country by key

## Parameters

- **marketId**: Market ID (e.g., 'US', 'EU', 'CA')
- **countryKey**: Country key (e.g., 'US', 'CA', 'GB')

## Note
This documentation refers exclusively to v1 endpoints.
