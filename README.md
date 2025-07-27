# GoDaddy PHP SDK

[![PHP Version](https://img.shields.io/badge/php-%3E%3D8.2-blue.svg)](https://php.net)
[![License](https://img.shields.io/badge/license-MIT-green.svg)](LICENSE)
[![Tests](https://img.shields.io/badge/tests-290%20passed-brightgreen.svg)](https://github.com/your-username/godaddy-php-sdk)

Unofficial PHP SDK for GoDaddy API. A comprehensive library that provides easy-to-use interfaces for all GoDaddy API services.

## Features

- **Complete API Coverage**: Support for all GoDaddy API services with full implementation
- **Type Safety**: Full PHP 8.2+ type hints and strict typing
- **PSR-4 Autoloading**: Modern PHP standards compliance
- **Comprehensive Testing**: 290+ tests with full coverage using Pest PHP
- **Multiple API Versions**: Complete support for both v1 and v2 APIs
- **DTO Pattern**: Clean data transfer objects for all API requests/responses
- **Exception Handling**: 50+ specific exception classes for different error scenarios
- **Enum Support**: Comprehensive enum classes for type-safe values
- **DNSSEC Support**: Full DNSSEC record management in v2 API
- **Advanced Domain Management**: Complete domain lifecycle management

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

### Example: List Domains (v1)

```php
<?php

use GoDaddy\Services\Domains\v1\DomainsService;
use GoDaddy\Services\Domains\v1\DTO\ListDomainsQueryData;

$domainsService = new DomainsService('api-key', 'api-secret', 'https://api.ote-godaddy.com');

try {
    $queryData = new ListDomainsQueryData();
    $queryData->limit = 100;
    $queryData->statusGroups = ['ACTIVE'];
    
    $domains = $domainsService->listDomains($queryData);
    foreach ($domains as $domain) {
        echo "Domain: {$domain['domain']}\n";
    }
} catch (GoDaddy\Exceptions\ServiceException $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
```

### Example: Get Domain Details (v2)

```php
<?php

use GoDaddy\Services\Domains\v2\DomainsService;
use GoDaddy\Services\Domains\v2\DTO\GetDomainDetailsQueryData;

$domainsService = new DomainsService('api-key', 'api-secret', 'https://api.ote-godaddy.com');

try {
    $queryData = new GetDomainDetailsQueryData();
    $queryData->includes = ['contacts', 'nameServers'];
    
    $domainDetails = $domainsService->getDomainDetails('customer123', 'example.com', $queryData);
    echo "Domain: {$domainDetails->domain}\n";
    echo "Status: {$domainDetails->status}\n";
} catch (GoDaddy\Exceptions\ServiceException $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
```

### Example: Manage DNSSEC Records (v2)

```php
<?php

use GoDaddy\Services\Domains\v2\DomainsService;
use GoDaddy\Services\Domains\v2\DTO\DnssecRecordData;
use GoDaddy\Services\Domains\v2\Enums\DnssecAlgorithm;

$domainsService = new DomainsService('api-key', 'api-secret', 'https://api.ote-godaddy.com');

try {
    $record = new DnssecRecordData(
        DnssecAlgorithm::RSA_SHA256->value,
        'digest123',
        '1',
        '12345'
    );
    
    $domainsService->addDnssecRecords('customer123', 'example.com', [$record]);
    echo "DNSSEC record added successfully\n";
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
  - [v1 API](src/Services/Abuse/v1/README.md) ✅ Complete
  - [v2 API](src/Services/Abuse/v2/README.md) ✅ Complete

- **[Aftermarket Service](src/Services/Aftermarket/README.md)** - Manage aftermarket listings
  - [v1 API](src/Services/Aftermarket/v1/README.md) ✅ Complete

- **[Agreements Service](src/Services/Agreements/README.md)** - Retrieve legal agreements
  - [v1 API](src/Services/Agreements/v1/README.md) ✅ Complete

- **[Auctions Service](src/Services/Auctions/README.md)** - Participate in domain auctions
  - [v1 API](src/Services/Auctions/v1/README.md) ✅ Complete

- **[Certificates Service](src/Services/Certificates/README.md)** - Manage SSL certificates
  - [v1 API](src/Services/Certificates/v1/README.md) ✅ Complete
  - [v2 API](src/Services/Certificates/v2/README.md) ✅ Complete

- **[Countries Service](src/Services/Countries/README.md)** - Get country information
  - [v1 API](src/Services/Countries/v1/README.md) ✅ Complete

- **[Domains Service](src/Services/Domains/README.md)** - Manage domain registrations
  - [v1 API](src/Services/Domains/v1/README.md) ✅ Complete (25+ methods)
  - [v2 API](src/Services/Domains/v2/README.md) ✅ Complete (40+ methods)
  - **New Features**: DNSSEC support, advanced transfers, notifications, domain forwards

- **[Orders Service](src/Services/Orders/README.md)** - Manage orders
  - [v1 API](src/Services/Orders/v1/README.md) ✅ Complete

- **[Parking Service](src/Services/Parking/README.md)** - Domain parking analytics
  - [v1 API](src/Services/Parking/v1/README.md) ✅ Complete

- **[Shoppers Service](src/Services/Shoppers/README.md)** - Manage customer accounts
  - [v1 API](src/Services/Shoppers/v1/README.md) ✅ Complete

- **[Subscriptions Service](src/Services/Subscriptions/README.md)** - Manage subscriptions
  - [v1 API](src/Services/Subscriptions/v1/README.md) ✅ Complete

## New Features & Improvements

### 🆕 Complete v2 Domains API Implementation
- **40+ new methods** for advanced domain management
- **DNSSEC support** with full record management
- **Advanced domain transfers** with granular control
- **Domain forwards** management
- **Notification system** with opt-in/opt-out
- **Domain actions** tracking
- **Registration schemas** for TLDs
- **Maintenance and usage** tracking

### 🆕 Enhanced v1 Domains API
- **3 new enums** added for complete API coverage
- **DomainSuggestionSource** enum for domain suggestions
- **DnsRecordType** enum for DNS record types
- **CheckType** enum enhanced with lowercase variants

### 🆕 Comprehensive Testing
- **290+ tests** with full coverage
- **658 assertions** ensuring reliability
- **Complete unit tests** for all DTOs and Enums
- **Feature tests** for all service methods

### 🆕 Enhanced Exception Handling
- **50+ specific exception classes** for different error scenarios
- **Proper error categorization** for better debugging
- **Comprehensive error messages** with context

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
./vendor/bin/pest tests/Feature/v2/DomainsServiceTest.php

# Run all tests (290 tests, 658 assertions)
./vendor/bin/pest
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

### Latest Updates
- ✅ **Complete v2 Domains API implementation** (40+ new methods)
- ✅ **Enhanced v1 Domains API** (3 new enums)
- ✅ **Comprehensive testing** (290+ tests, 658 assertions)
- ✅ **DNSSEC support** with full record management
- ✅ **Advanced domain transfers** with granular control
- ✅ **Domain forwards** management
- ✅ **Notification system** implementation
- ✅ **Enhanced exception handling** (50+ specific exceptions)

See [CHANGELOG.md](CHANGELOG.md) for a complete list of changes and version history.

## Acknowledgments

- GoDaddy for providing the API
- The PHP community for excellent tools and libraries
- All contributors who help improve this SDK

---

**Note**: This is an unofficial SDK and is not affiliated with or endorsed by GoDaddy Inc.
