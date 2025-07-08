# Shoppers Service v1

This service version uses GoDaddy v1 Shoppers API endpoints for managing customers and sub-accounts.

## Usage

```php
use GoDaddy\Services\Shoppers\v1\ShoppersService;
use GoDaddy\Services\Shoppers\v1\DTO\{
    CreateSubaccountData,
    UpdateShopperData,
    SetPasswordData,
    DeleteShopperQueryData,
    ShopperIncludesQueryData,
    ShopperStatusQueryData
};

$service = new ShoppersService($apiKey, $apiSecret, $baseUrl);

// Create sub-account
$createData = new CreateSubaccountData(
    'John Doe',
    'john@example.com',
    '123456789',
    'US',
    'en'
);
$subaccount = $service->createSubaccount($createData);

// Get customer
$includes = new ShopperIncludesQueryData(['domains', 'subscriptions']);
$shopper = $service->getShopper('shopper-id-123', $includes);

// Update customer
$updateData = new UpdateShopperData(
    'John Smith',
    'john.smith@example.com',
    '987654321',
    'CA',
    'fr'
);
$updatedShopper = $service->updateShopper('shopper-id-123', $updateData);

// Delete customer
$deleteQuery = new DeleteShopperQueryData('shopper-id-123');
$deleteResult = $service->deleteShopper('shopper-id-123', $deleteQuery);

// Get customer status
$statusQuery = new ShopperStatusQueryData('shopper-id-123');
$status = $service->getShopperStatus('shopper-id-123', $statusQuery);

// Set password
$passwordData = new SetPasswordData('newSecurePassword123');
$passwordResult = $service->setPassword('shopper-id-123', $passwordData);
```

## DTO Reference

- **CreateSubaccountData**: Data for creating sub-accounts (name, email, phone, country, locale)
- **UpdateShopperData**: Data for updating customers (name, email, phone, country, locale)
- **SetPasswordData**: Data for setting passwords (password)
- **DeleteShopperQueryData**: Data for deleting customers (shopperId)
- **ShopperIncludesQueryData**: Data for including additional information (includes)
- **ShopperStatusQueryData**: Data for retrieving status (shopperId)

## Methods

- **createSubaccount(CreateSubaccountData $data)**: Create new sub-account
- **getShopper(string $shopperId, ?ShopperIncludesQueryData $query = null)**: Get customer
- **updateShopper(string $shopperId, UpdateShopperData $data)**: Update customer
- **deleteShopper(string $shopperId, DeleteShopperQueryData $query)**: Delete customer
- **getShopperStatus(string $shopperId, ShopperStatusQueryData $query)**: Get customer status
- **setPassword(string $shopperId, SetPasswordData $data)**: Set password

## Note
This documentation refers exclusively to v1 endpoints.
