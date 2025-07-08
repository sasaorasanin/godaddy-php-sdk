<?php

namespace GoDaddy\Services\Certificates\v2;

use GoDaddy\Services\BaseService;
use GoDaddy\Support\ErrorCode;
use GuzzleHttp\Exception\ClientException;
use GoDaddy\Services\Certificates\v2\Exceptions\{
    CertificateSearchByEntitlementException,
    CertificateDownloadByEntitlementException,
    CustomerCertificatesFetchException,
    CustomerCertificateDetailsFetchException,
    DomainVerificationStatusFetchException,
    DomainVerificationDetailsFetchException,
    AcmeExternalAccountBindingFetchException
};

class CertificatesService extends BaseService
{
    public function searchByEntitlement(string $entitlementId, bool $latest = true): array
    {
        try {
            $response = $this->client->get('/v2/certificates', [
                'query' => [
                    'entitlementId' => $entitlementId,
                    'latest' => $latest ? 'true' : 'false',
                ]
            ]);

            return $this->decodeResponse($response);
        } catch (ClientException $e) {
            $this->handleHttpException($e, CertificateSearchByEntitlementException::class, ErrorCode::CERTIFICATE_SEARCH_FAILED);
        }
    }

    public function downloadByEntitlement(string $entitlementId): string
    {
        try {
            $response = $this->client->get('/v2/certificates/download', [
                'query' => [
                    'entitlementId' => $entitlementId,
                ]
            ]);

            return (string) $response->getBody();
        } catch (ClientException $e) {
            $this->handleHttpException($e, CertificateDownloadByEntitlementException::class, ErrorCode::CERTIFICATE_DOWNLOAD_FAILED);
        }
    }

    public function getCustomerCertificates(string $customerId, int $offset = 0, int $limit = 50): array
    {
        try {
            $response = $this->client->get("/v2/customers/{$customerId}/certificates", [
                'query' => compact('offset', 'limit'),
            ]);

            return $this->decodeResponse($response);
        } catch (ClientException $e) {
            $this->handleHttpException($e, CustomerCertificatesFetchException::class, ErrorCode::CUSTOMER_CERTIFICATES_FAILED);
        }
    }

    public function getCustomerCertificateDetails(string $customerId, string $certificateId): array
    {
        try {
            $response = $this->client->get("/v2/customers/{$customerId}/certificates/{$certificateId}");

            return $this->decodeResponse($response);
        } catch (ClientException $e) {
            $this->handleHttpException($e, CustomerCertificateDetailsFetchException::class, ErrorCode::CERTIFICATE_DETAILS_FAILED);
        }
    }

    public function getDomainVerifications(string $customerId, string $certificateId): array
    {
        try {
            $response = $this->client->get("/v2/customers/{$customerId}/certificates/{$certificateId}/domainVerifications");

            return $this->decodeResponse($response);
        } catch (ClientException $e) {
            $this->handleHttpException($e, DomainVerificationStatusFetchException::class, ErrorCode::DOMAIN_VERIFICATION_FAILED);
        }
    }

    public function getDomainVerificationDetails(string $customerId, string $certificateId, string $domain): array
    {
        try {
            $response = $this->client->get("/v2/customers/{$customerId}/certificates/{$certificateId}/domainVerifications/{$domain}");

            return $this->decodeResponse($response);
        } catch (ClientException $e) {
            $this->handleHttpException($e, DomainVerificationDetailsFetchException::class, ErrorCode::DOMAIN_VERIFICATION_DETAILS_FAILED);
        }
    }

    public function getAcmeExternalAccountBinding(string $customerId): array
    {
        try {
            $response = $this->client->get("/v2/customers/{$customerId}/certificates/acme/externalAccountBinding");

            return $this->decodeResponse($response);
        } catch (ClientException $e) {
            $this->handleHttpException($e, AcmeExternalAccountBindingFetchException::class, ErrorCode::ACME_EAB_FAILED);
        }
    }

}
