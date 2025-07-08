# GoDaddy PHP SDK

[![PHP Version](https://img.shields.io/badge/php-%3E%3D8.2-blue.svg)](https://php.net)
[![License](https://img.shields.io/badge/license-MIT-green.svg)](LICENSE)
[![Tests](https://img.shields.io/badge/tests-passing-brightgreen.svg)](https://github.com/your-username/godaddy-php-sdk)

Unofficial PHP SDK for GoDaddy API. A comprehensive library that provides easy-to-use interfaces for all GoDaddy API services.

## Features

- **Complete API Coverage**: Support for all GoDaddy API services
- **Type Safety**: Full PHP 8.2+ type hints and strict typing
- **PSR-4 Autoloading**: Modern PHP standards compliance
- **Comprehensive Testing**: Full test coverage with Pest PHP
- **Multiple API Versions**: Support for both v1 and v2 APIs where available
- **DTO Pattern**: Clean data transfer objects for all API requests/responses
- **Exception Handling**: Proper exception classes for different error scenarios

## Requirements

- PHP 8.2 or higher
- Guzzle HTTP Client 7.0 or higher
- Composer

## Installation

### Via Composer (Recommended)

```bash
composer require godaddy/sdk
```

### Manual Installation

1. Clone the repository:
```bash
git clone https://github.com/your-username/godaddy-php-sdk.git
cd godaddy-php-sdk
```

2. Install dependencies:
```bash
composer install
```

## Quick Start

### Basic Usage

```php
<?php

require_once 'vendor/autoload.php';

use GoDaddy\GoDaddy;

// Initialize the SDK with your API credentials
$godaddy = new GoDaddy(
    apiKey: 'your-api-key',
    apiSecret: 'your-api-secret',
    baseUrl: 'https://api.ote-godaddy.com' // Use production URL for live
);

// Use any service
$domains = $godaddy->domains();
$certificates = $godaddy->certificates();
$shoppers = $godaddy->shoppers();
```

### Example: List Domains

```php
<?php

use GoDaddy\Services\Domains\DomainsService;

$domainsService = new DomainsService('api-key', 'api-secret', 'https://api.ote-godaddy.com');

try {
    $domains = $domainsService->listDomains();
    foreach ($domains as $domain) {
        echo "Domain: {$domain['domain']}\n";
    }
} catch (GoDaddy\Exceptions\ServiceException $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
```

### Example: Create Certificate

```php
<?php

use GoDaddy\Services\Certificates\v1\CertificatesService;
use GoDaddy\Services\Certificates\v1\DTO\{
    CertificateCreateData,
    ContactData,
    AddressData,
    OrganizationData
};

$certificatesService = new CertificatesService('api-key', 'api-secret', 'https://api.ote-godaddy.com');

$contactData = new ContactData(
    'John Doe',
    'john@example.com',
    '123456789',
    '123 Main St',
    'City',
    'State',
    '12345',
    'US'
);

$addressData = new AddressData(
    '123 Main St',
    '',
    'City',
    'US',
    '12345',
    'State'
);

$orgData = new OrganizationData(
    $addressData,
    'Example Corp',
    'Example Corporation',
    '123456789',
    'Registration Agent',
    'REG123456'
);

$createData = new CertificateCreateData(
    'https://callback.example.com',
    'example.com',
    $contactData,
    'CSR_STRING',
    false,
    $orgData,
    12,
    'DV',
    'ROOT_TYPE',
    'SLOT_SIZE',
    ['example.com']
);

try {
    $result = $certificatesService->createCertificate($createData);
    echo "Certificate created: " . $result['certificateId'] . "\n";
} catch (GoDaddy\Exceptions\ServiceException $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
```

## Available Services

The SDK provides access to all GoDaddy API services. Each service has its own documentation with detailed usage examples:

### Core Services
- **[Abuse Service](src/Services/Abuse/README.md)** - Report and manage abuse tickets
  - [v1 API](src/Services/Abuse/v1/README.md)
  - [v2 API](src/Services/Abuse/v2/README.md)

- **[Aftermarket Service](src/Services/Aftermarket/README.md)** - Manage aftermarket listings
  - [v1 API](src/Services/Aftermarket/v1/README.md)

- **[Agreements Service](src/Services/Agreements/README.md)** - Retrieve legal agreements
  - [v1 API](src/Services/Agreements/v1/README.md)

- **[Auctions Service](src/Services/Auctions/README.md)** - Participate in domain auctions
  - [v1 API](src/Services/Auctions/v1/README.md)

- **[Certificates Service](src/Services/Certificates/README.md)** - Manage SSL certificates
  - [v1 API](src/Services/Certificates/v1/README.md)
  - [v2 API](src/Services/Certificates/v2/README.md)

- **[Countries Service](src/Services/Countries/README.md)** - Get country information
  - [v1 API](src/Services/Countries/v1/README.md)

- **[Domains Service](src/Services/Domains/README.md)** - Manage domain registrations
  - Complete domain management functionality

- **[Orders Service](src/Services/Orders/README.md)** - Manage orders
  - [v1 API](src/Services/Orders/v1/README.md)

- **[Parking Service](src/Services/Parking/README.md)** - Domain parking analytics
  - [v1 API](src/Services/Parking/v1/README.md)

- **[Shoppers Service](src/Services/Shoppers/README.md)** - Manage customer accounts
  - [v1 API](src/Services/Shoppers/v1/README.md)

- **[Subscriptions Service](src/Services/Subscriptions/README.md)** - Manage subscriptions
  - [v1 API](src/Services/Subscriptions/v1/README.md)

## Configuration

### API Credentials

You'll need to obtain API credentials from GoDaddy:

1. Log in to your GoDaddy Developer account
2. Create a new application
3. Get your API Key and API Secret
4. Use the appropriate base URL:
   - **Production**: `https://api.godaddy.com`
   - **OTE (Testing)**: `https://api.ote-godaddy.com`

### Environment Variables

For security, store your credentials in environment variables:

```bash
export GODADDY_API_KEY="your-api-key"
export GODADDY_API_SECRET="your-api-secret"
export GODADDY_BASE_URL="https://api.ote-godaddy.com"
```

Then use them in your code:

```php
$godaddy = new GoDaddy(
    apiKey: $_ENV['GODADDY_API_KEY'],
    apiSecret: $_ENV['GODADDY_API_SECRET'],
    baseUrl: $_ENV['GODADDY_BASE_URL']
);
```

## Error Handling

The SDK provides specific exception classes for different error scenarios:

```php
use GoDaddy\Exceptions\{
    ServiceException,
    NotFoundException,
    ForbiddenException,
    RateLimitExceededException,
    InternalServerErrorException
};

try {
    $result = $service->someMethod();
} catch (NotFoundException $e) {
    // Resource not found (404)
    echo "Resource not found: " . $e->getMessage();
} catch (ForbiddenException $e) {
    // Access denied (403)
    echo "Access denied: " . $e->getMessage();
} catch (RateLimitExceededException $e) {
    // Rate limit exceeded (429)
    echo "Rate limit exceeded: " . $e->getMessage();
} catch (ServiceException $e) {
    // General service error
    echo "Service error: " . $e->getMessage();
}
```

## Testing

Run the test suite:

```bash
# Run all tests
composer test

# Run tests with coverage
./vendor/bin/pest --coverage

# Run specific test file
./vendor/bin/pest tests/Feature/v1/DomainsServiceTest.php
```

## Contributing

1. Fork the repository
2. Create a feature branch (`git checkout -b feature/amazing-feature`)
3. Commit your changes (`git commit -m 'Add amazing feature'`)
4. Push to the branch (`git push origin feature/amazing-feature`)
5. Open a Pull Request

### Development Setup

```bash
# Clone the repository
git clone https://github.com/your-username/godaddy-php-sdk.git
cd godaddy-php-sdk

# Install dependencies
composer install

# Run tests
composer test
```

## License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

## Support

- **Documentation**: Each service has detailed documentation in its respective README file
- **Issues**: Report bugs and feature requests on [GitHub Issues](https://github.com/your-username/godaddy-php-sdk/issues)
- **Discussions**: Join the conversation on [GitHub Discussions](https://github.com/your-username/godaddy-php-sdk/discussions)

## Changelog

See [CHANGELOG.md](CHANGELOG.md) for a list of changes and version history.

## Acknowledgments

- GoDaddy for providing the API
- The PHP community for excellent tools and libraries
- All contributors who help improve this SDK

---

**Note**: This is an unofficial SDK and is not affiliated with or endorsed by GoDaddy Inc.
