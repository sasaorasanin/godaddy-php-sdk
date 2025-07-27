# Domains Service

Complete implementation of GoDaddy Domains API for domain management with support for both v1 and v2 endpoints.

## Status

✅ **Complete** - Both v1 and v2 APIs fully implemented with comprehensive test coverage

## Overview

The Domains service provides comprehensive domain management capabilities including:

- **Domain Registration & Management**
- **DNS Management & DNSSEC**
- **Domain Transfers**
- **Privacy & Forwarding**
- **Notifications & Actions**
- **Contact Management**

## API Versions

### v1 API
Complete implementation of the original GoDaddy Domains API with 25+ methods covering all domain management operations.

**Key Features:**
- Domain listing and details
- Domain availability checking
- Domain registration and purchase
- DNS record management
- Domain transfers and renewals
- Privacy protection
- Contact management

**Documentation:** [v1 API Documentation](v1/README.md)

### v2 API
Complete implementation of the modern GoDaddy Domains API with enhanced features and improved structure.

**Key Features:**
- Enhanced domain details
- DNSSEC record management
- Advanced domain transfers
- Domain forwards
- Notification management
- Domain actions tracking
- Registration schemas
- Maintenance and usage tracking

**Documentation:** [v2 API Documentation](v2/README.md)

## Quick Start

### Basic Usage

```php
<?php

use GoDaddy\Services\Domains\v1\DomainsService as DomainsV1;
use GoDaddy\Services\Domains\v2\DomainsService as DomainsV2;

// Initialize v1 service
$domainsV1 = new DomainsV1('api-key', 'api-secret', 'https://api.ote-godaddy.com');

// Initialize v2 service
$domainsV2 = new DomainsV2('api-key', 'api-secret', 'https://api.ote-godaddy.com');

// List domains (v1)
$domains = $domainsV1->listDomains();

// Get domain details (v2)
$domainDetails = $domainsV2->getDomainDetails('customer123', 'example.com');
```

### Check Domain Availability

```php
// v1 - Check single domain
$availability = $domainsV1->checkDomainAvailability('example.com');

// v1 - Check multiple domains
$domains = ['example.com', 'test.com', 'demo.com'];
$availability = $domainsV1->checkDomainsAvailability($domains);
```

### Purchase Domain

```php
use GoDaddy\Services\Domains\v1\DTO\{PurchaseDomainData, ContactData, ConsentData};

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

$consentData = new ConsentData(['agreementKeys' => ['UNIVERSAL_TERMS']]);

$purchaseData = new PurchaseDomainData(
    'example.com',
    $contactData,
    $consentData,
    1,
    true,
    true
);

$result = $domainsV1->purchaseDomain($purchaseData);
```

### Manage DNS Records

```php
use GoDaddy\Services\Domains\v1\DTO\DnsRecordData;
use GoDaddy\Services\Domains\v1\Enums\DnsRecordType;

// v1 - Add DNS record
$record = new DnsRecordData(
    DnsRecordType::A,
    'www',
    '192.168.1.1',
    600
);

$domainsV1->addDomainRecords('example.com', [$record]);

// v2 - Add DNSSEC record
use GoDaddy\Services\Domains\v2\DTO\DnssecRecordData;
use GoDaddy\Services\Domains\v2\Enums\DnssecAlgorithm;

$dnssecRecord = new DnssecRecordData(
    DnssecAlgorithm::RSA_SHA256->value,
    'digest123',
    '1',
    '12345'
);

$domainsV2->addDnssecRecords('customer123', 'example.com', [$dnssecRecord]);
```

### Transfer Domain

```php
// v1 - Transfer domain in
use GoDaddy\Services\Domains\v1\DTO\TransferDomainData;

$transferData = new TransferDomainData(
    'auth-code-123',
    $consentData,
    $contactData,
    1,
    true,
    true
);

$result = $domainsV1->transferDomain('example.com', $transferData);

// v2 - Transfer with enhanced options
use GoDaddy\Services\Domains\v2\DTO\DomainTransferData;

$transferData = new DomainTransferData(
    'auth-code-123',
    'consent-data'
);

$result = $domainsV2->transferDomain('customer123', 'example.com', $transferData);
```

