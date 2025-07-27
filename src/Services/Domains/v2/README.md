# Domains Service v2

Complete implementation of GoDaddy Domains API v2 for domain management.

## Status

✅ **Complete** - All v2 endpoints implemented with full test coverage

## Available Methods

### Domain Management
- `getDomainDetails()` - Get specific domain details
- `cancelChangeOfRegistrant()` - Cancel change of registrant request

### DNS Security (DNSSEC)
- `addDnssecRecords()` - Add DNSSEC records to domain
- `removeDnssecRecords()` - Remove DNSSEC records from domain

### Name Servers
- `updateNameServers()` - Replace name servers on domain

### Privacy & Forwarding
- `getPrivacyForwarding()` - Get privacy email forwarding settings
- `updatePrivacyForwarding()` - Update privacy email forwarding settings

### Domain Operations
- `redeemDomain()` - Redeem an expired domain
- `renewDomain()` - Renew a domain

### Domain Transfers
- `transferDomain()` - Transfer a domain
- `validateTransfer()` - Validate domain transfer
- `acceptTransferIn()` - Accept transfer in
- `cancelTransferIn()` - Cancel transfer in
- `restartTransferIn()` - Restart transfer in
- `retryTransferIn()` - Retry transfer in
- `transferOut()` - Initiate transfer out
- `acceptTransferOut()` - Accept transfer out
- `rejectTransferOut()` - Reject transfer out

### Domain Forwards
- `getDomainForward()` - Get domain forwards
- `createDomainForward()` - Create domain forward
- `updateDomainForward()` - Update domain forward
- `deleteDomainForward()` - Delete domain forward

### Domain Actions
- `getDomainActions()` - Get domain actions
- `getDomainAction()` - Get specific domain action

### Notifications
- `getNotifications()` - Get notifications
- `optInNotifications()` - Opt in to notifications
- `getNotificationSchema()` - Get notification schema
- `acknowledgeNotification()` - Acknowledge notification

### Domain Registration
- `registerDomain()` - Register a domain
- `getRegistrationSchema()` - Get registration schema
- `validateRegistration()` - Validate domain registration

### Maintenance & Usage
- `getMaintenances()` - Get maintenances
- `getMaintenance()` - Get specific maintenance
- `getUsage()` - Get domain usage

### Domain Contacts
- `getDomainContacts()` - Get domain contacts
- `updateDomainContacts()` - Update domain contacts

## DTO Reference

### Query DTOs
- **GetDomainDetailsQueryData**: Query parameters for getting domain details

### Data DTOs
- **DomainDetailsV2Data**: Domain details response
- **DnssecRecordData**: DNSSEC record data
- **NameServerUpdateData**: Name server update data
- **PrivacyForwardingData**: Privacy forwarding data
- **DomainRedeemData**: Domain redemption data
- **DomainRenewData**: Domain renewal data
- **DomainTransferData**: Domain transfer data
- **DomainForwardData**: Domain forward data
- **NotificationOptInData**: Notification opt-in data
- **DomainRegisterData**: Domain registration data

## Enums

- **ActionType**: Domain action types (DNSSEC_CREATE, DNSSEC_DELETE, DOMAIN_UPDATE_NAME_SERVERS, CHANGE_OF_REGISTRANT_DELETE, DOMAIN_RENEW, DOMAIN_TRANSFER_IN, DOMAIN_TRANSFER_OUT, DOMAIN_REDEEM)
- **NotificationType**: Notification types (DOMAIN_EXPIRY, DOMAIN_TRANSFER, DOMAIN_RENEWAL, DOMAIN_REGISTRATION)
- **DnssecAlgorithm**: DNSSEC algorithms (RSA_SHA1, RSA_SHA256, RSA_SHA512, ECDSA_P256_SHA256, ECDSA_P384_SHA384, ED25519, ED448)

## Exceptions

- **DomainsDetailsV2Exception**: Exception for domain details errors
- **DomainsChangeOfRegistrantCancelException**: Exception for change of registrant cancellation errors
- **DnssecException**: Exception for DNSSEC operations
- **NameServerException**: Exception for name server operations
- **PrivacyForwardingException**: Exception for privacy forwarding operations
- **DomainRedeemException**: Exception for domain redemption operations
- **DomainRenewException**: Exception for domain renewal operations
- **DomainTransferException**: Exception for domain transfer operations
- **DomainForwardException**: Exception for domain forward operations
- **DomainActionException**: Exception for domain action operations
- **NotificationException**: Exception for notification operations
- **DomainRegisterException**: Exception for domain registration operations
- **MaintenanceException**: Exception for maintenance operations
- **UsageException**: Exception for usage operations
- **DomainContactsException**: Exception for domain contacts operations

## Usage Examples

### Get Domain Details
```php
use GoDaddy\Services\Domains\v2\DomainsService;
use GoDaddy\Services\Domains\v2\DTO\GetDomainDetailsQueryData;

$service = new DomainsService('api-key', 'api-secret', 'https://api.ote-godaddy.com');

$queryData = new GetDomainDetailsQueryData();
$queryData->includes = ['contacts', 'nameServers'];

$domainDetails = $service->getDomainDetails('customer123', 'example.com', $queryData);
```

### Manage DNSSEC Records
```php
use GoDaddy\Services\Domains\v2\DTO\DnssecRecordData;
use GoDaddy\Services\Domains\v2\Enums\DnssecAlgorithm;

$record = new DnssecRecordData(
    DnssecAlgorithm::RSA_SHA256->value,
    'digest123',
    '1',
    '12345'
);

$service->addDnssecRecords('customer123', 'example.com', [$record]);
```

### Update Name Servers
```php
use GoDaddy\Services\Domains\v2\DTO\NameServerUpdateData;

$nameServers = ['ns1.example.com', 'ns2.example.com'];
$data = new NameServerUpdateData($nameServers);

$service->updateNameServers('customer123', 'example.com', $data);
```

### Transfer Domain
```php
use GoDaddy\Services\Domains\v2\DTO\DomainTransferData;

$transferData = new DomainTransferData(
    'auth-code-123',
    'consent-data'
);

$result = $service->transferDomain('customer123', 'example.com', $transferData);
```

### Register Domain
```php
use GoDaddy\Services\Domains\v2\DTO\DomainRegisterData;

$registerData = new DomainRegisterData(
    'example.com',
    ['agreementKeys' => ['UNIVERSAL_TERMS']],
    ['contacts' => ['admin' => $contactData]],
    1,
    true,
    true,
    ['ns1.example.com', 'ns2.example.com']
);

$result = $service->registerDomain('customer123', $registerData);
```

### Manage Domain Forwards
```php
use GoDaddy\Services\Domains\v2\DTO\DomainForwardData;

$forwardData = new DomainForwardData(
    'https://example.com',
    true,
    'Example Title',
    'Example Description',
    'example, keywords'
);

$service->createDomainForward('customer123', 'example.com', $forwardData);
```

### Opt-in to Notifications
```php
use GoDaddy\Services\Domains\v2\DTO\NotificationOptInData;
use GoDaddy\Services\Domains\v2\Enums\NotificationType;

$optInData = new NotificationOptInData(
    NotificationType::DOMAIN_EXPIRY->value,
    ['email', 'sms']
);

$service->optInNotifications('customer123', $optInData);
```

## Testing

All methods are fully tested with comprehensive unit and feature tests:

```bash
# Run domain service tests
./vendor/bin/pest tests/Feature/v2/DomainsServiceTest.php

# Run unit tests for DTOs and Enums
./vendor/bin/pest tests/Unit/Domains/v2/
```
