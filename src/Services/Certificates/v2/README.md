# Certificates Service v2

This service version uses GoDaddy v2 Certificates API endpoints for SSL certificate management with enhanced functionality.

## Usage

```php
use GoDaddy\Services\Certificates\v2\CertificatesService;

$service = new CertificatesService($apiKey, $apiSecret, $baseUrl);

// Search certificates by entitlement ID
$certificates = $service->searchByEntitlement('entitlement-id-123', true);

// Download certificate by entitlement ID
$certificateContent = $service->downloadByEntitlement('entitlement-id-123');

// Get customer certificates
$customerCertificates = $service->getCustomerCertificates('customer-id-456', 0, 50);

// Get customer certificate details
$certificateDetails = $service->getCustomerCertificateDetails('customer-id-456', 'certificate-id-789');

// Get domain verifications
$domainVerifications = $service->getDomainVerifications('customer-id-456', 'certificate-id-789');

// Get domain verification details for specific domain
$verificationDetails = $service->getDomainVerificationDetails('customer-id-456', 'certificate-id-789', 'example.com');

// Get ACME External Account Binding
$acmeBinding = $service->getAcmeExternalAccountBinding('customer-id-456');
```

## Methods

- **searchByEntitlement(string $entitlementId, bool $latest = true)**: Search certificates by entitlement ID
- **downloadByEntitlement(string $entitlementId)**: Download certificate by entitlement ID
- **getCustomerCertificates(string $customerId, int $offset = 0, int $limit = 50)**: Get customer certificates
- **getCustomerCertificateDetails(string $customerId, string $certificateId)**: Get customer certificate details
- **getDomainVerifications(string $customerId, string $certificateId)**: Get domain verifications
- **getDomainVerificationDetails(string $customerId, string $certificateId, string $domain)**: Get domain verification details
- **getAcmeExternalAccountBinding(string $customerId)**: Get ACME External Account Binding

## Note
This documentation refers exclusively to v2 endpoints. For v1, see README in the v1 folder.
