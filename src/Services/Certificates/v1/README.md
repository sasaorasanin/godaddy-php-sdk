# Certificates Service v1

This service version uses GoDaddy v1 Certificates API endpoints for SSL certificate management.

## Usage

```php
use GoDaddy\Services\Certificates\v1\CertificatesService;
use GoDaddy\Services\Certificates\v1\DTO\CertificateCreateData;
use GoDaddy\Services\Certificates\v1\DTO\CertificateReissueData;
use GoDaddy\Services\Certificates\v1\DTO\CertificateRenewData;
use GoDaddy\Services\Certificates\v1\DTO\CertificateRevokeData;
use GoDaddy\Services\Certificates\v1\DTO\ContactData;
use GoDaddy\Services\Certificates\v1\DTO\OrganizationData;
use GoDaddy\Services\Certificates\v1\DTO\AddressData;

$service = new CertificatesService($apiKey, $apiSecret, $baseUrl);

// Create a new certificate
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

$orgData = new OrganizationData(
    'Example Corp',
    '123456789',
    '123 Main St',
    'City',
    'State',
    '12345',
    'US'
);

$createData = new CertificateCreateData(
    'example.com',
    'DV',
    12,
    $contactData,
    $orgData,
    'example.com'
);
$certificate = $service->createCertificate($createData);

// Validate certificate before creation
$validation = $service->validateCertificate($createData);

// Get certificate details
$certificateDetails = $service->getCertificate('certificate-id-123');

// Get certificate actions
$actions = $service->getCertificateActions('certificate-id-123');

// Resend email
$service->resendEmail('certificate-id-123', 'email-id-456');

// Resend all emails to alternate address
$service->resendAllToAlternateEmail('certificate-id-123', 'admin@example.com');

// Resend specific email to specific address
$service->resendEmailToSpecificAddress('certificate-id-123', 'email-id-456', 'admin@example.com');

// Get email history
$emailHistory = $service->getEmailHistory('certificate-id-123');

// Register callback
$service->registerCallback('certificate-id-123', 'https://example.com/callback');

// Get callback
$callback = $service->getCallback('certificate-id-123');

// Unregister callback
$service->unregisterCallback('certificate-id-123');

// Cancel certificate
$service->cancelCertificate('certificate-id-123');

// Download certificate
$certificateContent = $service->downloadCertificate('certificate-id-123');

// Reissue certificate
$reissueData = new CertificateReissueData(
    'example.com',
    $contactData,
    $orgData,
    'example.com'
);
$reissueResponse = $service->reissueCertificate('certificate-id-123', $reissueData);

// Renew certificate
$renewData = new CertificateRenewData(
    'example.com',
    $contactData,
    $orgData,
    'example.com'
);
$renewResponse = $service->renewCertificate('certificate-id-123', $renewData);

// Revoke certificate
$revokeData = new CertificateRevokeData('Compromised');
$service->revokeCertificate('certificate-id-123', $revokeData);

// Get site seal
$siteSeal = $service->getSiteSeal('certificate-id-123', 'LIGHT', 'en');

// Verify domain control
$service->verifyDomainControl('certificate-id-123');
```

## DTO Reference

- **CertificateCreateData**: Data for creating certificates (domain, type, validityPeriod, contact, organization, commonName)
- **CertificateReissueData**: Data for reissuing certificates (domain, contact, organization, commonName)
- **CertificateRenewData**: Data for renewing certificates (domain, contact, organization, commonName)
- **CertificateRevokeData**: Data for revoking certificates (reason)
- **ContactData**: Contact information (name, email, phone, address1, city, state, postalCode, country)
- **OrganizationData**: Organization information (name, phone, address1, city, state, postalCode, country)
- **AddressData**: Address information (address1, city, state, postalCode, country)

## Note
This documentation refers exclusively to v1 endpoints. For v2, see README in the v2 folder.
