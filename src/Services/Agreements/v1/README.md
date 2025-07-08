# Agreements Service

The `AgreementsService` allows you to retrieve legal agreements for provided agreement keys from GoDaddy's API.

## Usage

```php
use GoDaddy\Services\Agreements\v1\AgreementsService;
use GoDaddy\Services\Agreements\v1\DTO\GetAgreementsData;

$service = new AgreementsService($apiKey, $apiSecret, $baseUrl);

// Retrieve agreements
$data = new GetAgreementsData(
    keys: ['UNIVERSAL_TERMS', 'PRIVACY_POLICY'],
    privateLabelId: 1234, // optional
    marketId: 'en-US'     // optional, default is 'en-US'
);
$response = $service->getAgreements($data);
```

## DTO Reference

- **GetAgreementsData**: Data for retrieving agreements
  - `keys` (array, required): Agreement keys to retrieve (e.g., `['UNIVERSAL_TERMS', 'PRIVACY_POLICY']`)
  - `privateLabelId` (int, optional): Private label ID for the request
  - `marketId` (string, optional): Market ID (default: 'en-US')

## Error Handling

If the request fails, a `GetAgreementsException` will be thrown. You can catch it as follows:

```php
use GoDaddy\Services\Agreements\v1\Exceptions\GetAgreementsException;

try {
    $response = $service->getAgreements($data);
} catch (GetAgreementsException $e) {
    echo "Error: " . $e->getMessage();
}
```