## Data Transfer Objects (DTOs)

The service uses comprehensive DTOs for type-safe data handling:

### v1 DTOs
- **Query DTOs**: ListDomainsQueryData, CheckDomainAvailabilityQueryData, etc.
- **Data DTOs**: PurchaseDomainData, ContactData, DnsRecordData, etc.
- **Response DTOs**: DomainDetailsData, PurchaseSchemaData, etc.

### v2 DTOs
- **Query DTOs**: GetDomainDetailsQueryData
- **Data DTOs**: DomainRegisterData, DnssecRecordData, DomainTransferData, etc.
- **Response DTOs**: DomainDetailsV2Data

## Enums

### v1 Enums
- **DomainStatus**: 232 domain status values
- **DomainStatusGroup**: Status groups (INACTIVE, PRE_REGISTRATION, etc.)
- **DomainInclude**: Include options (AUTH_CODE, CONTACTS, NAME_SERVERS)
- **CheckType**: Check types (FAST, FULL, fast, full)
- **DomainSuggestionSource**: Suggestion sources (CC_TLD, EXTENSION, etc.)
- **DnsRecordType**: DNS record types (A, AAAA, CNAME, MX, NS, SOA, SRV, TXT)

### v2 Enums
- **ActionType**: Domain action types (DNSSEC_CREATE, DOMAIN_RENEW, etc.)
- **NotificationType**: Notification types (DOMAIN_EXPIRY, DOMAIN_TRANSFER, etc.)
- **DnssecAlgorithm**: DNSSEC algorithms (RSA_SHA256, ECDSA_P256_SHA256, etc.)

## Exception Handling

The service provides specific exception classes for different error scenarios:

### v1 Exceptions
- **DomainException**: Base exception for domain operations
- **DomainsAgreementsException**: Agreements errors
- **DomainsAvailabilityException**: Availability check errors
- **DomainsPurchaseException**: Purchase errors
- **DomainsRecordsException**: DNS records errors
- And 20+ more specific exceptions

### v2 Exceptions
- **DomainsDetailsV2Exception**: Domain details errors
- **DnssecException**: DNSSEC operations
- **DomainTransferException**: Transfer operations
- **NotificationException**: Notification operations
- And 15+ more specific exceptions

## Testing

Comprehensive test coverage with 290+ tests:

```bash
# Run all domain service tests
./vendor/bin/pest tests/Feature/v1/DomainsServiceTest.php
./vendor/bin/pest tests/Feature/v2/DomainsServiceTest.php

# Run unit tests for DTOs and Enums
./vendor/bin/pest tests/Unit/Domains/v1/
./vendor/bin/pest tests/Unit/Domains/v2/

# Run all tests
./vendor/bin/pest
```

## Migration Guide

### From v1 to v2

The v2 API provides enhanced functionality and improved structure:

1. **Customer ID**: v2 uses customer IDs instead of shopper IDs
2. **Enhanced DTOs**: More structured data objects
3. **DNSSEC Support**: Native DNSSEC record management
4. **Advanced Transfers**: More granular transfer control
5. **Notifications**: Built-in notification management
6. **Actions Tracking**: Domain action history

### Example Migration

```php
// v1 - List domains
$domains = $domainsV1->listDomains();

// v2 - Get domain details with includes
$queryData = new GetDomainDetailsQueryData();
$queryData->includes = ['contacts', 'nameServers'];
$domainDetails = $domainsV2->getDomainDetails('customer123', 'example.com', $queryData);
```

## Best Practices

1. **Use v2 for new projects**: v2 provides enhanced features and better structure
2. **Handle exceptions properly**: Use specific exception classes for error handling
3. **Validate data**: Use DTOs for type-safe data handling
4. **Use enums**: Leverage enum classes for consistent values
5. **Test thoroughly**: All methods are fully tested

## Support

- **Documentation**: Detailed documentation for [v1](v1/README.md) and [v2](v2/README.md)
- **Examples**: Comprehensive usage examples in each version's README
- **Testing**: Full test coverage with examples
- **Issues**: Report bugs and feature requests on GitHub

---

**Note**: This service provides complete coverage of GoDaddy's Domains API with both v1 and v2 implementations, offering comprehensive domain management capabilities. 