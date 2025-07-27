# Domains Service v1

Complete implementation of GoDaddy Domains API v1 for domain management.

## Status

✅ **Complete** - All v1 endpoints implemented with full test coverage

## Available Methods

### Domain Management
- `listDomains()` - List all domains
- `getDomainDetails()` - Get specific domain details
- `updateDomain()` - Update domain information
- `cancelDomain()` - Cancel domain registration

### Domain Availability
- `checkDomainAvailability()` - Check if a domain is available
- `checkDomainsAvailability()` - Check availability for multiple domains
- `suggestDomains()` - Get domain suggestions
- `getTlds()` - Get available TLDs

### Domain Registration
- `purchaseDomain()` - Purchase a new domain
- `getPurchaseSchema()` - Get purchase schema for TLD
- `validatePurchase()` - Validate purchase data
- `getAgreements()` - Get required agreements

### Domain Contacts
- `updateDomainContacts()` - Update domain contact information
- `validateContacts()` - Validate contact information

### Domain Privacy
- `purchaseDomainPrivacy()` - Purchase privacy protection
- `cancelDomainPrivacy()` - Cancel privacy protection

### DNS Management
- `getDomainRecords()` - Get DNS records
- `addDomainRecords()` - Add DNS records
- `replaceDomainRecords()` - Replace DNS records
- `updateDomainRecords()` - Update DNS records
- `deleteDomainRecords()` - Delete DNS records
- `replaceDomainRecordsByType()` - Replace records by type

### Domain Operations
- `renewDomain()` - Renew domain registration
- `transferDomain()` - Transfer domain in
- `verifyRegistrantEmail()` - Verify registrant email

## DTO Reference

### Query DTOs
- **ListDomainsQueryData**: Query parameters for listing domains
- **CheckDomainAvailabilityQueryData**: Query parameters for domain availability
- **CheckDomainsAvailabilityData**: Data for checking multiple domains
- **SuggestDomainsQueryData**: Query parameters for domain suggestions
- **GetAgreementsQueryData**: Query parameters for agreements
- **GetDnsRecordsQueryData**: Query parameters for DNS records

### Data DTOs
- **DomainDetailsData**: Domain details response
- **PurchaseDomainData**: Domain purchase data
- **PurchaseSchemaData**: Purchase schema response
- **ValidatePurchaseData**: Purchase validation data
- **ValidateContactsData**: Contact validation data
- **TransferDomainData**: Domain transfer data
- **RenewDomainData**: Domain renewal data
- **UpdateDomainData**: Domain update data
- **UpdateDomainContactsData**: Contact update data
- **PurchasePrivacyData**: Privacy purchase data
- **PurchasePrivacyResponseData**: Privacy purchase response
- **DnsRecordData**: DNS record data
- **DnsRecordUpdateData**: DNS record update data
- **ContactData**: Contact information
- **ContactAddressData**: Contact address
- **ConsentData**: Consent information
- **TldData**: TLD information
- **SuggestedDomainData**: Domain suggestion data

## Enums

- **DomainStatus**: All domain status values (232 statuses)
- **DomainStatusGroup**: Domain status groups (INACTIVE, PRE_REGISTRATION, REDEMPTION, RENEWABLE, VERIFICATION_ICANN, VISIBLE)
- **DomainInclude**: Include options (AUTH_CODE, CONTACTS, NAME_SERVERS)
- **CheckType**: Check types (FAST, FULL, fast, full)
- **DomainSuggestionSource**: Suggestion sources (CC_TLD, EXTENSION, KEYWORD_SPIN, PREMIUM, and lowercase variants)
- **DnsRecordType**: DNS record types (A, AAAA, CNAME, MX, NS, SOA, SRV, TXT)

## Exceptions

- **DomainException**: Base exception for domain operations
- **DomainsAgreementsException**: Exception for agreements errors
- **DomainsAvailabilityException**: Exception for availability check errors
- **DomainsCancelException**: Exception for domain cancellation errors
- **DomainsDetailsException**: Exception for domain details errors
- **DomainsPurchaseException**: Exception for domain purchase errors
- **DomainsPurchaseSchemaException**: Exception for purchase schema errors
- **DomainsPurchaseValidationException**: Exception for purchase validation errors
- **DomainsSuggestException**: Exception for domain suggestions errors
- **DomainsTldsException**: Exception for TLDs errors
- **DomainsUpdateException**: Exception for domain update errors
- **DomainsContactsException**: Exception for contacts errors
- **DomainsContactsValidationException**: Exception for contact validation errors
- **DomainsPrivacyException**: Exception for privacy errors
- **DomainsPrivacyPurchaseException**: Exception for privacy purchase errors
- **DomainsPrivacyCancelException**: Exception for privacy cancellation errors
- **DomainsRecordsException**: Exception for DNS records errors
- **DomainsRecordsAddException**: Exception for adding DNS records errors
- **DomainsRecordsReplaceException**: Exception for replacing DNS records errors
- **DomainsRecordsUpdateException**: Exception for updating DNS records errors
- **DomainsRecordsDeleteException**: Exception for deleting DNS records errors
- **DomainsRenewException**: Exception for domain renewal errors
- **DomainsTransferException**: Exception for domain transfer errors
- **DomainsVerifyRegistrantEmailException**: Exception for email verification errors

## Usage Examples

### List Domains
```php
use GoDaddy\Services\Domains\v1\DomainsService;
use GoDaddy\Services\Domains\v1\DTO\ListDomainsQueryData;

$service = new DomainsService('api-key', 'api-secret', 'https://api.ote-godaddy.com');

$queryData = new ListDomainsQueryData();
$queryData->statusGroups = ['ACTIVE'];
$queryData->limit = 100;

$domains = $service->listDomains($queryData);
```

### Check Domain Availability
```php
use GoDaddy\Services\Domains\v1\DTO\CheckDomainAvailabilityQueryData;
use GoDaddy\Services\Domains\v1\Enums\CheckType;

$queryData = new CheckDomainAvailabilityQueryData();
$queryData->checkType = CheckType::FAST;

$availability = $service->checkDomainAvailability('example.com', $queryData);
```

### Purchase Domain
```php
use GoDaddy\Services\Domains\v1\DTO\PurchaseDomainData;
use GoDaddy\Services\Domains\v1\DTO\ContactData;
use GoDaddy\Services\Domains\v1\DTO\ConsentData;

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

$result = $service->purchaseDomain($purchaseData);
```

### Manage DNS Records
```php
use GoDaddy\Services\Domains\v1\DTO\DnsRecordData;
use GoDaddy\Services\Domains\v1\Enums\DnsRecordType;

$record = new DnsRecordData(
    DnsRecordType::A,
    'www',
    '192.168.1.1',
    600
);

$service->addDomainRecords('example.com', [$record]);
```

## Testing

All methods are fully tested with comprehensive unit and feature tests:

```bash
# Run domain service tests
./vendor/bin/pest tests/Feature/v1/DomainsServiceTest.php

# Run unit tests for DTOs and Enums
./vendor/bin/pest tests/Unit/Domains/v1/
```
